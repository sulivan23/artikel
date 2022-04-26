@extends('layouts.table_layouts',['title' => 'Artikel'])

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Post Artikel</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Post Artikel</li>
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
                <h3 class="card-title">Data Post Artikel</h3>
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
                <a class="btn btn-primary" href="{{ url('home/createpost') }}"><i class="fa fa-plus"></i> Buat Artikel</a>
                <div class="table-responsive">
                  <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Post ID</th>
                      <th>Judul</th>
                      <th>Kategori</th>
                      <th>Views</th>
                      <th>Likes</th>
                      <th>Status</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th style="width:200px">Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $post)
                      <tr>
                          <td>{{ $post->article_id }}</td>
                          <td>{{ $post->judul_artikel }}</td>
                          <td>{{ $post->category->category_name }}</td>
                          <td>{{ $post->views_count }}</td>
                          <td>{{ $post->likes_count }}</td>
                          <td>{{ $post->status }}</td>
                          <td>{{ $post->created_at }}</td>
                          <td>{{ $post->updated_at }}</td>
                          <td>
                          <form action="{{ url('home/post/'.$post->article_id) }}" method="POST">
                              <a href="{{ url('home/post/'.$post->article_id.'/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i> Update</a> 
                              @csrf
                              <input type="hidden" name="_method" value="DELETE">
                              <button onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger" name="delete" value="delete"><i class="fa fa-trash"></i> Delete</button> 
                              {{-- <a href="{{ url('home/user/'.$user->id) }}" class="btn btn-secondary"><i class="fa fa-eye"></i> Detail</a>  --}}
                          </form>
                          </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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