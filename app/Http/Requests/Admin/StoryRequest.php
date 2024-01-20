<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Helper;

class StoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Helper::userCan('them_story_data') || Helper::userCan('sua_story_data');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'author_id' => 'required',
            'desc' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên truyện',
            'author_id' => 'tác giả',
            'desc' => 'mô tả',
        ];
    }
}
