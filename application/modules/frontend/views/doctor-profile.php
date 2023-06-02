			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Doctor Profile</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Doctor Profile</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">

					<!-- Doctor Widget -->
					<div class="card">
						<div class="card-body">
							<div class="doctor-widget">
								<div class="doc-info-left">
									<div class="doctor-img">
										<img src="<?php echo base_url().$doctor_profile_data->img_url ?>" class="img-fluid" alt="User Image">
									</div>
									<?php 
										$education = json_decode($doctor_profile_data->education);
                                    	$degree_here = "";
										foreach($education as $ky=>$val)
										{
											if($degree_here=="")
											{
												$degree_here .= $val->degree;
											}
											else
											{
												$degree_here .= ', '.$val->degree;
											}
										} 

										$speciality_icon = $this->frontend_model->getspecialityIcon($doctor_profile_data->profile);
										
									?>
									<div class="doc-info-cont">
										<h4 class="doc-name"><?php echo $doctor_profile_data->name ?></h4>
										<p class="doc-speciality"><?php echo $degree_here; ?></p>
										<p class="doc-department"><img src="<?php echo $speciality_icon ?>" onerror="this.src='uploads/favicon.png'" class="img-fluid" alt="Speciality"><?php echo $doctor_profile_data->profile ?></p>
										<div class="rating">
											<?php for($i=1; $i<=5; $i++) { ?>
												<?php if($rating[0]->avg_rating > ($i-1) && $rating[0]->avg_rating < $i){ ?>
													<i class="fas fa-star-half-alt filled"></i>
												<?php } elseif($rating[0]->avg_rating >= $i){ ?>
													<i class="fas fa-star filled"></i>
												<?php } else { ?>
													<i class="fas fa-star"></i>
												<?php } ?>
											<?php } ?>
											<span class="d-inline-block average-rating">(<?= $rating[0]->total; ?>)</span>
										</div>
										<div class="clinic-details">
											<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?php $address = json_decode($doctor_profile_data->address); echo $address[0].' '.$address[1]; ?></p>
											<!-- <ul class="clinic-gallery">
												<li>
													<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery">
														<img src="assets/img/features/feature-01.jpg" alt="Feature">
													</a>
												</li>
												<li>
													<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery">
														<img  src="assets/img/features/feature-02.jpg" alt="Feature Image">
													</a>
												</li>
												<li>
													<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery">
														<img src="assets/img/features/feature-03.jpg" alt="Feature">
													</a>
												</li>
												<li>
													<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery">
														<img src="assets/img/features/feature-04.jpg" alt="Feature">
													</a>
												</li>
											</ul> -->
										</div>
										<!-- <div class="clinic-services">
											<span>Dental Fillings</span>
											<span>Teeth Whitneing</span>
										</div> -->
									</div>
								</div>
								<div class="doc-info-right">
									<div class="clini-infos">
										<ul>
											<li><i class="far fa-thumbs-up"></i> 99%</li>
											<li><i class="far fa-comment"></i> 35 Feedback</li>
											<li><i class="fas fa-map-marker-alt"></i> <?php echo $address[0].' '.$address[1]; ?></li>
											<li><i class="far fa-money-bill-alt"></i> <?php if($doctor_profile_data->pricing !="" and $doctor_profile_data->pricing > 0){echo $doctor_profile_data->symbol.' '.$doctor_profile_data->pricing; }else{ echo "Free"; }?> </li>
										</ul>
									</div>
									<div class="doctor-action">
										<a class="btn btn-<?= $favourite>0 ? 'danger' : 'white'; ?> fav-btn" href="frontend/add_favourites/<?php echo $doctor_profile_data->id ?>"><i class="far fa-bookmark"></i> Add to Favourites</a>
									</div>
									<div class="clinic-booking">
										<a class="apt-btn" href="frontend/booknormalappointmentwithdoctor?doctor_id=<?php echo $doctor_profile_data->id ?>">Book Appointment</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Doctor Widget -->
					
					<!-- Doctor Details Tab -->
					<div class="card">
						<div class="card-body pt-0">
						
							<!-- Tab Menu -->
							<nav class="user-tabs mb-4">
								<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
									<li class="nav-item">
										<a class="nav-link <?= !isset($_GET['review']) ? 'active' : ''; ?>" href="#doc_overview" data-toggle="tab">Overview</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?= isset($_GET['location']) ? 'active' : ''; ?>" href="#doc_locations" data-toggle="tab">Locations</a>
									</li>
									<li class="nav-item">
										<a class="nav-link <?= isset($_GET['review']) ? 'active' : ''; ?>" href="#doc_reviews" data-toggle="tab">Reviews</a>
									</li>
									<!--<li class="nav-item">-->
									<!--	<a class="nav-link" href="#doc_business_hours" data-toggle="tab">Business Hours</a>-->
									<!--</li>-->
								</ul>
							</nav>
							<!-- /Tab Menu -->
							
							<!-- Tab Content -->
							<div class="tab-content pt-0">
							
								<!-- Overview Content -->
								<div role="tabpanel" id="doc_overview" class="tab-pane fade<?= ! isset($_GET['review']) ? ' show active' : ''; ?>">
									<div class="row">
										<div class="col-md-12 col-lg-9">
										
											<!-- About Details -->
											<div class="widget about-widget">
												<h4 class="widget-title">About Me</h4>
												<p><?php echo $doctor_profile_data->about_me ?></p>
											</div>
											<!-- /About Details -->
										
											<!-- Education Details -->
											<div class="widget education-widget">
												<h4 class="widget-title">Education</h4>
												<div class="experience-box">
													<ul class="experience-list">
														<?php $education = json_decode($doctor_profile_data->education);
															foreach($education as $ky=>$value)
															{
														?>
														<li>
															<div class="experience-user">
																<div class="before-circle"></div>
															</div>
															<div class="experience-content">
																<div class="timeline-content">
																	<a href="#/" class="name"><?php echo $value->college_institute ?></a>
																	<div><?php echo $value->degree ?></div>
																	<span class="time"><?php echo $value->degree_compl_year ?></span>
																</div>
															</div>
														</li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<!-- /Education Details -->
									
											<!-- Experience Details -->
											<div class="widget experience-widget">
												<h4 class="widget-title">Work & Experience</h4>
												<div class="experience-box">
													<ul class="experience-list">
													<?php $experience = json_decode($doctor_profile_data->experience);
														foreach($experience as $ky=>$value)
														{
													?>
														<li>
															<div class="experience-user">
																<div class="before-circle"></div>
															</div>
															<div class="experience-content">
																<div class="timeline-content">
																	<a href="#/" class="name"><?php echo $value->exp_hospital_name ?></a>
																	<span class="time"><?php echo $value->exp_from ?> - <?php echo $value->exp_to ?> (<?php echo $value->designation ?>)</span>
																</div>
															</div>
														</li>
													<?php } ?>
													</ul>
												</div>
											</div>
											<!-- /Experience Details -->
								
											<!-- Awards Details -->
											<div class="widget awards-widget">
												<h4 class="widget-title">Awards</h4>
												<div class="experience-box">
													<ul class="experience-list">
													<?php $awards = json_decode($doctor_profile_data->awards);
													foreach($awards as $ky=>$value)
													{
													?>
														<li>
															<div class="experience-user">
																<div class="before-circle"></div>
															</div>
															<div class="experience-content">
																<div class="timeline-content">
																	<p class="exp-year"><?php echo $value->award_year; ?></p>
																	<h4 class="exp-title"><?php echo $value->awards; ?></h4>
																	<p><?php echo $value->award_description; ?></p>
																</div>
															</div>
														</li>
													<?php } ?>
													</ul>
												</div>
											</div>
											<!-- /Awards Details -->
											
											<!-- Services List -->
											<div class="service-list">
												<h4>Services</h4>
												<ul class="clearfix">
													<?php $services = explode(',', $doctor_profile_data->services);
													for($i=0; $i<count($services);$i++)
													{
													?>
													<li><?php echo $services[$i]; ?></li>
													<?php } ?>													
												</ul>
											</div>
											<!-- /Services List -->
											
											<!-- Specializations List -->
											<div class="service-list">
												<h4>Specializations</h4>
												<ul class="clearfix">
													<?php $specialization = explode(',', $doctor_profile_data->specialization);
													for($i=0; $i<count($specialization);$i++)
													{
													?>
													<li><?php echo $specialization[$i]; ?></li>
													<?php } ?>		
												</ul>
											</div>
											<!-- /Specializations List -->

										</div>
									</div>
								</div>
								<!-- /Overview Content -->
								
								<!-- Locations Content -->
								<div role="tabpanel" id="doc_locations" class="tab-pane fade<?= isset($_GET['location']) ? ' show active' : ''; ?>">
								<?php $clinic_information = json_decode($doctor_profile_data->clinic_info);
	                                // echo "<pre>";
	                                // print_r($clinic_information);
	                              foreach($clinic_information as $key => $valdata){
	                               ?>
									<!-- Location List -->
									<div class="location-list">
										<div class="row">
										
											<!-- Clinic Content -->
											<div class="col-md-6">
												<div class="clinic-content">
													<h4 class="clinic-name"><a href="#"><?php echo $valdata->clinic_name ?></a></h4>
													<p class="doc-speciality"><?php echo $degree_here; ?></p>
													<div class="rating">
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star filled"></i>
														<i class="fas fa-star"></i>
														<span class="d-inline-block average-rating">(4)</span>
													</div>
													<div class="clinic-details mb-0">
														<h5 class="clinic-direction"> <i class="fas fa-map-marker-alt"></i> <?php echo $valdata->clinic_address ?> 
														<!-- <br><a href="javascript:void(0);">Get Directions</a> -->
														</h5>
														<!-- <ul>
															<li>
																<a href="assets/img/features/feature-01.jpg" data-fancybox="gallery2">
																	<img src="assets/img/features/feature-01.jpg" alt="Feature Image">
																</a>
															</li>
															<li>
																<a href="assets/img/features/feature-02.jpg" data-fancybox="gallery2">
																	<img src="assets/img/features/feature-02.jpg" alt="Feature Image">
																</a>
															</li>
															<li>
																<a href="assets/img/features/feature-03.jpg" data-fancybox="gallery2">
																	<img src="assets/img/features/feature-03.jpg" alt="Feature Image">
																</a>
															</li>
															<li>
																<a href="assets/img/features/feature-04.jpg" data-fancybox="gallery2">
																	<img src="assets/img/features/feature-04.jpg" alt="Feature Image">
																</a>
															</li>
														</ul> -->
													</div>
												</div>
											</div>
											<!-- /Clinic Content -->
											
											<!-- Clinic Timing -->
											<div class="col-md-4">
												<div class="clinic-timing">
													
													 <?php $clinicday = json_decode($valdata->clinic_day);
				                                     $from_clinic_time = json_decode($valdata->from_clinic_time);
				                                     $to_clinic_time = json_decode($valdata->to_clinic_time);
				                                      for($i=0;$i<count($clinicday);$i++){
				                                     ?>
													<div>
														<p class="timings-days">
															<span> <?php echo $clinicday[$i] ?> </span>
														</p>
														<p class="timings-times">
															<span><?php echo $from_clinic_time[$i] ?> - <?php echo $from_clinic_time[$i] ?></span>
															<!-- <span>4:00 PM - 9:00 PM</span> -->
														</p>
													</div>
													<?php } ?>
												</div>
											</div>
											<!-- /Clinic Timing -->
											
											<div class="col-md-2">
												<!-- <div class="consult-price">
													$250
												</div> -->
											</div>
										</div>
									</div>
									<!-- /Location List -->
									<?php } ?>

								</div>
								<!-- /Locations Content -->
								
								<!-- Reviews Content -->
								<div role="tabpanel" id="doc_reviews" class="tab-pane fade<?= isset($_GET['review']) ? ' show active' : ''; ?>">
								
									<!-- Review Listing -->
									<?php if(count($doctor_review) > 0) { ?>
									<div class="widget review-listing">
										<ul class="comments-list">
											<?php foreach($doctor_review as $row) { ?>
											<!-- Comment List -->
											<li>
												<div class="comment">
													<img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?= $row->img; ?>" onerror="this.src='uploads/favicon.png'">
													<div class="comment-body">
														<div class="meta-data">
															<span class="comment-author"><?= $row->patient_name; ?></span>
															<span class="comment-date">Reviewed <?= $this->common->time_ago($row->created_at); ?></span>
															<div class="review-count rating">
																<i class="fas fa-star <?= $row->ratings >= 1 ? "filled" : ""; ?>"></i>
																<i class="fas fa-star <?= $row->ratings >= 2 ? "filled" : ""; ?>"></i>
																<i class="fas fa-star <?= $row->ratings >= 3 ? "filled" : ""; ?>"></i>
																<i class="fas fa-star <?= $row->ratings >= 4 ? "filled" : ""; ?>"></i>
																<i class="fas fa-star <?= $row->ratings >= 5 ? "filled" : ""; ?>"></i>
															</div>
														</div>
														<p class="comment-content">
															<?= $row->comment; ?>
														</p>
													</div>
												</div>
												
											</li>
											<!-- /Comment List -->
											<?php } ?>
										</ul>										
									</div>
									<?php } ?>
									<!-- /Review Listing -->
									
									<!-- Write Review -->
									<?php if(isset($_GET["review"]) && $_GET["review"] > 0 && $this->ion_auth->get_user_id() > 0 && $this->ion_auth->in_group(array('Patient'))) { ?>
										<div class="write-review">
											<h4>Write a review for <strong>Dr. Darren Elder</strong></h4>
											
											<!-- Write Review Form -->
											<form action="<?= base_url("frontend/add_review"); ?>" method="POST">
												<div class="form-group">
													<label>Review</label>
													<div class="star-rating">
														<input id="star-5" type="radio" name="rating" value="5">
														<label for="star-5" title="5 stars">
															<i class="active fa fa-star"></i>
														</label>
														<input id="star-4" type="radio" name="rating" value="4">
														<label for="star-4" title="4 stars">
															<i class="active fa fa-star"></i>
														</label>
														<input id="star-3" type="radio" name="rating" value="3">
														<label for="star-3" title="3 stars">
															<i class="active fa fa-star"></i>
														</label>
														<input id="star-2" type="radio" name="rating" value="2">
														<label for="star-2" title="2 stars">
															<i class="active fa fa-star"></i>
														</label>
														<input id="star-1" type="radio" name="rating" value="1">
														<label for="star-1" title="1 star">
															<i class="active fa fa-star"></i>
														</label>
													</div>
												</div>
												<div class="form-group">
													<label>Your review</label>
													<textarea id="review_desc" name="review_desc" maxlength="100" class="form-control"></textarea>
												  
												  <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">100</span> characters remaining</small></div>
												  <input type="hidden" name="doctor_id" value="<?= $doctor_profile_data->id; ?>">
												  <input type="hidden" name="user_id" value="<?= $this->ion_auth->get_user_id(); ?>">
												  <input type="hidden" name="order_no" value="<?= $_GET["review"]; ?>">
												  <input type="hidden" name="type" value="Doctor">
												</div>
												<hr>
												<div class="form-group">
													<div class="terms-accept">
														<div class="custom-checkbox">
														   <input type="checkbox" id="terms_accept">
														   <label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
														</div>
													</div>
												</div>
												<div class="submit-section">
													<button type="submit" class="btn btn-light submit-btn" disabled >Add Review</button>
												</div>
											</form>
											<!-- /Write Review Form -->
											
										</div>
									<?php } ?>
									<!-- /Write Review -->
						
								</div>
								<!-- /Reviews Content -->
								
								<!-- Business Hours Content -->
								<div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
									<div class="row">
										<div class="col-md-6 offset-md-3">
										
											<!-- Business Hours Widget -->
											<div class="widget business-widget">
												<div class="widget-content">
													<div class="listing-hours">
														<div class="listing-day current">
															<div class="day">Today <span>5 Nov 2019</span></div>
															<div class="time-items">
																<span class="open-status"><span class="badge bg-success-light">Open Now</span></span>
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Monday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Tuesday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Wednesday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Thursday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Friday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day">
															<div class="day">Saturday</div>
															<div class="time-items">
																<span class="time">07:00 AM - 09:00 PM</span>
															</div>
														</div>
														<div class="listing-day closed">
															<div class="day">Sunday</div>
															<div class="time-items">
																<span class="time"><span class="badge bg-danger-light">Closed</span></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- /Business Hours Widget -->
									
										</div>
									</div>
								</div>
								<!-- /Business Hours Content -->
								
							</div>
						</div>
					</div>
					<!-- /Doctor Details Tab -->

				</div>
			</div>		
			<!-- /Page Content -->