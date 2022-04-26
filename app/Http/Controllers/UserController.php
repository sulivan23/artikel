<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Followers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function index()
    {
        if(auth()->user()->role->role_name == "ADMIN"){
            $data = User::all();
        }else{
            $data = User::where('id', auth()->user()->id)->get();
        }
        return view('panel.show.user', compact('data'));
    }

    public function profile()
    {
        $followers = Followers::where('follower_user_id', auth()->user()->id)->count();
        $following = Followers::where('user_id', auth()->user()->id)->count();
        return view('panel.show.profile', compact('followers', 'following'));
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'name'  => 'string|required',
            'role'  => 'required',
            'email' => 'email|required'
        ]);
        if($validate->fails()){
            return redirect()
            ->back()
            ->withErrors($validate);
        }else{
            $user = User::where('id', $id);
            if($request->email !== $user->first()->email){
                $cekEmailHasUsed = User::where('email', $request->email);
                if($cekEmailHasUsed->count() > 0){      
                    return redirect()
                    ->back()
                    ->withErrors(['Email sudah digunakan']);
                }
            }else{
                $file = $request->file('file');
                $update = true;
                $photo = $user->first()->photo;
                $new_password = $user->first()->password;
                if($file !== null){
                    $size = $file->getSize();
                    $name = $file->getClientOriginalName();
                    $ext = $file->getClientOriginalExtension();
                    if($ext == "jpg" || $ext == "png" || $ext == "jpeg"){
                        if($size <= 1024000){
                            $path = "img/src/".$user->first()->photo;
                            File::delete(public_path().'/img/user/'.$user->first()->photo);
                            $update = true;
                            $file->move("img/user", $name);
                            $photo = $name;
                        }else{
                            $update = false;
                            return redirect()
                            ->back()
                            ->withErrors(['Size photo maks 1MB']);
                        }
                    }else{
                        $update = false;
                        return redirect()
                        ->back()
                        ->withErrors(['Extension photo yang diperbolehkan hanya : jpg, png']);
                    }
                }
                if($request->password !== "" || $request->old_password !== ""){
                    if(Hash::check($request->old_password, $user->first()->password) == true){
                        if($request->password == $request->confirm_password && $request->password !== ""){
                            $new_password = Hash::make($request->password);
                        }else{
                            $update = false;
                            return redirect()
                            ->back()
                            ->withErrors(['Password yang anda masukan tidak sama']);
                        }
                    }else{
                        $update = false;
                        return redirect()
                        ->back()
                        ->withErrors(['Password lama yang anda masukan tidak sesuai']);
                    }
                }
                if($update == true){
                    $data = array(
                        'name'          => $request->name,
                        'roles'         => $request->role,
                        'email'         => $request->email,
                        'jenis_kelamin' => $request->jenkel,
                        'nickname'      => $request->nickname,
                        'password'      => $new_password,
                        'photo'         => $photo
                    );
                    $user->update($data);
                    return redirect(url('home/user'))
                    ->with('success', 'User berhasil diupdate');
                }
            }
        }
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        if(User::where('id', $id)->count() == 0){
            return redirect(url('home/user'));
        }
        return view('panel.update.user', compact('data'));
    }

    public function destroy($id)
    {
        $data = User::where('id', $id);
        if($data->first()->role->role_name == "ADMIN"){
            return redirect()
            ->back()
            ->withErrors(['Administrator tidak bisa dihapus']);
        }else{
            if(auth()->user()->role->role_name == "USER"){
                return redirect()
                ->back()
                ->withErrors(['Anda tidak punya akses untuk menghapus akun']);
            }else{
                $article = Article::where('author_id', $id);
                if($article->count() > 0){
                    return redirect()
                    ->back()
                    ->withErrors(['User tidak bisa dihapus karena sudah post artikel']);
                }else{
                    $data->delete();
                    return redirect(url('home/user'))
                    ->with('success', 'User berhasil dihapus');
                }
            }
        }
    }
}
