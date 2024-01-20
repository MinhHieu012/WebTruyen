<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;

class Helper
{
    public static function userRoleName(): string
    {
        $user = self::currentUser();
        return $user?->roles?->first()?->name ?: '';
    }

    public static function currentUser()
    {
        static $user;
        if (empty($user)) {
            $user = auth()->user();
        }
        return $user;
    }

    public static function userCan($perm): bool
    {
        static $cache;
        if (isset($cache[$perm])) {
            return $cache[$perm];
        }
        $user = self::currentUser();
        return $cache[$perm] = $user->can($perm);
    }

    public static function correctPhone($phone)
    {
        // thay the cac ky tu khong phai so ve rong
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (Str::startsWith($phone, '84')) {
            return $phone;
        }
        if (Str::startsWith($phone, '0')) {
            return Str::replaceFirst('0', '84', $phone);
        }
        return $phone;
    }

    public static function menuData(): array
    {
        $user     = self::currentUser();
        $roleName = self::userRoleName();

        $user_tdv_items = [];
//        if ($roleName == User::ROLE_SCAN_QR_CODE) {
//            $user_tdv_items = config('menu_qr_code');
//        } else if ($roleName == User::ROLE_TDV || $roleName == User::ROLE_MARKETING_LOCAL) {
//            $user_tdv_items = config('menu_tdv');
//        } else if ($roleName == User::ROLE_THIEN_DIEU) {
//            $user_tdv_items = config('menu_thien_dieu');
//        } else {
        $menu_items = config('menu.default');
//        }

        $user_items = [
            'name'  => 'Tài khoản:',
            'group' => true,
            'child' => [
                [
                    'name'    => $user->email ?? '',
                    'href'    => '#',
                    'icon'    => '<i data-feather="mail"></i>',
                    'display' => (bool)($user->email ?? '')
                ],
                [
                    'name'  => 'Đăng xuất',
                    'route' => 'admin.logout',
                    'icon'  => '<i data-feather="log-out"></i>',
                ],
            ]
        ];
//        if ($user->other_user) {
//            $user_items['child'][] = [
//                'name' => 'Đổi TK: ' . $user->other_user->username,
//                'href' => route('admin.users.switch', $user->other_user->id),
//                'icon' => '<i data-feather="log-in"></i>',
//            ];
//        }

        $menu_items[] = $user_tdv_items;
        $menu_items[] = $user_items;
        foreach ($menu_items as &$item) {
            $item = self::validMenu($item, $user);
        }
        unset($item);
        return array_filter($menu_items);
    }

    static function validMenu($item, $user)
    {
        if (isset($item["display"]) && $item["display"] === false) {
            return false;
        }
        if (!empty($item['perm'])) {
            if (!$user) {
                return false;
            }
            $perms = (array)$item['perm'];
            if (!$user->hasAnyPermission($perms)) {
                return false;
            }
        }

        if (isset($item["display"]) && $item["display"] === false) {
            return false;
        }
        $item['active'] = false;
        if (!empty($item['route']) && Route::has($item['route'])) {
            $item['href'] = route($item['route']);
            if (request()->route()->getName() == $item['route']) {
                $item['active'] = true;
            }
        }
        if (!empty($item['href']) && !$item['active'] && !empty($item['pattern'])) {
            foreach ($item['pattern'] as $pattern) {
                $active = self::checkPattern($pattern);
                if ($active) {
                    $item['active'] = true;
                    break;
                }
            }
        }
        if (!empty($item['child'])) {
            foreach ($item['child'] as &$child_item) {
                $child_item = self::validMenu($child_item, $user);
            }
            $item['child'] = array_filter($item['child']);
            if ($item['child'] && collect($item['child'])->where('active', true)->count()) {
                $item['class'] = 'open';
            }
        }
        if (isset($item['group']) && empty($item['child'])) {
            return false;
        } elseif (empty($item['child']) && empty($item['href'])) {
            return false;
        }
        return $item;
    }

    static function checkPattern(string $pattern): bool
    {
        $pattern = preg_replace('@^https?://@', '*', URL::to($pattern));
        $path    = preg_replace('@^https?://@', '', request()->fullUrl());

        return Str::is(trim($pattern), trim($path));
    }

    public static function getCurrentPermissions()
    {
        return request()->user()->getAllPermissions()->pluck('name')->toArray();
    }

