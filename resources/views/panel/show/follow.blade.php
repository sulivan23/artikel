@extends('layouts.table_layouts',['title' => 'Followers'])

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Followers & Following</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Followers & Following</li>
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
                <h3 class="card-title">Data Followers</h3>
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
                    <th>Followers ID</th>
                    <th>Nama</th>
                    <th>Photo</th>
                    <th>Follow At</th>
                    <th>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($follow as $followers)
                    <tr>
                        <td>{{ $followers->followers_id }}</td>
                        <td>{{ $followers->followers->name }}</td>
                        <td><img src="{{ url('img/user/'.$followers->followers->photo) }}" style="height:50px;widht:50px" class="img-fluid"></td>
                        <td>{{ $followers->followers->created_at }}</td>
                        <td>
                            <form method="POST" action="{{ url('home/follow/'.$followers->followers_id) }}">
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Following</h3>
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
                <table id="datatable1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Followers ID</th>
                    <th>Nama</th>
                    <th>Photo</th>
                    <th>Follow At</th>
                    <th>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($following as $foll)
                    <tr>
                        <td>{{ $foll->followers_id }}</td>
                        <td>{{ $foll->following->name }}</td>
                        <td><img src="{{ url('img/user/'.$foll->following->photo) }}" style="height:50px;widht:50px" class="img-fluid"></td>
                        <td>{{ $foll->following->created_at }}</td>
                        <td>
                            <form method="POST" action="{{ url('home/follow/'.$foll->comment_id) }}">
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