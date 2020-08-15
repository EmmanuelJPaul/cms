@extends('layouts.staff')

@section('content')
<?php 
    function dynamic_date($from, $to){
        $from_date = date_create(date('Y-m-d', strtotime($from)));
        $to_date = date_create(date('Y-m-d', strtotime($to)));
        $diff = date_diff($from_date, $to_date);
        return $diff->format("%m Month %d Day");
    }
?>
<div class="main_content_wrapper">
    <div class="main_content">
    <!-- start of content -->

        <!--
            *
            *
            * Workshop Section
            *
            * 
        -->		

        <form class="ui form" method="POST" action="{{ route('staff.workshop.edit') }}" id="form_workshop" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>Workshop</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="workshop">
                    <?php 
                    //Select the Workshop JSON from the $data[]
                    $workshop_array = json_decode($data['workshop']);
                
                    foreach ($workshop_array as $object_key => $object) {
                        $total = dynamic_date($object->workshop_from,$object->workshop_to);
                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_workshop"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_workshop" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->workshop_name.'</h3>
                                <p>'.$object->workshop_venue.'</p>
                                <p>From: '.$object->workshop_from.' - '.$object->workshop_to.' | Total: '.$total.'</p>

                                
                                <input type="hidden" name="workshop_name[]" value="'.$object->workshop_name.'">
                                <input type="hidden" name="workshop_venue[]" value="'.$object->workshop_venue.'">
                                <input type="hidden" name="workshop_from[]" value="'.$object->workshop_from.'">
                                <input type="hidden" name="workshop_to[]" value="'.$object->workshop_to.'">
                                <input type="hidden" name="total[]" value="'.$total.'">										 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_workshop"></span>
                <br>
                <button class="ui button" id="add_workshop"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_workshop">
            <input type="hidden" name="workshop_name[]">
            <input type="hidden" name="workshop_venue[]">
            <input type="hidden" name="workshop_from[]">
            <input type="hidden" name="workshop_to[]">
            <input type="hidden" name="total[]">										 
        </span>

        <div class="ui modal modal_workshop">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Workshop</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_workshop">
                    <input type="hidden" id="modal_workshop_id">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Title</label>
                            <input type="text" id="modal_workshop_name">
                        </div>
                        <div class="eight wide field">
                            <label>Venue</label>
                            <input type="text" id="modal_workshop_venue">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>From</label>
                            <div class="ui calendar" id="workshop_from_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_workshop_from" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field">
                            <label>To</label>
                            <div class="ui calendar" id="workshop_to_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_workshop_to" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="modal_button_workshop"></span>
            </div>
        </div>
        <br><br><br>

<script>
    $('#modal_form_workshop').form({
        on: 'blur',
        fields: {
            modal_workshop_name  : 'empty',
            modal_workshop_venue : 'empty',
            modal_workshop_from  : 'empty',
            modal_workshop_to    : 'empty',
        } 
    }); 

    //Initialise the variables
    var workshop_name, workshop_venue, workshop_from, workshop_to;		
    function get_workshop_array(){
        //Get the Workshop Array
        workshop_name = $('[name="workshop_name[]"]');
        workshop_venue = $('[name="workshop_venue[]"]');
        workshop_from = $('[name="workshop_from[]"]');
        workshop_to = $('[name="workshop_to[]"]');
    }
    //Is called on Default for the Edit Functions
    get_workshop_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_workshop').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_workshop_id').val(id);
        $('#modal_workshop_name').val(workshop_name[id].value);
        $('#modal_workshop_venue').val(workshop_venue[id].value);
        $('#modal_workshop_from').val(workshop_from[id].value);
        $('#modal_workshop_to').val(workshop_to[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_workshop').html('<div class="ui blue right floated button" id="modal_workshop_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_workshop').modal('show');
        
        //Add Calender Script
        $('#script').html("<script>$('#workshop_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#workshop_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_workshop').on('click','#modal_workshop_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_workshop').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_workshop_id').val();
            //Update the Data
            add_workshop_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_workshop').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_workshop').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_workshop').html('<div class="ui blue right floated button" id="modal_workshop_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_workshop').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#workshop_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#workshop_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_workshop').on('click', '#modal_workshop_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_workshop').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_workshop').clone().appendTo('#hidden_form_holder_workshop');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="workshop_name[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_workshop_array();
            //Update the Data
            add_workshop_data(id);
        }
    });
    
    
    function add_workshop_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        workshop_name[id].value = $('#modal_workshop_name').val();
        workshop_venue[id].value = $('#modal_workshop_venue').val();
        workshop_from[id].value = $('#modal_workshop_from').val();
        workshop_to[id].value = $('#modal_workshop_to').val();
    
        //Submit the Hidden Form
        $('#form_workshop').submit();
    }	

    $('.delete_workshop').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_workshop').submit();

    });