    public static function formatDate($date, $style = 1, $format = 'd/m/Y')
    {
        if ($style == 2) {
            $format = 'H:i, d/m/Y';
        } elseif ($style == 3) {
            $format = 'H:i';
        }
        return $date ? Carbon::parse($date)->format($format) : '';
    }

    public static function formatPrice($price, $unit = '', $k = false): ?string
    {
        if ($unit) {
            $unit = "<sup>$unit</sup>";
        }
        if (!$price) {
            return null;
        }
        if ($k && $price > 1e6) {
            $unit  = $unit ? 'k ' . $unit : 'k';
            $price = $price / 1000;
        }

        $result = null;
        if (!empty($price)) $result = number_format($price) . $unit;

        return $result;
    }

    public static function settingView($name, $default = 20, $style = '', $items = [10, 20, 50, 100, 500])
    {
        $item_default = self::getPerPage($name, $default);
        return view('Admin.snippets.per-page', compact('items', 'item_default', 'name', 'style'))->render();
    }

    public static function getPerPage($name, $default = 20)
    {
        return Cookie::get($name, $default);
    }

    public static function getImagePath($imagePath): string
    {
        return Storage::exists('public/' . $imagePath) ? asset('storage/' . $imagePath) : asset('images/default_image.jpg');
    }

    public static function arrayToAttribute(array $attributes): string
    {
        $output = '';
        foreach ($attributes as $key => $value) {
            $output .= $key . '="' . $value . '" ';
        }
        return $output;
    }

    public static function getExcelNameFromNumber($num)
    {
        $numeric = $num % 26;
        $letter  = chr(65 + $numeric);
        $num2    = intval($num / 26);
        if ($num2 > 0) {
            return self::getExcelNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }

    public static function getSql($query): string
    {
        $bindings = collect($query->getBindings())->map(function ($item) {
            if (!is_numeric($item) && is_string($item)) {
                $item = "'" . $item . "'";
            }
            return $item;
        })->toArray();
        return Str::replaceArray('?', $bindings, $query->toSql());
    }

    static function explodeDateRange($str)
    {
        $arr = explode('to', $str);
        $arr = array_map('trim', $arr);

        return array_map(function ($date) {
            if ($date) {
                $obj = Carbon::parse($date);
                if ($obj->year == 1970) {
                    return null;
                }
            }
            return $date;
        }, [
            'from' => $arr[0] ?? null,
            'to'   => $arr[1] ?? null,
        ]);
    }
    
    public static function getCategoies() {
        return Category::query()->get();
    }

    static function setSEO($objectSEO)
    {
        $args = [
            'title'         => $objectSEO->name ?? env('APP_NAME') ?? '',
            'description'   => $objectSEO->description ?? '',
            'keywords'      => $objectSEO->keywords ?? '',
            'no_index'      => $objectSEO->no_index,
            'type'          => $objectSEO->meta_type ?? 'website',
            'url_canonical' => $objectSEO->url_canonical ?? route('home'),
            'image'         => $objectSEO->image,
            'site_name'     => $objectSEO->site_name ?? '',
        ];

        OpenGraph::addProperty('locale', 'vi_VN');
        OpenGraph::addProperty('type', $args['type']);
        JsonLdMulti::setType($args['type']);
        TwitterCard::setType('summary');

        if ($args['site_name']) {
            OpenGraph::setSiteName($args['site_name']);
            TwitterCard::addValue('domain', $args['site_name']);
        }
        if ($args['title']) {
            SEOTools::setTitle($args['title']);
        }
        if ($args['description']) {
            SEOTools::setDescription($args['description']);
        }
        if ($args['keywords']) {
            SEOMeta::setKeywords($args['keywords']);
        }
        if ($args['url_canonical']) {
            SEOTools::setCanonical($args['url_canonical']);
        }
        if ($args['image']) {
            SEOTools::addImages($args['image']);
        }

        if (!empty($objectSEO->article)) {
            foreach ($objectSEO->article as $_key => $_value) {
                SEOMeta::addMeta('article:' . $_key, $_value, 'property');
            }
        }

        if (config('app.env') == 'local') {
            SEOMeta::setRobots('noindex,nofollow');
        } else {
            SEOMeta::setRobots($args['no_index'] ? 'noindex,nofollow' : 'index,follow');
        }
    }

    static function getSetting() {
        $setting = Setting::query()->first();
        return $setting;
    }
}
