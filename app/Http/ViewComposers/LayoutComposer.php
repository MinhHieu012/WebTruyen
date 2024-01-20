<?php

namespace App\Http\ViewComposers;

use App\Helpers\Helper;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cookie;

class LayoutComposer
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
        $categories = Helper::getCategoies();
        $menu = [
            'the_loai' => $categories,
        ];

        $bgColorCookie = $_COOKIE['bg_color'] ?? '';
        $setting = Helper::getSetting();
        
        $view->with([
            // 'categories'    => $categories,
            'bgColorCookie' => $bgColorCookie,
            'menu'          => $menu,
            'setting' => $setting
        ]);
    }
}
