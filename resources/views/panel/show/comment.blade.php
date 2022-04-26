@extends('layouts.table_layouts',['title' => 'Komentar'])

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Komentar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Komentar</li>
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
                <h3 class="card-title">Data Komentar</h3>
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
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Comment ID </th>
                    <th>Isi Komentar</th>
                    <th>User</th>
                    <th>Artikel</th>
                    <th>Is Reply Comment</th>
                    {{-- <th>Reply Comment</th> --}}
                    <th>Comment At</th>
                    <th>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $comment)
                    <tr>
                        <td>{{ $comment->comment_id }}</td>
                        <td>{{ $comment->comment_value }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->article->judul_artikel }}</td>
                        <td>{{ $comment->is_reply_comment }}</td>
                        {{-- <td>{{ $comment-> }}</td> --}}
                        <td>{{ $comment->created_at }}</td>
                        <td>
                            <form method="POST" action="{{ url('home/komentar/'.$comment->comment_id) }}">
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