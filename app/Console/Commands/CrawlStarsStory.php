<?php

namespace App\Console\Commands;

use function Laravel\Prompts\text;

use App\Models\Star;
use App\Models\Story;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;

class CrawlStarsStory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-stars-story';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $linkStory = text(
        //     label: 'Link truyện ?',
        //     placeholder: 'https://truyenfull.vn/phi-thien',
        // );
        $linkStories = [
            'https://truyenfull.vn/truyen-dau-pha-thuong-khung/',
            'https://truyenfull.vn/tu-cam-270192/',
            'https://truyenfull.vn/ngao-the-dan-than/',
            'https://truyenfull.vn/nang-khong-muon-lam-hoang-hau/',
            'https://truyenfull.vn/kieu-sung-vi-thuong/',
            'https://truyenfull.vn/linh-vu-thien-ha/',
            'https://truyenfull.vn/anh-dao-ho-phach/',
            'https://truyenfull.vn/than-dao-dan-ton-606028/',
            'https://truyenfull.vn/cuoi-truoc-yeu-sau-mong-tieu-nhi-221970/',
            'https://truyenfull.vn/me-dam/',
            'https://truyenfull.vn/khong-phu-the-duyen/',
            'https://truyenfull.vn/diu-dang-tan-xuong/',
            'https://truyenfull.vn/vo-chong-sieu-sao-hoi-ngot/',
            'https://truyenfull.vn/that-u-that-u-phai-la-hong-phai-xanh-tham-594002/',
            'https://truyenfull.vn/thieu-tuong-vo-ngai-noi-gian-roi-543143/',
            'https://truyenfull.vn/cung-chieu-vo-nho-troi-ban-930006/',
            'https://truyenfull.vn/thien-huong-nguoi-mu-liec-mat-dua-tinh/',
            'https://truyenfull.vn/hat-de-va-chanel/',
            'https://truyenfull.vn/lan-huong-sau-man-truong/',
            'https://truyenfull.vn/nghich-thien-tam-gioi/',
            'https://truyenfull.vn/xuyen-chung-chi-thanh-xuan/',
            'https://truyenfull.vn/dan-loi-vao-tim-em/',
            'https://truyenfull.vn/that-gia-vo-ngai-lai-buong-roi/',
            'https://truyenfull.vn/co-nang-xau-xi-la-ban-gai-tong-tai/',
            'https://truyenfull.vn/co-vo-buong-binh-mua-mot-tang-hai/',
            'https://truyenfull.vn/su-phu-toi-la-than-tien/',
            'https://truyenfull.vn/em-anh-va-chung-ta/',
            'https://truyenfull.vn/me-vo-khong-loi-ve-982891/',
            'https://truyenfull.vn/truyen-dau-pha-thuong-khung/',
            'https://truyenfull.vn/the-gioi-hoan-my/',
            'https://truyenfull.vn/co-vo-ngot-ngao-co-chut-bat-luong-vo-moi-bat-luong-co-chut-ngot/',
            'https://truyenfull.vn/pham-nhan-tu-tien/',
            'https://truyenfull.vn/nhat-niem-vinh-hang/',
            'https://truyenfull.vn/de-ba/',
            'https://truyenfull.vn/re-quy-troi-cho-480197/',
            'https://truyenfull.vn/vu-dong-can-khon/',
            'https://truyenfull.vn/dau-pha-thuong-khung-vo-thuong-canh-gioi/',
            'https://truyenfull.vn/thien-trieu-tien-quan/',
            'https://truyenfull.vn/do-de-xuong-nui-vo-dich-thien-ha/',
            'https://truyenfull.vn/bi-an-doi-long-phuong/',
            'https://truyenfull.vn/thien-ha-hoan-ca/',
            'https://truyenfull.vn/dai-tien-ca-koi-muon-ra-mat/',
            'https://truyenfull.vn/quay-lai-tuoi-15/',
            'https://truyenfull.vn/ma-ton-han-nho-mai-khong-quen/',
            'https://truyenfull.vn/sao-toi-co-the-thich-cau-ta-duoc/',
            'https://truyenfull.vn/thuong-long-chien-than-to-truong-phong/',
            'https://truyenfull.vn/doc-ton-tam-gioi/',
            'https://truyenfull.vn/tien-nghich/',
            'https://truyenfull.vn/de-ton/',
            'https://truyenfull.vn/ngao-the-cuu-trong-thien/',
            'https://truyenfull.vn/dau-la-dai-luc-2/',
            'https://truyenfull.vn/nguyen-ton/',
            'https://truyenfull.vn/tinh-than-bien/',
            'https://truyenfull.vn/kiem-dong-cuu-thien/',
            'https://truyenfull.vn/phi-thien/',
            'https://truyenfull.vn/hon-nhan-manh-me-sep-tha-cho-toi-di/',
            'https://truyenfull.vn/trieu-hoan-than-binh/',
            'https://truyenfull.vn/lang-thien-truyen-thuyet/',
            'https://truyenfull.vn/vu-than/',
            'https://truyenfull.vn/cam-y-ve/',
            'https://truyenfull.vn/mang-hoang-ky/',
            'https://truyenfull.vn/di-the-ta-quan/',
            'https://truyenfull.vn/than-mo/',
            'https://truyenfull.vn/thong-thien-chi-lo/',
            'https://truyenfull.vn/xuyen-nhanh-nam-than-bung-chay-di/',
            'https://truyenfull.vn/nam-chu-benh-kieu-sung-len-troi-657780/',
            'https://truyenfull.vn/benh-yeu/',
            'https://truyenfull.vn/vuong-phi-da-tai-da-nghe-303562/',
            'https://truyenfull.vn/nguoi-vo-thu-bay-cua-tong-tai-ac-ma-522328/',
            'https://truyenfull.vn/bay-nam-van-ngoanh-ve-phuong-bac/',
            'https://truyenfull.vn/yeu-sau-nang-de-thieu-am-tham-cung-chieu-vo/',
        ];

        $this->info('#Đang tiến hành crawl star truyện ...');

        $this->main($linkStories);

        $this->info("\nCrawl story stars completed!");
    }

    protected function main($linkStories) {
        set_time_limit(500);

        $client = new Client();
        foreach ($linkStories as $linkStory) {
            $crawler = $client->request('GET', $linkStory);
            $htmlString = $crawler->getBody()->getContents();
    
            $crawler = new Crawler($htmlString, $linkStory);
            if ($crawler->filter('.title')->getNode(0)) {
                $storyName = $crawler->filter('.title')->text();
                $storyNameSlug = Str::slug($storyName);
            }

            if ($crawler->filter('span[itemprop="ratingValue"]')->getNode(0) && $crawler->filter('span[itemprop="ratingCount"]')->getNode(0)) {
                $stars = $crawler->filter('span[itemprop="ratingValue"]')->text();
                $count = $crawler->filter('span[itemprop="ratingCount"]')->text();
    
                // dd($stars, $count);
        
                $storyTarget = Story::query()->where('slug', '=', $storyNameSlug)->first();
                if ($storyTarget) {
                    $storyId = $storyTarget->id;
    
                    $star = Star::query()->where('story_id', '=', $storyId)->first();
                    if (!$star) {
                        $star = new Star();
                    }
                    $star->story_id = $storyId;
                    $star->controller_name = 'StoryController';
                    $star->stars = $stars;
                    $star->count = $count;
                    $star->approved = 1;
                    $star->save();
                }
            }
        }
    }
}
