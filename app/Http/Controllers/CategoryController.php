<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ArticleCategory::all();
        return view('panel.show.category', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('panel.create.category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'category_name' => 'required|string|min:3',
            'level'         => 'required|integer',
        ]);
        if($validate->fails()){
            return redirect()->back()
            ->withErrors($validate)
            ->withInput();
        }else{
            if($request->level > 1 && $request->parent_category == ""){
                return redirect()
                ->back()
                ->withErrors(['Parent kategori harus dipilih'])
                ->withInput();
            }else{
                $category = new ArticleCategory;
                $category->category_name = $request->category_name;
                $category->level = $request->level;
                $category->parent_category_id = $request->parent_category;
                $category->save();
                return redirect(url('home/kategori'))
                ->with('success', "Kategori berhasil ditambahkan");
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ArticleCategory::where('category_id', $id)->first();
        $parentCategory = ArticleCategory::where("level", $data->level-1)->where("category_id", '!=',$id);
        return view('panel.update.category', compact('data','parentCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'category_name' => 'required|string',
            'level'         => 'required|integer',
        ]);
        if($validate->fails()){
            return redirect()
            ->back()
            ->withErrors($validate)
            ->withInput();
        }else{
            if($id !== $request->parent_category){
                $category = ArticleCategory::where('category_id', $id);
                if(ArticleCategory::where('parent_category_id', $id)->count() > 0){
                    return redirect()
                    ->back()
                    ->withErrors(['Tidak bisa update level karena sudah ada sub kategori'])
                    ->withInput();
                }else{
                    $data = array(
                        'category_name'     => $request->category_name,
                        'level'             => $request->level,
                        'parent_category_id'=> $request->parent_category
                    );
                    $category->update($data);
                    return redirect(url('home/kategori'))
                    ->with('success','Kategori berhasil diupdate');
                }
            }else{
                return redirect()
                ->back()
                ->withErrors(['Gagal update, kategori tidak bisa diupdate'])
                ->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = ArticleCategory::where('category_id', $id);
        $cekArtikel = Post::where('category_id', $id);
        $cekSubCategory = ArticleCategory::where('parent_category_id', $id);
        if($data->count() > 0 && $cekArtikel->count() == 0){
            if($cekSubCategory->count() == 0){
                $data->delete();
                return redirect(url('home/kategori'))
                ->with('success','Data kategori berhasil dihapus');
            }else{
                return redirect()
                ->back()
                ->withErrors(['Tidak bisa dihapus karena sudah ada sub kategori']);
            }
        }else{
            return redirect(url('home/kategori'))
            ->withErrors(['Data kategori gagal dihapus']);
        }
    }

    public function showParentCategory(Request $request)
    {
        $level = $request->level;
        if($level > 1){
            if($level == 2){
                $category = ArticleCategory::where("level",1);
            }
            elseif($level == 3){
                $category = ArticleCategory::where("level",2);
            }
            $getAll = [];
            foreach($category->get() as $data){
                $getAll[] = array(
                    'category_id'       => $data->category_id,
                    'category_name'     => $data->category_name
                );
            }
            return response()->json($getAll);
        }
    }
}
