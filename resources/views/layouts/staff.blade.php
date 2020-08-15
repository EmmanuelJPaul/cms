<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Staff</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Include Fomantic UI -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
       
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/semantic.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
        <script src="{{ URL::asset('js/semantic.min.js') }}"></script>
      
    </head>
    <body>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Top Navbar -->
		<div class="ui fixed menu">
			<img src="assets/images/clg_logo.png">
			<div class="content">
	        	<span>JEPPIAAR INSTITUTE OF TECHNOLOGY</span>
	            <div class="sub header">self respect | self belief | self discipline</div>
        	</div>
			<div class="right menu">
			
			    <div class="ui simple dropdown item" style="align-items: center;">
           	 		<i class="big user circle icon"></i>
					
					<i class="small angle down icon" style="margin-left: -10px;"></i>

           	 		<div class="menu">
						<div class="item"><i class="edit icon"></i>Edit</div>
    					<div class="item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="sign out icon"></i>Logout</div>           	 			
           	 		</div>
           	 	</div> 
			</div>
			<div class="item">
			
		  	</div>
		</div>
		<div class="side_bar">
			<div class="ui accordion">
				<div class="title active">
					<div class="item ele_id" onclick="tabFunc('profile_page')" id="item">	
						<span style="letter-spacing: 1px;"><i class="edit outline icon" id="medium"></i> PERSONAL DETAILS</span>
					</div>
				</div>
				<div class="content active">
					<a href="{{ route('staff.profile') }}"><button class="sub_item {{ request()->is('staff/profile') ? 'focus' : ''}}">PROFILE</button></a>
					<a href="{{ route('staff.qualification') }}"><button class="sub_item {{ request()->is('staff/qualification') ? 'focus' : ''}}">QUALIFICATION</button></a>
					<a href="{{ route('staff.publication') }}"><button class="sub_item {{ request()->is('staff/publication') ? 'focus' : ''}}">PUBLICATIONS</button></a>
					<a href="{{ route('staff.workshop') }}"><button class="sub_item {{ request()->is('staff/workshop') ? 'focus' : ''}}">WORSHOP & FDP</button></a>
					<a href="{{ route('staff.online_course') }}"><button class="sub_item {{ request()->is('staff/online_course') ? 'focus' : ''}}">ONLINE COURSE</button></a>
				</div>

				<div class="item ele_id" onclick="tabFunc('mark_portal_page')" id="item">					    
					<span style="letter-spacing: 1px;"><i class="file alternate outline icon" id="medium"></i> MARK PORTAL</span>
				</div>

				<div class="item ele_id" onclick="tabFunc('attendence_portal_page')" id="item">			    
					<span style="letter-spacing: 1px;"><i class="calendar alternate outline icon" id="medium"></i> ATTENDENCE PORTAL</span>
				</div>

				<div class="content"></div>
			</div>
		</div>
		@yield('content')
		
		<script>
			$('.ui.accordion').accordion();
		</script>
    </body>
</html>