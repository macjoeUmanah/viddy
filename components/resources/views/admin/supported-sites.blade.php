<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ __('VidClear Dashboard') }}</title>
	
    <x-admin.headerAssets />
    
    @livewireStyles

</head>
<body class="g-sidenav-show bg-gray-100">
	
	<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white" id="sidenav-main">
		
		<x-admin.sidenav-header />

		<hr class="horizontal dark mt-0">

		<x-admin.sidebar />
		
	</aside>
	
	<main class="main-content mt-1 border-radius-lg">
		    <!-- Navbar -->
		    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="false">
		     <div class="container-fluid py-1 px-3">

		        <x-admin.breadcrumbs />

		        <x-admin.navright />

		     </div>
		   </nav>
		  <!-- End Navbar -->

		  <div class="container-fluid py-4">

		  	<div class="card">
		  		<div class="card-body">

		  			<div class="row">

		  				@foreach (glob( app_path() . "/Classes/*.php") as $file)
		  					@php

		  						$name = explode('.', basename($file));

								$data = '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
											<div class="card card-plain text-center">
												<a href="javascript:;">
													<img class="avatar avatar-xl shadow" src="'.asset('assets/img/plugins/%s.svg').'">
												</a>

												<div class="card-body">
													<h5 class="card-title">%s</h5>
													<h6 class="category text-info text-gradient">Last updated: %s</h6>
												</div>
											</div>
										</div>';

                          		if (!empty($name[0]) && File::exists( getcwd() . '/assets/img/plugins/' . strtolower($name[0]) . '.svg') ) {

                          			printf($data, strtolower($name[0]), $name[0], date('Y/m/d', filemtime($file) ) );

                          		};

		  					@endphp
		  				@endforeach

		  			</div>

		  		</div>
		  	</div>

		  </div>
			
		<x-admin.footer />

	</main>

    <x-admin.footerAssets />

    @livewireScripts
</body>
</html>