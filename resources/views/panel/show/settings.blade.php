@extends('layouts.table_layouts',['title' => 'Settings'])

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
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
                <h3 class="card-title">Data Pengaturan</h3>
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
                    <th>Settings ID </th>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Deskripsi</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Opsi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $settings)
                    <tr>
                        <td>{{ $settings->settings_id }}</td>
                        <td>{{ $settings->settings_key }}</td>
                        <td>
                          @if($settings->settings_key == "LOGO" || $settings->settings_key == "FAVICON")
                          <img src="{{ url('img/web/'.$settings->settings_value) }}" class="img-fluid" style="width:100px;height:70px;">
                          @else
                          {{ $settings->settings_value }}
                          @endif
                        </td>
                        <td>{{ $settings->settings_description }}</td>
                        <td>{{ $settings->created_at }}</td>
                        <td>{{ $settings->updated_at }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ url('home/settings/'.$settings->settings_id.'/edit') }}"><i class="fa fa-edit"></i></a> 
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