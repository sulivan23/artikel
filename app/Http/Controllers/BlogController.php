<?php

namespace App\Http\Controllers;

use App\Jobs\Follow;
use App\Jobs\KomenMail;
use App\Mail\SendTestEmail;
use App\Models\Comments;
use App\Models\Followers;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    //

    protected $data, $category, $recentPost, $tags;

    public function __construct()
    {
        $this->data = Post::where('status','Published')->orderByDesc('publish_date');
        $this->category = DB::table('tb_article AS a')
        ->join('tb_article_category AS b','a.category_id','=','b.category_id')
        ->where('status','Published')
        ->selectRaw('b.category_name, COUNT(*) as jml')
        ->groupBy('b.category_name')
        ->get();
        $this->recentPost = $this->data->orderBy('views_count', 'desc')->limit(5) ->get();
        $arrTags = [];
        foreach($this->data->get() as $post){
            array_push($arrTags, $post->tags);
        }
        $this->tags = str_replace(' ','',implode(',', $arrTags));
    }

    public function landingPage(Request $request)
    {
        if($request->has('title')){
            $posts = $this->data->where('judul_artikel','like','%'.$request->get('title').'%')->paginate(6);
        }else{
            $posts = $this->data->paginate(6);
        }
        $data = [
            'category'  => $this->category,
            'posts'     => $posts,
            'tags'      => $this->tags,
            'recentPost'=> $this->recentPost,
            'title'     => $request->get('title'),
            'message'   => 'Menampilkan artikel dengan pencairan "'.$request->get('title').'"'
        ];
        return view('landing', $data);
    }

    public function getPostByCategory($category, Request $request)
    {
        if($request->has('title')){
            $posts = $this->data->where('judul_artikel','like','%'.$request->get('title').'%');
        }else{
            $posts = $this->data;
        }
        $posts = $posts->whereRelation('category','category_name', $category)->paginate(6);
        $data = [
            'category'  => $this->category,
            'message'   => 'Menampilkan artikel untuk kategori "'.$category.'"',
            'message2'  => 'Menampilkan artikel dengan pencairan "'.$request->get('title').'"',
            'posts'     => $posts,
            'tags'      => $this->tags,
            'title'     => $request->get('title'),
            'recentPost'=> $this->recentPost
        ];
        return view('postkategori', $data);
    }

    public function getPostByTag($tag, Request $request)
    {
        if($request->has('title')){
            $posts = $this->data->where('judul_artikel','like','%'.$request->get('title').'%');
        }else{
            $posts = $this->data;
        }
        $posts = $posts->where('tags', 'like','%'.$tag.'%')->paginate(6);
        $data = [
            'category'  => $this->category,
            'message'   => 'Menampilkan artikel dengan tag "'.$tag.'"',
            'message2'  => 'Menampilkan artikel dengan pencairan "'.$request->get('title').'"',
            'posts'     => $posts,
            'tags'      => $this->tags,
            'title'     => $request->get('title'),
            'recentPost'=> $this->recentPost
        ];
        return view('posttags', $data);
    }

    public function getPostBySlug($slug)
    {
        if($this->data->where('slug', $slug)->count() > 0){
            $posts = $this->data->where('slug', $slug)->first();
            $posttag = explode(',', $posts->tags);
            $comment = Comments::where('article_id', $posts->article_id)
            ->where('is_reply_comment','T')
            ->orderBy('created_at','desc')
            ->get();
            $replyComment = Comments::where('article_id', $posts->article_id)
            ->where('is_reply_comment','Y')
            ->orderBy('created_at','desc')
            ->get();
            $this->data->where('slug', $slug)->update(['views_count' => $posts->views_count + 1]);
            $countComment = Comments::where('article_id', $posts->article_id)->count();
        }
        $hasLike = 0;
        $hasFollow = 0;
        if(auth()->check()){
            $hasLike = Likes::where("user_id", auth()->user()->id)
            ->where("article_id",$posts->article_id)
            ->count();
            $hasFollow = Followers::where('user_id', auth()->user()->id)
            ->where('follower_user_id', $posts->author_id)
            ->count();
        }
        $data = [ 
            'category'      => $this->category,
            'posts'         => $posts ?? '',
            'tags'          => $this->tags,
            'recentPost'    => $this->recentPost,
            'postTags'      => $posttag ?? '',
            'comments'      => $comment ?? '',
            'replyComment'  => $replyComment ?? '',
            'countComment'  => $countComment ?? '',
            'countPost'     => $this->data->where('slug', $slug)->count(),
            'hasLike'       => $hasLike,
            'hasFollow'     => $hasFollow
        ];
        return view('single-post', $data);
    }

    public function komenArtikel($postid, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'comment'   => 'required|max:255|min:5'
        ],[
            'comment.required'  => 'Komentar tidak boleh kosong',
            'comment.max'       => 'Maksimal karakter untuk komentar adalah 255',
            'comment.min'       => 'Minimal karakter untuk komentar adalah 5'
        ]);
        if(!$validate->fails()){
            $data = [
                'comment_id'       => lastId('comment'),
                'comment_value'     => $request->comment,
                'user_id'           => auth()->user()->id,
                'article_id'        => $postid,
                'is_reply_comment'  => 'T',
                'reply_comment_id'  => null,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now()
            ];
            $post = Post::where('article_id', $postid)->first();
            if($post->author_id !== auth()->user()->id){
                $detailEmails = [
                    'name'      => $post->user->name,
                    'judul'     => $post->judul_artikel,
                    'status'    => 'komen',
                    'email'     => $post->user->email,
                    'walpaper'  => $post->walpaper,
                    'message'   => $post->user->name. ' mengomentari artikel anda "'. '<a target="_blank" href="'.url('/'.$post->slug).'">'.$request->comment.'</a>"'
                ];
                KomenMail::dispatch($detailEmails);
            }
            Comments::insert($data);
            return redirect(url()->previous().'#komentar')
            ->with('success', 'Komentar berhasil ditambahkan')
            ->withInput();
        }else{
            return redirect(url()->previous().'#komentar')
            ->withErrors($validate)
            ->withInput();
        }
    }

    public function replyKomen($commentid, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'reply'   => 'required|max:255|min:5'
        ],[
            'reply.required'  => 'Komentar tidak boleh kosong',
            'reply.max'       => 'Maksimal karakter untuk komentar adalah 255',
            'reply.min'       => 'Minimal karakter untuk komentar adalah 5'
        ]);
        $reply = Comments::where('comment_id', $commentid)->first();
        if(!$validate->fails()){
            $data = [
                'comment_id'       => lastId('comment'),
                'comment_value'    => $request->reply,
                'user_id'          => auth()->user()->id,
                'article_id'       => $reply->article_id,
                'is_reply_comment' => 'Y',
                'reply_comment_id' => $commentid,
                'created_at'       => \Carbon\Carbon::now(),
                'updated_at'       => \Carbon\Carbon::now()
            ];
            if($reply->user_id !== auth()->user()->id){
                $detailEmails = [
                    'name'      => $reply->user->name,
                    'judul'     => $reply->article->judul_artikel,
                    'status'    => 'reply',
                    'email'     => $reply->user->email,
                    'walpaper'  => $reply->walpaper,
                    'message'   => auth()->user()->name. ' membalas komentar anda "'. '<a target="_blank" href="'.url('/'.$reply->article->slug).'">'.$request->reply.'</a>"'
                ];
                KomenMail::dispatch($detailEmails);
            }
            Comments::insert($data);
            return redirect(url()->previous().'#komentar')
            ->with('success', 'Reply komentar berhasil ditambahkan');
        }else{
            return redirect(url()->previous().'#komentar')
            ->withErrors($validate);
        }
    }

    public function deleteKomen($commentid)
    {
        $comment = Comments::where("comment_id", $commentid);
        if($comment->count() > 0){
            if($comment->first()->is_reply_comment == "T"){
                Comments::where('reply_comment_id', $commentid)->delete();
            }
            $comment->delete();
            return redirect(url()->previous().'#komentar')
            ->with('success', 'Komentar berhasil dihapus');
        }else{
            return redirect(url()->previous().'#komentar')
            ->withErrors(['Komentar gagal dihapus']);
        }
    }

    public function getUser($userid)
    {
        $user  = User::where('id', $userid);
        if($user->count() == 0){
            return redirect(url(''));
        }
        $posts = Post::where('author_id', $user->first()->id);;
        $countFollowers = Followers::where('follower_user_id', $user->first()->id)->count();
        $hasLike = 0;
        $hasFollow = 0;
        if(auth()->check()){
            $hasFollow = Followers::where('user_id', auth()->user()->id)
            ->where('follower_user_id', $userid)
            ->count();
        }
        $data = [
            'posts'         => $posts->paginate(6),
            'category'      => $this->category,
            'tags'          => $this->tags,
            'recentPost'    => $this->recentPost,
            'message'       => 'Menampilkan artikel yang dibuat oleh '.$user->first()->name,
            'user'          => $user->first(),
            'countFollowers'=> $countFollowers,
            'countPost'     => $posts->count(),
            'hasLike'       => $hasLike,
            'hasFollow'     => $hasFollow
        ];
        return view('user', $data);
    }

    //from user variable untuk klik follow saat klik profile user
    public function actionPost($postid, $fromUser=false, Request $request)
    {
        $post = Post::where('article_id', $postid)->first();
        if($fromUser){
            $user = User::where('id', $fromUser)->first();
            $userId = $user->id;
            $name = $user->name;
            $email = $user->email;
            $img = $user->photo;
        }else{
            $userId = $post->author_id;
            $name = $post->user->name;
            $email = $post->user->email;
            $img = $post->user->photo;
        }
        if($request->has('follow')){
            $data = [
                'followers_id'      => lastId('followers'),
                'user_id'           => auth()->user()->id,
                'follower_user_id'  => $userId,
                'created_at'        => \Carbon\Carbon::now(),
                'updated_at'        => \Carbon\Carbon::now(),
            ];
            Followers::insert($data);
            $message = "Saat ini anda mengikuti ".$name;
            $messageMail = 'Mengikuti akun anda';
        }
        elseif($request->has('unfollow')){
            Followers::where('user_id', auth()->user()->id)
            ->where('follower_user_id', $userId)
            ->delete();
            $message = "Saat ini anda berhenti mengikuti ".$name;
            $messageMail = 'Berhenti mengikuti akun anda';
        }
        elseif($request->has('likepost')){
            $data = [
                'likes_id'      => lastId('likes'),
                'user_id'       => auth()->user()->id,
                'article_id'    => $postid,
                'liked_at'      => \Carbon\Carbon::now()
            ];
            Post::where('article_id', $postid)->update(['likes_count' => $post->likes_count + 1]);
            Likes::insert($data);
            $message = "Saat ini kamu menyukai artikel ".$post->judul_artikel;
        }
        elseif($request->has('unlikepost')){
            Likes::where("user_id", auth()->user()->id)
            ->where("article_id", $post->article_id)
            ->delete();
            Post::where('article_id', $postid)->update(['likes_count' => $post->likes_count - 1]);
            $message = "Saat ini kamu tidak menyukai artikel ".$post->judul;
        }
        if($request->has('follow') || $request->has('unfollow')){
            $detailEmails = [
                'name'      => $name,
                'judul'     => auth()->user()->name,
                'email'     => $email,
                'walpaper'  => $img,
                'message'   => $messageMail,
                'status'    => $request->has('follow') == true ? 'follow' : 'unfollow'
            ];
            Follow::dispatch($detailEmails);
        }
        if($fromUser){
            return redirect(url()->previous())->with('successaction', $message);
        }else{
            return redirect(url()->previous()."#info")->with('successaction', $message);
        }
    }

    public function tesEmail()
    {
        $details = [];
        Mail::to('sulistioirvan@gmail.com')
        ->bcc('irvansulis23@gmail.com')
        ->send(new SendTestEmail($details));
        dd('Email terkirim');
    }
}
