<?php

namespace App\Http\Middleware;

use App\Models\Comments;
use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $url = url()->current();
        $getUrl = explode('/',$url);
        $check = isset($getUrl[4]) == true ? "/". $getUrl[4] : '';
        $post = Post::all();
        $comment = Comments::all();
        $newUrl = $getUrl[3].$check;
        $role = DB::table("v_list_role_url")
        ->where("role_id", auth()->user()->roles)
        ->where("role_url", $newUrl);
        $except = [
            'home/createpost',
            'home/savepost',
            'home/user',
        ];
        foreach($post as $posts){
            array_push($except, 'komen_artikel/'.$posts->article_id);
            array_push($except, 'actionpost/'.$posts->article_id);
        }

        foreach($comment as $comments){
            array_push($except, 'reply_komen/'.$comments->comment_id);
        }

        if($role->count() == 0 && !in_array($newUrl, $except)){
            echo '<script> alert("Anda tidak mempunyai memiliki akses ke halaman ini"); history.back(); </script>';
        }
        return $next($request);
    }
}
