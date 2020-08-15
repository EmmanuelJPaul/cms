@extends('layouts.staff')

@section('content')
<?php 
    function dynamic_date($from, $to){
        $from_date = date_create(date('Y-m-d', strtotime($from)));
        $to_date = date_create(date('Y-m-d', strtotime($to)));
        $diff = date_diff($from_date, $to_date);
        return $diff->format("%y Year %m Month %d Day");
    }
?>
<div class="main_content_wrapper">
    <div class="main_content">
    <!-- start of content -->
        <!--
            *
            *
            * Online Course Section
            *
            *
        -->		

        <form class="ui form" method="POST" action="{{ route('staff.online_course.edit') }}" id="form_online_course" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>Online Course</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="online_course">
                    <?php 
                    //Select the Online Course JSON from the $data[]
                    $online_course_array = json_decode($data['online_course']);
                
                    foreach ($online_course_array as $object_key => $object) {
                        $total = dynamic_date($object->online_course_from,$object->online_course_to);
                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_online_course"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_online_course" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->online_course_name.'</h3>
                                <p>'.$object->online_course_platform.'</p>
                                <p>From: '.$object->online_course_from.' - '.$object->online_course_to.' | Total: '.$total.'</p>

                                
                                <input type="hidden" name="online_course_name[]" value="'.$object->online_course_name.'">
                                <input type="hidden" name="online_course_platform[]" value="'.$object->online_course_platform.'">
                                <input type="hidden" name="online_course_from[]" value="'.$object->online_course_from.'">
                                <input type="hidden" name="online_course_to[]" value="'.$object->online_course_to.'">
                                <input type="hidden" name="total[]" value="'.$total.'">										 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_online_course"></span>
                <br>
                <button class="ui button" id="add_online_course"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_online_course">
            <input type="hidden" name="online_course_name[]">
            <input type="hidden" name="online_course_platform[]">
            <input type="hidden" name="online_course_from[]">
            <input type="hidden" name="online_course_to[]">
            <input type="hidden" name="total[]">										 
        </span>

        <div class="ui modal modal_online_course">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Online Course</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_online_course">
                    <input type="hidden" id="modal_online_course_id">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Name</label>
                            <input type="text" id="modal_online_course_name">
                        </div>
                        <div class="eight wide field">
                            <label>Platform</label>
                            <input type="text" id="modal_online_course_platform">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>From</label>
                            <div class="ui calendar" id="online_course_from_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_online_course_from" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field">
                            <label>To</label>
                            <div class="ui calendar" id="online_course_to_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_online_course_to" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="modal_button_online_course"></span>
            </div>
        </div>
        <br><br><br>

<script>
    $('#modal_form_online_course').form({
        on: 'blur',
        fields: {
            modal_online_course_name  : 'empty',
            modal_online_course_platform : 'empty',
            modal_online_course_from  : 'empty',
            modal_online_course_to    : 'empty',
        } 
    }); 

    //Initialise the variables
    var online_course_name, online_course_platform, online_course_from, online_course_to;		
    function get_online_course_array(){
        //Get the Online Course Array
        online_course_name = $('[name="online_course_name[]"]');
        online_course_platform = $('[name="online_course_platform[]"]');
        online_course_from = $('[name="online_course_from[]"]');
        online_course_to = $('[name="online_course_to[]"]');
    }
    //Is called on Default for the Edit Functions
    get_online_course_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_online_course').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_online_course_id').val(id);
        $('#modal_online_course_name').val(online_course_name[id].value);
        $('#modal_online_course_platform').val(online_course_platform[id].value);
        $('#modal_online_course_from').val(online_course_from[id].value);
        $('#modal_online_course_to').val(online_course_to[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_online_course').html('<div class="ui blue right floated button" id="modal_online_course_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_online_course').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#online_course_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#online_course_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_online_course').on('click','#modal_online_course_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_online_course').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_online_course_id').val();
            //Update the Data
            add_online_course_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_online_course').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_online_course').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_online_course').html('<div class="ui blue right floated button" id="modal_online_course_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_online_course').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#online_course_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#online_course_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_online_course').on('click', '#modal_online_course_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_online_course').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_online_course').clone().appendTo('#hidden_form_holder_online_course');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="online_course_name[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_online_course_array();
            //Update the Data
            add_online_course_data(id);
        }
    });
    
    
    function add_online_course_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        online_course_name[id].value = $('#modal_online_course_name').val();
        online_course_platform[id].value = $('#modal_online_course_platform').val();
        online_course_from[id].value = $('#modal_online_course_from').val();
        online_course_to[id].value = $('#modal_online_course_to').val();
    
        //Submit the Hidden Form
        $('#form_online_course').submit();
    }	

    $('.delete_online_course').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_online_course').submit();

    });

