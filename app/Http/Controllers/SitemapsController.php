<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Watson\Sitemap\Facades\Sitemap;

class SitemapsController extends Controller
{
    public function post()
    {
        $post = Post::where("status", "Published")->get();

        foreach ($post as $article) {
            $tag = Sitemap::addTag(url($article->slug), $article->updated_at, 'daily', '0.8');

            foreach ($article->attachments as $image) {
                $tag->addImage(url('img/article/content/'.$image->attachment_url), $image->alt);
            }
        }

        return Sitemap::render();
    }

    public function pages()
    {
        
    }
}
