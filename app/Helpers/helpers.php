<?php

use App\Models\ArticleCategory;
use Illuminate\support\Facades\DB;

function getModul()
{
    return DB::table("v_list_role_url")
    ->where("role_id", auth()->user()->roles)
    ->where("jenis","Modul");
}

function lastId($key)
{
    switch($key)
    {
        case 'article' :
            $data =  DB::table('tb_article')->selectRaw('max(article_id) AS id')->get()->first();
            $maxid = $data->id + 1;
        break;

        case 'comment'  :
            $data =  DB::table('tb_comments')->selectRaw('max(comment_id) AS id')->get()->first();
            $maxid = $data->id + 1;
        break;

        case 'followers' :
            $data =  DB::table('tb_followers')->selectRaw('max(followers_id) AS id')->get()->first();
            $maxid = $data->id + 1;
        break;

        case 'likes' :
            $data =  DB::table('tb_likes_article')->selectRaw('max(likes_id) AS id')->get()->first();
            $maxid = $data->id + 1;
        break;

            
    }
    return $maxid;
}

function webInfo($key)
{
   $data= DB::table('settings')->where('settings_key', $key)->first();
   return $data->settings_value;
}

function category($lvl)
{
    return ArticleCategory::where('level', $lvl)->get();
}

function categoryByParent($id)
{
    return ArticleCategory::where('parent_category_id', $id);
}