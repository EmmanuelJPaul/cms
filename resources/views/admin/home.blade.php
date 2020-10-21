@extends('layouts.dashboard')

@section('content')

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
            <table class="ui table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td data-label="name">
                                <h4 class="ui image header">
                                    <img src="{{ asset('/storage/avatar/'.$user->avatar) }}" class="ui small circular image">
                                    <div class="content">
                                        {{ $user->name }}
                                        <div class="sub header">
                                        @if (isset($user->profile))
                                            <i>{{ $user->profile->designation }} ({{ $user->profile->department }})</i>
                                        @endif
                                    </div>
                                    </div>
                                </h4>
                            </td>
                            <td data-label="email">{{ $user->email }}</td>
                            <td data-label="role">
                                <?php $userRole =  ''; ?>
                                @foreach($user->roles as $role)
                                    {{ $role->name }}
                                    
                                    <?php $userRole =  $role->name; ?>
                                @endforeach
                            
                            </td>
                            <td>
                                <?php $adminFlag = false; ?>

                                @foreach($user->roles as $role)
                                    @if($role->name == 'admin')
                                        <?php $adminFlag = true; ?>
                                    @endif
                                @endforeach
                                @if(!$adminFlag)
                                <div class="ui icon top left pointing dropdown icon_btn_inv button">
                                    <i class="ellipsis vertical icon"></i>
                                    <div class="menu">
                                        <div class="header">Basic</div>
                                        @if(isset($user->profile->staff_id))
                                            <a class="item" href="/search/{{ $user->profile->staff_id }}"><i class="eye outline icon"></i>View</a>
                                        @else
                                            <div class="disabled item"><i class="eye outline icon"></i> View</div>
                                        @endif
                                        <div class="item user_delete" id="{{ $user->id }}"><i class="trash alternate icon"></i>Delete</div>
                                        <div class="ui divider"></div>
                                        <div class="header">Previledge</div>
                                        <div class="item">
                                            <i class="dropdown icon"></i>
                                            <i class="user shield icon"></i> Role
                                            <div class="menu user_role" id="{{ $user->id }}">
                                                <div class="item" id="staff">
                                                    Staff
                                                </div>
                                                <div class="item" id="student">
                                                    Student
                                                </div>
                                                <div class="item" id="guest">
                                                    Guest
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <div class="ui icon top left pointing dropdown disabled icon_btn_inv button">
                                        <i class="ellipsis vertical icon"></i>
                                    </div>
                                @endif 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alert Modal -->
    <!-- <div class="ui alert modal">
        <div style="text-align: center; margin: 30px;">
            <h1><i class="circular small exclamation icon"></i> Change user's role to Student?</h1>			    	
        </div>
        <div class="content" style="padding-right: 30px; padding-left: 30px; padding-bottom: 50px;">
            <button class="ui blue right floated button" id="confirm_alert">Yes</button>
            <button class="ui right floated button" id="cancel_alert">Cancel</button>
        </div>
    </div>   -->

<span id="alert_modal"></span>
<script>
    $('.ui.selection').dropdown();
    $('.ui.dropdown').dropdown();
    
    $('#search').on('keyup', function(event){
        event.preventDefault();
        var value = $('#search').val();
        $.post("{{ route('admin.user.search') }}", {value: value, _token: '{{ Session::token() }}' }, function(data){
            $('#search_target').html(data);
        });
    });


    function alert_modal(resolve, reject) {
        // Generate the modal
        var modal = '<div class="ui alert modal"><div style="text-align: center; margin: 30px;"><h2>Are you sure?</h2></div><div class="content" style="padding-right: 30px; padding-left: 30px; padding-bottom: 50px;"><button class="ui blue right floated button" id="confirm_alert">Yes</button><button class="ui right floated button" id="cancel_alert">Cancel</button></div></div>';
        $('#alert_modal').html(modal);
        $('.ui.alert.modal').modal('show');
        // Alert Cancelled
        $('#cancel_alert').on('click', function(event){
            event.preventDefault();
            $('.ui.alert.modal').modal('hide');
            reject('Error');
        });
        // Alert Confirmed
        $('#confirm_alert').on('click', function(event){
            event.preventDefault();
            $('.ui.alert.modal').modal('hide');
            resolve();
        }); 
    }
    
    $('.user_role').children().on('click', function(event){
        event.preventDefault();
        // Toggle Alert Modal
        new Promise(alert_modal).then(() => {
            var data = {'role': event.target.id, 'userId': $(event.target).parent()[0].id};
            $.post("{{ route('admin.user.role') }}", {data: data, _token: '{{ Session::token() }}' }, function(data){
                location.reload();
            }); 
        }).catch((e) => {console.log()});
    });

    $('.user_delete').on('click', function(event){
        event.preventDefault();
        $.post("{{ route('user.delete') }}", {data: event.target.id, _token: '{{ Session::token() }}' }, function(data){
            location.reload();
        }); 
    });
</script>
@endsection