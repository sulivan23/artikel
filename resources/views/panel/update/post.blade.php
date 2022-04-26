@extends('layouts.panel_layouts',['title' => 'Update Artikel'])

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Artikel</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Artikel</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

 <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-8">
            <!-- Horizontal Form -->
          <form id="post" enctype="multipart/form-data" action="" novalidate>
          <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
          <input type="hidden" id="postid" value="{{ $post->article_id }}">
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Form Update Artikel</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {{-- @if(session()->has('errors'))
                <div class="alert alert-danger mt-2">
                    @foreach($errors->all() as $error)
                            {{ $error }}<br>
                    @endforeach
                </div>   
            @endif
            @if(session()->has('status'))
                <div class="alert alert-success mt-2">
                    {{ session('status') }}
                </div>   
            @endif --}}
            <div id="alert" style="display:hidden">
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Judul Artikel</label>
                  <input type="text" class="form-control" value="{{ $post->judul_artikel }}" placeholder="Judul artikel..." name="title">
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label>Walpaper (Isi jika ingin diubah)</label>
                    <div class="custom-file">
                        <input type="file" name="walpaper" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                </div>
                <!-- /.form-group -->
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="form-control selectkategori" name="category" style="width: 100%;">
                    <option value="">Pilih</option>
                    @foreach($allCategory as $category)
                        <option value="{{ $category->category_id }}" @if($category->category_id == old('category') || $category->category_id == $post->category_id) selected @endif>{{ $category->category_name }}</option>
                    @endforeach
                  </select>
                </div>
               </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label>Tags</label>
                  <input type="text" class="form-control" placeholder="Tags.. (pisahkan koma, e.g : komputer, laptop, monitor)" name="tags" value="{{ $post->tags }}">
                </div>
               </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Slug (Opsional Link URL)</label>
                  <input type="text" class="form-control" placeholder="Link artikel (e.g : 5-cara-membuat-kue)" name="slug" value="{{ $post->slug }}">
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Publish</label>
                  <input type="date" name="publish_date" value="{{ $post->publish_date }}" class="form-control">
                </div>
              </div>
            </div>
             <div class="col-md-12">
                <div class="form-group">
                  <label>Isi Artikel</label>
                    <textarea id="artikel" name="content">
                        {{ $post->content }}
                    </textarea>
                </div>
              </div>
            </div>
            <!-- /.row -->
          <!-- /.card-body -->
          <div class="card-footer">
            <div class="float-sm-right">
                @if(auth()->user()->role->role_name == "ADMIN" && ($post->status == "Need Verified" || $post->status == "Draft"))
                <button name="button" id="approve" value="approve" class="btn btn-success"><i class="fa fa-check"></i> Approve</button>
                <button name="button" id="reject" value="reject" class="btn btn-danger"><i class="fa fa-times"></i> Reject</button>
                @else 
                <button name="button" id="unpublish" value="unpublish" class="btn btn-danger"><i class="fa fa-times"></i> Unpublish</button>
                @endif
                <button name="button" id="draft" value="draftupdate" class="btn btn-secondary"><i class="fa fa-newspaper"></i> Draft</button>
                <button name="button" id="cancel" value="cancel" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</button>
                <button name="button" id="update" value="update" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
            </div>
          </div>
        </div>
        </div>
        <!-- /.card -->
        </form>
         <div class="col-md-4">
            <!-- Horizontal Form -->
          <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Walpaper</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <img src="{{ url('img/article/walpaper/'.$post->walpaper) }}" class="img-fluid" style="width:100%;height:250px;">
          </div>
        </div>
    </section>
</div>
@endsection