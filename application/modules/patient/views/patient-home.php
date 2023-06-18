<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<!-- patient top info and graph status -->
	<?php $this->load->view("partial/_patient_top_info"); ?>
	<!-- / patient top info and graph status -->
	<div class="card">
		<div class="card-body pt-0">
		
			<!-- Tab Menu -->
			<nav class="user-tabs mb-4">
				<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
					<li class="nav-item">
						<a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link" href="#home-appointments" data-toggle="tab">Home Visit</a>
					</li> -->
					<li class="nav-item">
						<a class="nav-link" href="#pat_prescriptions" data-toggle="tab">Prescriptions</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#pat_diagnostic_tests" data-toggle="tab"><span class="med-records">Diagnostic Tests</span></a>
					</li>
					<!--<li class="nav-item">
						<a class="nav-link" href="#pat_documents" data-toggle="tab"><span class="documents">Documents</span></a>
					</li>-->
					<li class="nav-item">
						<a class="nav-link" href="#pat_medical_history" data-toggle="tab"><span class="medical_history">Medical History</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#part_timeline" data-toggle="tab">Timeline</a>
					</li>
				</ul>
			</nav>
			<!-- /Tab Menu -->
			
			<!-- Tab Content -->
			<div class="tab-content pt-0">
				
				<!-- Appointment Tab -->
				<div id="pat_appointments" class="tab-pane fade show active">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Doctor</th>
											<th>Appt Date Time</th>
											<!--<th>Booking Date</th>-->
											<th>Reason</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($appointments as $row){ ?>
											<?php 
												if($row->status == 'Confirmed') $badge_color = 'success'; 
												elseif($row->status == 'Requested') $badge_color = 'warning'; 
												else $badge_color = 'danger';
											?>
										<tr>
											<td>
												<h2 class="table-avatar">
													<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>" class="avatar avatar-sm mr-2">
														<img class="avatar-img rounded-circle" src="<?= $row->doctor_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $row->doctor_name; ?> Image">
													</a>
													<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>"><?= $row->doctor_name; ?> <span><?= substr($row->doctor_me, 0, 20); ?></span></a>
												</h2>
											</td>
											<td><?= $row->date; ?> <span class="d-block text-info"><?= $row->time_slot; ?></span></td>
											<!--<td><?= date('d-m-Y', $row->registration_time); ?></td>-->
											<td><?= $row->remarks; ?></td>
											<td><span class="badge badge-pill bg-<?= $badge_color; ?>-light"><?= $row->status; ?></span></td>
											<td class="text-right">
												<div class="table-action">
													<?php if($row->status == 'Initiated') { ?>
														<a href="frontend/bookingsuccessfull_payment_notdone/<?= $row->id; ?>" class="btn btn-sm bg-info" title="Chat">
															<i class="fas fa-money-check-alt"></i> Pay Now
														</a>
													<?php } else {
														if($row->status == 'Confirmed') {
															$sdate = explode('T',$row->s_time)[0];
															if($sdate == date("Y-m-d") && ($row->join_url != "" || $row->join_url != null)){ ?>
																<a class="btn btn-sm bg-danger-light mediaBtn" href="javascript:void(0);" data-message="Are you sure you want to join?" data-ref="<?= $row->join_url; ?>" title="<?= lang('live'); ?>">
																	<i class="fa fa-headphones"></i>
																</a><?php 
															} 
														} ?>
														<?php $openchatid = base_convert($patient_data->ion_user_id, 10, 16)."-".base_convert($row->doctor_ion_user_id, 10, 16); ?>
														<a href="chat/open/<?= $openchatid; ?>" class="btn btn-sm bg-info-light" title="Chat">
															<i class="fas fa-comments"></i>
														</a>
														<a href="<?= base_url("patient/viewInvoice/".$row->id); ?>" class="btn btn-sm bg-info-light" title="View">
															<i class="far fa-eye"></i>
														</a>
														<?php if($row->review == 0){ ?>
															<a href="<?= base_url("frontend/doctor_profile/".@$row->doctor."?review=".$row->id); ?>" class="btn btn-sm bg-info-light" title="Go to Review Page"><i class="fa fa-star"></i> </a> 
														<?php } else { ?>
															<a class="btn btn-sm bg-warning-light" title="You give <?= $row->review; ?> star"><i class="fa fa-star"></i></a> 
														<?php }
													}?>
												</div>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /Appointment Tab -->
				
				<!-- Home visit Tab -->
				<!-- <div class="tab-pane" id="home-appointments">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Visit Date</th>
											<th>Doctor Name</th>
											<th>Phone No.</th>
											<th>Purpose</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(count($home_appointment_requests) > 0){
											foreach($home_appointment_requests as $row){ ?>
												<tr>
													<td><?= date('d-m-Y', strtotime($row->date)); ?> <span class="d-block text-info"><?= $row->preffered_time; ?></span></td>
													<td>
														<h2 class="table-avatar">
															<a href="javascript:void(0);" class="view_patient avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= $row->doctor_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image"></a>
															<a href="javascript:void(0);" class="view_patient"><?= $row->doctor_name; ?> </a>
														</h2>
													</td>
													<td><?= $row->doctor_phone; ?></td>
													<td><?= $row->reason; ?></td>
												</tr><?php 
											} 
										} ?>
									</tbody>
								</table>		
							</div>	
						</div>	
					</div>	
				</div> -->
				<!-- /Home visit Tab -->
				
				<!-- Prescription Tab -->
				<div class="tab-pane fade" id="pat_prescriptions">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Date </th>
											<th>Doctor Name</th>									
											<th>Medicine</th>
											<th></th>
										</tr>     
									</thead>
									<tbody>
										<?php foreach($prescriptions as $row) { ?>
										<tr>
											<td><?= date('d-m-Y', strtotime($row->date)); ?></td>
											<td>
												<h2 class="table-avatar">
													<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>" class="avatar avatar-sm mr-2">
														<img class="avatar-img rounded-circle" src="<?= $row->doctor_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $row->doctor_name; ?> Image">
													</a>
													<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>"><?= $row->doctor_name; ?> <span><?= substr($row->doctor_me, 0, 20); ?></span></a>
												</h2>
											</td>
											<td>
												<?php
												if (!empty($row->medicine)) {
													$medicine = explode('###', $row->medicine);

													foreach ($medicine as $key => $value) {
														$medicine_id = explode('***', $value);
														$medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
														if (!empty($medicine_details)) {
															$medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
															$medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
															rtrim($medicine_name_with_dosage, ',');
															echo '<p>' . $medicine_name_with_dosage . '</p>';
														}
													}
												}
												?>
											</td>
											<td class="text-right">
												<div class="table-action">
													<!--<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
														<i class="fas fa-print"></i> Print
													</a>-->
													<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
														<i class="far fa-eye"></i> View
													</a>
												</div>
											</td>
										</tr>
										<?php } ?>
									</tbody>	
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /Prescription Tab -->
					
				<!-- Diagnostic Tests Tab -->
				<div id="pat_diagnostic_tests" class="tab-pane fade">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Date </th>
											<!--<th>Description</th>-->
											<!--<th>Attachment</th>-->
											<th>Created</th>
											<th></th>
										</tr>     
									</thead>
									<tbody>
										<?php foreach ($labs as $row) { ?>
											<tr>
												<td><?= $row->id; ?></td>
												<td><?= date('d-m-Y', $row->date); ?></td>
												<!--<td><?= $row->report; ?></td>-->
												<!--<td><a href="#">Report 1.pdf</a></td>-->
												<td>
													<h2 class="table-avatar">
														<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" src="<?= $row->doctor_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $row->doctor_name; ?> Image">
														</a>
														<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>"><?= $row->doctor_name; ?> <span><?= substr($row->doctor_me, 0, 20); ?></span></a>
													</h2>
												</td>
												<td class="text-right">
													<div class="table-action">
														<a href="patient/report_view?id=<?php echo $row->id; ?>" class="btn btn-sm bg-info-light">
															<i class="far fa-eye"></i> View
														</a>
													</div>
												</td>
											</tr>
										<?php } ?>
									</tbody>  	
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /Diagnostic Tests Tab -->
				
				<!-- Documents Tab 
				<div id="pat_documents" class="tab-pane fade">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="row">
								<?php foreach ($patient_materials as $patient_material) { ?>
									<?php
									$ext = pathinfo($patient_material->url, PATHINFO_EXTENSION);
									$extensionImg = array("jpeg", "jpg", "png", "gif", "pdf" );
									$extensionVideo = array(  "mp4", "wav", "ogg", "avi","webm");
									?>
									<div class="col-lg-4 mb-3">
										<div class="card text-center doctor-book-card">
											<?php if(in_array($ext,$extensionImg)){ ?>
											<a href=<?php echo $patient_material->url; ?>" data-lightbox="example-1">
											<img style="max-height:150px" src="<?php echo $patient_material->url; ?>" alt="image-1" /></a>
											
											<div class="doctor-book-card-content tile-card-content-1">
												<div>
													<h3 class="card-title mb-0"><?= (!empty($patient_material->title)) ? $patient_material->title : '' ?></h3>
													<a href="<?php echo $patient_material->url; ?>" download class="btn book-btn1 px-3 py-2 mt-3" style="top: 30px;position: relative;">
														<?php echo lang('download'); ?>
													</a>
												</div>
											</div>
											<?php } ?>
											<?php if(in_array($ext,$extensionVideo)){ ?>
												<a class="example-image-link" href="<?=base_url($patient_material->url)?>"  data-lightbox="example-1">
													<video controls width="100%">
														<source src="<?=base_url($patient_material->url) ?>" type="video/webm">
														<source src="<?=base_url($patient_material->url) ?>" type="video/mp4">
														Sorry, your browser doesn't support embedded videos.
													</video>
												</a>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<!-- /Documents Tab -->
				
				<!-- Medical History Tab -->
				<div id="pat_medical_history" class="tab-pane fade">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="row" style="padding: 20px;">
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
				</div>
				<!-- /Medical History Tab -->
				
				<!-- Timeline Tab -->
				<div id="part_timeline" class="tab-pane fade">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<tbody>
										<?php 
										if (!empty($timeline)) {
											krsort($timeline);												
											foreach($timeline as $row) { ?>
											<tr>
												<td style="width:100px;text-align: center;"><?= $row['title']; ?><br><i class="<?= $row['icon']; ?>" style="padding: 15px; border-radius: 50%; background: <?= $row['bg']; ?>"></i></td>
												<td><span style="color:<?= $row['bg']; ?>"><?= $row['date']; ?><br>
													<?= $row['dtitle']; ?></span><br>
													<?= $row['details']; ?></td>
												<td style="width:100px;"><?= $row['date']; ?></td>
											</tr>
										<?php }
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /Timeline Tab -->
					
			</div>
			<!-- Tab Content -->
			
		</div>
	</div>
</div>
<!-- / main page content in right side -->