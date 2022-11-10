<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::inRandomOrder()->first();
        return new ArticleResource($article);
    }

    public function saying()
    {
        $article = Article::where('type', 'saying')->inRandomOrder()->first();
        return new ArticleResource($article);
    }

    public function joke()
    {
        $article = Article::where('type', 'joke')->inRandomOrder()->first();
        return new ArticleResource($article);
    }
}
