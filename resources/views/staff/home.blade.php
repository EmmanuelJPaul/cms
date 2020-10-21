@extends('layouts.dashboard')

@section('content')

<style>
    #time{
        font-size: 28px;
    }
</style>
<div class="main_content_wrapper"> 
    <div class="ui form">
        <div class="field">
            <div class="ui big icon input">
                <input type="text" name="search" id="search" placeholder="Search...">
                <i class="search icon"></i>
            </div>   
        </div>
    </div>


    <br><br>
        <div id="search_target"></div>
        

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
        <a href="{{ route('staff.profile') }}"><h1 id="text" style="font-size: 82px; font-weight: 900; text-align: center;">Go to the Profile Page <i id="icon" class="right arrow icon"></i></h1></a> 
        
        <div>
            <button class="ui blue button">Profile Page</button>
        </div>    
    </div>
</div>

    


@if(Session::has('success'))
<script>
    var msg = '{{ Session::get("success") }}';
    $('body')
    .toast({
        title: msg,
        message: "{{ $user['name'] }}",
        showImage: "{{ asset('/storage/avatar/'.$data['avatar']) }}",
        classImage: 'avatar',
        showProgress: 'bottom',
        classProgress: 'blue'
    });
</script>
@endif

<script>
    $('#text').mouseover(function(event){
        $('#icon').toggleClass('fade');
    });
    $('#text').mouseout(function(event){
        $('#icon').toggleClass('fade');
    });
</script>
<script>
$('#search').on('keyup', function(event){
    event.preventDefault();

    var value = $('#search').val();

    $.post("{{ route('search') }}", {_token: '{{ Session::token() }}', value: value}, function(data){
        $('#search_target').html(data);
    });
});
</script>
@endsection