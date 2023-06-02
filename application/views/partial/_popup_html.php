<div class="modal fade show static-modal" id="confirm_box">
	<div class="modal-dialog mb-2" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<p></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-primary confirm_box_ok">Yes</button>
			</div>
		</div>
	</div>
</div>

<?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
	<!-- Graph -->
	<div class="modal fade custom-modal show" id="graph1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">BMI Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="bmi-status"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade custom-modal show" id="graph2">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Heart Rate Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="heartrate-status"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade custom-modal show" id="graph5">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Respiratory Rate Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="resrate-status"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade custom-modal show" id="graph6">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Temperature Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="temperature-status"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade custom-modal show" id="graph3">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">FBC Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="fbc-status"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade custom-modal show" id="graph7">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Blood Pressure</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="bp-status"></div>
				</div>
			</div>
		</div>
	</div>
	
	<!--<div class="modal fade custom-modal show" id="graph8">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Vaccination</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="vaccination-status"></div>
				</div>
			</div>
		</div>
	</div>-->
	
	<div class="modal fade custom-modal show" id="graph4">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Weight Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="weight-status"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Graph-->
	
	<!-- Medical Records Modal -->
	<div class="modal fade custom-modal custom-medicalrecord-modal" id="add_medical_records_modal" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Medical Records</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<form id="medical_records_form" method="post" action="patient/addPatientMaterial" enctype="multipart/form-data">          
					<div class="modal-body">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Title Name</label>
									<input type="text" name="title" class="form-control" placeholder="Enter Title Name">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Patient</label>
									<select name="patient_id" class="form-control">
										<option value="<?= @$patient_data->id; ?>"><?= @$patient_data->name; ?></option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Hospital Name</label>
									<input type="hidden" value="<?= @$hospital->id; ?>" name="hospital_id">
									<input type="text" value="<?= @$hospital->name; ?>" class="form-control" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Upload</label>
									<div class="upload-medical-records">
										<input class="form-control" type="file" name="user_file" id="user_files_mr">
										<div class="upload-content dropzone">
											<div class="text-center">
												<div class="upload-icon mb-2"><img src="new_assets/img/upload-icon.png" alt=""></div>
												<h5>Drag &amp; Drop</h5>
												<h6>or <span class="text-danger">Browse</span></h6>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Symptoms</label>
									<input type="text" data-role="tagsinput" class="input-tags form-control" placeholder="Fever, Fatigue" name="symptoms" id="services">
								</div> 
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label>Date</label>
									<div class="form-group">
										<input type="date" class="form-control" name="tratment_date" id="tratment_date">
									</div> 
								</div>
							</div>
						</div> -->
						<div class="text-center mt-4">
							<div class="submit-section text-center">
								<button type="submit" id="medical_btn" class="btn btn-primary submit-btn">Submit</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Medical Records Modal -->
	<!-- Add Medical Detail -->
	<div id="modal_medical_form" class="modal fade custom-modal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form enctype="multipart/form-data" autocomplete="off" method="post" action="patient/addPatientMedicalHistory"> 
					<div class="modal-header">
						<h5 class="modal-title">Add new data</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="hidden" value="<?= $patient_data->id; ?>" name="patient_id"> 
						<div class="row">
							<div class="form-group col-6">
								<label class="control-label mb-10"> Vaccine Name</label>
								<input type="text" name="vaccine" class="form-control">
							</div>
							<div class="form-group col-6">
								<label class="control-label mb-10">Heart rate </label>
								<input type="text" name="heart_rate" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6">
								<label class="control-label mb-10">Respiratory rate </label>
								<input type="text" name="res_rate" class="form-control">
							</div>
							<div class="form-group col-6">
								<label class="control-label mb-10">Blood Pressure </label>
								<input type="text" name="blood_pressure" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6">
								<label class="control-label mb-10">Temperature </label>
								<input type="text" name="temperature" class="form-control">
							</div>
							<div class="form-group col-6">
								<label class="control-label mb-10">Glucose Level</label>
								<input type="text" id="fbc" name="fbc" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6">
								<label class="control-label mb-10"> BMI</label>
								<input type="text" name="bmi" class="form-control">
							</div>
							<div class="form-group col-6">
								<label class="control-label mb-10">Weight</label>
								<input type="text" name="weight" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label mb-10">Created Date </label>
							<input type="date" name="date" id="date" class="form-control">
						</div>
					</div>
					<div class="modal-footer text-center">
						<button type="submit" class="btn btn-outline btn-success ">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Add Medical Detail -->
	<!-- Add Dependent Modal-->
	<div id="modal_form" class="modal fade custom-modal" tabindex="-1" role="dialog" aria-modal="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form action="patient/update_dependent" enctype="multipart/form-data" autocomplete="off" method="post"> 
					<div class="modal-header">
						<h5 class="modal-title">Add new member</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label mb-10"> Name <span class="text-danger">*</span></label>
							<input type="text" name="name" value="<?= @$dependent->dep_name; ?>" class="form-control">
						</div>
						<div class="row">
							<div class="form-group col-md-6 col-sm-12">
								<label class="control-label mb-10">Relationship </label>
								<input type="text" name="relationship" value="<?= @$dependent->relation; ?>" class="form-control">
							</div>
							<div class="form-group col-md-6 col-sm-12">
								<label class="control-label mb-10">Gender </label>
								<select class="form-control" name="gender">
									<option value="">Select</option>
									<option <?= @$dependent->dep_gender == 'Male' ? 'selected' : ''; ?>>Male</option>
									<option <?= @$dependent->dep_gender == 'Female' ? 'selected' : ''; ?>>Female</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6 col-sm-12">
								<label class="control-label mb-10">Blood Groupd </label>
								<select class="form-control" name="blood_group">
									<option value="">Select</option>
									<option <?= @$dependent->dep_blood_group == 'A-' ? 'selected' : ''; ?>>A-</option>
									<option <?= @$dependent->dep_blood_group == 'A+' ? 'selected' : ''; ?>>A+</option>
									<option <?= @$dependent->dep_blood_group == 'B-' ? 'selected' : ''; ?>>B-</option>
									<option <?= @$dependent->dep_blood_group == 'B+' ? 'selected' : ''; ?>>B+</option>
									<option <?= @$dependent->dep_blood_group == 'AB-' ? 'selected' : ''; ?>>AB-</option>
									<option <?= @$dependent->dep_blood_group == 'AB+' ? 'selected' : ''; ?>>AB+</option>
									<option <?= @$dependent->dep_blood_group == 'O-' ? 'selected' : ''; ?>>O-</option>
									<option <?= @$dependent->dep_blood_group == 'O+' ? 'selected' : ''; ?>>O+</option>
								</select>
							</div>
							<div class="form-group col-md-6 col-sm-12">
								<label class="control-label mb-10">Date of Birth </label>
								<input type="date" name="dob" value="<?= @$dependent->dep_dob; ?>" id="dob" value="" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label mb-10">Mobile Number </label>
							<input type="text" name="phone" value="<?= @$dependent->dep_number; ?>" class="form-control">
						</div>
						<div class="form-group">
							<label class="control-label mb-10">Photo </label>
							<?php if(isset($dependent->dep_img)) { ?>
							<img src="<?= @$dependent->dep_img; ?>" width="100px" height="100px">
							<input type="hidden" name="old_profile_image" value="<?= @$dependent->dep_img; ?>" class="form-control">
							<?php } ?>
							<input type="file" name="profile_image" class="form-control">
						</div>
					</div>
					<div class="modal-footer text-center">
						<input type="hidden" name="patient_id" value="<?= empty($dependent) ? $patient_data->id : $dependent->patient_id; ?>">
						<input type="hidden" name="id" value="<?= $dependent->id; ?>">
						<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Add Dependent Modal-->
