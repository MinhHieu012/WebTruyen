<?php

namespace App\Http\ViewComposers;

use App\Helpers\Helper;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cookie;

class ChapterComposer
{

    /**
     * Create a new view composer instance.
     *
     */
    public function __construct(
        
    )
    {
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose($view)
    {
        $chapterFont = $_COOKIE['font_chapter'] ?? '';
        $chapterFontSize = $_COOKIE['font_size_chapter'] ?? '';
        $chapterLineHeight = $_COOKIE['line_height_chapter'] ?? '';
        
        $view->with([
            'chapterFont' => $chapterFont,
            'chapterFontSize' => $chapterFontSize,
            'chapterLineHeight' => $chapterLineHeight,
        ]);
    }
}
