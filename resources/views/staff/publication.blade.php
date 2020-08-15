@extends('layouts.staff')

@section('content')
<?php 
    function dynamic_date($conference_name, $to){
        $from_date = date_create(date('Y-m-d', strtotime($from)));
        $to_date = date_create(date('Y-m-d', strtotime($to)));
        $diff = date_diff($from_date, $to_date);
        return $diff->format("%y Year %m Month");
    }
?>
<div class="main_content_wrapper">
    <div class="main_content">
    <!-- start of content -->
        <!--
            *
            *
            * Journal Qualification Section
            *
            * 
        -->
        <form class="ui form" method="POST" id="form_journal" action="{{ route('staff.publication.edit') }}" autocomplete="off">
            @csrf
            <div class="display_details">		
        
            <h2>Journal</h2>
            <div class="ui divider"></div>
            <input type="hidden" name="field" value="journal">
                <?php 
                //Select the Journal JSON from the $data[]
                $journal_array = json_decode($data['journal']);
            
                foreach ($journal_array as $object_key => $object) {
                    print(' 
                        <span id="entry">
                            <button class="ui icon_btn button right floated delete_journal"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                            <button class="ui icon_btn button right floated edit_journal" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                            <h3>'.$object->journal_title.'</h3>
                            <p>'.$object->journal_name.' ('.$object->journal_type.')</p>
                            <p>Volume: '.$object->journal_volume.' | Page No: '.$object->journal_page_number.' | Citations: '.$object->journal_citations.'</p>
                            <p>'.$object->journal_date.' | '.$object->journal_publication_type.'</p>
                            
                            <input type="hidden" name="journal_title[]" value="'.$object->journal_title.'">
                            <input type="hidden" name="journal_publication_type[]" value="'.$object->journal_publication_type.'">
                            <input type="hidden" name="journal_name[]" value="'.$object->journal_name.'">
                            <input type="hidden" name="journal_type[]" value="'.$object->journal_type.'">
                            <input type="hidden" name="journal_volume[]" value="'.$object->journal_volume.'">
                            <input type="hidden" name="journal_page_number[]" value="'.$object->journal_page_number.'">
                            <input type="hidden" name="journal_citations[]" value="'.$object->journal_citations.'">
                            <input type="hidden" name="journal_date[]" value="'.$object->journal_date.'">

                        </span>
                    ');
                }

            ?>
                <span id="hidden_form_holder_journal"></span>
                <br>
                <button class="ui button" id="add_journal"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_journal">
            <input type="hidden" name="journal_title[]">
            <input type="hidden" name="journal_publication_type[]">
            <input type="hidden" name="journal_name[]">
            <input type="hidden" name="journal_type[]">
            <input type="hidden" name="journal_volume[]">
            <input type="hidden" name="journal_page_number[]">
            <input type="hidden" name="journal_citations[]">
            <input type="hidden" name="journal_date[]">
        </span>

        <div class="ui modal modal_journal">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Journals</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_journal">
                    <input type="hidden" id="modal_journal_id">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Title</label>
                            <input id="modal_journal_title" name="modal_journal_title" type="text">
                        </div>
                        <div class="four wide field">
                            <label>Type</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_journal_publication_type">
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <div class="item" data-value="National">National</div>
                                    <div class="item" data-value="International">International</div>
                                </div>
                            </div>
                        </div>
                        <div class="four wide field">
                            <label>Journal</label>
                            <input id="modal_journal_name" type="text">
                        </div>
                    </div>
                    <div class="fields"> 
                        <div class="three wide field">
                            <label>Journal Type</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_journal_type">
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <div class="item" data-value="UGC">UGC</div>
                                    <div class="item" data-value="SCOPUS">SCOPUS</div>
                                    <div class="item" data-value="WOS">WOS</div>
                                    <div class="item" data-value="DOI">DOI</div>
                                </div>
                            </div>													    
                        </div>
                        <div class="four wide field">
                            <label>Volume</label>
                            <input id="modal_journal_volume" type="text">
                        </div>
                        <div class="two wide field">
                            <label>Page Number</label>
                            <input id="modal_journal_page_number" type="text">
                        </div>
                        <div class="four wide field">
                            <label>Citations</label>
                            <input id="modal_journal_citations" type="text">
                        </div>
                        <div class="three wide field">
                            <label>Date</label>
                            <div class="ui calendar" id="journal_month_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_journal_date" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <span id="modal_button_journal"></span>
            </div>
        </div>
        <br><br><br>
<script>
    $('.selection.dropdown').dropdown();

    $('#modal_form_journal').form({
        on: 'blur',
        fields: {
            modal_journal_title            : 'empty',
            modal_journal_publication_type : 'empty',
            modal_journal_name             : 'empty',
            modal_journal_type             : 'empty',
            modal_journal_volume           : 'empty',
            modal_journal_page_number      : 'empty',
            modal_journal_citations        : 'empty',
            modal_journal_date             : 'empty'
        } 
    });          
    //Initialise the variables
    var journal_title, journal_publication_type, journal_name, journal_type, journal_volume, journal_page_number, journal_citations, journal_date;		
    function get_journal_array(){
        //Get the Journal Array
        journal_title = $('[name="journal_title[]"]');
        journal_publication_type = $('[name="journal_publication_type[]"]');
        journal_name = $('[name="journal_name[]"]');
        journal_type = $('[name="journal_type[]"]');
        journal_volume = $('[name="journal_volume[]"]');
        journal_page_number = $('[name="journal_page_number[]"]');
        journal_citations = $('[name="journal_citations[]"]');
        journal_date = $('[name="journal_date[]"]');

    }
    //Is called on Default for the Edit Functions
    get_journal_array();

    /*
        *
        * Edit Functionalities
        *
        */
    //Triggered when Edit Button is Clicked
    $('.edit_journal').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_journal_id').val(id);
        $('#modal_journal_title').val(journal_title[id].value);
        $('#modal_journal_publication_type').val(journal_publication_type[id].value);
        $('#modal_journal_name').val(journal_name[id].value);
        $('#modal_journal_type').val(journal_type[id].value);
        $('#modal_journal_volume').val(journal_volume[id].value);
        $('#modal_journal_page_number').val(journal_page_number[id].value);
        $('#modal_journal_citations').val(journal_citations[id].value);
        $('#modal_journal_date').val(journal_date[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_journal').html('<div class="ui blue right floated button" id="modal_journal_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_journal').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#journal_month_calender').calendar({type: 'month',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_journal').on('click','#modal_journal_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_journal').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_journal_id').val();
            //Update the Data
            add_journal_data(id);
        }
    });


    //Triggered when Add Button is Clicked
    $('#add_journal').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_journal').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_journal').html('<div class="ui blue right floated button" id="modal_journal_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_journal').modal('show');
        
        //Add Calender Script
        $('#script').html("<script>$('#journal_month_calender').calendar({type: 'month',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_journal').on('click', '#modal_journal_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_journal').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_journal').clone().appendTo('#hidden_form_holder_journal');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="journal_title[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_journal_array();
            //Update the Data
            add_journal_data(id);
        }
    });
    
    
    function add_journal_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        journal_title[id].value = $('#modal_journal_title').val();
        journal_publication_type[id].value = $('#modal_journal_publication_type').val();
        journal_name[id].value = $('#modal_journal_name').val();
        journal_type[id].value = $('#modal_journal_type').val();
        journal_volume[id].value = $('#modal_journal_volume').val();
        journal_page_number[id].value = $('#modal_journal_page_number').val();
        journal_citations[id].value = $('#modal_journal_citations').val();
        journal_date[id].value = $('#modal_journal_date').val();

        
        //Submit the Hidden Form
        $('#form_journal').submit();
        
       
    }	

    $('.delete_journal').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_journal').submit();

    });

