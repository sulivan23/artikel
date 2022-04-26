<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ webInfo('JUDUL_WEB')." - ". $title }}</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ url('img/web/'.webInfo('FAVICON')) }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link">
      <img src="{{ url('img/web/'.webInfo('LOGO')) }}"  class="brand-image elevation-1" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ webInfo('JUDUL_WEB') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(auth()->user()->photo !== null)
          <img src="{{ url('img/user')."/".auth()->user()->photo }}" class="img-circle elevation-2" style="height:30px;" alt="User Image">
          @else
          <img src="{{ url('adminlte') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>


      <form method="POST" class="form-inline" action="{{ route('logout') }}">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @foreach(getModul()->get() as $modul)
            <li class="nav-item">
            <a href="{{ url($modul->role_url) }}" class="nav-link">
              <i class="nav-icon {{ $modul->role_icon }}"></i>
              <p>
                {{ $modul->role_access }}
              </p>
            </a>
          </li>
          @endforeach
           <li class="nav-item">
                @csrf
                <button name="logout" type="submit" class="nav-link bg-transparent text-left border-0">
                    <i class="nav-icon fas fa-sign-out-alt" style="color:#c2c7d0"></i>
                    <p style="color:#c2c7d0">
                        Logout
                    </p>
                </button>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </form>
    </div>
    <!-- /.sidebar -->
  </aside>

    @yield('content')

    <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="https://adminlte.io">{{ webInfo('JUDUL_WEB') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0 | Made with <i class="fa fa-heart"></i> by <a href="https://irvansulistio.com" target="_blank">Irvan Sulistio</a>
    </div>
  </footer>

  {{-- <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar --> --}}
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('adminlte') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('adminlte') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Datatables -->
<script src="{{ url('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/jszip/jszip.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ url('adminlte') }}/plugins/chart.js/Chart.min.js"></script>
<!-- JQVMap -->
<script src="{{ url('adminlte') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('adminlte') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ url('adminlte') }}/plugins/moment/moment.min.js"></script>
<script src="{{ url('adminlte') }}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('adminlte') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ url('adminlte') }}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ url('adminlte') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('adminlte') }}/dist/js/adminlte.js"></script>
{{-- <!-- AdminLTE for demo purposes -->
<script src="{{ url('adminlte') }}/dist/js/demo.js"></script> --}}
<!-- bs-custom-file-input -->
<script src="{{ url('adminlte') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
 $('#datatable').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
});
 $('#datatable1').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
});
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
