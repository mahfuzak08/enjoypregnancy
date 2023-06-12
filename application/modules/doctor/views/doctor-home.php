<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<!-- patient top info and graph status -->
	<?php $this->load->view("partial/_doctor_top_info"); ?>
	<!-- / patient top info and graph status -->
	<div class="row">
		<div class="col-md-12">
			<h4 class="mb-4">Patient Appoinment</h4>
			<div class="appointment-tab">
			
				<!-- Appointment Tab -->
				<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
					<!-- <li class="nav-item">
						<a class="nav-link" href="#calendar-tab" data-toggle="tab">Calendar</a>
					</li>  -->
					<li class="nav-item">
						<a class="nav-link active" href="#all-appointments" data-toggle="tab">All Appointment</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#today-appointments" data-toggle="tab">Today</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#home-appointments" data-toggle="tab">Home Visit</a>
					</li>
				</ul>
				<!-- /Appointment Tab -->
				
				<div class="tab-content">
					<!-- Calendar Tab -->
					<!-- <div class="tab-pane show active" id="calendar-tab">
						<div class="card card-table mb-0">
							<div class="card-body">
								<div id="calendar"></div>
							</div>	
						</div>	
					</div> -->
					<!-- /Calendar Tab -->
					
					<!-- All Appointment Appointment Tab -->
					<div class="tab-pane show active" id="all-appointments">
						<div class="card card-table mb-0">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>Patient Name</th>
												<th>Appt Date</th>
												<th>Purpose</th>
												<th class="text-center">Paid Amount</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(count($appointments) > 0){
												foreach($appointments as $row){ ?>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= $row->patient_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image"></a>
																<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient"><?= $row->patient_name; ?> <span>#PT<?= $row->patient_ion_user_id; ?></span></a>
															</h2>
														</td>
														<td><?= $row->date; ?> <span class="d-block text-info"><?= $row->s_time; ?></span></td>
														<td><?= $row->reason; ?></td>
														<td class="text-center"><?= $settings->currency; ?> <?= $row->amount ? $row->amount : ''; ?></td>
														<td class="text-right">
															<div class="table-action">
																<!--<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																	<i class="far fa-eye"></i> View
																</a>-->
																<a class="btn btn-sm bg-danger-light mediaBtn" href="<?php echo base_url('meeting/startinzoom?p='.md5($row->patient_ion_user_id).'&a='.$row->id.'&d='.md5($doctor_data->ion_user_id)); ?>" data-message="Are you sure you want to start a live video meeting with this doctor?">
																	<i class="fa fa-headphones"></i>
																</a>
																<?php $openchatid = base_convert($row->patient_ion_user_id, 10, 16)."-".base_convert($doctor_data->ion_user_id, 10, 16); ?>
																<a href="chat/open/<?= $openchatid; ?>" class="btn btn-sm bg-info-light" title="Chat">
																	<i class="fas fa-comments"></i>
																</a>
																<a href="doctor/openPrescriptionForm" class="btn btn-sm bg-danger-light" title="Add Prescription">
																	<i class="fa fa-prescription"></i>
																</a>
																<a href="<?= base_url("doctor/viewInvoice/".$row->id); ?>" class="btn btn-sm bg-info-light" title="View Invoice">
																	<i class="far fa-eye"></i>
																</a>
															</div>
														</td>
													</tr><?php 
												} 
											} ?>
										</tbody>
									</table>		
								</div>
							</div>
						</div>
					</div>
					<!-- /All Appointment Appointment Tab -->
			   
					<!-- Today Appointment Tab -->
					<div class="tab-pane" id="today-appointments">
						<div class="card card-table mb-0">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>Patient Name</th>
												<th>Appt Date</th>
												<th>Purpose</th>
												<th class="text-center">Paid Amount</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(count($appointments) > 0){
												$today = strtotime(date('d-m-Y'));
												foreach($appointments as $row){ 
													if($today == date('d-m-Y', $row->date)){ ?>
													<tr>
														<td>
															<h2 class="table-avatar">
																<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= $row->patient_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image"></a>
																<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient"><?= $row->patient_name; ?> <span>#PT<?= $row->patient_ion_user_id; ?></span></a>
															</h2>
														</td>
														<td><?= date('d-m-Y', $row->date); ?> <span class="d-block text-info"><?= $row->s_time; ?></span></td>
														<td><?= $row->reason; ?></td>
														<td class="text-center"><?= $settings->currency; ?> <?= $row->amount ? $row->amount : ''; ?></td>
														<td class="text-right">
															<div class="table-action">
																<!--<a href="javascript:void(0);" class="btn btn-sm bg-info-light">
																	<i class="far fa-eye"></i> View
																</a>-->
																<a class="btn btn-sm bg-danger-light mediaBtn" href="javascript:void(0);" data-message="Are you sure you want to start a live video meeting with this doctor?" data-ref="<?php echo base_url('meeting/liveChatApp?roomId='.$row->patient.'-'.$row->doctor.'&amp;type=1&amp;m=2'); ?>" title="<?= lang('live'); ?>">
																	<i class="fa fa-headphones"></i>
																</a>
																<?php $openchatid = base_convert($row->patient_ion_user_id, 10, 16)."-".base_convert($doctor_data->ion_user_id, 10, 16); ?>
																<a href="chat/open/<?= $openchatid; ?>" class="btn btn-sm bg-info-light" title="Chat">
																	<i class="fas fa-comments"></i>
																</a>
																<a href="doctor/openPrescriptionForm" class="btn btn-sm bg-danger-light" title="Add Prescription">
																	<i class="fa fa-prescription"></i>
																</a>
																<a href="<?= base_url("doctor/viewInvoice/".$row->id); ?>" class="btn btn-sm bg-info-light" title="View Invoice">
																	<i class="far fa-eye"></i>
																</a>
															</div>
														</td>
													</tr><?php 
													}
												} 
											} ?>
										</tbody>
									</table>		
								</div>	
							</div>	
						</div>	
					</div>
					<!-- /Today Appointment Tab -->
					
					<!-- Home visit Tab -->
					<div class="tab-pane" id="home-appointments">
						<div class="card card-table mb-0">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>Visit Date</th>
												<th>Patient Name</th>
												<th>Purpose</th>
												<th class="text-center">Address</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											// print_r($home_appointment_requests);
											if(count($home_appointment_requests) > 0){
												foreach($home_appointment_requests as $row){ ?>
													<tr>
														<td><?= date('d-m-Y', strtotime($row->date)); ?> <span class="d-block text-info"><?= $row->preffered_time; ?></span></td>
														<td>
															<h2 class="table-avatar">
																<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="<?= $row->patient_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image"></a>
																<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient"><?= $row->patient_name; ?> <span>#PT<?= $row->patient_ion_user_id; ?></span></a>
															</h2>
														</td>
														<td><?= $row->reason; ?></td>
														<td class="text-center"><?= $row->home_address .'<br>'. $row->address; ?></td>
													</tr><?php 
												} 
											} ?>
										</tbody>
									</table>		
								</div>	
							</div>	
						</div>	
					</div>
					<!-- /Home visit Tab -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / main page content in right side -->