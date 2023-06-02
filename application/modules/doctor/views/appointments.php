<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="appointments">	
		<?php
		foreach($appointments as $row) { ?>
			<!-- Appointment List -->
			<div class="appointment-list">
				<div class="profile-info-widget">
					<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient booking-doc-img">
						<img src="<?= $row->patient_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
					</a>
					<div class="profile-det-info">
						<h3><a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient"><?= $row->patient_name; ?></a></h3>
						<div class="patient-details">
							<h5><i class="far fa-clock"></i> <?= date('d-m-Y', $row->date); ?>, <?= $row->s_time; ?></h5>
							<h5><i class="fas fa-map-marker-alt"></i> <?= $row->patient_address; ?></h5>
							<h5><a href="mailto:<?= $row->patient_email; ?>" target="_blank"><i class="fas fa-envelope"></i> <?= $row->patient_email; ?></a></h5>
							<h5 class="mb-0"><a href="tel:<?= $row->patient_phone; ?>" target="_blank"><i class="fas fa-phone"></i> <?= $row->patient_phone; ?></a></h5>
						</div>
					</div>
				</div>
				<div class="appointment-action">
					<a href="#" class="btn btn-sm bg-info-light" data-toggle="modal" data-target="#appt_details">
						<i class="far fa-eye"></i> View
					</a>
					<a href="javascript:void(0);" class="btn btn-sm bg-success-light">
						<i class="fas fa-check"></i> Accept
					</a>
					<a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
						<i class="fas fa-times"></i> Cancel
					</a>
				</div>
			</div>
			<!-- /Appointment List --><?php 
		} ?>
	</div>
</div>
<!-- / main page content in right side -->