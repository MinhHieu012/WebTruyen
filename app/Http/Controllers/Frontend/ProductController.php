<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class ProductController extends Controller implements ControllerInterface
{
    public static function index(Request $request)
    {
        dd($request->all(), 'Product controller function index');
    }
}
