@extends('layouts.layout')

@section('content')
<div class="main_content_wrapper"> 
    <style>
        h1{
            color: #093344;
            transition: color ease-in-out 0.5s; 
        }
        i{
            transition: transform ease-in-out 0.5s;
        }
        .fade{
            transform: translateX(40px);
            transition: transform ease-in-out 0.5s;
        }
      
        h1:hover{
            color: #20BF55;
            transition: color ease-in-out 0.5s; 
        }

    </style>
    <div style="text-align: center; center; height: 100vh; transform: translateY(35%);">
        <a href="{{ route('staff.profile') }}"><h1 id="text" style="font-size: 82px; font-weight: 900; text-align: center;">Welcome!</h1></a> 
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <div>
            <h3>Your account has been registered... Please wait for the admin to grant permission.</h3>
            <button class="ui blue button"><a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();  document.getElementById('logout-form').submit();"> {{ __('Logout') }} </a></button>
        </div>    
    </div>
</div>

@endsection
