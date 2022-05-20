<?php

namespace App\Http\Controllers;

use App\Jobs\PostMail;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\ArticleAttachments;
use App\Models\Comments;

class PostController extends Controller
{
    public function index()
    {
        if(auth()->user()->role->role_name == "ADMIN"){
            $data = Post::all();
        }else{
            $data = Post::where('author_id', auth()->user()->id)->get();
        }
        return view('panel.show.post', compact('data'));
    }

    public function editPost($postid)
    {
        $allCategory = ArticleCategory::all();
        $post = Post::where('article_id', $postid)->first();
        return view("panel.update.post", compact('allCategory','post'));
    }

    public function createPost()
    {
        $allCategory = ArticleCategory::all();
        return view('panel.create.post', compact('allCategory'));
    }

    public function savePost(Request $request)
    {
        $arrReturn = [];
        if($request->button == "save" || $request->button == "draft"){
            $validate = Validator::make($request->all(),[
                'title'     => 'required|min:5',
                'walpaper'  => 'mimes:jpeg,jpg,png|required|max:1024',
                'category'  => 'required',
                'tags'      => 'required',
                'content'   => 'required'
            ],[
                'title.required' => 'Judul artikel harus di isi',
                'walpaper.required' => 'Walpaper harus di isi',
                'category.required' => 'Kategori harus dipilih',
                'tags.required'     => 'Tag artikel harus di isi',
                'content.required'  => 'Konten artikel harus di isi',
                'title.min' => 'Judul artikel minimal 5 karakter',
                'walpaper.mimes' => 'Walpaper yang diupload harus gambar (jpg, jpeg, png)',
                'walpaper.max'  => 'Walpaper yang diupload maksimal 1MB'
            ]);
            if($validate->fails()){
                $arrReturn = array(
                    'error'         => true,
                    'message'       => $validate->errors(),
                    'validate_error'=> true  
                );
             }else{
                $content = $request->content;
                $dom = new \DomDocument;
                $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | libxml_use_internal_errors(true));
                $imageFile = $dom->getElementsByTagName('img');
                foreach($imageFile as $item => $image){
                    $data = $image->getAttribute('src');
                    $alt = $image->getAttribute('alt');
                    $title = $image->getAttribute('title');
                    $caption = $image->getAttribute('caption');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $imgeData = base64_decode($data);
                    $image_name= time().$item.'.png';
                    $path = '/img/article/content/'.$image_name;
                    file_put_contents($path, $imgeData);
                    $image->removeAttribute('src');
                    $image->setAttribute('src', url('img/article/content/'.$image_name));
                    $attachments = [
                        'article_id'        => lastId('article'),
                        'attachment_url'    => $image_name,
                        'attachment_type'   => 'Image',
                        'attachment_size'   => 0,
                        'title'             => $title,
                        'alt'               => $alt,
                        'caption'           => $caption,
                        'created_at'        => \Carbon\Carbon::now(),
                        'updated_at'        => \Carbon\Carbon::now()
                    ];
                    ArticleAttachments::create($attachments);
                }
                $content = $dom->saveHTML();
                $walpaper = $request->file('walpaper');
                $walpaper->move('img/article/walpaper/',$walpaper->getClientOriginalName());
                $slug = str_replace(" ","-",$request->title);
                if($request->slug !== null){
                    $slug = $request->slug;
                }
                $cekSlug = Post::where("slug", $slug);
                if($cekSlug->count() == 0) {
                    $data = [
                        'article_id'   => lastId('article'),
                        'judul_artikel'=> $request->title,
                        'category_id'  => $request->category,
                        'author_id'    => $request->user_id,
                        'tags'         => $request->tags,
                        'walpaper'     => $walpaper->getClientOriginalName(),
                        'content'      => $content,
                        'views_count'  => 0,
                        'likes_count'  => 0,
                        'status'       => $request->button == "save" ? "Need Verified" : "Draft",
                        'slug'         => $slug,
                        'publish_date' => $request->publish_date,
                        'created_at'   => \Carbon\Carbon::now(),
                        'updated_at'   => \Carbon\Carbon::now(),
                    ];
                    Post::create($data);
                    $status = $request->button == "save" ? "Artikel berhasil dipublish dan saat ini statusnya menunggu verifikasi admin" : "Artikel berhasil disimpan dan sudah dijadikan draft";
                    $arrReturn = array(
                        'error'      => false,
                        'message'    => $status,
                        'validate_error'=> false  
                    );
                }else{
                    //  return redirect()
                    //  ->back()
                    //  ->withErrors(['Slug sudah tidak bisa dipakai, silahkan ganti'])
                    //  ->withInput();
                    $arrReturn = array(
                        'error'      => true,
                        'message'    => 'Slug sudah tidak bisa dipakai, silahkan ganti',
                        'validate_error'=> false
                    );
                }
            }
        }
        return response()->json($arrReturn);
    }

    public function updatePost($id, Request $request)
    {
        $arrReturn = [];
        if($request->button == "update" || $request->button == "draftupdate" || $request->button == "approve"){
            $validate = Validator::make($request->all(),[
                'title'     => 'required|min:5',
                //'walpaper'  => 'mimes:jpeg,jpg,png,gif|required|max:1024',
                'category'  => 'required',
                'tags'      => 'required',
                'content'   => 'required'
            ],[
                'title.required' => 'Judul artikel harus di isi',
                // 'walpaper.required' => 'Walpaper harus di isi',
                'category.required' => 'Kategori harus dipilih',
                'tags.required'     => 'Tag artikel harus di isi',
                'content.required'  => 'Konten artikel harus di isi',
                'title.min' => 'Judul artikel minimal 5 karakter',
                'walpaper.mimes' => 'Walpaper yang diupload harus gambar (jpg, jpeg, png)',
                'walpaper.max'  => 'Walpaper yang diupload maksimal 1MB'
            ]);
            if($validate->fails()){
                $arrReturn = array(
                    'error'         => true,
                    'message'       => $validate->errors(),
                    'validate_error'=> true  
                );
             }else{
                $post = Post::where('article_id', $id)->first();
                $content = $request->content;
                $attachment = ArticleAttachments::where("article_id", $id)->get();
                $dom = new \DomDocument;
                $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | libxml_use_internal_errors(true));
                $imageFile = $dom->getElementsByTagName('img');
                ArticleAttachments::where('article_id', $post->article_id)->delete();
                foreach($imageFile as $item => $image){
                    $data = $image->getAttribute('src');
                    $alt = $image->getAttribute('alt');
                    $title = $image->getAttribute('title');
                    $caption = '';
                    if(strpos($data,';') == true){
                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $imgeData = base64_decode($data); 
                    }else{
                        $img = str_replace(url("")."/","", $data);
                        $imgeData = file_get_contents($img);
                        if(file_exists($img)){
                            unlink($img);
                        }
                    }
                    $image_name = time().$item.'.png';
                    $path = public_path().'/img/article/content/'.'aww.txt';   
                    file_put_contents($path, "Some text here");
                    $image->removeAttribute('src');
                    $image->setAttribute('src', url('img/article/content/'.$image_name));
                    $attachments = [
                        'article_id'        => $id,
                        'attachment_url'    => $image_name,
                        'attachment_type'   => 'Image',
                        'attachment_size'   => 0,
                        'title'             => $title,
                        'alt'               => $alt,
                        'caption'           => $caption,
                        'created_at'        => \Carbon\Carbon::now(),
                        'updated_at'        => \Carbon\Carbon::now()
                    ];
                    ArticleAttachments::create($attachments);
                }
                $content = $dom->saveHTML();
                $walpaper = $request->file('walpaper');
                $gambar = $post->walpaper;
                if($walpaper !== null){
                    unlink("img/article/walpaper/".$post->walpaper);
                    $walpaper->move('img/article/walpaper/',$walpaper->getClientOriginalName());
                    $gambar = $walpaper->getClientOriginalName();
                }
                $slug = str_replace(" ","-",$request->title);
                if($request->slug !== null){
                    $slug = $request->slug;
                }
                $cekSlug = Post::where("slug", $slug)->where('article_id','<>',$id);
                if($cekSlug->count() == 0) {
                    $status = "";
                    switch($request->button){
                        case "update" :
                            $status = "Need Verified";
                            $message = "Artikel berhasil diupdate dan saat ini statusnya menunggu verifikasi admin";
                        break;
                        case "draftupdate" :
                            $status = "Draft";
                            $message = "Artikel berhasil diupdate dan sudah dijadikan draft";
                        break;
                        case "approve" :
                            $status = "Published";
                            $message = "Artikel telah di approve dan saat ini statusnya published";
                        break;
                    }
                    $data = [
                        'judul_artikel'=> $request->title,
                        'category_id'  => $request->category,
                        // 'author_id'    => $request->user_id,
                        'tags'         => $request->tags,
                        'walpaper'     => $gambar,
                        'content'      => $content,
                        'views_count'  => 0,
                        'likes_count'  => 0,
                        'status'       => $status,
                        'slug'         => $slug,
                        'publish_date' => $request->publish_date,
                        //'created_at'   => \Carbon\Carbon::now(),
                        'updated_at'   => \Carbon\Carbon::now(),
                    ];
                    Post::where("article_id", $id)->update($data);
                    $arrReturn = array(
                        'error'      => false,
                        'message'    => $message,
                        'validate_error'=> false  
                    );
                }else{
                    //  return redirect()
                    //  ->back()
                    //  ->withErrors(['Slug sudah tidak bisa dipakai, silahkan ganti'])
                    //  ->withInput();
                    $arrReturn = array(
                        'error'      => true,
                        'message'    => 'Slug sudah tidak bisa dipakai, silahkan ganti',
                        'validate_error'=> false
                    );
                }
            }
        }
        else{
            $status = "";
            if($request->button == "unpublish"){
                $status = "Need Verified";
                $message = "Unpublish";
            }else{
                $status = "Rejected";
                $message = "Reject";
            }
            Post::where("article_id", $id)->update(['status' => $status]);
            $arrReturn = array(
                'error'      => false,
                'message'    => 'Artikel telah di '.$message.'',
                'validate_error'=> false
            );
        }
        $postan = Post::where("article_id", $id)->first();
        $detailEmails = [
            'name'      => $postan->user->name,
            'judul'     => $postan->judul_artikel,
            'status'    => $request->button,
            'email'     => $postan->user->email,
            'walpaper'  => $postan->walpaper,
        ];
        if($request->button == 'approve'){
            $detailEmails['message'] = 'Selamat! saat ini artikel kamu sudah disetujui oleh administrator dan kini telah tayang';
        }
        else if($request->button == 'unpublish'){
            $detailEmails['message'] = 'Artikel telah di unpublish dan saat ini menunggu verifikasi administrator';
        }
        else if($request->button == 'reject'){
            $detailEmails['message'] = 'Mohon maaf :( artikel kamu statusnya ditolak';
        }
        if($request->button == 'approve' || $request->button == 'unpublish' || $request->button == 'reject'){
            PostMail::dispatch($detailEmails);
        }
        return response()->json($arrReturn);
    }

    public function deletePost($id, Request $request)
    {
        if($request->delete == "delete"){
            $post = Post::where('article_id', $id);
            if($post->count() > 0){
                $data = $post->first();
                $attachment = ArticleAttachments::where('article_id', $data->article_id);
                unlink("img/article/walpaper/". $data->walpaper);
                foreach($attachment->get() as $att){
                    unlink("img/article/content/".$att->attachment_url);
                }
                ArticleAttachments::where("article_id",$data->article_id)->delete();
                $post->delete();
                Comments::where('article_id', $id)->delete();
                Likes::where('article_id', $id)->delete();
                return redirect(url('home/post'))->with('success', 'Artikel berhasil dihapus');
            }else{
                return redirect()
                ->back()
                ->withErrors(['Artikel tidak ditemukan']);
            }
        }else{
            return redirect()
            ->back()
            ->withErrors(['Something has errors']);
        }
    }

    public function verifikasi()
    {
        $data = Post::where("status", "Need Verified")->get();
        return view('panel.show.verifikasi', compact('data'));
    }


    public function showPost()
    {

    }
}
