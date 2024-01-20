<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class BasePageController extends Controller
{
    public function action(Request $request)
    {
        $domain = $request->getHost();

        if (request()->path() == 'products') {
            $controller = "ProductController";
        } else {
            $controller = "HomeController";
        }

        $controllerName = "\App\Http\Controllers\Frontend\\$controller";

        return $controllerName::index($request);
    }
}
