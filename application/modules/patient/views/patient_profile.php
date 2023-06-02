<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body">
			
			<!-- Profile Settings Form -->
			<form action="patient/add_update" method="POST" enctype="multipart/form-data">
				<div class="row form-row">
					<div class="col-12 col-md-12">
						<div class="form-group">
							<div class="change-avatar">
								<div class="profile-img">
									<img src="<?= $patient_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
									<input type="hidden" name="old_profileimage" value="<?= $patient_data->img_url; ?>">
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
							<input type="text" name="name" class="form-control" value="<?= $patient_data->name; ?>">
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
							<input type="email" name="email" class="form-control" value="<?= $patient_data->email; ?>">
							<input type="hidden" name="oldemail" value="<?= $patient_data->email; ?>">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label>Mobile</label>
							<input type="text" name="phone" value="<?= $patient_data->phone; ?>" class="form-control">
							<input type="hidden" name="oldphone" value="<?= $patient_data->phone; ?>">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label>Date of Birth</label>
							<div class="cal-icon">
								<input type="text" name="date_of_birth" class="form-control datetimepicker" value="<?= $patient_data->birthdate; ?>">
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label>Gender</label>
							<select class="form-control" name="gender">
								<option>Select</option>
								<option value="Male" <?= strtolower($patient_data->sex) == 'male' ? 'selected' : ''; ?>>Male</option>
								<option value="Female" <?= strtolower($patient_data->sex) == 'female' ? 'selected' : ''; ?>>Female</option>
							</select>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label>Blood Group</label>
							<select class="form-control" name="bloodgroup">
								<option <?= $patient_data->bloodgroup == 'A-' ? 'selected' : ''; ?>>A-</option>
								<option <?= $patient_data->bloodgroup == 'A+' ? 'selected' : ''; ?>>A+</option>
								<option <?= $patient_data->bloodgroup == 'B-' ? 'selected' : ''; ?>>B-</option>
								<option <?= $patient_data->bloodgroup == 'B+' ? 'selected' : ''; ?>>B+</option>
								<option <?= $patient_data->bloodgroup == 'AB-' ? 'selected' : ''; ?>>AB-</option>
								<option <?= $patient_data->bloodgroup == 'AB+' ? 'selected' : ''; ?>>AB+</option>
								<option <?= $patient_data->bloodgroup == 'O-' ? 'selected' : ''; ?>>O-</option>
								<option <?= $patient_data->bloodgroup == 'O+' ? 'selected' : ''; ?>>O+</option>
							</select>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" class="form-control" value="<?= $patient_data->address; ?>">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label>Medical History</label>
							<div class="row">
								<?php $mh = explode(",", $patient_data->medicale_history); ?>
								<?php foreach($medicalHistoryLists as $row){ ?>
								<div class="checkbox col-12 col-md-4">
									<label>
										<input type="checkbox" name="medicaleHistory[]" value="<?= $row->title; ?>" <?= @(in_array($row->title, $mh) ? 'checked' : ''); ?> > <?= $row->title; ?>
									</label>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<!-- medicalHistoryLists -->
				</div>
				<div class="submit-section">
					<input type="hidden" name="id" value="<?= $patient_data->id; ?>">
					<button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
				</div>
			</form>
			<!-- /Profile Settings Form -->
			
		</div>
	</div>
</div>
<!-- / main page content in right side -->