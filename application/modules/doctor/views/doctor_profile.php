<!-- Bootstrap CSS -->
<link rel="stylesheet" href="new_assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
<?php 
$extensionImg = array("jpeg", "jpg", "png", "gif" );
$videotype = array("avi", "3gp", "mp4", "mov", "mkv", "m4v", "flv");
?>
<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
			<!-- Profile Settings Form -->
			<form action="profile/update" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Basic Information</h4>
						<?php if($doctor_data->is_approved == 2) { ?>
						<h6 class="text-warning"><i class='fa fa-exclamation-triangle'></i> Account Approval In Progress: </strong>You will be able to see all features once admin approve your account.</h6>
						<?php } ?>
						<div class="row form-row">
							<div class="col-12 col-md-12">
								<div class="form-group">
									<div class="change-avatar">
										<div class="profile-img">
											<img src="<?= $doctor_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
											<input type="hidden" name="old_profileimage" value="<?= $doctor_data->img_url; ?>">
										</div>
										<div class="upload-img">
											<div class="change-photo-btn">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input type="file" name="profileimage" class="upload">
											</div>
											<small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Full Name</label>
									<input type="text" name="name" class="form-control" value="<?= $doctor_data->name; ?>" required>
								</div>
							</div>
							<!--<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" class="form-control" value="Wilson">
								</div>
							</div>-->
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Email ID</label>
									<input type="email" name="email" class="form-control" value="<?= $doctor_data->email; ?>">
									<input type="hidden" name="oldemail" value="<?= $doctor_data->email; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" name="phone" value="<?= $doctor_data->phone; ?>" class="form-control">
									<input type="hidden" name="oldphone" value="<?= $doctor_data->phone; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Date of Birth</label>
									<input type="date" name="date_of_birth" class="form-control" value="<?= $doctor_data->date_of_birth; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Gender</label>
									<select class="form-control" name="gender" required>
										<option>Select</option>
										<option value="Male" <?= strtolower($doctor_data->gender) == 'male' ? 'selected' : ''; ?>>Male</option>
										<option value="Female" <?= strtolower($doctor_data->gender) == 'female' ? 'selected' : ''; ?>>Female</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Speciality</label>
									<select class="form-control" name="speciality" required>
										<option>Select</option>
										<?php foreach($speciality as $row) { ?>
											<option value="<?= $row->speciality; ?>" <?= $doctor_data->profile == $row->speciality ? 'selected' : ''; ?>><?= $row->speciality; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label class="d-block">Appiontment Type</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="urgent_care" id="type_gp" value="1" <?= $doctor_data->urgent_care_status ==  1 ? "checked" : ""; ?>>
										<label class="form-check-label" for="type_gp"> Urgent Consult </label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="home_visit" id="type_sp" value="1" <?= $doctor_data->home_visit_status ==  1 ? "checked" : ""; ?>>
										<label class="form-check-label" for="type_sp"> Home Visit </label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<!--
								<div class="form-group">
									<label class="d-block">Doctor Type</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="doctor_type" id="type_gp" value="0" <?= $doctor_data->doctor_type ==  0 ? "checked" : ""; ?>>
										<label class="form-check-label" for="type_gp"> GP </label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="doctor_type" id="type_sp" value="1" <?= $doctor_data->doctor_type ==  1 ? "checked" : ""; ?>>
										<label class="form-check-label" for="type_sp"> Specialist </label>
									</div>
								</div>
								-->
							</div>
							<div class="col-12">
								<div class="form-group">
									<label>Biography</label>
									<input type="text" name="about_me" class="form-control" value="<?= $doctor_data->about_me; ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Contact Details</h4>
						<div class="row form-row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Address Line 1</label>
									<input type="text" name="address[]" class="form-control" value="<?= json_decode($doctor_data->address)[0]; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Address Line 2</label>
									<input type="text" name="address[]" class="form-control" value="<?= json_decode($doctor_data->address)[1]; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>City</label>
									<input type="text" name="city" class="form-control" value="<?= $doctor_data->city; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>State / Province</label>
									<input type="text" name="state_province" class="form-control" value="<?= $doctor_data->state_province; ?>">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Country:</label>
									<select class="form-control" name="country" id="country" required>
										<option>Select</option>
										<?php foreach($countries as $row) { ?>
											<option value="<?= $row->country; ?>" data-currency_code="<?= $row->currency_code; ?>" <?= $doctor_data->country == $row->country ? 'selected' : ''; ?>><?= $row->country; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Postal Code</label>
									<input type="text" name="postal_code" class="form-control" value="<?= $doctor_data->postal_code; ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Pricing -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Pricing in <span id="ccode"><?= $doctor_data->currency_code; ?></span></h4>
						<div class="row form-row">
							<div class="col-12 col-md-6">
								<div class="form-group mb-0">
									<div id="pricing_select">
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="price_free" name="rating_option" class="custom-control-input" value="price_free" <?php if($doctor_data->pricing=='free' or $doctor_data->pricing==''){ echo 'checked'; } ?>>
											<label class="custom-control-label" for="price_free">Free</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="price_custom" name="rating_option" value="custom_price" class="custom-control-input" <?php if($doctor_data->pricing > 0){ echo 'checked'; } ?>>
											<label class="custom-control-label" for="price_custom">Custom Price</label>
										</div>
									</div>
								</div>
								<div class="row custom_price_cont" id="custom_price_cont" style="<?= $doctor_data->pricing > 0 ? '' : 'display: none;'; ?>">
									<div class="col-md-6">
										<input type="text" class="form-control" id="custom_rating_input" name="cust_price" value="<?php if($doctor_data->pricing > 0){ echo $doctor_data->pricing; } ?>" placeholder="20">
										<small class="form-text text-muted">Custom price you can add</small>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group mb-0">
									<div id="pricing_select">
										<div class="custom-control custom-control-inline">
											<label class="">Urgent Consultation Fee</label>
										</div>
										<div class="custom-control custom-control-inline">
											<label class="">Home Visit Fee</label>
										</div>
									</div>
								</div>
								<div class="row custom_price_cont">
									<div class="col-md-6">
										<input type="text" class="form-control"  name="urgent_fee" value="<?php echo $doctor_data->urgent_fee ?>" placeholder="20">
										<small class="form-text text-muted">Urgent Consultation Fee</small>
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control" name="home_fee" value="<?php echo $doctor_data->home_fee ?>" placeholder="20">
										<small class="form-text text-muted">Home Visit Fee</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Pricing -->
				
				<!-- Services and Specialization -->
				<div class="card services-card">
					<div class="card-body">
						<h4 class="card-title">Services and Specialization</h4>
						<div class="form-group">
							<label>Services</label>
							<input type="text" data-role="tagsinput" class="input-tags form-control" placeholder="Enter Services" name="services" value="<?php if($doctor_data->services !=''){ echo $doctor_data->services; }else{ ?>Audio, Video, Chat<?php } ?>" id="services">
							<small class="form-text text-muted">Note : Type & Press enter to add new services</small>
						</div> 
						<div class="form-group mb-0">
							<label>Specialization </label>
							<input class="input-tags form-control" type="text" data-role="tagsinput" placeholder="Enter Specialization" name="specialization"  value="<?php echo $doctor_data->specialization ?>" id="specialist">
							<small class="form-text text-muted">Note : Type & Press  enter to add new specialization</small>
						</div> 
					</div>              
				</div>
				<!-- /Services and Specialization -->
				
				<!-- Clinic Info -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Clinic Info</h4>
							<div class="clinic-info">
							<?php $clinic_information = json_decode($doctor_data->clinic_info);
							foreach($clinic_information as $key => $valdata){ ?>
									<div class="row form-row clinic-cont">
										<div class="col-12 col-md-10 col-lg-11">
											<div class="row form-row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Clinic Name</label>
														<input type="text" name="clinic_name[]" value="<?php echo $valdata->clinic_name ?>" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Clinic Address</label>
														<input type="text" class="form-control" name="clinic_address[]" value="<?php echo $valdata->clinic_address ?>">
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php 
							} ?>
							</div>
							<div class="add-more">
								<a href="javascript:void(0);" class="add-clinic"><i class="fa fa-plus-circle"></i> Add More</a>
							</div>
					</div>
				</div>
				<!-- /Clinic Info -->
			 
				<!-- Education -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Education</h4>
						<div class="education-info">
							<?php $education = json_decode($doctor_data->education);
							foreach($education as $val){ ?>
								<div class="row form-row education-cont">
									<div class="col-12 col-md-10 col-lg-11">
										<div class="row form-row">
											<div class="col-12 col-md-6 col-lg-4">
												<div class="form-group">
													<label>Degree</label>
													<input type="text" name="degree[]" value="<?php echo $val->degree ?>" class="form-control">
												</div> 
											</div>
											<div class="col-12 col-md-6 col-lg-4">
												<div class="form-group">
													<label>College/Institute</label>
													<input type="text" name="college_institute[]" value="<?php echo $val->college_institute ?>" class="form-control">
												</div> 
											</div>
											<div class="col-12 col-md-6 col-lg-4">
												<div class="form-group">
													<label>Year of Completion</label>
													<input type="text" name="degree_compl_year[]" value="<?php echo $val->degree_compl_year ?>" class="form-control">
												</div> 
											</div>
										</div>
									</div>
								</div><?php
							} ?>
						</div>
						<div class="add-more">
							<a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
						</div>
					</div>
				</div>
				<!-- /Education -->
			
				<!-- Experience -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Experience</h4>
						<div class="experience-info">
							<?php $experience = json_decode($doctor_data->experience);
							foreach($experience as $val){ ?>
								<div class="row form-row experience-cont">
									<div class="col-12 col-md-10 col-lg-11">
										<div class="row form-row">
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label>Hospital Name</label>
													<input type="text" class="form-control" name="exp_hospital_name[]" value="<?php echo $val->exp_hospital_name ?>">
												</div> 
											</div>
											<div class="col-6 col-md-2">
												<div class="form-group">
													<label>From</label>
													<input type="text" class="form-control" name="exp_from[]" value="<?php echo $val->exp_from ?>">
												</div> 
											</div>
											<div class="col-6 col-md-2">
												<div class="form-group">
													<label>To</label>
													<input type="text" class="form-control" name="exp_to[]" value="<?php echo $val->exp_to ?>">
												</div> 
											</div>
											<div class="col-12 col-md-4">
												<div class="form-group">
													<label>Designation</label>
													<input type="text" class="form-control" name="designation[]" value="<?php echo $val->designation ?>">
												</div> 
											</div>
										</div>
									</div>
								</div> <?php
							} ?>
						</div>
						<div class="add-more">
							<a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
						</div>
					</div>
				</div>
				<!-- /Experience -->
				
				<!-- Awards -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Awards</h4>
						<div class="awards-info">
							<?php $awards = json_decode($doctor_data->awards);
							foreach($awards as $val){ ?>
								<div class="row form-row awards-cont">
									<div class="col-12 col-md-5">
										<div class="form-group">
											<label>Awards</label>
											<input type="text" class="form-control" name="awards[]" value="<?php echo $val->awards ?>">
										</div> 
									</div>
									<div class="col-12 col-md-5">
										<div class="form-group">
											<label>Year</label>
											<input type="text" class="form-control" name="award_year[]" value="<?php echo $val->award_year ?>">
										</div> 
									</div>
								</div><?php 
							} ?>
						</div>
						<div class="add-more">
							<a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i> Add More</a>
						</div>
					</div>
				</div>
				<!-- /Awards -->
				
				<!-- Document -->
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Attachments</h4>
						
						<div class="row form-row awards-cont">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label>License registration</label>
									<input type="file" class="form-control" name="license_registeration">
									<input type="hidden" name="sec_doctor_lic_doc" value="<?php echo $doctor_data->doctor_lic_doc; ?>">
								</div> 
							</div>
							<div class="col-12 col-md-5" style="margin: auto; float: left;">
								<?php $lrurl = base_url("assets/doctor_prop_data/".$doctor_data->doctor_lic_doc); ?>
								<?php if(! empty($doctor_data->doctor_lic_doc)){ ?>
								<a href="<?= $lrurl; ?>" target="_blank">
									<?php 
									$ext = strtolower(pathinfo($lrurl, PATHINFO_EXTENSION));
									if(in_array($ext,$extensionImg)){ ?>
										<img style="max-height: 90px; max-width: 90px;" src="<?= $lrurl; ?>" alt="image-1" />
									<?php } elseif($ext == 'pdf') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/pdf.png" alt="image-1" />
									<?php } elseif($ext == 'doc' || $ext == 'docx') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/doc.png" alt="image-1" />
									<?php } elseif($ext == 'zip' || $ext == 'rar') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/zip.png" alt="image-1" />
									<?php } elseif(in_array($ext, $videotype)) { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/video.png" alt="image-1" />
									<?php } else { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/other.png" alt="image-1" />
									<?php } ?>
									<?= $doctor_data->doctor_lic_doc; ?>
								</a>
								<?php } ?>
							</div>
						</div>
					
						<div class="row form-row awards-cont">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label>Identity document</label>
									<input type="file" class="form-control" name="identity_doc">
									<input type="hidden" name="sec_identitydoc" value="<?= $doctor_data->identitydoc; ?>">
								</div> 
							</div>
							<div class="col-12 col-md-5" style="margin: auto; float: left;">
								<?php $lrurl = base_url("assets/doctor_prop_data/".$doctor_data->identitydoc); ?>	
								<?php if(! empty($doctor_data->identitydoc)){ ?>
								<a href="<?= $lrurl; ?>" target="_blank">
									<?php 
									$ext = strtolower(pathinfo($lrurl, PATHINFO_EXTENSION));
									if(in_array($ext,$extensionImg)){ ?>
										<img style="max-height: 90px; max-width: 90px;" src="<?= $lrurl; ?>" alt="image-1" />
									<?php } elseif($ext == 'pdf') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/pdf.png" alt="image-1" />
									<?php } elseif($ext == 'doc' || $ext == 'docx') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/doc.png" alt="image-1" />
									<?php } elseif($ext == 'zip' || $ext == 'rar') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/zip.png" alt="image-1" />
									<?php } elseif(in_array($ext, $videotype)) { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/video.png" alt="image-1" />
									<?php } else { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/other.png" alt="image-1" />
									<?php } ?>
									<?= $doctor_data->identitydoc; ?>
								</a>
								<?php } ?>
							</div>
						</div>
					
						<div class="row form-row awards-cont">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label>Address proof</label>
									<input type="file" class="form-control" name="proof_of_address">
									<input type="hidden" name="sec_proof_of_address" value="<?= $doctor_data->proof_of_address; ?>">
								</div> 
							</div>
							<div class="col-12 col-md-5" style="margin: auto; float: left;">
								<?php $lrurl = base_url("assets/doctor_prop_data/".$doctor_data->proof_of_address); ?>	
								<?php if(! empty($doctor_data->proof_of_address)){ ?>
								<a href="<?= $lrurl; ?>" target="_blank">
									<?php 
									$ext = strtolower(pathinfo($lrurl, PATHINFO_EXTENSION));
									if(in_array($ext,$extensionImg)){ ?>
										<img style="max-height: 90px; max-width: 90px;" src="<?= $lrurl; ?>" alt="image-1" />
									<?php } elseif($ext == 'pdf') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/pdf.png" alt="image-1" />
									<?php } elseif($ext == 'doc' || $ext == 'docx') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/doc.png" alt="image-1" />
									<?php } elseif($ext == 'zip' || $ext == 'rar') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/zip.png" alt="image-1" />
									<?php } elseif(in_array($ext, $videotype)) { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/video.png" alt="image-1" />
									<?php } else { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/other.png" alt="image-1" />
									<?php } ?>
									<?= $doctor_data->proof_of_address; ?>
								</a>
								<?php } ?>
							</div>
						</div>
						
						<div class="row form-row awards-cont">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label>Professional Insurance</label>
									<input type="file" class="form-control" name="professional_insurance_doc">
									<input type="hidden" name="sec_professional_insurance_doc" value="<?= $doctor_data->professional_insurance_doc; ?>">
								</div> 
							</div>
							<div class="col-12 col-md-5" style="margin: auto; float: left;">
								<?php $lrurl = base_url("assets/doctor_prop_data/".$doctor_data->professional_insurance_doc); ?>
								<?php if(! empty($doctor_data->professional_insurance_doc)){ ?>
								<a href="<?= $lrurl; ?>" target="_blank">
									<?php 
									$ext = strtolower(pathinfo($lrurl, PATHINFO_EXTENSION));
									if(in_array($ext,$extensionImg)){ ?>
										<img style="max-height: 90px; max-width: 90px;" src="<?= $lrurl; ?>" alt="image-1" />
									<?php } elseif($ext == 'pdf') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/pdf.png" alt="image-1" />
									<?php } elseif($ext == 'doc' || $ext == 'docx') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/doc.png" alt="image-1" />
									<?php } elseif($ext == 'zip' || $ext == 'rar') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/zip.png" alt="image-1" />
									<?php } elseif(in_array($ext, $videotype)) { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/video.png" alt="image-1" />
									<?php } else { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/other.png" alt="image-1" />
									<?php } ?>
									<?= $doctor_data->professional_insurance_doc; ?>
								</a>
								<?php } ?>
							</div>
						</div>
						
						<div class="row form-row awards-cont">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label>Professional References (1)</label>
									<input type="file" class="form-control" name="professional_ref_doc1">
									<input type="hidden" name="sec_professional_ref_doc1" value="<?= $doctor_data->professional_ref_doc1; ?>">
								</div> 
							</div>
							<div class="col-12 col-md-5" style="margin: auto; float: left;">
								<?php $lrurl = base_url("assets/doctor_prop_data/".$doctor_data->professional_ref_doc1); ?>
								<?php if(! empty($doctor_data->professional_ref_doc1)){ ?>
								<a href="<?= $lrurl; ?>" target="_blank">
									<?php 
									$ext = strtolower(pathinfo($lrurl, PATHINFO_EXTENSION));
									if(in_array($ext,$extensionImg)){ ?>
										<img style="max-height: 90px; max-width: 90px;" src="<?= $lrurl; ?>" alt="image-1" />
									<?php } elseif($ext == 'pdf') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/pdf.png" alt="image-1" />
									<?php } elseif($ext == 'doc' || $ext == 'docx') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/doc.png" alt="image-1" />
									<?php } elseif($ext == 'zip' || $ext == 'rar') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/zip.png" alt="image-1" />
									<?php } elseif(in_array($ext, $videotype)) { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/video.png" alt="image-1" />
									<?php } else { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/other.png" alt="image-1" />
									<?php } ?>
									<?= $doctor_data->professional_ref_doc1; ?>
								</a>
								<?php } ?>
							</div>
						</div>
						<div class="row form-row awards-cont">
							<div class="col-12 col-md-5">
								<div class="form-group">
									<label>Professional References (2)</label>
									<input type="file" class="form-control" name="professional_ref_doc2">
									<input type="hidden" name="sec_professional_ref_doc2" value="<?= $doctor_data->professional_ref_doc2; ?>">
								</div> 
							</div>
							<div class="col-12 col-md-5" style="margin: auto; float: left;">
								<?php $lrurl = base_url("assets/doctor_prop_data/".$doctor_data->professional_ref_doc2); ?>
								<?php if(! empty($doctor_data->professional_ref_doc2)){ ?>
								<a href="<?= $lrurl; ?>" target="_blank">
									<?php 
									$ext = strtolower(pathinfo($lrurl, PATHINFO_EXTENSION));
									if(in_array($ext,$extensionImg)){ ?>
										<img style="max-height: 90px; max-width: 90px;" src="<?= $lrurl; ?>" alt="image-1" />
									<?php } elseif($ext == 'pdf') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/pdf.png" alt="image-1" />
									<?php } elseif($ext == 'doc' || $ext == 'docx') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/doc.png" alt="image-1" />
									<?php } elseif($ext == 'zip' || $ext == 'rar') { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/zip.png" alt="image-1" />
									<?php } elseif(in_array($ext, $videotype)) { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/video.png" alt="image-1" />
									<?php } else { ?>
										<img style="max-height: 60px; max-width: 40px;" src="new_assets/img/other.png" alt="image-1" />
									<?php } ?>
									<?= $doctor_data->professional_ref_doc2; ?>
								</a>
								<?php } ?>
							</div>
						</div>
					
					</div>
				</div>
				<!-- /Document -->
				
				<div class="submit-section submit-btn-bottom">
					<input type="hidden" name="id" value="<?= $doctor_data->id; ?>">
					<input type="hidden" name="support_status" value="<?php echo $doctor_data->is_approved ?>">
					<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
				</div>
			</form>
			<!-- /Profile Settings Form -->
</div>
<!-- / main page content in right side -->
<script src="new_assets/js/profile-settings.js"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="new_assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>
<script>
	$("#country").on("change", function(){
		$("#ccode").text($(this).find(':selected').attr('data-currency_code'));
	});
</script>