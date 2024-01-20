<?php

namespace App\Http\Middleware\Admin;

use App\Helpers\Helper;
use App\Models\User;
use Closure;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View;


class AutoBreamcrum
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        $user = Helper::currentUser();

//        $roleName = @$user->roles[0]->name;
//        if ($roleName == User::ROLE_TDV || $roleName == User::ROLE_MARKETING_LOCAL) {
//            $menuData = [config('menu_tdv')];
//        } else if ($roleName == User::ROLE_THIEN_DIEU) {
//            $menuData = config('menu_thien_dieu');
//        } else {
            $menuData = config('menu.default');
//        }

        $currentPath      = $request->getPathInfo();
        $currentRouteName = $request->route()->getName();

        $childRoute = [];
        $dataMenu   = $this->getMenu($menuData, $currentRouteName, $childRoute);

        if ($dataMenu && isset($dataMenu["parents"])) {
            $_currentMenuName  = $dataMenu["name"];
            $_currentRouteName = $dataMenu["route"];
            $_parents          = $dataMenu["parents"];

            if ($currentPath != "/" && $currentPath != "" && $currentPath != "/tdv") {
                Breadcrumbs::for('main', function ($trail) use ($_parents, $_currentMenuName, $_currentRouteName, $currentRouteName) {
                    $trail->parent('home');
                    foreach ($_parents as $_menu) {
                        $menuText   = $_menu["name"];
                        $_routeName = $_menu["route"];
                        ($_routeName) ? $trail->push($menuText, route($_routeName)) : $trail->push($menuText);
                    }
                    ($_currentRouteName) ? $trail->push($_currentMenuName, $_currentRouteName) : $trail->push($_currentMenuName);
                });
            }

            View::share('titlePage', $_currentMenuName);
        }

        return $next($request);
    }

    function getMenu($menuData, $routeName, $parentdRoute)
    {
        foreach ($menuData as $_menu) {
            if (isset($_menu["route"]) && $_menu["route"] == $routeName) {
                $_menu["parents"] = $parentdRoute;
                return $_menu;
            }
            if (isset($_menu["child"])) {
                if (!isset($_menu["name"])) continue;

                $_child = $_menu["child"];

                $parentName = $_menu["name"];
                $_parent    = [
                    "name"  => $parentName,
                    "route" => @$_menu["route"]
                ];

                //$parentdRoute[$parentName] = $_parent;

                $menu = $this->getMenu($_child, $routeName, $parentdRoute);
                if ($menu) {
                    if ($parentName)
                        $parentdRoute[$parentName] = $_parent;
                    $menu = $this->getMenu($_child, $routeName, $parentdRoute);
                    return $menu;
                }
            }
        }
        return false;
    }
}
