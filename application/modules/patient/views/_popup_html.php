<!-- Graph One-->
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
<!-- /Graph One-->

<!-- Graph Two-->
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
<!-- /Graph Two-->

<!-- Graph Two-->
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
<!-- /Graph Two-->

<!-- Graph Two-->
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
<!-- /Graph Two-->
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
					<div class="form-group">
						<label class="control-label mb-10"> BMI</label>
						<input type="text" name="bmi" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label mb-10">Heart rate </label>
						<input type="text" name="heart_rate" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label mb-10">Weight</label>
						<input type="text" name="weight" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label mb-10">Fbc</label>
						<input type="text" id="fbc" name="fbc" class="form-control">
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