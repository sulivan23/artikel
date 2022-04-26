@extends('layouts.table_layouts',['title' => 'Update User'])

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit User</li>
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
                    <h3 class="card-title">Edit User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('home/user/'. $data->id) }}" enctype="multipart/form-data">
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
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{ $data->name }}" class="form-control" placeholder="Nama Lengkap...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                            @if( auth()->user()->role->role_name == "ADMIN")
                                <select class="form-control" name="role">
                                    <option @if($data->role->role_name == "ADMIN") selected @endif value="{{ $data->roles }}">ADMIN</option>
                                    <option @if($data->role->role_name == "USER") selected @endif value="{{ $data->roles }}">USER</option>
                                </select>
                            @else
                                <input type="text" name="role" value="{{ $data->role->role_name }}" class="form-control" readonly>
                            @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" value="{{ $data->email }}" class="form-control" placeholder="Email...">
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="jenkel">
                                    <option value="">Pilih</option>
                                    <option @if($data->jenis_kelamin == "L") selected @endif value="L">Laki - Laki</option>
                                    <option @if($data->jenis_kelamin == "P") selected @endif value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nickname</label>
                            <div class="col-sm-10">
                                <input type="text" name="nickname" value="{{ $data->nickname }}" class="form-control" placeholder="Nickname...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Photo</label>
                            <div class="col-sm-10">
                                 <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <p>Update Password (Isi jika ingin diganti)</p>
                         <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Old Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="old_password"  class="form-control" placeholder="Old Password...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password"  class="form-control" placeholder="New Password...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm new password</label>
                            <div class="col-sm-10">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password...">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="{{ url('home/user') }}" class="btn btn-danger">Cancel</a>
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

