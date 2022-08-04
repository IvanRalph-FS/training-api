<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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
        \Log::debug($this->request->all());

        return [
            'article_category_id' => [
                'required',
                'exists:article_category,id'
            ],
            'title' => [
                'required',
                'max:255',
                'string'
            ],
            'slug' => [
                'required',
                'max:255',
                'string'
            ],
            'contents' => [
                'required'
            ],
            'image' => [
                'required',
                'mimes:jpeg,png,jpg,gif'
            ],
        ];
    }
}
