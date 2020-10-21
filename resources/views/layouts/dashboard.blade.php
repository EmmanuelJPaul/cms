<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

				
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
		
        <!-- Include Fomantic UI -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/semantic.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">

		<script src="{{ URL::asset('js/semantic.min.js') }}"></script>
		
      
    </head>
    <body>
		<form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
		<div class="side_bar">
			<div class="brand" style="text-align: center;">
				<img src="{{ asset('/images/clg_logo.png') }}">
				<!-- <h1 style="font-weight: 900; text-align: center; margin-bottom: 0px; letter-spacing: 2px;">JEPPIAAR</h1>
				<p style="text-align: center;">Institute of Technology</p> -->
			</div>
			@if(Auth::user()->hasRole('admin'))
				<div class="item ele_id {{ request()->is('admin') ? 'active' : ''}} " id="item">	
					<a href="{{ route('admin.') }}"><span><i class="search icon"></i> Search</span></a>	
				</div>
			@endif
			@if(Auth::user()->hasRole('staff'))
				<div class="item ele_id {{ request()->is('staff') ? 'active' : ''}} " id="item">	
					<a href="{{ route('staff.') }}"><span><i class="search icon"></i> Search</span></a>	
				</div>
				<div class="item ele_id {{ request()->is('staff/profile') ? 'active' : ''}} " id="item">	
					<a href="{{ route('staff.profile') }}"><span><i class="edit outline icon"></i> Profile</span>
						<a class="ui green basic label" style="background-color: transparent; font-size: 10px; padding: 2px;">Beta</a>
					</a>
					
				</div>
				<div class="item ele_id" id="item">	
					<span><i class="file alternate outline icon"></i> Marks Entry</span>
				</div>
				<div class="item ele_id" id="item">	
					<span><i class="calendar alternate outline icon"></i> Attendence</span>
				</div>
				<div class="item ele_id" id="item">

					<span><i class="bar chart outline icon"></i> Analytics</span>
				</div>
			@endif
		</div>
		<main>
			<!-- Top Navbar -->
			<div class="ui menu">
				<div class="content">
					<i class="large bars icon" id="menu-toggle"></i>
				</div>
				<div class="item">
					
				</div>
				<div class="right menu">
					<div class="ui simple dropdown item" style="align-items: center;">
						<img src="{{ asset('/storage/avatar/'.$avatar) }}" style="display: block; width: 40px; height: 40px; padding: 0px; margin: 0px 15px; border-radius: 50%;">
						<i class="small angle down icon" style="margin-left: -10px;"></i>
						<div class="menu">
							@if(Auth::user()->hasRole('staff'))
								<a href="{{ route('staff.profile') }}" class="item"><i class="edit icon"></i>Edit</a>
							@endif
							<div class="item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="sign out icon"></i>Logout</div>
						</div>
					</div> 
				</div>
				<div class="item"></div>
			</div>	
			
			@yield('content')

		</main>
		
		<script>
			//SideBar Sub-menu Script
			$('.ui.accordion').accordion();

			// SideBar Toggle Script
			$('#menu-toggle').on('click', function(event){
				event.preventDefault();
				$('.side_bar').toggleClass('side_bar_toggle');
				$('main').toggleClass('main_toggle');
			});
			$(window).resize(function(){
				if($(window).width() < 768){
					$('.side_bar').addClass('side_bar_toggle');
					$('main').addClass('main_toggle');
				}else{
					$('.side_bar').removeClass('side_bar_toggle');
					$('main').removeClass('main_toggle');
				}
			});
			if($(window).width() < 768){
				$('.side_bar').addClass('side_bar_toggle');
				$('main').addClass('main_toggle');
			}	
		</script>

		<!-- Copy to Clipboard -->
		<script type="text/javascript">
			function cc(newClip) {
				navigator.clipboard.writeText(newClip).then(function() {
					alert('Copied!');
				}, function() {
					alert('Error!');
				});
			}
		</script>
		
    </body>
</html>