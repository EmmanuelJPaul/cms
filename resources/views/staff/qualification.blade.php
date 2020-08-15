@extends('layouts.staff')

@section('content')
<?php 
    function dynamic_date($from, $to){
        $from_date = date_create(date('Y-m-d', strtotime($from)));
        $to_date = date_create(date('Y-m-d', strtotime($to)));
        $diff = date_diff($from_date, $to_date);
        return $diff->format("%y Year %m Month");
    }

    //Creating the Degree Dropdown Menu
    $degree_dropdown = '';
    foreach($degrees as $degree) {
        $degree_dropdown .= '<div class="item" data-value="'.$degree->degree.'">'.$degree->degree.'</div>';
    }

?>
<div class="main_content_wrapper">
    <div class="main_content">
        <!-- start of content -->
        <!--
            *
            *
            * Academic Qualification Section
            *
            * 
        -->
        <form class="ui form" method="POST" id="form_academic" action="{{ route('staff.qualification.edit') }}" autocomplete="off">
            @csrf
            <div class="display_details">		
        
            <h2>Academic Qualification</h2>
            <div class="ui divider"></div>
            <input type="hidden" name="field" value="academic_qualification">
                <?php 
                //Select the Academic JSON from the $data[]
                $academic_array = json_decode($data['academic_qualification']);
            
                foreach ($academic_array as $object_key => $object) {
                    print(' 
                        <span id="entry">
                            <button class="ui icon_btn button right floated delete_academic"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                            <button class="ui icon_btn button right floated edit_academic" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                            <h3>'.$object->degree.' '.$object->specialization.'</h3>
                            <p>'.$object->college.', '.$object->university.'</p>
                            <p>CGPA: '.$object->cgpa.'/10 | '.$object->class.'</p>

                            
                            <input type="hidden" name="degree[]" value="'.$object->degree.'">
                            <input type="hidden" name="specialization[]" value="'.$object->specialization.'">
                            <input type="hidden" name="college[]" value="'.$object->college.'">
                            <input type="hidden" name="university[]" value="'.$object->university.'">
                            <input type="hidden" name="cgpa[]" value="'.$object->cgpa.'">
                            <input type="hidden" name="class[]" value="'.$object->class.'">
                            
                        </span>
                    ');
                }

            ?>
                <span id="hidden_form_holder_academic"></span>
                <br>
                <button class="ui button" id="add_academic"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_academic">
            <input type="hidden" name="degree[]">
            <input type="hidden" name="specialization[]">
            <input type="hidden" name="college[]">
            <input type="hidden" name="university[]">
            <input type="hidden" name="cgpa[]">
            <input type="hidden" name="class[]">
        </span>

        <div class="ui modal modal_academic">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Academic Qualification</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_academic">
                    <input type="hidden" id="modal_academic_id">
                    <div class="fields">
                        <div class="four wide field">
                            <label>Degree</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_academic_degree" value="">
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <?php print($degree_dropdown); ?>
                                </div>
                            </div>
                        </div>
                        <div class="twelve wide field">
                            <label>Specialization</label>
                            <input type="text" id="modal_academic_specialization">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>College</label>
                            <input type="text" id="modal_academic_college">
                        </div>
                        <div class="eight wide field">
                            <label>University</label>
                            <input type="text" id="modal_academic_university">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>CGPA</label>
                            <input type="text" id="modal_academic_cgpa">
                            <p class="sub_label">(x/10)</p>
                        </div>
                        <div class="eight wide field">
                            <label>Class</label>
                            <input type="text" id="modal_academic_class">
                        </div>
                    </div>
                </div>
                <span id="modal_button_academic"></span>
            </div>
        </div>
        <br><br><br>
<script>
    $('.selection.dropdown').dropdown();
    
    $('#modal_form_academic').form({
        on: 'blur',
        fields: {
            modal_academic_degree         : 'empty',
            modal_academic_specialization : 'empty',
            modal_academic_college        : 'empty',
            modal_academic_university     : 'empty',
            modal_academic_cgpa     : 'empty',
            modal_academic_class_     : 'empty',
        } 
    });              

    //Initialise the variables
    var degree, specialization, college, university, cgpa, class_;		
    function get_academic_array(){
        //Get the Academic Qualification Array
        degree = $('[name="degree[]"]');
        specialization = $('[name="specialization[]"]');
        college = $('[name="college[]"]');
        university = $('[name="university[]"]');
        cgpa = $('[name="cgpa[]"]');
        class_ = $('[name="class[]"]');

    }
    //Is called on Default for the Edit Functions
    get_academic_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_academic').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_academic_id').val(id);
        $('#modal_academic_degree').val(degree[id].value);
        $('#modal_academic_specialization').val(specialization[id].value);
        $('#modal_academic_college').val(college[id].value);
        $('#modal_academic_university').val(university[id].value);
        $('#modal_academic_cgpa').val(cgpa[id].value);
        $('#modal_academic_class').val(class_[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_academic').html('<div class="ui blue right floated button" id="modal_academic_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_academic').modal('show');
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_academic').on('click','#modal_academic_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_academic').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_academic_id').val();
            //Update the Data
            add_academic_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_academic').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_academic').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_academic').html('<div class="ui blue right floated button" id="modal_academic_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_academic').modal('show');
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_academic').on('click', '#modal_academic_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_academic').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_academic').clone().appendTo('#hidden_form_holder_academic');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="degree[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_academic_array();
            //Update the Data
            add_academic_data(id);
        }
    });
    
    
    function add_academic_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        degree[id].value = $('#modal_academic_degree').val();
        specialization[id].value = $('#modal_academic_specialization').val();
        college[id].value = $('#modal_academic_college').val();
        university[id].value = $('#modal_academic_university').val();
        cgpa[id].value = $('#modal_academic_cgpa').val();
        class_[id].value = $('#modal_academic_class').val();

        //Submit the Hidden Form
        $('#form_academic').submit();
    }	

    $('.delete_academic').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_academic').submit();

    });

