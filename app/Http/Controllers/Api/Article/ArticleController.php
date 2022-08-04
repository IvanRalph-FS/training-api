<?php

namespace App\Http\Controllers\Api\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleStoreRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use App\Services\FileService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ArticleResource::collection(Article::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleStoreRequest $request, FileService $fileService)
    {
        $imagePath = $fileService->storeFile($request->file('image'), 'images');

        $article = Article::create([
            'article_category_id' => $request->article_category_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'contents' => $request->contents,
            'image_path' => $imagePath,
            'updated_user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'data' => new ArticleResource($article)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $article = ArticleResource::make(Article::find($id));

        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleUpdateRequest $request, $id, FileService $fileService)
    {
        $data = $request->validated();

        if ($request->has('image')) {
            $imagePath = $fileService->storeFile($request->file('image'), 'images');

            $data['image_path'] = $imagePath;
        }

        $article = Article::find($id)->update($data);

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Article::find($id)->delete();

        return response()->json();
    }
}
