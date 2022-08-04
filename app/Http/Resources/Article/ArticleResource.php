<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_category' => $this->article_category,
            'article_category_id' => $this->article_category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'contents' => $this->contents,
            'image_path' => $this->image_path,
            'updated_user' => $this->updated_user
        ];
    }
}
