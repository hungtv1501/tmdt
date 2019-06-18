<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Cửa hàng Thời trang TMDT</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/detail.css') }}">

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{ asset('frontend/css/shop.css') }}" rel="stylesheet">

  @stack('css')

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #BBBBBB;">
    <div class="container">
      <a class="navbar-brand" href="/">TMDT - Thời trang giới trẻ</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('fr.product') }}">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('fr.contact') }}">Liên hệ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('fr.transportationMethod') }}">Phương thức vận chuyển</a>
          </li>
          {{-- <li><a class="nav-link" href="{{ route('switchLang',['lang' => 'en']) }}">En</a></li>
          <li><a class="nav-link" href="{{ route('switchLang',['lang' => 'vi']) }}">Vi</a></li> --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('fr.showCart') }}"><img src="{{ URL::to('/') }}/upload/images/app_type_shop_512px_GREY.png" width="25" height="25"></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">Danh Mục</h1>
        <div class="list-group mt-4">
          @foreach($cat as $key => $item)
            <a href="{{ route('fr.showCategori',['id' => $item['id']]) }}" class="list-group-item {{ isset($id) ? ($item['id'] == $id ? 'active' : '') : '' }}">{{ $item['name'] }}</a>
          @endforeach
        </div>

      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9" style="background-color: #F0F8FF;">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel" data-interval="1000">
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" src="{{ URL::to('/') }}/upload/images/slide1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="{{ URL::to('/') }}/upload/images/slide2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" src="{{ URL::to('/') }}/upload/images/slide3.jpg" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

    	@yield('content')
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  {{-- <br><br> --}}
  <br><br>
  <footer class="py-5" style="background-color: #BBBBBB;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-lg-3">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.282088595304!2d105.78528725071726!3d20.981326585955447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135accdcf7b0bd1%3A0xc1cf5dd00247628a!2zSOG7jWMgVmnhu4duIEPDtG5nIG5naOG7hyBCxrB1IENow61uaCBWaeG7hW4gVGjDtG5n!5e0!3m2!1svi!2s!4v1555634794918!5m2!1svi!2s" width="300" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="col-md-3 col-lg-3">
          <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FMandoShop1%2Fhttps%3A%2F%2Fwww.facebook.com%2FMandoShop1%2F&tabs=timeline&width=300&height=350&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=346715669394895" width="300" height="350" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </div>
        <div class="col-md-3 col-lg-3">
          <p class="m-0 text-white">Nhóm 4- Thành Viên</p>
          <br>
          <p>Trần Văn Hưng : B15DCCN258</p>
          <br>
          <p>Hà Thị Thanh Mai : B15DCCN335</p>
          <br>
          <p>Bùi Lan Anh : B15DCCN038</p>
          <br>
          <p>Nguyễn Thị Thanh : B15DCCN501</p>
          <br>
          <p>Nguyễn Phúc Mạnh : B15DCCN346</p>
        </div>
        <div class="col-md-3 col-lg-3">
          <p>GIỚI THIỆU</p>
          <p>Cơ quan chủ quản: Công ty Cổ phần Quảng cáo Trực tuyến 24H.</p>
          <p>Trụ sở: Tầng 12, Tòa nhà Geleximco, 36 Hoàng Cầu, Phường Ô Chợ Dừa, Quận Đống Đa, TP Hà Nội.</p>
          <p>Tel: (84-24) 73 00 24 24 hoặc (84-24) 3512 1806 - Fax: (84-24) 3512 1804.</p>
          <p>Chi nhánh: Tầng 7 – Toà nhà Việt Úc - 402 Nguyễn Thị Minh Khai, Phường 5, Quận 3, TP.Hồ Chí Minh.</p>
        </div>
      </div>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script type="text/javascript">
    $(function() {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
    })
  </script>
  @stack('js')
</body>

</html>