<?php } elseif ($this->ion_auth->in_group(array('Doctor'))) { ?>
	<style>
	.modal #patient_details .left-info p{
		border-bottom: 1px solid #DEDEDE;
	}
	.modal #patient_details .left-info p span{
		float: right;
		margin-right: 20px;
	}
	
	</style>
	<div class="modal fade show" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" aria-modal="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="ajaxModalLabel">Header</h4>
					<button class="close closeajaxModal" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body" style="max-height: calc(100vh - 100px); overflow-y: auto;">
					<div id="ajaxModalContent">

					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="TemplateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"> Add Template</h4>
				</div>
				<div class="modal-body row  ">

					<?php
					$template = $this->bodycharttemplate_model->getBodychart();
					foreach ($template as $key => $item) {
						?>
						<a href="javascript:;" data-template_id="<?=$item->id?>" data-img="<?= base_url('common/' . $item->image) ?>"
						   class="col-md-3 thumbnails text-center">
							<img src="<?= base_url('common/' . $item->thumbnil) ?>"
								 class="img img-thumbnail img-responsive">
							<h5> <?= $item->title; ?></h5>
						</a>

					<?php } ?>

				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade patient_details_modal show">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myLargeModalLabel">Patient Details</h4>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body" id="patient_details">
					
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade show" id="emailModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Send Email</h4>
					<button class="close closeajaxModal" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
				</div>
				<div class="modal-body">
					<input value="" id="email" type="hidden"/>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="message">Email Message</label>
							<textarea class='form-control' id="body" placeholder="Type your email here"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary" id="sendEmail" onclick="sendEmail()">Send Email</button>
						</div>
					</div>
					<div class="error" id="info" style="display:none">

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
	</div>

	<div class="modal fade show" id="smsModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Send Message</h4>
					<button type="button" class="close closeajaxModal" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<input value="" id="to_number" type="hidden"/>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="message">Message</label>
							<textarea class='form-control' id="message" placeholder="Type your message here"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary" id="sendSms" onclick="sendSms()">Send SMS</button>
						</div>
					</div>
					<div class="" id="info" style="display:none">

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
	</div>
	
	<div class="modal fade show static-modal" id="prescription_form">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title mt-0">Prescription</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add Time Slot Modal -->
	<div class="modal fade custom-modal" id="add_time_slot">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Time Slots</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="schedule/addSchedule2" method="post">
						<div class="row">
							<div class="col-10">
								<div class="form-group">               
									<label>Timing Slot Duration</label>
									<select class="form-control" name="duration">
										<option>-</option>
										<option>15 mins</option>
										<option selected="selected">30 mins</option>  
										<option>45 mins</option>
										<option>1 Hour</option>
									</select>
								</div>
							</div>
						</div>
						<div class="hours-info">
							<div class="row form-row hours-cont">
								<div class="col-12 col-md-10">
									<div class="row form-row">
										<div class="col-6">
											<div class="form-group">
												<label>Start Time</label>
												<input type="time" name="s_time[]" class="form-control">
												<span class="form-text text-muted">HH:MM AM</span>
											</div> 
										</div>
										<div class="col-6">
											<div class="form-group">
												<label>End Time</label>
												<input type="time" name="e_time[]" class="form-control">
												<span class="form-text text-muted">HH:MM AM</span>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="add-more mb-3">
							<a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
						</div>
						<div class="submit-section text-center">
							<input type="hidden" name="weekday" id="weekday">
							<input type="hidden" name="doctor_id" value="<?= $doctor_data->id; ?>">
							<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Time Slot Modal -->
	
	<!-- Add Holiday Modal -->
	<div class="modal fade custom-modal" id="add_holiday">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Date(s)</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="schedule/addHoliday2" method="post">
						<div class="hours-info">
							<div class="row form-row hours-cont">
								<div class="col-12 col-md-10">
									<div class="row form-row">
										<div class="col-6">
											<div class="form-group">
												<label>Start Date</label>
												<input type="date" name="s_date" class="form-control">
											</div> 
										</div>
										<div class="col-6">
											<div class="form-group">
												<label>End Date</label>
												<input type="date" name="e_date" class="form-control">
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="submit-section text-center">
							<input type="hidden" name="doctor_id" value="<?= $doctor_data->id; ?>">
							<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Time Slot Modal -->
	
	<div class="modal fade show static-modal" id="editbodycharttmp">
		<div class="modal-dialog mb-2" role="document">
			<div class="modal-content">
				<form role="form" id="editDoctorForm" class="clearfix" action="prescription/addNewBodyTemplate" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<h5 class="modal-title mt-0">Add New Template</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row form-row">
							<div class="col-12">
								<label><?php echo lang('title'); ?></label>
								<input type="text" class="form-control" name="title" id="" value='' placeholder="">
							</div>
						</div>
						<div class="row form-row">
							<div class="col-12 col-md-6">
								<label class="control-label">Image Upload</label>
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<img src="" id="img" alt="" onerror="this.src='uploads/default.jpg'" style="width: 200px; height: 150px;" />
								</div>
							</div>
							<div class="col-12 col-md-6">
								<br>
								<div class="upload-img">
									<div class="change-photo-btn">
										<span><i class="fa fa-upload"></i> Upload Photo</span>
										<input type="file" name="img_url" class="upload">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="id" value=''>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<!-- Payment Request Moodal -->
	<div class="modal fade custom-modal" id="payment_request_modal" role="dialog" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form method="post" action="payment/add_update_trans">
					<div class="modal-header">
						<h3 class="modal-title">Payment Request</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Request Amount</label>
							<input type="text" name="amount" id="request_amount" class="form-control" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
							<span class="help-block"></span>
						</div>
						<div class="form-group">
							<label>Description (Optional)</label>
							<textarea class="form-control" name="details" id="description"></textarea>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="modal-footer text-center">
						<input type="hidden" name="currency" value="GBP">
						<input type="hidden" name="method" value="bank_transfer">
						<input type="hidden" name="trns_type" value="withdraw">
						<input type="hidden" name="from" value="<?= $doctor_data->hospital_id; ?>">
						<input type="hidden" name="to" value="<?= $doctor_data->id; ?>">
						<button type="submit" id="request_btn" class="btn btn-primary">Request</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- /Payment Request Moodal -->

	<!-- Account Details Modal-->
	<div class="modal fade custom-modal" id="account_modal" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="accounts_form" action="payment/add_edit_account" method="post">
					<div class="modal-header">
						<h3 class="modal-title">Account Details</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Bank Name</label>
									<input type="text" name="bank_name" class="form-control bank_name" value="<?= @$acc_info->bank_name; ?>">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Branch Name</label>
									<input type="text" name="branch_name" class="form-control branch_name" value="<?= @$acc_info->branch_name; ?>">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Account Number</label>
									<input type="text" name="account_no" class="form-control account_no" value="<?= @$acc_info->account_no; ?>">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Account Name</label>
									<input type="text" name="account_name" class="form-control acc_name" value="<?= @$acc_info->account_name; ?>">
									<span class="help-block"></span>
								</div>
							</div> 
						</div>
					</div>
					<div class="modal-footer text-center">
						<input type="hidden" name="whom" value="Doctor">
						<input type="hidden" name="acc_id" value="<?= @$acc_info->id; ?>">
						<input type="hidden" name="ref_id" value="<?= $doctor_data->id; ?>">
						<button type="submit" id="acc_btn" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Account Details Modal-->

<?php } ?>