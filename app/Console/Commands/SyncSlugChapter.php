<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use Illuminate\Console\Command;

class SyncSlugChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-slug-chapter';

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
        $this->info('# Đang đồng bộ slug chapter ');
        
        $chapters = Chapter::all();

        foreach ($chapters as $chapter) {
            $slug = 'chuong-'. $chapter->chapter;
            $chapter = Chapter::query()->find($chapter->id);
            $chapter->slug = $slug;
            $chapter->save();
        }

        $this->info('# Done');
    }
}
