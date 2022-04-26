@extends('layouts.table_layouts',['title' => 'Kategori'])

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kategori</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kategori</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kategori</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">   
                @if(session()->has('errors'))
									<div class="alert alert-danger mt-2">
										@foreach($errors->all() as $error)
												{{ $error }}<br>
										@endforeach
									</div>   
								@endif
								
								@if(session()->has('success'))
									<div class="alert alert-success mt-2">
										{{ session('success') }}
									</div>   
								@endif
                <a class="btn btn-primary" href="{{ url('home/kategori/create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Category ID </th>
                    <th>Nama Kategori</th>
                    <th>Level</th>
                    <th>Parent Category</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $category)
                    <tr>
                        <td>{{ $category->category_id }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->level }}</td>
                        <td>{{ $category->parent->category_name ?? '' }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            <form method="POST" action="{{ url('home/kategori/'.$category->category_id) }}">
                              <a class="btn btn-primary" href="{{ url('home/kategori/'.$category->category_id.'/edit') }}"><i class="fa fa-edit"></i> Update</a> 
                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <button type="submit" onclick="return confirm('Apakah anda yakin?')"  class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button> 
                            </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection