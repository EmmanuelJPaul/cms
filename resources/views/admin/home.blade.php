@extends('layouts.dashboard')

@section('content')

    <!-- Top Navbar -->
    <div class="ui menu">
        <div class="content">
            <i class="large bars icon" id="menu-toggle"></i>
        </div>
        <div class="item">
            
        </div>
        <div class="right menu">
            <div class="ui simple dropdown item" style="align-items: center;">
                <img src="{{ asset('/storage/avatar/default') }}" style="display: block; width: 40px; height: 40px; padding: 0px; margin: 0px 15px; border-radius: 50%;">
                <i class="small angle down icon" style="margin-left: -10px;"></i>
                <div class="menu">
                    <div class="item"><i class="edit icon"></i>Edit</div>
                    <div class="item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="sign out icon"></i>Logout</div>
                </div>
            </div> 
        </div>
        <div class="item"></div>
    </div> 

    <div class="main_content_wrapper">
        
        <!-- start of content -->
        <h2 style="margin-bottom: 0px">Search</h2>
        <div class="ui breadcrumb">
            <a class="section">Home</a>
            <i class="right angle icon divider"></i>
            <a class="active section">Search</a>
        </div>
        <br><br>
        <div class="ui form">
            <div class="field">
                <div class="ui big icon input">
                    <input type="text" name="search" id="search" placeholder="Search...">
                    <i class="search icon"></i>
                </div>   
            </div>
        </div>


        <br><br>
        <div id="search_target">

        <table class="ui  table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td data-label="name">{{ $user->name }}</td>
                        <td data-label="email">{{ $user->email }}</td>
                        <td data-label="role">
                            <?php $userRole =  ''; ?>
                            @foreach($user->roles as $role)
                                {{ $role->name }}
                                
                                <?php $userRole =  $role->name; ?>
                            @endforeach
                        
                        </td>
                        <td data-label="action">
                            <?php $adminFlag = false; ?>

                            @foreach($user->roles as $role)
                                @if($role->name == 'admin')
                                    <?php $adminFlag = true; ?>
                                @endif
                            @endforeach
                            @if(!$adminFlag)
                                <form class="ui form" method="POST" action="{{ route('admin.user.role') }}">
                                    @csrf
                                    <input type="hidden" name="userId" value="{{ $user->id }}"> 
                                    <div class="fields">
                                        <div class="eleven wide field">
                                            <div class="ui selection dropdown">
                                                <input type="hidden" name="role" value="{{ $userRole }}">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Role</div>
                                                <div class="menu">
                                                    <div class="item" data-value="staff">Staff</div>
                                                    <div class="item" data-value="student">Student</div>
                                                    <div class="item" data-value="guest">Guest</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="five wide field">
                                            <button class="ui red button" type="submit">Commit</button>
                                        </div>
                                    </div>
                                </form>
                            @endif  
                        </td>
                        @if(isset($user->profile)){
                            <td data-label="view"><a class="ui blue button" href="/search/{{ $user->profile->staff_id }}"><i class="eye outline icon"></i> View</a></td>
                            @else
                                <td data-label="view"></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>  
<script>
    $('.ui.selection').dropdown();

    $('#search').on('keyup', function(event){
        event.preventDefault();

        var value = $('#search').val();

        $.post("{{ route('admin.user.search') }}", {value: value, _token: '{{ Session::token() }}' }, function(data){
            $('#search_target').html(data);
        });
    });
</script>
@endsection