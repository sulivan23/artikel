@extends('layouts.table_layouts',['title' => 'User'])

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User</li>
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
                <h3 class="card-title">Data User</h3>
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
                {{-- <a class="btn btn-primary" href="#"><i class="fa fa-plus"></i> Tambah Data</a> --}}
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Photo</th>
                    <th>Created At</th>
                    <th>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->role_name }}</td>
                        <td><img src="{{ url('img/user/'.$user->photo) }}" style="height:50px;widht:50px" class="img-fluid"></td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                        <form action="{{ url('home/user/'.$user->id) }}" method="POST">
                            <a href="{{ url('home/user/'.$user->id.'/edit') }}" class="btn btn-primary"><i class="fa fa-edit"></i> Update</a> 
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button> 
                            {{-- <a href="{{ url('home/user/'.$user->id) }}" class="btn btn-secondary"><i class="fa fa-eye"></i> Detail</a>  --}}
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