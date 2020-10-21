//These Values Hold the Modal and Hidden Form Values
var holders, elements, field, validator;

/**
 *
 * Editing Functionalities
 *
 */

//Gets the Values of the Selected Hidden Form

$('.edit').on('click', function (event) {
    event.preventDefault();

    //Stores the Hidden Form Array
    elements = $(this).parent().children(':input[type=hidden]');

    //Gets the Field of the selected Hidden Form (eg: academic_qulification, experience)
    var field_tag = $(this).parent().parent().children('input[type=hidden]');
    field = field_tag[0].value;

    //Contains the Respective Modal Form Array
    holders = $('#modal_form_' + field).find(':input');

    for (var i = 0; i < holders.length; i++) {
        holders[i].value = elements[i].value;
    }

    //Change the Button in the Modal to a Save Button
    var button = $('#modal_form_' + field + ' .modal_button');
    button.html('<div class="ui blue right floated button" id="modal_save" style="margin-bottom: 15px;">Save</div>');

    //Toggle the Modal
    $('.ui.modal_' + field).modal('show');

    //Add Calendar Scripts
    $('#' + field + '_date_calendar_1, #'+ field +'_date_calendar_2').calendar({
        type: 'date',
        maxDate: new Date(),
    });
    $('#' + field + '_month_calendar_1,  #' + field + '_month_calendar_2').calendar({
        type: 'month',
        maxDate: new Date(),
    });
    $('#' + field + '_year_calendar').calendar({
        type: 'year',
        maxDate: new Date(),
    });
});



$('.modal_button').on('click', '#modal_save', function (event) {
    event.preventDefault();

    //Generate Dynamic Validator Script
    validator(field, holders);

    //Validate the Form
    $('#modal_form_' + field).form('submit');

    if ($('#modal_form_' + field).form('is valid')) {
        //Replaces the Values From the Modal to the Hidden Form
        for (var i = 0; i < holders.length; i++) {
            elements[i].value = holders[i].value;
        }
        //Toggle the Model
        $('.ui.modal_' + field).modal('hide');

        //Submit the Hidden Form
        $('#form_' + field).form('submit');
    }

});




/**
 *
 * Adding Functionalities
 *
 */

$('.add').on('click', function (event) {
    event.preventDefault();


    //Stores the Hidden Form Array
    elements = $(this).parent().children(':input[type=hidden]');

    //Gets the Field of the selected Hidden Form (eg: academic_qulification, experience)
    var field_tag = $(this).siblings('input[type=hidden]');
    field = field_tag[0].value;

    //Contains the Respective Modal Form Array
    holders = $('#modal_form_' + field).find(':input');
    for (var i in holders) {
        holders[i].value = '';
    }

    //Change the Button in the Modal to a Add Button
    var button = $('#modal_form_' + field + ' .modal_button');
    button.html('<div class="ui blue right floated button" id="modal_add" style="margin-bottom: 15px;">Add</div>');

    //Toggle the Model
    $('.ui.modal_' + field).modal('show');

    //Add Calendar Scripts
    $('#' + field + '_date_calendar_1, #' + field + '_date_calendar_2').calendar({
        type: 'date',
        maxDate: new Date(),
    });
    $('#' + field + '_month_calendar_1,  #' + field + '_month_calendar_2').calendar({
        type: 'month',
        maxDate: new Date(),
    });
    $('#' + field + '_year_calendar').calendar({
        type: 'year',
        maxDate: new Date(),
    });

});


$('.modal_button').on('click', '#modal_add', function (event) {
    event.preventDefault();

    //Generate Dynamic Validator Script
    validator(field, holders);

    //Validate the Form
    $('#modal_form_' + field).form('submit');

    if ($('#modal_form_' + field).form('is valid')) {

        //Replaces the Values from the Modal to the Temp Hidden Form
        var tmp_fields = $('#hidden_form_' + field).children();
        for (var i in holders) {
            tmp_fields[i].value = holders[i].value;
        }

        //Copy the Temp Form to the Hidden Form
        $('#hidden_form_' + field).clone().appendTo('#hidden_form_holder_' + field);

        //Toggle the Model
        $('.ui.modal_' + field).modal('hide');

        //Submit the Hidden Form
        $('#form_' + field).form('submit');
    }

});


/**
 *
 * Deleting Functionalities
 *
 */

$('.delete').on('click', function (event) {
    event.preventDefault();

    //Get the Entry
    var entry = $(this).parent();
    //Gets the Field of the selected Hidden Form (eg: academic_qulification, experience)
    var field_tag = $(this).parent().parent().children('input[type=hidden]');
    field = field_tag[0].value;

    //Toggle Alert Model
    $('.alert.modal').modal('show');

    //Confirms the Delete
    $('#confirm_delete').on('click', function (event) {
        event.preventDefault();

        //Remove the Entry
        entry.remove();
       
        //Toggle Alert Model
        $('.alert.modal').modal('hide');

        //Submit the Hidden Form
        $('#form_' + field).form('submit');
    });

    //Cancels the delete
    $('#cancel_delete').on('click', function () {
        $('.alert.modal').modal('hide');
    })

});


function validator(field, form_array, action="") {

    var validator = "<script>$('#modal_form_" + field + "').form({" + action + " inline: true,fields: {";
    for (var i = 0; i < form_array.length; i++) {
        var tag_id = form_array[i].id;
        validator += tag_id + ": { rules: [";
        if (form_array[i].required) {
            //If Field is Required
            validator += "{type: 'empty', prompt: 'This field is required!'},";
        }
        if (form_array[i].minLength != -1) {
            validator += "{type: 'minLength[" + form_array[i].minLength + "]', prompt: 'Min Length is " + form_array[i].minLength + "!'},";
        }
        if (form_array[i].maxLength != -1) {
            validator += "{type: 'maxLength[" + form_array[i].maxLength + "]', prompt: 'Max Length is " + form_array[i].maxLength + "!'},";
        }
        if (form_array[i].pattern) {
            validator += "{type: 'regExp[" + form_array[i].pattern + "]', prompt: 'Invalid Format!'},";
        }
        validator += "]},";
    }
    validator += "}});<\/script>";
    $('#validator').html(validator);

}