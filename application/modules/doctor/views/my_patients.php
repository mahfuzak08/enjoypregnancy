<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="row row-grid">
		<?php
		foreach($patient_lists as $row) { ?>
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="card widget-profile pat-widget-profile">
					<div class="card-body">
						<div class="pro-widget-content">
							<div class="profile-info-widget">
								<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient booking-doc-img">
									<img src="<?= $row->patient_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
								</a>
								<div class="profile-det-info">
									<h3><a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient"><?= $row->patient_name; ?></a></h3>
									
									<div class="patient-details">
										<h5><b>Patient ID :</b> P<?= $row->patient_ion_user_id; ?></h5>
										<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $row->patient_address; ?></h5>
									</div>
								</div>
							</div>
						</div>
						<div class="patient-info">
							<ul>
								<li>Phone <span><a href="tel:<?= $row->patient_phone; ?>" target="_blank"><?= $row->patient_phone; ?></a></span></li>
								<li>Age <span><?= floor(abs(strtotime(date("Y-m-d")) - strtotime($row->birthdate)) / (365*60*60*24)); ?> Years, <?= $row->sex; ?></span></li>
								<li>Blood Group <span><?= $row->bloodgroup; ?></span></li>
							</ul>
						</div>
					</div>
				</div>
			</div><?php 
		} ?>
	</div>
</div>
<!-- / main page content in right side -->