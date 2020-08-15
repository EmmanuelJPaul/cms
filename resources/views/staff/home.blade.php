@extends('layouts.staff')

@section('content')
<div class="main_content_wrapper">
    <div class="main_content">
    <!-- start of content -->
        <div class="ui center aligned placeholder segment">
            <h1>STAFF DETAILS</h1>
            <img src="assets/svg/teacher.svg" class="segment_svg">
        </div>
        <!-- <h1>STAFF DETAILS</h1>
        <div class="ui divider"></div> -->
        <br>	
        <div class="sub_section">
            <h3>Personal Details:</h3>
            <div class="ui right aligned">
                <button class="ui blue colored button" onclick="event.preventDefault(); document.getElementById('details-form').submit();">Save</button>
            </div>
            <form id="details-form" action="" method="POST" novalidate>
                @csrf
                <div class="ui form">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Name</label>
                            <input type="text">
                        </div>
                        <div class="eight wide field">
                            <label>Email</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="fields"> 
                        <div class="six wide field">
                            <label>Department</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="department">
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
                        <div class="five wide field">
                            <label>Designation</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="designation">
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
                            <label>Date Joined</label>
                            <div class="ui calendar" id="date_joined_calendar">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Profile Picture</label>
                        <div class="ui action input">
                            <input type="text" placeholder="-- Browse --" >
                            <input type="file" name="audio_file" hidden>
                            <div class="ui icon button">
                                <i class="attach icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <!------------------------------ Academic Qualification --------------------------->
        <div class="sub_section">
            <h3>Academic Qualification:</h3>
            <form method="POST" action="" novalidate>
                <div class="ui form">
                    <div class="fields">
                        <div class="eight wide field">
                            <label>Name</label>
                            <input type="text">
                        </div>
                        <div class="eight wide field">
                            <label>Email</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="fields"> 
                        <div class="six wide field">
                            <label>Department</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="department">
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
                        <div class="five wide field">
                            <label>Designation</label>
                            <div class="ui selection dropdown">
                                <input type="hidden" name="designation">
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
                            <label>Date Joined</label>
                            <div class="ui calendar" id="date_joined_calendar">
                                <div class="ui input left icon">
                                    <i class="alternate calendar outline icon"></i>
                                    <input type="text" placeholder="-- Pick Date --">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Profile Picture</label>
                        <div class="ui action input">
                            <input type="text" placeholder="-- Browse --" >
                            <input type="file" name="audio_file" hidden>
                            <div class="ui icon button">
                                <i class="attach icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div><!-- end of content-->
</div>
<script>
var today = new Date();
$('.selection.dropdown').dropdown();
$('#inline_calendar').calendar({
    type: 'date',
    minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() - 5),
    maxDate: new Date(),
    eventDates: [
        {
            date: new Date(),
            class: 'green'
        }
    ]

});

</script>
<!-- start of Js for tab/page function -->
<script>
function tabFunc(menuPages) {
    var i;
    var x = document.getElementsByClassName("pages");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
        }
    document.getElementById(menuPages).style.display = "block"; 

    //Clear prev Focus
    document.getElementsByClassName('ele_id').style.display = "none"; 
}

</script>
<!-- end of Js for tab/page function -->

<!-- Script For Details -->
<script>
$('#date_joined_calendar').calendar({
    type: 'month',
    minDate:  new Date(2011,5,0),
    maxDate: new Date()
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

@endsection