</script>	
        

                
                                
        <!--
            *
            *
            * Experience Section
            *
            * 
        -->		

        <form class="ui form" method="POST" action="{{ route('staff.qualification.edit') }}" id="form_experience" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>Experience</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="experience">
                    <?php 
                    //Select the Experience JSON from the $data[]
                    $experience_array = json_decode($data['experience']);
                
                    foreach ($experience_array as $object_key => $object) {
                        $total = dynamic_date($object->from,$object->to);
                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_experience"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_experience" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->job_title.'</h3>
                                <p>'.$object->institution.'</p>
                                <p>From: '.$object->from.' - '.$object->to.' | Total: '.$total.'</p>

                                
                                <input type="hidden" name="job_title[]" value="'.$object->job_title.'">
                                <input type="hidden" name="institution[]" value="'.$object->institution.'">
                                <input type="hidden" name="from[]" value="'.$object->from.'">
                                <input type="hidden" name="to[]" value="'.$object->to.'">
                                <input type="hidden" name="total[]" value="'.$total.'">										 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_experience"></span>
                <br>
                <button class="ui button" id="add_experience"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_experience">
            <input type="hidden" name="job_title[]">
            <input type="hidden" name="institution[]">
            <input type="hidden" name="from[]">
            <input type="hidden" name="to[]">
            <input type="hidden" name="total[]">										 
        </span>

        <div class="ui modal modal_experience">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Experience</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_experience">
                    <input type="hidden" id="modal_experience_id">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Title</label>
                            <input type="text" id="modal_experience_job_title">
                        </div>
                        <div class="eight wide field">
                            <label>Institution</label>
                            <input type="text" id="modal_experience_institution">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="eight wide field">
                            <label>From</label>
                            <div class="ui calendar" id="experience_from_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_experience_from" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                        <div class="eight wide field">
                            <label>To</label>
                            <div class="ui calendar" id="experience_to_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_experience_to" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="modal_button_experience"></span>
            </div>
        </div>
        <br><br><br>
    </div>
</div> 
<script>

    $('#modal_form_experience').form({
        on: 'blur',
        fields: {
            modal_experience_job_title   : 'empty',
            modal_experience_institution : 'empty',
            modal_experience_from        : 'empty',
            modal_experience_to          : 'empty',
        } 
    }); 

    //Initialise the variables
    var job_title, institution, from, to;		
    function get_experience_array(){
        //Get the Experience Array
        job_title = $('[name="job_title[]"]');
        institution = $('[name="institution[]"]');
        from = $('[name="from[]"]');
        to = $('[name="to[]"]');
    }
    //Is called on Default for the Edit Functions
    get_experience_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_experience').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_experience_id').val(id);
        $('#modal_experience_job_title').val(job_title[id].value);
        $('#modal_experience_institution').val(institution[id].value);
        $('#modal_experience_from').val(from[id].value);
        $('#modal_experience_to').val(to[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_experience').html('<div class="ui blue right floated button" id="modal_experience_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_experience').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#experience_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#experience_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_experience').on('click','#modal_experience_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_experience').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_experience_id').val();
            //Update the Data
            add_experience_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_experience').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_experience').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_experience').html('<div class="ui blue right floated button" id="modal_experience_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_experience').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#experience_from_calender').calendar({type: 'date',maxDate: new Date(),});$('#experience_to_calender').calendar({type: 'date',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_experience').on('click', '#modal_experience_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_experience').form('is valid')) { 
            //Create a new empty Hidden Form
            $('#hidden_form_experience').clone().appendTo('#hidden_form_holder_experience');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="job_title[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_experience_array();
            //Update the Data
            add_experience_data(id);
        }
    });
    
    
    function add_experience_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        job_title[id].value = $('#modal_experience_job_title').val();
        institution[id].value = $('#modal_experience_institution').val();
        from[id].value = $('#modal_experience_from').val();
        to[id].value = $('#modal_experience_to').val();
    
        //Submit the Hidden Form
        $('#form_experience').submit();
    }	

    $('.delete_experience').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_experience').submit();

    });

</script>	

<span id="script"></span> 

@endsection