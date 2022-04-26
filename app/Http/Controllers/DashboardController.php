<?php

namespace App\Http\Controllers;

use App\Console\Commands\AcceptPost;
use App\Models\Comments;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    //

    public function index()
    {
        if(auth()->user()->role->role_name == "ADMIN"){
            $totalPost = Post::select('*')->count();
            $totalLike = Post::sum('likes_count');
            $totalKomen = Comments::select("*")->count();
            $totalPv = Post::sum('views_count');
        }else{
            $id = auth()->user()->id;
            $totalPost = Post::select('*')->where('author_id', $id)->count();
            $totalLike = Post::where('author_id', $id)->sum('likes_count');
            $totalKomen = Comments::whereExists(function($query) use($id){
                $query->selectRaw(1)
                ->from('tb_article')
                ->where('author_id', $id);
            })->count();
            $totalPv = Post::where('author_id', $id)->sum('views_count');
        }
        return view('panel.index', compact('totalPost', 'totalLike', 'totalKomen', 'totalPv'));
    }

    public function settings()
    {
        $data = DB::table('settings')->get();
        return view('panel.show.settings', compact('data'));
    }

    public function editSettings($id)
    {
        $data = DB::table('settings')->where('settings_id', $id)->first();
        return view('panel.update.settings', compact('data'));
    }

    public function updateSettings($id, Request $request)
    {
        $data = DB::table('settings')->where('settings_id', $id)->first();
        if($data->settings_key == "FAVICON" || $data->settings_key == "LOGO"){
            $validate = Validator::make($request->all(), [
                'file'  => 'mimes:jpeg,jpg,png,ico|required|max:1024'
            ],[
                'file.required' => 'File harus di isi'
            ]);
            if(!$validate->fails()){
                $file = $request->file('file');
                $file_name = $file->getClientOriginalName();
                $oldDataPath = 'img/web/'.$data->settings_value; 
                if(file_exists($oldDataPath)){
                    unlink($oldDataPath);
                }
                $file->move('img/web/',$file_name);
                DB::table('settings')->where('settings_id', $id)->update([
                    'settings_value'    => $file_name,
                    'updated_at'        => \Carbon\Carbon::now()
                ]);
                return redirect(url('home/settings'))->with('success', 'Settings berhasil diupdate');
            }else{
                return redirect()->back()->withErrors($validate)->withInput();
            }
        }else{
            $validate = Validator::make($request->all(), [
                'settings_value'  => 'required'
            ],[
                'settings_value.required' => 'Value harus di isi'
            ]);
            if(!$validate->fails()){
                DB::table('settings')->where('settings_id', $id)->update([
                    'settings_value'    => $request->settings_value,
                    'updated_at'        => \Carbon\Carbon::now()
                ]);
                return redirect(url('home/settings'))->with('success', 'Settings berhasil diupdate');
            }else{
                return redirect()->back()->withErrors($validate)->withInput();
            }
        }
    }


}
