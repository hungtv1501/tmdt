<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Admin Manage</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/admin/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item"><a class="nav-link collapsed" href="{{ route('admin.products') }}" aria-expanded="true" aria-controls="collapseTwo">Sản Phẩm</a>
      </li>

      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.categories') }}" aria-expanded="true" aria-controls="collapseTwo">Danh Mục</a>
      </li>

      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.brand') }}" aria-expanded="true" aria-controls="collapseTwo">Thương Hiệu</a>
      </li>

      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.color') }}" aria-expanded="true" aria-controls="collapseTwo">Màu sắc</a>
      </li>

      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.size') }}" aria-expanded="true" aria-controls="collapseTwo">Kích cỡ</a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <div class="col-md-12">
            <a href="{{ route('admin.logout') }}" class="btn" style="float: right;">Đăng xuất</a>
          </div>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          @yield('content')
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
  
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  {{-- <script src="{{ asset('js/admin/sb-admin-2.min.js') }}"></script> --}}

  <!-- Page level plugins -->
  {{-- <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

  Page level custom scripts
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script> --}}
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  
  @stack('js')
  

</body>

</html>
