@extends('layouts.staff')

@section('content')
<div class="main_content_wrapper">
    <div class="main_content">
        <!-- start of content -->
        You have reached the Admin Panel!



        <table class="ui celled table">
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
                    <td data-label="name">{{ $user->name }}</td>
                    <td data-label="email">{{ $user->email }}</td>
                    <td data-label="role">
                        <?php $userRole =  ''; ?>
                        @foreach($user->roles as $role)
                            {{ $role->name }}
                            
                            <?php $userRole =  $role->name; ?>
                        @endforeach
                    
                    </td>
                    <td data-label="role">
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
                                <div class="ui selection dropdown">
                                    <input type="hidden" name="role" value="{{ $userRole }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Role</div>
                                    <div class="menu">
                                        <div class="item" data-value="staff">Staff</div>
                                        <div class="item" data-value="student">Student</div>
                                        <div class="item" data-value="none">None</div>
                                    </div>
                                </div>
                                <button class="ui red button" type="submit">Commit</button>
                            </form>
                        @endif
                    </td>
                </tr>
                
            @endforeach
        </tbody>
        </table>

        
    </div>
</div>
<script>
    $('.ui.selection').dropdown();
</script>
@endsection