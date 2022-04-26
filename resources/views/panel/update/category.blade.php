@extends('layouts.panel_layouts',['title' => 'Update Kategori'])

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Kategori</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Kategori</li>
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
          <div class="col-md-6">
            <!-- Horizontal Form -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Edit Kategori</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('home/kategori/'. $data->category_id) }}">
                    @csrf
                    <div class="card-body">
                         @if(session()->has('errors'))
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
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" name="category_name" value="{{ $data->category_name }}" class="form-control" placeholder="Nama kategori...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Level</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="level">
                                    <option value="">Pilih</option>
                                    @for($i=1; $i<=3; $i++)
                                        <option value="{{ $i }}" {{ $i == $data->level ? 'selected' : '' }} >{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" @if($data->parent_category_id == "") style="display:none" @endif id="parent_category" >
                            <label class="col-sm-2 col-form-label">Parent Category</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="parent_category" id="select_parent">
                                    <option value="">Pilih</option>
                                    @foreach($parentCategory->get() as $parent)
                                        <option value="{{ $parent->category_id }}"  {{ $parent->category_id == $data->parent_category_id ? 'selected' : '' }}> {{ $parent->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="{{ url('home/kategori') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-secondary float-right">Save</button>
                    </div>
                    <!-- /.card-footer -->
                    <input type="hidden" name="_method" value="PUT">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

