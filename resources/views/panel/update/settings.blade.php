@extends('layouts.panel_layouts',['title' => 'Update Settings'])

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Update Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Settings</li>
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
                    <h3 class="card-title">Update Settings</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('home/settings/'. $data->settings_id) }}" enctype="multipart/form-data">
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
                            <label class="col-sm-2 col-form-label">Settings Key</label>
                            <div class="col-sm-10">
                                <input type="text" name="settings_key" value="{{ $data->settings_key }}" class="form-control" placeholder="Settings key" readonly>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Settings Value</label>
                            <div class="col-sm-10">
                                @if($data->settings_key == "LOGO" || $data->settings_key == "FAVICON")
                                 <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                @else
                                <textarea name="settings_value" style="width:300px;height:300px;">{{ old('settings_value') !== null ? old('settings_value') : $data->settings_value }}</textarea>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Settings Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="settings_description" value="{{ $data->settings_key }}" class="form-control" placeholder="Settings description" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="{{ url('home/settings') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-secondary float-right">Save</button>
                    </div>
                    <!-- /.card-footer -->
                    <input type="hidden" name="_method" value="PUT">
                    </form>
                    </div>
                </div>
                @if($data->settings_key == "LOGO" || $data->settings_key == "FAVICON")
                <div class="col-md-4">
                <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
                <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">{{ $data->settings_key }}</h3>
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
                    <img src="{{ url('img/web/'.$data->settings_value) }}" class="img-fluid" style="width:100%;height:250px;">
                </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