</script>	


        <!--
            *
            *
            * FDP Section
            *
            * [{"fdp_name": "", "fdp_venue": "", "fdp_from": "", "fdp_to": "", "fdp_total": ""}]
        -->		
   
        <form class="ui form" method="POST" action="{{ route('staff.workshop.edit') }}" id="form_fdp" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>FDP</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="fdp">
                    <?php 
                    //Select the FDP JSON from the $data[]
                    $fdp_array = json_decode($data['fdp']);
                
                    foreach ($fdp_array as $object_key => $object) {
                        $total = dynamic_date($object->fdp_from,$object->fdp_to);
                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_fdp"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_fdp" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->fdp_name.'</h3>
                                <p>'.$object->fdp_venue.'</p>
                                <p>From: '.$object->fdp_from.' - '.$object->fdp_to.' | Total: '.$total.'</p>

                                
                                <input type="hidden" name="fdp_name[]" value="'.$object->fdp_name.'">
                                <input type="hidden" name="fdp_venue[]" value="'.$object->fdp_venue.'">
                                <input type="hidden" name="fdp_from[]" value="'.$object->fdp_from.'">
                                <input type="hidden" name="fdp_to[]" value="'.$object->fdp_to.'">
                                <input type="hidden" name="total[]" value="'.$total.'">										 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_fdp"></span>
                <br>
                <button class="ui button" id="add_fdp"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_fdp">
            <input type="hidden" name="fdp_name[]">
            <input type="hidden" name="fdp_venue[]">
            <input type="hidden" name="fdp_from[]">
            <input type="hidden" name="fdp_to[]">
            <input type="hidden" name="total[]">										 
        </span>

        <div class="ui modal modal_fdp">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>FDP</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_fdp">
                    <input type="hidden" id="modal_fdp_id">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Title</label>
                            <input type="text" id="modal_fdp_name">
                        </div>
                        <div class="eight wide field">
                            <label>Venue</label>
                            <input type="text" id="modal_fdp_venue">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>From</label>
                            <div class="ui calendar" id="fdp_from_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_fdp_from" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field">
                            <label>To</label>
                            <div class="ui calendar" id="fdp_to_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_fdp_to" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="modal_button_fdp"></span>
            </div>
        </div>
        <br><br><br>



<script>
    $('#modal_form_fdp').form({
        on: 'blur',
        fields: {
            modal_fdp_name  : 'empty',
            modal_fdp_venue : 'empty',
            modal_fdp_from  : 'empty',
            modal_fdp_to    : 'empty',
        } 
    }); 

    //Initialise the variables
    var fdp_name, fdp_venue, fdp_from, fdp_to;		
    function get_fdp_array(){
        //Get the FDP Array
        fdp_name = $('[name="fdp_name[]"]');
        fdp_venue = $('[name="fdp_venue[]"]');
        fdp_from = $('[name="fdp_from[]"]');
        fdp_to = $('[name="fdp_to[]"]');
    }
    //Is called on Default for the Edit Functions
    get_fdp_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_fdp').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_fdp_id').val(id);
        $('#modal_fdp_name').val(fdp_name[id].value);
        $('#modal_fdp_venue').val(fdp_venue[id].value);
        $('#modal_fdp_from').val(fdp_from[id].value);
        $('#modal_fdp_to').val(fdp_to[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_fdp').html('<div class="ui blue right floated button" id="modal_fdp_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_fdp').modal('show');
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_fdp').on('click','#modal_fdp_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_fdp').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_fdp_id').val();
            //Update the Data
            add_fdp_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_fdp').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_fdp').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_fdp').html('<div class="ui blue right floated button" id="modal_fdp_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_fdp').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#fdp_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#fdp_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_fdp').on('click', '#modal_fdp_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_fdp').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_fdp').clone().appendTo('#hidden_form_holder_fdp');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="fdp_name[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_fdp_array();
            //Update the Data
            add_fdp_data(id);
        }
    });
    
    
    function add_fdp_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        fdp_name[id].value = $('#modal_fdp_name').val();
        fdp_venue[id].value = $('#modal_fdp_venue').val();
        fdp_from[id].value = $('#modal_fdp_from').val();
        fdp_to[id].value = $('#modal_fdp_to').val();
    
        //Submit the Hidden Form
        $('#form_fdp').submit();
    }	

    $('.delete_fdp').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_fdp').submit();

    });

</script>	
<span id="script"></span>          
    </div>
</div>
@endsection