</script>	


        <!--
            *
            *
            * Award Section
            *
            * [{"award_name": "", "award_from_year": "", "award_to_year": ""}]
        -->		

        <form class="ui form" method="POST" action="{{ route('staff.online_course.edit') }}" id="form_award" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>Awards</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="award">
                    <?php 
                    //Select the Online Course JSON from the $data[]
                    $award_array = json_decode($data['award']);
                
                    foreach ($award_array as $object_key => $object) {
                        $total = dynamic_date($object->award_from_year,$object->award_to_year);
                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_award"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_award" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->award_name.'</h3>
                                <p>From: '.$object->award_from_year.' - '.$object->award_to_year.' | Total: '.$total.'</p>

                                
                                <input type="hidden" name="award_name[]" value="'.$object->award_name.'">
                                <input type="hidden" name="award_from_year[]" value="'.$object->award_from_year.'">
                                <input type="hidden" name="award_to_year[]" value="'.$object->award_to_year.'">
                                <input type="hidden" name="total[]" value="'.$total.'">										 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_award"></span>
                <br>
                <button class="ui button" id="add_award"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_award">
            <input type="hidden" name="award_name[]">
            <input type="hidden" name="award_from_year[]">
            <input type="hidden" name="award_to_year[]">
            <input type="hidden" name="total[]">										 
        </span>

        <div class="ui modal modal_award">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Awards</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_award">
                    <input type="hidden" id="modal_award_id">
                    <div class="fields">
                        <div class="sixteen wide field">
                            <label>Name</label>
                            <input type="text" id="modal_award_name">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>From</label>
                            <div class="ui calendar" id="award_from_year_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_award_from_year" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field">
                            <label>To</label>
                            <div class="ui calendar" id="award_to_year_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_award_to_year" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="modal_button_award"></span>
            </div>
        </div>
        <br><br><br>

<script>
    $('#modal_form_award').form({
        on: 'blur',
        fields: {
            modal_award_name       : 'empty',
            modal_award_from_year  : 'empty',
            modal_award_to_year    : 'empty',
        } 
    }); 

    //Initialise the variables
    var award_name, award_platform, award_from_year, award_to_year;		
    function get_award_array(){
        //Get the Online Course Array
        award_name = $('[name="award_name[]"]');
        award_from_year = $('[name="award_from_year[]"]');
        award_to_year = $('[name="award_to_year[]"]');
    }
    //Is called on Default for the Edit Functions
    get_award_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_award').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_award_id').val(id);
        $('#modal_award_name').val(award_name[id].value);
        $('#modal_award_from_year').val(award_from_year[id].value);
        $('#modal_award_to_year').val(award_to_year[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_award').html('<div class="ui blue right floated button" id="modal_award_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_award').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#award_from_year_calender').calendar({type: 'date',maxDate: new Date(),});$('#award_to_year_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_award').on('click','#modal_award_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_award').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_award_id').val();
            //Update the Data
            add_award_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_award').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_award').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_award').html('<div class="ui blue right floated button" id="modal_award_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_award').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#award_from_year_calender').calendar({type: 'date',maxDate: new Date(),});$('#award_to_year_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_award').on('click', '#modal_award_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_award').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_award').clone().appendTo('#hidden_form_holder_award');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="award_name[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_award_array();
            //Update the Data
            add_award_data(id);
        }
    });
    
    
    function add_award_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        award_name[id].value = $('#modal_award_name').val();
        award_from_year[id].value = $('#modal_award_from_year').val();
        award_to_year[id].value = $('#modal_award_to_year').val();
    
        //Submit the Hidden Form
        $('#form_award').submit();
    }	

    $('.delete_award').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_award').submit();

    });

</script>



<span id="script"></span> 

    </div>
</div>
@endsection