@extends('layouts.table_layouts',['title' => 'Profile'])

@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if(auth()->user()->photo !== null)
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url('img/user/'.auth()->user()->photo) }}" style="height:90px;width:90px;"
                       alt="User profile picture">
                  @else
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url('adminlte') }}/dist/img/user2-160x160.jpg" style="height:90px;width:90px;"
                       alt="User profile picture">
                  @endif
                </div>

                <h3 class="profile-username text-center">{{  auth()->user()->name }}</h3>

                <p class="text-muted text-center">{{ auth()->user()->email }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">{{ $followers }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">{{ $following }}</a>
                  </li>
                  {{-- <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li> --}}
                </ul>

                <a href="{{ url("home/user"."/".auth()->user()->id."/edit") }}" class="btn btn-primary btn-block"><b>Edit</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <div class="col-md-6">
            <!-- About Me Box -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Roles</strong>

                <p class="text-muted">
                  {{ auth()->user()->role->role_name }}
                </p>

                <hr>

                <strong><i class="fas fa-mars-double"></i> Jenis Kelamin</strong>

                <p class="text-muted">@php $jenkel = array('L' => 'Laki - Laki', 'P' => 'Perempuan', '' => 'Belum disetting'); echo $jenkel[auth()->user()->jenis_kelamin] @endphp</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Nickname</strong>
                <p class="text-muted">{{ auth()->user()->nickname !== "" ? auth()->user()->nickname : "Belum disetting"  }}</p>

                <hr>

                <strong><i class="fa fa-calendar-alt"></i> Tanggal Registed</strong>

                <p class="text-muted">{{ auth()->user()->created_at }}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection 