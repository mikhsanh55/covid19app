<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title_page')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ url('/vendor/perfect-scrollbar.css') }}">
    <link rel="icon" href="{{ url('/images/papua.png') }}" type="image/png" sizes="16x16"> 
    <link rel="stylesheet" href="{{ url('/vendor/pickadate/classic.date.css') }}">
    <link rel="stylesheet" href="{{ url('/vendor/pickadate/classic.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>
	<div class="app-admin-wrap">
		<div class="main-header">
	        <div class="logo">
	        	<a href="/">
	            	<img src="{{ url('/images/papua.png') }}" alt="Logo">
	            </a>
	        </div>

	        <div class="menu-toggle">
	            <div></div>
	            <div></div>
	            <div></div>
	        </div>

	        <div class="d-flex align-items-center">

	        </div>

	        <div style="margin: auto"></div>

	        <div class="header-part-right">
	            <!-- Full screen toggle -->
	            <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
	            <!-- Notificaiton -->
	            <div class="dropdown">
	                <!-- <div class="badge-top-container" id="dropdownNotification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    <span class="badge badge-primary">2</span>
	                    <i class="i-Bell text-muted header-icon"></i>
	                </div> -->
	                <!-- Notification dropdown -->
	                <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
	                    <div class="dropdown-item d-flex">
	                        <div class="notification-icon">
	                            <i class="i-Empty-Box text-danger mr-1"></i>
	                        </div>
	                        <div class="notification-details flex-grow-1">
	                            <p class="m-0 d-flex align-items-center">
	                                <span>Product out of stock</span>
	                                <span class="badge badge-pill badge-danger ml-1 mr-1">3</span>
	                                <span class="flex-grow-1"></span>
	                                <span class="text-small text-muted ml-auto">10 hours ago</span>
	                            </p>
	                            <p class="text-small text-muted m-0">Headphone E67, R98, XL90, Q77</p>
	                        </div>
	                    </div>
	                    <div class="dropdown-item d-flex">
	                        <div class="notification-icon">
	                            <i class="i-Data-Power text-success mr-1"></i>
	                        </div>
	                        <div class="notification-details flex-grow-1">
	                            <p class="m-0 d-flex align-items-center">
	                                <span>Server Up!</span>
	                                <span class="badge badge-pill badge-success ml-1 mr-1">3</span>
	                                <span class="flex-grow-1"></span>
	                                <span class="text-small text-muted ml-auto">14 hours ago</span>
	                            </p>
	                            <p class="text-small text-muted m-0">Server rebooted successfully</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <!-- Notificaiton End -->
	            <!-- User avatar dropdown -->
	            <div class="dropdown">
	                <div class="user col align-self-end">
	                    <img src="{{ url('/images/faces/3.jpg')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

	                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
	                        <div class="dropdown-header">
	                            <i class="i-Lock-User mr-1"></i> {{@Session::get('user')->name}}
	                        </div>
	                        <!-- <a class="dropdown-item">Profile</a> -->
	                        <!-- <a class="dropdown-item" href="/logout">Sign out</a> -->
	                        <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
	                    </div>
	                </div>
	            </div>
	        </div>

	    </div> 
	    <!-- End Header -->

	    <!-- Sidebar -->
	    <div class="side-content-wrap">
	        <div class="sidebar-left open" data-perfect-scrollbar data-suppress-scroll-x="true">
	            <ul class="navigation-left">
	            	
	                <!-- Dashboard -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/" target="_self">
	                    	
	                        <span class="nav-text"><i class="i-Dashboard pr-2"></i>Dashboard</span>
	                    </a>
	                </li>

	                <!-- Tambah Pasien -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/pasien/add" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Add-User pr-2"></i>Tambah Pasien</span>
	                    </a>
	                </li>

	                <!-- Data Positif Corona -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/pasien/data" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Checked-User pr-2"></i>Data Pasien</span>
	                    </a>
	                </li>

	                <!-- No Dar -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/no-darurat" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Old-Telephone pr-2"></i>No Darurat</span>
	                    </a>
	                </li>

	                <!-- Rujukan -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/rumah-sakit-rujukan" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Hospital1 pr-2"></i>RS Rujukan</span>
	                    </a>
	                </li>

	                <!-- Rujukan -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/rumah-sakit" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Hospital pr-2"></i>RS</span>
	                    </a>
	                </li>

	                <!-- Kontak -->
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/kontak" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Telephone-2 pr-2"></i>Kontak Kab/Kota</span>
	                    </a>
	                </li>

	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/slider" target="_self">
	                        
	                        <span class="nav-text"><i class="i-File-Text--Image pr-2"></i>Slider</span>
	                    </a>
	                </li>
	                 <!-- <li class="nav-item" data-item="forms">
	                    <a class="nav-item-hold" href="http://192.168.0.14/admincovid/artikel/">
	                        
	                        <span class="nav-text">Artikel</span>
	                    </a>
	                </li> -->
	                
	                <li class="nav-item">
	                    <a class="nav-item-hold" href="/infografis" target="_self">
	                        
	                        <span class="nav-text"><i class="i-Information pr-2"></i>Info Grafis</span>
	                    </a>
	                </li>
	            </ul>
	        </div>x
	        <div class="sidebar-overlay"></div>
	    </div>
	    <!-- End Sidebar -->
	    <div class="ml-4">
			@yield('content')		
		</div>
	</div>
	<script src="{{ url('/js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ url('/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ url('/js/vendor/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ url('/js/vendor/echarts.min.js')}}"></script>
    <script src="{{ url('/js/vendor/datatables.min.js')}}"></script>

    <script src="{{ url('/js/es5/echart.options.min.js')}}"></script>
    <script src="{{ url('/js/es5/dashboard.v2.script.min.js')}}"></script>
    <script src="{{ url('/js/es5/script.min.js')}}"></script>
    <script src="{{ url('/js/form.validation.script.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/5.3.8/sweetalert2.js"></script>
    @if(!empty($__env->yieldContent('script')))
    	@yield('script')
    @endif
</body>
</html>