</script>

        <!--
            *
            *
            * Book Section
            *
            * 
        -->		

        <form class="ui form" method="POST" action="{{ route('staff.publication.edit') }}" id="form_book" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>Books</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="book">
                    <?php 
                    //Select the Book JSON from the $data[]
                    $book_array = json_decode($data['book']);
                
                    foreach ($book_array as $object_key => $object) {

                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_book"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_book" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->book_title.'</h3>
                                <p>Authors: '.$object->book_author.', '.$object->book_author_2.', '.$object->book_author_3.'</p>
                                <p>Publisher: '.$object->book_publisher.' | ISSN: '.$object->book_issn.'</p>
                                <p>'.$object->book_year.'</p>

                                
                                <input type="hidden" name="book_title[]" value="'.$object->book_title.'">
                                <input type="hidden" name="book_author[]" value="'.$object->book_author.'">
                                <input type="hidden" name="book_author_2[]" value="'.$object->book_author_2.'">
                                <input type="hidden" name="book_author_3[]" value="'.$object->book_author_3.'">
                                <input type="hidden" name="book_publisher[]" value="'.$object->book_publisher.'">
                                <input type="hidden" name="book_year[]" value="'.$object->book_year.'">
                                <input type="hidden" name="book_issn[]" value="'.$object->book_issn.'">										 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_book"></span>
                <br>
                <button class="ui button" id="add_book"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_book">
            <input type="hidden" name="book_title[]">
            <input type="hidden" name="book_author[]">
            <input type="hidden" name="book_author_2[]">
            <input type="hidden" name="book_author_3[]">
            <input type="hidden" name="book_publisher[]">
            <input type="hidden" name="book_year[]">
            <input type="hidden" name="book_issn[]">										 
        </span>

        <div class="ui modal modal_book">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Book</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_book">
                    <input type="hidden" id="modal_book_id">
                    <div class="fields">
                        <div class="five wide field">
                            <label>Title</label>
                            <input id="modal_book_title" type="text">
                        </div>
                        <div class="five wide field">
                            <label>Publisher</label>
                            <input id="modal_book_publisher" type="text">
                        </div>
                        <div class="three wide field">
                            <label>Date</label>
                            <div class="ui calendar" id="book_month_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_book_year" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                        <div class="three wide field">
                            <label>ISSN Number</label>
                            <input id="modal_book_issn" type="text">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="six wide field">
                            <label>Author</label>
                            <input id="modal_book_author" type="text">
                        </div>
                        <div class="five wide field">
                            <label>Author 2</label>
                            <input id="modal_book_author_2" type="text">
                        </div>
                        <div class="five wide field">
                            <label>Author 3</label>
                            <input id="modal_book_author_3" type="text">
                        </div>
                    </div>
                </div>
                <span id="modal_button_book"></span>
            </div>
        </div>
        <br><br><br>




<script>
    /**
     * Form Validation Setup
     */
    $('#modal_form_book').form({
        on: 'blur',
        fields: {
            modal_book_title        : 'empty',
            modal_book_author       : 'empty',
            modal_book_publisher    : 'empty',
            modal_book_year         : 'empty',
            modal_book_issn         : 'empty'
        } 
    }); 

    //Initialise the variables
    var book_title, book_author, book_publisher, book_year, book_issn;		
    function get_book_array(){
        //Get the Book Array
        book_title = $('[name="book_title[]"]');
        book_author = $('[name="book_author[]"]');
        book_author_2 = $('[name="book_author_2[]"]');
        book_author_3 = $('[name="book_author_3[]"]');
        book_publisher = $('[name="book_publisher[]"]');
        book_year = $('[name="book_year[]"]');
        book_issn = $('[name="book_issn[]"]');
    }
    //Is called on Default for the Edit Functions
    get_book_array();

    /*
    *
    * Edit Functionalities
    *
    */
    //Triggered when Edit Button is Clicked
    $('.edit_book').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_book_id').val(id);
        $('#modal_book_title').val(book_title[id].value);
        $('#modal_book_author').val(book_author[id].value);
        $('#modal_book_author_2').val(book_author_2[id].value);
        $('#modal_book_author_3').val(book_author_3[id].value);
        $('#modal_book_publisher').val(book_publisher[id].value);
        $('#modal_book_year').val(book_year[id].value);
        $('#modal_book_issn').val(book_issn[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_book').html('<div class="ui blue right floated button" id="modal_book_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_book').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#book_month_calender').calendar({type: 'month',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_book').on('click','#modal_book_save', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_book').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_book_id').val();
            //Update the Data
            add_book_data(id);
        }
    });

    /*
     *
     * Add Functionalities
     *
    */
    //Triggered when Add Button is Clicked
    $('#add_book').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_book').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_book').html('<div class="ui blue right floated button" id="modal_book_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_book').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#book_month_calender').calendar({type: 'month',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_book').on('click', '#modal_book_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_book').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_book').clone().appendTo('#hidden_form_holder_book');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="book_title[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_book_array();
            //Update the Data
            add_book_data(id);
        }

    });
    
    
    function add_book_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        book_title[id].value = $('#modal_book_title').val();
        book_author[id].value = $('#modal_book_author').val();
        book_author_2[id].value = $('#modal_book_author_2').val();
        book_author_3[id].value = $('#modal_book_author_3').val();
        book_publisher[id].value = $('#modal_book_publisher').val();
        book_year[id].value = $('#modal_book_year').val();
        book_issn[id].value = $('#modal_book_issn').val();

      
        //Submit the Hidden Form
        $('#form_book').submit();
        
    }	

    $('.delete_book').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_book').submit();

    });

