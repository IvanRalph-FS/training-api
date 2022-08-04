<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'article_category_id' => [
                'nullable',
                'exists:article_category,id'
            ],
            'title' => [
                'nullable',
                'max:255',
                'string'
            ],
            'slug' => [
                'nullable',
                'max:255',
                'string'
            ],
            'contents' => [
                'nullable'
            ],
            'image' => [
                'nullable',
                'mimes:jpeg,png,jpg,gif'
            ],
        ];
    }
}
