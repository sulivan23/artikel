@extends('layouts.panel_layouts',['title' => 'Buat Artikel'])

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Buat Artikel</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Buat Artikel</li>
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
          <div class="col-md-12">
            <!-- Horizontal Form -->
          <form id="post" enctype="multipart/form-data" action="">
          <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Form Artikel</h3>
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
                  <input type="text" class="form-control" value="{{ old('title') }}" placeholder="Judul artikel..." name="title">
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label>Walpaper</label>
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
                        <option value="{{ $category->category_id }}" @if($category->category_id == old('category')) selected @endif>{{ $category->category_name }}</option>
                    @endforeach
                  </select>
                </div>
               </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label>Tags (Ketik lalu enter)</label>
                  <input type="text"data-role="tagsinput" class="form-control" name="tags" value="{{ old('tags') }}">
                </div>
               </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Slug (Opsional Link URL)</label>
                  <input type="text" class="form-control" placeholder="Link artikel (e.g : 5-cara-membuat-kue)" name="slug" value="{{ old('slug') }}">
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Publish</label>
                  <input type="date" name="publish_date" value="{{ date('Y-m-d') }}" class="form-control">
                </div>
              </div>
            </div>
             <div class="col-md-12">
                <div class="form-group">
                  <label>Isi Artikel</label>
                    <textarea id="artikel" name="content">
                        {{ old('content') }}
                    </textarea>
                </div>
              </div>
            </div>
            <!-- /.row -->
          <!-- /.card-body -->
          <div class="card-footer">
            <div class="float-sm-right">
                <button name="button" id="draft" value="draft" class="btn btn-secondary"><i class="fa fa-draft"></i> Draft</button>
                <button name="button" id="cancel" value="cancel" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</button>
                <button name="button" id="save" value="save" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
          </div>
        </div>
        </div>
        <!-- /.card -->
        </form>
    </section>
</div>
@endsection