</script>	


        <!--
            *
            *
            * Conference Section
            *
            * 
        -->		

        <form class="ui form" method="POST" action="{{ route('staff.qualification.edit') }}" id="form_conference" autocomplete="off">
            @csrf
            <div class="display_details">		
                <h2>Conference</h2>
                <div class="ui divider"></div>
                <input type="hidden" name="field" value="conference">
                    <?php 
                    //Select the Conference JSON from the $data[]
                    $conference_array = json_decode($data['conference']);
                
                    foreach ($conference_array as $object_key => $object) {

                        print(' 
                            <span id="entry">
                                <button class="ui icon_btn button right floated delete_conference"  data-id="'.$object_key.'"><i class="times icon"></i></button>
                                <button class="ui icon_btn button right floated edit_conference" data-id="'.$object_key.'"><i class="pen icon"></i></button>
                                <h3>'.$object->conference_title.'</h3>
                                <p>Conference: '.$object->conference_name.' ('.$object->conference_publication_type.')</p>
                                <p>'.$object->conference_date.'</p>

                                
                                <input type="hidden" name="conference_title[]" value="'.$object->conference_title.'">
                                <input type="hidden" name="conference_publication_type[]" value="'.$object->conference_publication_type.'">
                                <input type="hidden" name="conference_name[]" value="'.$object->conference_name.'">
                                <input type="hidden" name="conference_date[]" value="'.$object->conference_date.'">									 
                                
                            </span>
                        ');
                    }

                ?>
                <span id="hidden_form_holder_conference"></span>
                <br>
                <button class="ui button" id="add_conference"><i class="plus icon"></i> Add</button>
            </div>
        </form>
        <span id="hidden_form_conference">
            <input type="hidden" name="conference_title[]">
            <input type="hidden" name="conference_publication_type[]">
            <input type="hidden" name="conference_name[]">
            <input type="hidden" name="conference_date[]">										 
        </span>

        <div class="ui modal modal_conference">
            <i class="close icon"></i>
            <div style="text-align: center; margin: 30px;">
                <h2>Conference</h2>				    	
            </div>
            <div class="content" style="padding-right: 30px; padding-left: 30px">
                <div class="ui form" id="modal_form_conference">
                    <input type="hidden" id="modal_conference_id">
                    <div class="fields">
                        <div class="twelve wide field">
                            <label>Title</label>
                            <input type="text" id="modal_conference_title" required>
                        </div>
                        <div class="four wide field">
                            <label>Type</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" id="modal_conference_publication_type" required>
                                <i class="dropdown icon"></i>
                                <div class="default text">-- Select --</div>
                                <div class="menu">
                                    <div class="item" data-value="National">National</div>
                                    <div class="item" data-value="International">International</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fields">
                        <div class="twelve wide field">
                            <label>Conference Name</label>
                            <input type="text" id="modal_conference_name" required>
                        </div>
                        <div class="four wide field">
                            <label>Date</label>
                            <div class="ui calendar" id="conference_month_calender">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" id="modal_conference_date" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span id="modal_button_conference"></span>
            </div>
        </div>
        <br><br><br>
  
    </div>
</div> 	
<span id="script"></span>
<script>
    $('#modal_form_conference').form({
        on: 'blur',
        fields: {
            modal_conference_title            : 'empty',
            modal_conference_publication_type : 'empty',
            modal_conference_name             : 'empty',
            modal_conference_date             : 'empty',
        } 
    }); 
    
    //Initialise the variables
    var conference_title, conference_publication_type, conference_name, conference_date;		
    function get_conference_array(){
        //Get the Conference Array
        conference_title = $('[name="conference_title[]"]');
        conference_publication_type = $('[name="conference_publication_type[]"]');
        conference_name = $('[name="conference_name[]"]');
        conference_date = $('[name="conference_date[]"]');
    }
    //Is called on Default for the Edit Functions
    get_conference_array();

    /*
     *
     * Edit Functionalities
     *
    */
    //Triggered when Edit Button is Clicked
    $('.edit_conference').on('click', function(event){
        event.preventDefault();
        //Get the ID of the Entry from the Hidden Form
        var id = $(this).attr('data-id');

        //Assign the values in the Modal Form from the Hidden Form
        $('#modal_conference_id').val(id);
        $('#modal_conference_title').val(conference_title[id].value);
        $('#modal_conference_publication_type').val(conference_publication_type[id].value);
        $('#modal_conference_name').val(conference_name[id].value);
        $('#modal_conference_date').val(conference_date[id].value);

        //Change the Button in the Modal to a Save Button
        $('#modal_button_conference').html('<div class="ui blue right floated button" id="modal_conference_save" style="margin-bottom: 15px;">Save</div>');

        //Toggle the Modal
        $('.ui.modal_conference').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#conference_month_calender').calendar({type: 'month',maxDate: new Date(),});<\/script>");
    });

    //Triggered when Save Button in Modal is Clicked
    $('#modal_button_conference').on('click','#modal_conference_save', function(event){
        event.preventDefault();
        //Validate the Form
        if ($('#modal_form_conference').form('is valid')) {
            //Get the ID of the Entry from the Modal Form
            var id = $('#modal_conference_id').val();
            //Update the Data
            add_conference_data(id);
        }
    });


    /*
     *
     * Add Functionalities
     *
    */

    //Triggered when Add Button is Clicked
    $('#add_conference').on('click', function(event){
        event.preventDefault();
        //Clear the values in the Modal Form
        $('#modal_form_conference').form('clear');

        //Change the Button in the Modal to a Add Button
        $('#modal_button_conference').html('<div class="ui blue right floated button" id="modal_conference_add" style="margin-bottom: 15px;">Add</div>');

        //Toggle the Modal
        $('.ui.modal_conference').modal('show');

        //Add Calender Script
        $('#script').html("<script>$('#conference_month_calender').calendar({type: 'month',maxDate: new Date(),});<\/script>");
    });


    //Triggered when Add Button in the Modal is Clicked
    $('#modal_button_conference').on('click', '#modal_conference_add', function(event){
        event.preventDefault();

        //Validate the Form
        if ($('#modal_form_conference').form('is valid')) {
            //Create a new empty Hidden Form
            $('#hidden_form_conference').clone().appendTo('#hidden_form_holder_conference');
            
            //Get the Last Index of the Hidden Input Fields
            var id = $('[name="conference_title[]"]').length - 2;
            //Is called on Again incase of the Add Functions
            get_conference_array();
            //Update the Data
            add_conference_data(id);
        }
    });
    
    
    function add_conference_data(id){
        //Update the values in the Hidden Form from the Modal Form 
        conference_title[id].value = $('#modal_conference_title').val();
        conference_publication_type[id].value = $('#modal_conference_publication_type').val();
        conference_name[id].value = $('#modal_conference_name').val();
        conference_date[id].value = $('#modal_conference_date').val();
    
        //Submit the Hidden Form
        $('#form_conference').submit();
    }	

    $('.delete_conference').on('click', function(event){
        event.preventDefault();

        //Remove the Entry
        $(this).parent().remove();

        //Submit the Hidden Form
        $('#form_conference').submit();

    });

</script>
@endsection