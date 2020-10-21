@extends('layouts.dashboard')

@section('content')
<?php 
     function dynamic_date($from, $to){
        $from_date = date_create(date('Y-m-d', strtotime($from)));
        $to_date = date_create(date('Y-m-d', strtotime($to . '+1 day')));
        $diff = date_diff($from_date, $to_date);
        return $diff->format("%y Year %m Month %d Day");
    }
?>
<div class="main_content_wrapper">
	<br><br>
	<div class="ui stackable centered grid">
		<div class="sixteen wide column">
			<div class="ui grid">
				<div class="nine wide column">
					<h2 style="margin-bottom: 0px">Profile</h2>
					<div class="ui breadcrumb">
						<a href="{{ route('staff.') }}" class="section">Home</a>
						<i class="right angle icon divider"></i>
						<a class="disable section">Search</a>
                        <i class="right angle icon divider"></i>
						<a class="active section">Profile</a>
					</div>
				</div>
				
			</div>
		</div>
		<div class="sixteen wide column">			
			<div class="widget">
				<div class="widget-banner">
					<img src="{{ asset('/images/web-banner.jpg') }}">
					<em onclick="cc('{{ $data['staff_id'] }}')">#{{ $data['staff_id'] }}<i class="clipboard outline icon"></i></em>
					
				</div>	
				<div class="profile">
					<div class="basic">
						<div class="pic">
							<img class="ui circular image" src="{{ asset('/storage/avatar/'.$data['avatar']) }}" width="100px" height="100px" alt="avatar">
							<a class="ui circular label" id="avatar_button"><i class="camera icon"></i></a>
						</div>
						<div>									
							<h2 class="bolder">{{ $data['name'] }}</h2>
							<p>{{ $data['designation'] }}  -  {{ $data['department'] }}</p>									
						</div> 
					</div>
					<div class="contact">
						<div class="icon-holder">
							<div>
								<i class="phone alternate icon secondary-bg"></i>
							</div>
							<div>
								<strong>Phone</strong>
								<p>{{ $data['phone_number'] }}</p>
							</div>
						</div>	
						<div class="icon-holder">
							<div>
								<i class="envelope outline icon tertiary-bg"></i>
							</div>
							<div style="word-wrap: break-word;">
								<strong>Email</strong>
								<p>{{ $data['email'] }}</p>
							</div>
						</div>
						<div class="icon-holder">
							<div>
								<i class="map marker alternate icon primary-bg"></i>
							</div>
							<div>
								<strong>Present Address</strong>
								<p>{{ $data['present_address'] }}</p>
							</div>
						</div>	
					</div>
				</div>

			</div>
		</div>

		<div class="sixteen wide tablet twelve wide computer column">
			<div class="widget">
				<div class="widget-wrapper">
					<div class="ui stackable grid">
						<div class="sixteen wide tablet three wide computer column">
							<div class="ui secondary vertical menu" style="height: auto;">
								<a class="item active" data-tab="qualification">Qualification</a>
								<a class="item" data-tab="publication">Publication</a>
								<a class="item" data-tab="workshop_fdp">Workshop & FDP</a>
								<a class="item" data-tab="online_courses">Online Courses</a>
							</div>
						</div>
						<div class="sixteen wide tablet thirteen wide computer column">
							
							<div class="ui active tab" data-tab="qualification" >
								<!-- 
									*
									* Academic Qualification 
									*
								-->
                                <div class="display_details">		
                                <h2>Academic Qualification</h2>
                                <div class="line"></div>
                                    <?php 
                                    //Select the Academic JSON from the $data[]
                                    $academic_array = json_decode($data['academic_qualification']);
                                
                                    foreach ($academic_array as $object_key => $object) {
                                        print(' 
                                            <span id="entry">
                                            <h3>'.$object->degree.' '.$object->specialization.'</h3>
                                                <p>'.$object->college.', '.$object->university.'</p>
                                                <p>CGPA: '.$object->cgpa.'/10 | '.$object->class.'</p>
                                            </span>
                                        ');
                                    }

                                ?>
                                </div>
								<br><br>

								<!-- 
									*
									* Experience 
									*
								-->
                                <div class="display_details">		
                                    <h2>Experience Qualification</h2>
                                    <div class="line"></div>
                                        <?php 
                                        //Select the Experience JSON from the $data[]
                                        $experience_array = json_decode($data['experience']);
                                    
                                        foreach ($experience_array as $object_key => $object) {
                                            $total = dynamic_date($object->from,$object->to);
                                            print(' 
                                                <span id="entry">
                                                    <h3>'.$object->job_title.'</h3>
                                                    <p>'.$object->institution.'</p>
                                                    <p>From: '.$object->from.' - '.$object->to.' | Total: '.$total.'</p>
                                                </span>
                                            ');
                                        }

                                    ?>
                                </div>
							</div>

							<div class="ui tab" data-tab="publication">
								<!-- 
									*
									* Journal 
									*
								-->
								<div class="display_details">		
									<h2>Journal</h2>
									<div class="line"></div>
										<?php 
										//Select the Journal JSON from the $data[]
										$journal_array = json_decode($data['journal']);
									
										foreach ($journal_array as $object_key => $object) {
											print(' 
												<span id="entry">
													<h3>'.$object->journal_title.'</h3>
													<p>'.$object->journal_name.' ('.$object->journal_type.')</p>
													<p>Volume: '.$object->journal_volume.' | Page No: '.$object->journal_page_number.' | Citations: '.$object->journal_citations.'</p>
													<p>'.$object->journal_date.' | '.$object->journal_publication_type.'</p>
												</span>
											');
										}

									?>
								</div>								
								<br><br>

								<!-- 
									*
									* Books 
									*
								-->
                                <div class="display_details">		
                                    <h2>Books</h2>
                                    <div class="line"></div>						        		
                                        <?php 
                                        //Select the Book JSON from the $data[]
                                        $book_array = json_decode($data['book']);
                                    
                                        foreach ($book_array as $object_key => $object) {

                                            print(' 
                                                <span id="entry">
                                                    <h3>'.$object->book_title.'</h3>
                                                    <p>Authors: '.$object->book_author.', '.$object->book_author_2.', '.$object->book_author_3.'</p>
                                                    <p>Publisher: '.$object->book_publisher.' | ISBN: '.$object->book_isbn.'</p>
                                                    <p>'.$object->book_year.'</p>
                                                </span>
                                            ');
                                        }

                                    ?>
                                </div>
								<br><br>
								<!-- 
									*
									* Conference 
									*
								-->
                                <div class="display_details">		
                                    <h2>Conference</h2>
                                    <div class="line"></div>
                                        <?php 
                                        //Select the Conference JSON from the $data[]
                                        $conference_array = json_decode($data['conference']);
                                    
                                        foreach ($conference_array as $object_key => $object) {

                                            print(' 
                                                <span id="entry">
                                                    <h3>'.$object->conference_title.'</h3>
                                                    <p>Conference: '.$object->conference_name.' ('.$object->conference_publication_type.')</p>
                                                    <p>'.$object->conference_date.'</p>
                                                </span>
                                            ');
                                        }

                                    ?>
                                    
                                </div>
							</div>


							<div class="ui tab" data-tab="workshop_fdp">
								<!--
									*
									*
									* Workshop Section
									*
									* 
								-->		

                                <div class="display_details">		
                                    <h2>Workshop</h2>
                                    <div class="line"></div>
                                        <?php 
                                        //Select the Workshop JSON from the $data[]
                                        $workshop_array = json_decode($data['workshop']);
                                    
                                        foreach ($workshop_array as $object_key => $object) {
                                            $total = dynamic_date($object->workshop_from,$object->workshop_to);
                                            print(' 
                                                <span id="entry">
                                                    <h3>'.$object->workshop_name.'</h3>
                                                    <p>'.$object->workshop_venue.'</p>
                                                    <p>From: '.$object->workshop_from.' - '.$object->workshop_to.' | Total: '.$total.'</p>
                                                </span>
                                            ');
                                        }

                                    ?>
								</div>
								<br><br>

								<!--
									*
									*
									* FDP Section
									*
									* 
								-->	
                                <div class="display_details">		
                                    <h2>FDP</h2>
                                    <div class="line"></div>
                                        <?php 
                                        //Select the FDP JSON from the $data[]
                                        $fdp_array = json_decode($data['fdp']);
                                    
                                        foreach ($fdp_array as $object_key => $object) {
                                            $total = dynamic_date($object->fdp_from,$object->fdp_to);
                                            print(' 
                                                <span id="entry">
                                                    <h3>'.$object->fdp_name.'</h3>
                                                    <p>'.$object->fdp_venue.'</p>
                                                    <p>From: '.$object->fdp_from.' - '.$object->fdp_to.' | Total: '.$total.'</p>
                                                </span>
                                            ');
                                        }
                                    ?>
                                </div>
								
							</div>
							


							<div class="ui tab" data-tab="online_courses">
								<!--
									*
									*
									* Online Course Section
									*
									*
								-->		
                                <div class="display_details">		
                                    <h2>Online Course</h2>
                                    <div class="line"></div>
                                        <?php 
                                        //Select the Online Course JSON from the $data[]
                                        $online_course_array = json_decode($data['online_course']);
                                    
                                        foreach ($online_course_array as $object_key => $object) {
                                            $total = dynamic_date($object->online_course_from,$object->online_course_to);
                                            print(' 
                                                <span id="entry">
                                                     <h3>'.$object->online_course_name.'</h3>
                                                    <p>'.$object->online_course_platform.'</p>
                                                    <p>From: '.$object->online_course_from.' - '.$object->online_course_to.' | Total: '.$total.'</p> 
                                                </span>
                                            ');
                                        }

                                    ?>
                                </div>
								
								<br><br>

								<!--
									*
									*
									* Award Section
									*
									* 
								-->										
                                <div class="display_details">		
                                    <h2>Awards</h2>
                                    <div class="line"></div>
                                        <?php 
                                        //Select the Online Course JSON from the $data[]
                                        $award_array = json_decode($data['award']);								                
                                        foreach ($award_array as $object_key => $object) {
                                            print(' 
                                                <span id="entry">
                                                    <h3>'.$object->award_name.'</h3>
                                                    <p>Date: '.$object->award_year.'</p>       
                                                </span>
                                            ');
                                        }

                                    ?>
                                </div>
							</div>
							<!-- Online Courses Tab End -->

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="sixteen wide tablet four wide computer column">
			<div class="widgets two">
				<div class="widget">
					<div class="header divided">
						College Details
					</div>
					<div class="widget-wrapper">	
						<table class="ui celled table">
							<tbody>
								<tr>
									<td><h4 class="ui header">Staff ID</h4></td>
									<td>{{ $data['staff_id'] }}</td>
								</tr>
								<tr>
									<td><h4 class="ui header">Designation</h4></td>
									<td>{{ $data['designation'] }}</td>
								</tr>
								<tr>
									<td><h4 class="ui header">Department</h4></td>
									<td>{{ $data['department'] }}</td>
								</tr>
								<tr>
									<td><h4 class="ui header">Anna University ID</h4></td>
									<td>{{ $data['anna_university_id'] }}</td>
								</tr>
								<tr>
									<td><h4 class="ui header">AICTE ID</h4></td>
									<td>{{ $data['aicte_id'] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>							
			</div>
		</div>
	</div>
</div>
<script>
    $('.menu .item').tab();
</script>
@endsection
