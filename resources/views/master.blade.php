<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title_page')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL"></script>

    <link rel="stylesheet" href="{{ url('/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/themes/style.css') }}">
    <link rel="stylesheet" href="{{ url('/css/themes/animate.css') }}">
    <link rel="stylesheet" href="{{ url('/css/themes/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/themes/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('/vendor/perfect-scrollbar.css') }}">

    <link rel="icon" href="{{ url('/images/papua.png') }}" type="image/png" sizes="16x16"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.3.1/css/ol.css" type="text/css">
    <style>
      html {
      	scroll-behavior: smooth;
      }	
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <!-- Open Layers -->
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.3.1/build/ol.js"></script>
    <!-- Chart Js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body>
	   <!-- Mobile Menu Start Here -->
<div class="mobile-menu seo-bg">
  <nav class="mobile-header">
    <div class="header-logo">
      <a href="site/index.html"><img src="{{ url('/images/covid.png') }}" width="250px" alt="logo"></a>
    </div>
    <div class="header-bar">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </nav>
  <nav class="mobile-menu">
    <div class="mobile-menu-area">
      <div class="mobile-menu-area-inner">
        <ul class="lab-ul">
          <li><a href="#">Home</a></li>
              <li><a href="#">Data </a></li>             
          <li><a href="#">Berita</a></li>
          <li><a href="#">Kontak</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#"><span class="lab-btn">Call Center</span></a></li>          
        </ul>
      </div>
    </div>
  </nav>
</div>
<!-- Mobile Menu Ending Here -->
   <!-- Image and text -->
   <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white">
	    <div class="mx-auto order-0 ">
	        <a class="navbar-brand" href="#">
	            <img src="{{ url('/images/papua.png') }}" width="50" height="60" class="d-inline-block align-top" alt="">
	            <strong></strong>Pusat Informasi & Koordinasi COVID-19 - Provinsi Papua Barat</strong> 
	        </a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
	            <span class="navbar-toggler-icon"></span>
	        </button>
	    </div>
	   
	    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
	        <ul class="navbar-nav ml-auto d-flex align-items-center">
	            <li class="nav-item">
	                <a class="nav-link" href="/home">Home</a>
	            </li>
	            <li class="nav-item">
	                <a class="nav-link" href="#data-penyebaran">Data</a>
	            </li>
	             <!-- <li class="nav-item">
	                <a class="nav-link" href="#">Berita</a>
	            </li> -->
	            <li class="nav-item">
	                <a class="nav-link" href="#kontak">Kontak</a>
	            </li>
	            <li class="nav-item">
	                <a href="https://api.whatsapp.com/send?phone=08112543737"><button class="btn btn-danger btn-rounded btn-sm">Call Center</button></a>
	            </li>
	        </ul>
	    </div>
	</nav>
	<!-- Dynamic Content -->
	<!-- <div class="main-content-wrap sidenav-open " id="wrapper"> -->
		<div class="app-admin-wrap">
			@yield('content')	
		</div>
	
    <div class="alert alert-succes" role="alert"></div>
        <!-- Footer Start -->

	   <footer class="footer">
	     <div class="container-fluid">
	      <div class="row text-center">
	       <div class="col-lg-12">© 2020 - Pemerintahan Provinsi Papua Barat</div>
	      </div>
	     </div>        
	    </footer>
	    </div>
	        <!-- fotter end -->
	    </div>
	    <!-- ============ Body content End ============= -->
	</div>
	<script src="{{ url('/js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ url('/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ url('/js/vendor/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ url('/js/vendor/echarts.min.js')}}"></script>
    <script src="{{ url('/js/vendor/datatables.min.js')}}"></script>

    <script src="{{ url('/js/es5/echart.options.min.js')}}"></script>
    <script src="{{ url('/js/es5/dashboard.v2.script.min.js')}}"></script>
    <script src="{{ url('/js/es5/script.min.js')}}"></script>
    <!-- GOOGLE MAPS -->
    <script>
    	var base_uri = "{{asset('storage')}}"
    	console.warn(base_uri)
    </script>
    <script src="{{url('/js/maps.js')}}"></script>
    @if(!empty($__env->yieldContent('script')))
    	@yield('script')
    @endif
</body>
</html>