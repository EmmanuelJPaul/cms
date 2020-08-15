@extends('layouts.staff')

@section('content')
<div class="main_content_wrapper">
    <div class="main_content">
    <!-- start of content -->	
        <div class="ui centered stackable padded grid">
            <div class="two wide column">
                <img class="ui circular image" src="{{ asset('/storage/avatar/'.$data['avatar']) }}"><br>
                <button class="ui large fluid button" id="avatar_button">Photo</button>
            </div>

            <div class="eleven wide column">
                <span id="profile">
                    <span id="hash_id">STAFF ID #{{ $data['staff_id'] }}</span>
                    <h1>{{ $data['name'] }}</h1>
                    <p>{{ $data['email'] }} - {{ $data['phone_number'] }}</p>
                    <p>Gender: {{ $data['gender'] }} | D.O.B: {{ date('d-m-Y', strtotime($data['date_of_birth'])) }}</p>
                    <p>{{ $data['designation'] }} @ {{ $data['department'] }}</p>
                    <br><br>

                    <p><b>Permanent Address:</b></p>
                    <p>{{ $data['permanent_address'] }}</p><br>
                    <p><b>Present Address:</b></p>
                    <p>{{ $data['present_address'] }}</p>
                    <br><br>


                    <div class="ui stackable grid">
                        <div class="five wide column">
                            <p><b>Aadhar Card:</b> {{ $data['aadhar_card_number'] }}</p>
                            <p><b>PAN Card:</b> {{ $data['pan_card_number'] }}</p>
                        </div>
                        <div class="five wide column">
                            <p><b>Anna University ID:</b> {{ $data['anna_university_id'] }}</p>
                            <p><b>AICTE ID:</b> {{ $data['aicte_id'] }}</p>
                            <br>
                            <button class="ui blue right floated button" id="edit"><i class="pen icon"></i> Edit</button>
                        </div>
                    </div>

                </span>	
                <form method="POST" id="form_profile" action="{{ route('staff.profile.edit') }}" novalidate>
                    @csrf
                    <input type="hidden" id="name" name="name" value="{{ $data['name'] }}">
                    <input type="hidden" id="email" name="email" value="{{ $data['email'] }}">
                    <input type="hidden" id="staff_id" name="staff_id" value="{{ $data['staff_id'] }}">
                    <input type="hidden" id="phone_number" name="phone_number" value="{{ $data['phone_number'] }}">
                    <input type="hidden" id="permanent_address" name="permanent_address" value="{{ $data['permanent_address'] }}">
                    <input type="hidden" id="present_address" name="present_address" value="{{ $data['present_address'] }}">
                    <input type="hidden" id="department" name="department" value="{{ $data['department'] }}">
                    <input type="hidden" id="designation" name="designation" value="{{ $data['designation'] }}">
                    <input type="hidden" id="date_of_birth" name="date_of_birth" value="{{ $data['date_of_birth'] }}">
                    <input type="hidden" id="gender" name="gender" value="{{ $data['gender'] }}">
                    <input type="hidden" id="pan_card_number" name="pan_card_number" value="{{ $data['pan_card_number'] }}">
                    <input type="hidden" id="aadhar_card_number" name="aadhar_card_number" value="{{ $data['aadhar_card_number'] }}">
                    <input type="hidden" id="anna_university_id" name="anna_university_id" value="{{ $data['anna_university_id'] }}">
                    <input type="hidden" id="aicte_id" name="aicte_id" value="{{ $data['aicte_id'] }}">		  				 
                </form>
            </div>
        </div>
        <div class="ui first modal">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Basic Details</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" autocomplete="off">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Name</label>
                            <input id="modal_name" type="text" value="{{ $data['name'] }}">
                        </div>
                        <div class="eight wide field">
                            <label>Email</label>
                            <input id="modal_email" type="email" value="{{ $data['email'] }}">
                        </div>
                    </div>
                    <div class="fields"> 
                        <div class="five wide field">
                            <label>Date of Birth</label>
                            <div class="ui calendar" id="date_of_birth_calendar">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_date_of_birth" placeholder="-- Pick Date --"  value="{{ $data['date_of_birth'] }}">
                                </div>
                            </div>
                        </div>
                        <div class="five wide field">
                            <label>Gender</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_gender" value="{{ $data['gender'] }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <div class="item" data-value="Male">Male</div>
                                    <div class="item" data-value="Female">Female</div>
                                    <div class="item" data-value="Transgender">Transgender</div>
                                </div>
                            </div>				  		
                        </div>
                        <div class="six wide field">
                            <label>Phone</label>
                            <input id="modal_phone_number" type="number" value="{{ $data['phone_number'] }}">
                        </div>
                    </div>

                    <div class="fields">
                        <div class="eight wide field">
                            <label>Permanent Address</label>
                            <input id="modal_permanent_address" type="text" value="{{ $data['permanent_address'] }}">
                        </div>
                        <div class="eight wide field">
                            <label>Present Address</label>
                            <input id="modal_present_address" type="text" value="{{ $data['present_address'] }}">
                        </div>
                    </div>

                    <button class="ui right floated button" id="modal_next" style="margin-bottom: 15px;">Next</button>
                </div>
            </div>
        </div>

        <div class="ui second modal">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Staff Details</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" autocomplete="off">
                    <div class="fields"> 
                        <div class="six wide field">
                            <label>Staff ID</label>
                            <input id="modal_staff_id" type="text" value="{{ $data['staff_id'] }}">
                        </div>
                        <div class="five wide field">
                            <label>Designation</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_designation" value="{{ $data['designation'] }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <div class="item" data-value="Asst. Professor">Asst. Professor</div>
                                    <div class="item" data-value="Professor">Professor</div>
                                    <div class="item" data-value="HOD">HOD</div>
                                </div>
                            </div>
                        </div>
                        <div class="five wide field">
                            <label>Department</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_department" value="{{ $data['department'] }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <div class="item" data-value="CSE">CSE</div>
                                    <div class="item" data-value="IT">IT</div>
                                    <div class="item" data-value="ECE">ECE</div>
                                    <div class="item" data-value="EEE">EEE</div>
                                    <div class="item" data-value="MECH">MECH</div>
                                </div>
                            </div>
                        </div>								  	
                    </div>
                    
                    <div class="fields">
                        <div class="four wide field">
                            <label>Pan Card Number</label>
                            <input id="modal_pan_card_number" type="text" value="{{ $data['pan_card_number'] }}">
                        </div>
                        <div class="four wide field">
                            <label>Aadhar Card Number</label>
                            <input id="modal_aadhar_card_number" type="text" value="{{ $data['aadhar_card_number'] }}">
                        </div>
                        <div class="four wide field">
                            <label>Anna University ID</label>
                            <input id="modal_anna_university_id" type="text" value="{{ $data['anna_university_id'] }}">
                        </div>
                        <div class="four wide field">
                            <label>AICTE ID</label>
                            <input id="modal_aicte_id" type="text" value="{{ $data['aicte_id'] }}">
                        </div>
                    </div>
                    <button class="ui button" id="modal_prev" style="margin-bottom: 15px;">Prev</button>
                    <button class="ui blue right floated button" id="submit" style="margin-bottom: 15px;">Save</button>
                </div>
            </div>
        </div>
    <!-- End of Content -->
    </div>
</div>
<div class="ui avatar modal">
    <i class="close icon"></i>
    <div style="text-align: center; margin: 30px;">
        <h2>Avatar</h2>				    	
    </div>
    <div class="content" style="padding-right: 30px; padding-left: 30px">
        <form class="ui form" method="POST" action="{{ route('staff.profile.avatar.edit') }}" enctype="multipart/form-data">
            @csrf
            <div class="fields">
                <div class="fourteen wide field">
                    <div class="ui action input">
                        <input type="text" placeholder="-- Browse --" >
                        <input type="file" name="avatar" hidden>
                        <div class="ui icon button">
                            <i class="attach icon"></i>
                        </div>                 
                    </div>
                </div>
                <div class="two wide field">
                    <button class="ui blue button" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('.selection.dropdown').dropdown();

    /**
     * Avatar
     */
    $('#avatar_button').on('click', function(event){
        event.preventDefault();
        $('.ui.avatar').modal('show');
    })
    $("button#avatar_button").click(function() {
        $(this).parent().find("input:file").click();
    });

    $('input:file', '.ui.action.input')
        .on('change', function(e) {
        var name = e.target.files[0].name;
        $('input:text', $(e.target).parent()).val(name);
    });

    /**
     * Profile
     */
    $('#edit').click(function(event){
        event.preventDefault();
        // show first modal
        $('.first.modal').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#date_of_birth_calendar').calendar({type: 'date', maxDate: new Date(),});<\/script>");

    });

    $('#modal_next').click(function(event){
        event.preventDefault();
        // show second modal
        $('.second.modal').modal('show');
    });	

    $('#modal_prev').click(function(event){
        event.preventDefault();
        // show first modal
        $('.first.modal').modal('show');

    });

    $('#submit').click(function(event){
        event.preventDefault();

        //Insert the values from the Modal Form into the Hidden Form
        $('#name').val(
            $('#modal_name').val()
        ); 
        $('#email').val(
            $('#modal_email').val()
        ); 
        $('#staff_id').val(
            $('#modal_staff_id').val()
        ); 
        $('#phone_number').val(
            $('#modal_phone_number').val()
        ); 
        $('#permanent_address').val(
            $('#modal_permanent_address').val()
        ); 
        $('#present_address').val(
            $('#modal_present_address').val()
        ); 
        $('#department').val(
            $('#modal_department').val()
        ); 
        $('#designation').val(
            $('#modal_designation').val()
        ); 
        $('#date_of_birth').val(
            $('#modal_date_of_birth').val()
        ); 
        $('#gender').val(
            $('#modal_gender').val()
        ); 
        $('#pan_card_number').val(
            $('#modal_pan_card_number').val()
        ); 
        $('#aadhar_card_number').val(
            $('#modal_aadhar_card_number').val()
        ); 
        $('#anna_university_id').val(
            $('#modal_anna_university_id').val()
        );
        $('#aicte_id').val(
            $('#modal_aicte_id').val()
        );	

        $('#form_profile').submit();
    });	


$("input:text").click(function() {
    $(this).parent().find("input:file").click();
});

$('input:file', '.ui.action.input')
    .on('change', function(e) {
    var name = e.target.files[0].name;
    $('input:text', $(e.target).parent()).val(name);
});
</script>
<span id="script"></span>
@endsection