<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class CreateEditUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Helper::userCan('them_nguoi_dung') || Helper::userCan('sua_nguoi_dung');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ?: 0;
        return [
            'email'   => ['required', 'email', 'unique:users,email' . ($userId ? ',' . $userId : '')],
            'role_id' => ['required', 'numeric'],
            'status'  => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'role_id' => 'vai trò',
            'status'  => 'trạng thái',
        ];
    }
}
