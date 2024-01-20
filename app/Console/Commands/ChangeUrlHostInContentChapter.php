<?php

namespace App\Console\Commands;

use App\Models\Chapter;
use Illuminate\Console\Command;

class ChangeUrlHostInContentChapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-url-host-in-content-chapter';

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
        $this->info('# Đang thay đổi url trong content danh sách chapter truyện ... ');

        $chapters = Chapter::query()->get();

        foreach ($chapters as $chapter) {
            $oldContent = $chapter->content;
            $newContent = str_replace('https://truyenfull.vn', env('APP_URL', '#'), $oldContent);
            $newContent = str_replace('Truyện FULL', 'Suu Truyện', $newContent);
            $newContent = str_replace('- www.Suu Truyện', '', $newContent);
            $newContent = str_replace('<br>', '<div class="py-2"></div>', $newContent);

            $chapter->content = $newContent;
            $chapter->save();
        }

        $this->info('# Done');
    }
}
