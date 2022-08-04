<?php

namespace App\Http\Controllers\Api\ArticleCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCategory\ArticleCategoryStoreRequest;
use App\Http\Resources\ArticleCategory\ArticleCategoryResource;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ArticleCategoryResource::collection(ArticleCategory::paginate(10));
    }

    public function listAll()
    {
        return ArticleCategoryResource::collection(ArticleCategory::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleCategoryStoreRequest $request)
    {
        $category = ArticleCategory::create([
            'name' => $request->name,
            'updated_user_id' => auth()->user()->id
        ]);

        return response()->json([
            'data' => ArticleCategoryResource::make($category)
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
        $category = ArticleCategoryResource::make(ArticleCategory::find($id));

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleCategoryStoreRequest $request, $id)
    {
        $articleCategory = ArticleCategory::find($id)->update($request->validated());

        return response()->json($articleCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        ArticleCategory::find($id)->delete();

        return response()->json();
    }
}
