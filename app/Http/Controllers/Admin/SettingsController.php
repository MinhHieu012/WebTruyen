<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(
     
    ) {
        $this->middleware('can:xem_display_data')->only('index');
        $this->middleware('can:sua_display_data')->only('update');
    }

    public function index(Request $request) {
        $setting = Setting::query()->first();

        return view('Admin.pages.settings.index', [
            'setting' => $setting
        ]);
    }

    public function update(Request $request) {
        $setting = Setting::query()->first();
        if (!$setting) {
            $setting = new Setting();
        }
        
        $setting->title = $request->input('title');
        $setting->description = $request->input('description');
        $setting->index = $request->input('index');
        $setting->header_script = $request->input('header_script');
        $setting->body_script = $request->input('body_script');
        $setting->footer_script = $request->input('footer_script');

        $setting->save();

        return back()->with('success', 'Cập nhật thành công');
    }
}
