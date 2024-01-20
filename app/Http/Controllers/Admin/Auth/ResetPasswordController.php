<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Admin\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'string', 'min:8',
                function ($attribute, $value, $fail) {
                    $value = (string)$value;
                    if (!preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/u', $value)) {
                        $fail('Mật khẩu phải chứa ít nhất một chữ hoa và một chữ thường.');
                    } elseif (!preg_match('/\pN/u', $value)) {
                        $fail('Mật khẩu phải chứa ít nhất một số.');
                    }
//                    elseif (!Container::getInstance()->make(UncompromisedVerifier::class)->verify([
//                        'value'     => $value,
//                        'threshold' => 0,
//                    ])) {
//                        $fail('Mật khẩu bạn cung cấp đã bị rò rỉ dữ liệu. Vui lòng chọn một mật khẩu khác.');
//                    }
                }],
        ]);

        $password          = $request->input('password');
        $user              = Helper::currentUser();
        $user->password    = Hash::make($password);
        $user->change_pass = 0;
        $user->setRememberToken(Str::random(60));
        $user->update();

        Auth::guard()->login($user);

        return redirect(route('admin.dashboard.index'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $user = \auth()->user();
        return view('auth.edit', [
            'default_values' => $user
        ]);
    }

    public function update(Request $request, UserService $service)
    {
        $validatePassWord = [
            'password' => ['confirmed', 'string', 'min:8',
                function ($attribute, $value, $fail) {
                    $value = (string)$value;
                    if (!preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/u', $value)) {
                        $fail('Mật khẩu phải chứa ít nhất một chữ hoa và một chữ thường.');
                    } elseif (!preg_match('/\pN/u', $value)) {
                        $fail('Mật khẩu phải chứa ít nhất một số.');
                    }
                }],
        ];

        $validate = [
            'email' => ['required', 'unique:users,email,' . \auth()->user()->getAuthIdentifier()],
            'username' => ['required', 'string'],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
        ];

        if ($request->password) {
            $validate = array_merge($validate, $validatePassWord);
        }
        $data = $request->validate($validate);
        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = Helper::currentUser();
        $user->update($data);
        Auth::guard()->login($user);

        return redirect(route('admin.tdv.dashboard'))
            ->with('successMessage', 'Thay đổi thành công.');
    }
}
