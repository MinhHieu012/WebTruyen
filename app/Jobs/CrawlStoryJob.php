<?php

namespace App\Jobs;

use App\Models\Chapter;
use App\Repositories\Chapter\ChapterRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Repositories\Chapter\ChapterRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CrawlStoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $linkCrawlOrigin;
    protected $fromPaginate;
    protected $toPaginate;
    protected $storyId;
    /**
     * Create a new job instance.
     */
    public function __construct($linkCrawlOrigin, $fromPaginate, $toPaginate, $storyId)
    {
        $this->linkCrawlOrigin = $linkCrawlOrigin;
        $this->fromPaginate = $fromPaginate;
        $this->toPaginate = $toPaginate;
        $this->storyId = $storyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();

        for ($i = $this->fromPaginate; $i <= $this->toPaginate;) {
            $linkCrawl = str_replace('trang-' . $this->fromPaginate, 'trang-' . $i, $this->linkCrawlOrigin);

            $crawler = $client->request('GET', $linkCrawl);

            $htmlString = $crawler->getBody()->getContents();
            $baseUrl = $linkCrawl;

            $crawler = new Crawler($htmlString, $baseUrl);

            $chapterLinks = $crawler->filter('ul.list-chapter a')->links();
            foreach ($chapterLinks as $link) {
                preg_match('/chuong-(\d+)/', $link->getUri(), $matches);

                if (isset($matches[1])) {
                    $chapter = $matches[1];
                    $this->crawlChapter($link->getUri(), $this->storyId, $chapter);
                }
            }

            $i++;
        }
    }

    protected function crawlChapter($link, $storyId, $chapter)
    {
        $client = new Client();
        $crawler = $client->request('GET', $link);

        $htmlString = $crawler->getBody()->getContents();
        $baseUrl = $link;

        $crawler = new Crawler($htmlString, $baseUrl);

        if ($crawler->filter('div.chapter-c')->getNode(0)) {
            $content = $crawler->filter('div.chapter-c')->html();
            $titleChapter = $crawler->filter('.chapter-title')->text();
            $attributes = [
                'story_id' => $storyId,
                'chapter' => $chapter,
                'slug' => 'chuong-' . $chapter,
                'content' => $content,
                'name' => $titleChapter
            ];

            $chapter = Chapter::query()->where($attributes)->first();
            if (!$chapter) {
                Chapter::query()->create($attributes);
            }

            Log::info("Crawl " . $titleChapter);
        }
    }
}
