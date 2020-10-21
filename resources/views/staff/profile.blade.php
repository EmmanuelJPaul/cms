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
	<form method="POST" id="form_profile" action="{{ route('staff.profile.edit') }}">
		@csrf
		<input type="hidden" id="name" name="name" value="<?php echo($data['name'])?>">
		<input type="hidden" id="email" name="email" value="<?php echo($data['email'])?>">
		<input type="hidden" id="date_of_birth" name="date_of_birth" value="<?php echo($data['date_of_birth'])?>">
		<input type="hidden" id="gender" name="gender" value="<?php echo($data['gender'])?>">
		<input type="hidden" id="phone_number" name="phone_number" value="<?php echo($data['phone_number'])?>">
		<input type="hidden" id="permanent_address" name="permanent_address" value="<?php echo($data['permanent_address'])?>">
		<input type="hidden" id="present_address" name="present_address" value="<?php echo($data['present_address'])?>">	  	
		<input type="hidden" id="staff_id" name="staff_id" value="<?php echo($data['staff_id'])?>">
		<input type="hidden" id="designation" name="designation" value="<?php echo($data['designation'])?>">
		<input type="hidden" id="department" name="department" value="<?php echo($data['department'])?>">
		<input type="hidden" id="pan_card_number" name="pan_card_number" value="<?php echo($data['pan_card_number'])?>">
		<input type="hidden" id="aadhar_card_number" name="aadhar_card_number" value="<?php echo($data['aadhar_card_number'])?>">
		<input type="hidden" id="anna_university_id" name="anna_university_id" value="<?php echo($data['anna_university_id'])?>">
		<input type="hidden" id="aicte_id" name="aicte_id" value="<?php echo($data['aicte_id'])?>">		  				 		  				 
	</form>

	<div class="ui stackable centered grid">
		<div class="sixteen wide column">
			<div class="ui grid">
				<div class="nine wide column">
					<h2 style="margin-bottom: 0px">Profile</h2>
					<div class="ui breadcrumb">
						<a href="{{ route('staff.') }}" class="section">Home</a>
						<i class="right angle icon divider"></i>
						<a class="active section">Profile</a>
					</div>
				</div>
				<div class="seven wide column" style="margin-top: 10px;">
					<button class="ui right floated blue basic button" id="profile_edit"><i class="pen icon"></i> Edit Profile</button>
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
							<img class="ui circular image" src="{{ asset('/storage/avatar/'.$avatar) }}" width="100px" height="100px" alt="avatar">
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
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_academic_qualification" autocomplete="off">
									@csrf
									<div class="display_details">		
									<h2>Academic Qualification</h2>
									<div class="line"></div>
									<input type="hidden" name="field" value="academic_qualification">
										<?php 
										//Select the Academic JSON from the $data[]
										$academic_array = json_decode($data['academic_qualification']);
									
										foreach ($academic_array as $object_key => $object) {
											print(' 
												<span id="entry">
													<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
													<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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

										<span id="hidden_form_holder_academic_qualification"></span>
										<br>
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_academic_qualification">
									<input type="hidden" name="degree[]">
									<input type="hidden" name="specialization[]">
									<input type="hidden" name="college[]">
									<input type="hidden" name="university[]">
									<input type="hidden" name="cgpa[]">
									<input type="hidden" name="class[]">
								</span>
								<br><br>

								<!-- 
									*
									* Experience 
									*
								-->
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_experience" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>Experience Qualification</h2>
										<div class="line"></div>
										<input type="hidden" name="field" value="experience">
											<?php 
											//Select the Experience JSON from the $data[]
											$experience_array = json_decode($data['experience']);
										
											foreach ($experience_array as $object_key => $object) {
												$total = dynamic_date($object->from,$object->to);
												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_experience">
									<input type="hidden" name="job_title[]">
									<input type="hidden" name="institution[]">
									<input type="hidden" name="from[]">
									<input type="hidden" name="to[]">
									<input type="hidden" name="total[]">										 
								</span>
							</div>

							<div class="ui tab" data-tab="publication">
								<!-- 
									*
									* Journal 
									*
								-->
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_journal" autocomplete="off">
									@csrf
									<div class="display_details">		
									<h2>Journal</h2>
									<div class="line"></div>
									<input type="hidden" name="field" value="journal">
										<?php 
										//Select the Journal JSON from the $data[]
										$journal_array = json_decode($data['journal']);
									
										foreach ($journal_array as $object_key => $object) {
											print(' 
												<span id="entry">
													<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
													<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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
										<button class="ui button add"><i class="plus icon"></i> Add</button>
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
								<br><br>

								<!-- 
									*
									* Books 
									*
								-->
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_book" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>Books</h2>
										<div class="line"></div>						        		
										<input type="hidden" name="field" value="book">
											<?php 
											//Select the Book JSON from the $data[]
											$book_array = json_decode($data['book']);
										
											foreach ($book_array as $object_key => $object) {

												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
														<h3>'.$object->book_title.'</h3>
														<p>Authors: '.$object->book_author.', '.$object->book_author_2.', '.$object->book_author_3.'</p>
														<p>Publisher: '.$object->book_publisher.' | ISBN: '.$object->book_isbn.'</p>
														<p>'.$object->book_year.'</p>

														
														<input type="hidden" name="book_title[]" value="'.$object->book_title.'">
														<input type="hidden" name="book_publisher[]" value="'.$object->book_publisher.'">
														<input type="hidden" name="book_year[]" value="'.$object->book_year.'">
														<input type="hidden" name="book_isbn[]" value="'.$object->book_isbn.'">
														<input type="hidden" name="book_author[]" value="'.$object->book_author.'">
														<input type="hidden" name="book_author_2[]" value="'.$object->book_author_2.'">
														<input type="hidden" name="book_author_3[]" value="'.$object->book_author_3.'">
														
																								 
														
													</span>
												');
											}

										?>
										<span id="hidden_form_holder_book"></span>
										<br>
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_book">
									<input type="hidden" name="book_title[]">
									<input type="hidden" name="book_publisher[]">
									<input type="hidden" name="book_year[]">
									<input type="hidden" name="book_isbn[]">
									<input type="hidden" name="book_author[]">
									<input type="hidden" name="book_author_2[]">
									<input type="hidden" name="book_author_3[]">
																			 
								</span>
								<br><br>
								<!-- 
									*
									* Conference 
									*
								-->
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_conference" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>Conference</h2>
										<div class="line"></div>
										<input type="hidden" name="field" value="conference">
											<?php 
											//Select the Conference JSON from the $data[]
											$conference_array = json_decode($data['conference']);
										
											foreach ($conference_array as $object_key => $object) {

												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_conference">
									<input type="hidden" name="conference_title[]">
									<input type="hidden" name="conference_publication_type[]">
									<input type="hidden" name="conference_name[]">
									<input type="hidden" name="conference_date[]">										 
								</span>

							</div>


							<div class="ui tab" data-tab="workshop_fdp">
								<!--
									*
									*
									* Workshop Section
									*
									* 
								-->		

								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_workshop" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>Workshop</h2>
										<div class="line"></div>
										<input type="hidden" name="field" value="workshop">
											<?php 
											//Select the Workshop JSON from the $data[]
											$workshop_array = json_decode($data['workshop']);
										
											foreach ($workshop_array as $object_key => $object) {
												$total = dynamic_date($object->workshop_from,$object->workshop_to);
												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_workshop">
									<input type="hidden" name="workshop_name[]">
									<input type="hidden" name="workshop_venue[]">
									<input type="hidden" name="workshop_from[]">
									<input type="hidden" name="workshop_to[]">
									<input type="hidden" name="total[]">										 
								</span>
								<br><br>

								<!--
									*
									*
									* FDP Section
									*
									* 
								-->	
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_fdp" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>FDP</h2>
										<div class="line"></div>
										<input type="hidden" name="field" value="fdp">
											<?php 
											//Select the FDP JSON from the $data[]
											$fdp_array = json_decode($data['fdp']);
										
											foreach ($fdp_array as $object_key => $object) {
												$total = dynamic_date($object->fdp_from,$object->fdp_to);
												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_fdp">
									<input type="hidden" name="fdp_name[]">
									<input type="hidden" name="fdp_venue[]">
									<input type="hidden" name="fdp_from[]">
									<input type="hidden" name="fdp_to[]">
									<input type="hidden" name="total[]">										 
								</span>
							</div>
							


							<div class="ui tab" data-tab="online_courses">
								<!--
									*
									*
									* Online Course Section
									*
									*
								-->		
								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_online_course" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>Online Course</h2>
										<div class="line"></div>
										<input type="hidden" name="field" value="online_course">
											<?php 
											//Select the Online Course JSON from the $data[]
											$online_course_array = json_decode($data['online_course']);
										
											foreach ($online_course_array as $object_key => $object) {
												$total = dynamic_date($object->online_course_from,$object->online_course_to);
												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
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
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_online_course">
									<input type="hidden" name="online_course_name[]">
									<input type="hidden" name="online_course_platform[]">
									<input type="hidden" name="online_course_from[]">
									<input type="hidden" name="online_course_to[]">
									<input type="hidden" name="total[]">										 
								</span>
								<br><br>

								<!--
									*
									*
									* Award Section
									*
									* 
								-->		

								<form class="ui form" method="POST" action="{{ route('staff.profile.edit') }}" id="form_award" autocomplete="off">
									@csrf
									<div class="display_details">		
										<h2>Awards</h2>
										<div class="line"></div>
										<input type="hidden" name="field" value="award">
											<?php 
											//Select the Online Course JSON from the $data[]
											$award_array = json_decode($data['award']);								                
											foreach ($award_array as $object_key => $object) {
												print(' 
													<span id="entry">
														<button class="ui icon_btn button right floated delete"  data-id="'.$object_key.'"><i class="times icon"></i></button>
														<button class="ui icon_btn button right floated edit" data-id="'.$object_key.'"><i class="pen icon"></i></button>
														<h3>'.$object->award_name.'</h3>
														<p>Date: '.$object->award_year.'</p>

														
														<input type="hidden" name="award_name[]" value="'.$object->award_name.'">
														<input type="hidden" name="award_year[]" value="'.$object->award_year.'">					 
														
													</span>
												');
											}

										?>
										<span id="hidden_form_holder_award"></span>
										<br>
										<button class="ui button add"><i class="plus icon"></i> Add</button>
									</div>
								</form>
								<span id="hidden_form_award">
									<input type="hidden" name="award_name[]">
									<input type="hidden" name="award_year[]">										 
								</span>
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
				<div class="widget">
					<div class="header" style="padding-bottom: 0px;">Credentials</div>
					<div class="widget-wrapper">
						<form class="ui form" method="POST" action="{{ route('password.update') }}">
							@csrf
							<!-- <input type="hidden" name="token" value="{{ $token ?? '' }}"> -->

							@error('email')
								<!-- Credential Validation -->
								<div class="ui error message" style="width: 320px;">
									<i class="close icon"></i>
										{{ $message }}
								</div>
							@enderror
							<div class="field">
								<label>Email</label>
								<input type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
							</div>
							<div class="field">
								<label>New Password</label>
								<input type="password" name="password" required autocomplete="new-password">
							</div>
							<div class="field">
								<label>Confirm New Password</label>
								<input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
							</div>
							<div class="field">
								<div class="ui checkbox">
									<input type="checkbox">
									<label>I Agree</label>
								</div>
							</div>
							<button class="ui fluid blue button">Commit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-----------------
	MODALS
------------------>
<div class="ui first modal">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Basic Details</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_profile_first" autocomplete="off">
			<div class="fields">
				<div class="eight wide field">
					<label>Name</label>
					<input  id="modal_profile_name" type="text" value="<?php if(isset($data['name']))echo($data['name']) ?>" required>
				</div>
				<div class="eight wide field">
					<label>Email</label>
					<input id="modal_profile_email" type="email" value="<?php if(isset($data['email']))echo($data['email']) ?>" required>
				</div>
			</div>
			<div class="fields"> 
				<div class="five wide field">
					<label>Date of Birth</label>
					<div class="ui calendar" id="date_calendar">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_profile_date_of_birth" placeholder="-- Pick Date --"  value="<?php if(isset($data['date_of_birth']))echo($data['date_of_birth']) ?>" required>
						</div>
					</div>
				</div>
				<div class="five wide field">
					<label>Gender</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_profile_gender" value="<?php if(isset($data['gender']))echo($data['gender']) ?>" required>
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
					<input id="modal_profile_phone_number" type="number" value="<?php if(isset($data['phone_number']))echo($data['phone_number']) ?>" minlength="10" maxlength="10" required>
				</div>
			</div>

			<div class="fields">
				<div class="eight wide field">
					<label>Permanent Address</label>
					<input id="modal_profile_permanent_address" type="text" value="<?php if(isset($data['permanent_address']))echo($data['permanent_address']) ?>" required>
				</div>
				<div class="eight wide field">
					<label>Present Address</label>
					<input id="modal_profile_present_address" type="text" value="<?php if(isset($data['present_address']))echo($data['present_address']) ?>" required>
				</div>
			</div>

			<button class="ui right floated button" id="modal_profile_next" style="margin-bottom: 15px;">Next</button>
		</div>
	</div>
</div>

<div class="ui second modal">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Staff Details</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_profile_second" autocomplete="off">
			<div class="fields"> 
				<div class="six wide field">
					<label>Staff ID</label>
					<input id="modal_profile_staff_id" type="text" value="<?php if(isset($data['staff_id']))echo($data['staff_id']) ?>" required>
				</div>
				<div class="five wide field">
					<label>Designation</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_profile_designation" value="<?php if(isset($data['designation']))echo($data['designation']) ?>" required>
						<i class="dropdown icon"></i>
						<div class="default text">-- Select --</div>
						<div class="menu">
							<div class="item" data-value="Asst. Professor">Asst. Professor</div>
							<div class="item" data-value="Assoc. Professor">Assoc. Professor</div>
							<div class="item" data-value="Professor">Professor</div>
							<div class="item" data-value="HOD">HOD</div>
						</div>
					</div>
				</div>
				<div class="five wide field">
					<label>Department</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_profile_department" value="<?php if(isset($data['department']))echo($data['department']) ?>" required>
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
					<input id="modal_profile_pan_card_number" type="text" value="<?php if(isset($data['pan_card_number']))echo($data['pan_card_number']) ?>" minlength="10" maxlength="10" required>
				</div>
				<div class="four wide field">
					<label>Aadhar Card Number</label>
					<input id="modal_profile_aadhar_card_number" type="text" value="<?php if(isset($data['aadhar_card_number']))echo($data['aadhar_card_number']) ?>" minlength="12" maxlength="12" required>
				</div>
				<div class="four wide field">
					<label>Anna University ID</label>
					<input id="modal_profile_anna_university_id" type="text" value="<?php if(isset($data['anna_university_id']))echo($data['anna_university_id']) ?>" required>
				</div>
				<div class="four wide field">
					<label>AICTE ID</label>
					<input id="modal_profile_aicte_id" type="text" value="<?php if(isset($data['aicte_id']))echo($data['aicte_id']) ?>" required>
				</div>
			</div>
			<button class="ui button" id="modal_profile_prev" style="margin-bottom: 15px;">Prev</button>
			<button class="ui blue right floated button" id="modal_profile_submit" style="margin-bottom: 15px;">Save</button>
		</div>
	</div>
</div>


<div class="ui avatar modal">
    <i class="close icon"></i>
    <div style="text-align: center; margin: 30px;">
        <h2>Avatar</h2>
		<p><b>Image Criteria:</b><br>
			Size < 2mb |
			Square Image |
			Format: jpg, png											
		</p>				    	
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


<div class="ui modal modal_academic_qualification">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Academic Qualification</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_academic_qualification">
			<div class="fields">
				<div class="four wide field">
					<label>Degree</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_academic_degree" required>
						<i class="dropdown icon"></i>
						<div class="default text">-- Select --</div>
						<div class="menu">
							<div class="item" data-value="B.E">B.E</div>
							<div class="item" data-value="B.Tech">B.Tech</div>
							<div class="item" data-value="M.E">M.E</div>
							<div class="item" data-value="M.Tech">M.Tech</div>
							<div class="item" data-value="B.Sc">B.Sc</div>
							<div class="item" data-value="M.Sc">M.Sc</div>
							<div class="item" data-value="M.Phil">M.Phil</div>
							<div class="item" data-value="Ph.D">Ph.D</div>
							<div class="item" data-value="B.A">B.A</div>
							<div class="item" data-value="M.A">M.A</div>
						</div>		
					</div>
				</div>
				<div class="twelve wide field">
					<label>Specialization</label>
					<input type="text" name="modal_academic_specialization" id="modal_academic_specialization" required>

				</div>
			</div>
			<div class="fields">
				<div class="eight wide field">
					<label>College</label>
					<input type="text" id="modal_academic_college" required>
				</div>
				<div class="eight wide field">
					<label>University</label>
					<input type="text" id="modal_academic_university" required>
				</div>
			</div>
			<div class="fields">
				<div class="eight wide field">
					<label>CGPA</label>
					<input type="text" id="modal_academic_cgpa" pattern="/^[-+]?[0-9]+\.[0-9]+$/" required>
					<p class="sub_label">(x/10)</p>
				</div>
				<div class="eight wide field">
					<label>Class</label>
					<input type="text" id="modal_academic_class" required>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>


<div class="ui modal modal_experience">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Experience</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_experience">
			<div class="fields">
				<div class="eight wide field">
					<label>Title</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_experience_job_title" required>
						<i class="dropdown icon"></i>
						<div class="default text">-- Select --</div>
						<div class="menu">
							<div class="item" data-value="Lecturer">Lecturer</div>
							<div class="item" data-value="Asst. Professor">Asst. Professor</div>
							<div class="item" data-value="Assoc. Professor">Assoc. Professor</div>
							<div class="item" data-value="Professor">Professor</div>
						</div>		
					</div>
					
				</div>
				<div class="eight wide field">
					<label>Institution</label>
					<input type="text" id="modal_experience_institution" required>
				</div>
			</div>
			<div class="fields">
				<div class="eight wide field">
					<label>From</label>
					<div class="ui calendar" id="experience_month_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_experience_from" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
				<div class="eight wide field">
					<label>To</label>
					<div class="ui calendar" id="experience_month_calendar_2">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_experience_to" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>



<!------------   Publication   -------------->
<div class="ui modal modal_journal">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Journals</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_journal">
			<div class="fields">
				<div class="eight wide field">
					<label>Title</label>
					<input id="modal_journal_title" name="modal_journal_title" type="text" required>
				</div>
				<div class="four wide field">
					<label>Type</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_journal_publication_type" required>
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
					<input id="modal_journal_name" type="text" required>
				</div>
			</div>
			<div class="fields"> 
				<div class="three wide field">
					<label>Journal Type</label>
					<div class="ui selection dropdown">
						<input type="hidden" id="modal_journal_type" required>
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
					<input id="modal_journal_volume" type="text" required>
				</div>
				<div class="two wide field">
					<label>Page Number</label>
					<input id="modal_journal_page_number" type="text" required>
				</div>
				<div class="four wide field">
					<label>Citations</label>
					<input id="modal_journal_citations" type="text" required>
				</div>
				<div class="three wide field">
					<label>Date</label>
					<div class="ui calendar" id="journal_month_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_journal_date" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>

<div class="ui modal modal_book">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Book</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_book">
			<div class="fields">
				<div class="five wide field">
					<label>Title</label>
					<input id="modal_book_title" type="text" required>
				</div>
				<div class="five wide field">
					<label>Publisher</label>
					<input id="modal_book_publisher" type="text" required>
				</div>
				<div class="three wide field">
					<label>Date</label>
					<div class="ui calendar" id="book_month_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_book_year" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
				<div class="three wide field">
					<label>ISBN Number</label>
					<input id="modal_book_isbn" type="text" required>
				</div>
			</div>
			<div class="fields">
				<div class="six wide field">
					<label>Author</label>
					<input id="modal_book_author" type="text" required>
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
			<span class="modal_button"></span>
		</div>
	</div>
</div>

<div class="ui modal modal_conference">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Conference</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_conference">
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
					<div class="ui calendar" id="conference_date_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_conference_date" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>


<!-------------- Workshop & FDP ---------------->
<div class="ui modal modal_workshop">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Workshop</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_workshop">
			<div class="fields">
				<div class="eight wide field">
					<label>Title</label>
					<input type="text" id="modal_workshop_name" required>
				</div>
				<div class="eight wide field">
					<label>Venue</label>
					<input type="text" id="modal_workshop_venue" required>
				</div>
			</div>
			<div class="fields">
				<div class="eight wide field">
					<label>From</label>
					<div class="ui calendar" id="workshop_date_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_workshop_from" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
				<div class="eight wide field">
					<label>To</label>
					<div class="ui calendar" id="workshop_date_calendar_2">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_workshop_to" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>

<div class="ui modal modal_fdp">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>FDP</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_fdp">
			<div class="fields">
				<div class="eight wide field">
					<label>Title</label>
					<input type="text" id="modal_fdp_name" required>
				</div>
				<div class="eight wide field">
					<label>Venue</label>
					<input type="text" id="modal_fdp_venue" required>
				</div>
			</div>
			<div class="fields">
				<div class="eight wide field">
					<label>From</label>
					<div class="ui calendar" id="fdp_date_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_fdp_from" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
				<div class="eight wide field">
					<label>To</label>
					<div class="ui calendar" id="fdp_date_calendar_2">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_fdp_to" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>


<div class="ui modal modal_award">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Awards</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_award">
			<div class="fields">
				<div class="sixteen wide field">
					<label>Name</label>
					<input type="text" id="modal_award_name" required>
				</div>
			</div>
			<div class="fields">
				<div class="sixteen wide field">
					<label>Date</label>
					<div class="ui calendar" id="award_year_calendar">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_award_year" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>
		</div>
	</div>
</div>


<!------------------ Online Course ----------------->
<div class="ui modal modal_online_course">
	<i class="close icon"></i>
	<div style="text-align: center; margin: 30px;">
		<h2>Online Course</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px">
		<div class="ui form" id="modal_form_online_course">
			<div class="fields">
				<div class="eight wide field">
					<label>Name</label>
					<input type="text" id="modal_online_course_name" required>
				</div>
				<div class="eight wide field">
					<label>Platform</label>
					<input type="text" id="modal_online_course_platform" required>
				</div>
			</div>
			<div class="fields">
				<div class="eight wide field">
					<label>From</label>
					<div class="ui calendar" id="online_course_date_calendar_1">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_online_course_from" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
				<div class="eight wide field">
					<label>To</label>
					<div class="ui calendar" id="online_course_date_calendar_2">
						<div class="ui input left icon">
							<i class="alternate calendar outline icon"></i>
							<input type="text" id="modal_online_course_to" placeholder="-- Pick Date --" required>
						</div>
					</div>
				</div>
			</div>
			<span class="modal_button"></span>                 
		</div>
	</div>
</div>

		
<div class="ui alert modal">
	<div style="text-align: center; margin: 30px;">
		<h2>Are you sure you want to Delete this?</h2>				    	
	</div>
	<div class="content" style="padding-right: 30px; padding-left: 30px; padding-bottom: 50px;">
		<button class="ui blue right floated button" id="confirm_delete">Yes</button>
		<button class="ui right floated button" id="cancel_delete">Cancel</button>
	</div>
</div>

<!-- Scoped Scripts -->
<script type="text/javascript">
	$('.selection.dropdown').dropdown();

	$('.menu .item').tab();

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

	$("input:text").click(function() {
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

	//Get the Modal Values
	var modal_form_profile_first = Array.from($('#modal_form_profile_first').children().find(':input'));
	var modal_form_profile_second = Array.from($('#modal_form_profile_second').children().find(':input'));

	$('#profile_edit, #modal_profile_prev').on('click', function(event){
		event.preventDefault();

		// show first modal
		$('.first.modal').modal('show');
		$('#date_calendar').calendar({
			type: 'date',
			maxDate: new Date(),
		});
		//Generate Dynamic Validator Script
		validator('profile_first', modal_form_profile_first, "on: 'blur',");
		//Add Dynamic Scripts
		$('#dynamic_script').html('<script>' + $('#dynamic_script_holder').html() + '<\/script>');
	});

	$('#modal_profile_next').click(function(event){
		event.preventDefault();
		//Validate the Form
		if ($('#modal_form_profile_first').form('is valid')) {
			// show second modal
			$('.second.modal').modal('show');

			//Generate Dynamic Validator Script
			validator('profile_second', modal_form_profile_second, "on: 'blur',");
		}
	});

	$('#modal_profile_submit').click(function(event){
		event.preventDefault();
		
		if ($('#modal_form_profile_second').form('is valid')) {
			//Merge the Modal Values
			for(i = 0; i < modal_form_profile_second.length; i++){
				modal_form_profile_first.push(modal_form_profile_second[i]);
			}	
			//Get the hidden Form 
			var modal_form_profile_hidden = $('#form_profile').find('input[type="hidden"]');	
			for(i = 0; i < modal_form_profile_first.length; i++){
				//Update the Hidden Form
				modal_form_profile_hidden[i+1].value = modal_form_profile_first[i].value;
			}

			$('#form_profile').submit();
		}
		
	});
</script>

<span id="validator"></span>
<script src="{{ URL::asset('js/dynamic_forms.js') }}"></script>

@endsection
