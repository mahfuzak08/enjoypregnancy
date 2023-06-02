<div class="row form-row">
	<div class="col-12 col-md-3 left-info">
		<div class="row form-row">
			<div class="col-4 col-md-12" style="float:left">
				<img src="<?= $patient_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" alt="Patient Image" style="max-width: 100%; height: auto; max-height: 250px;">
			</div>
			<div class="col-8 col-md-12" style="float:right">
				<h3 class="patient_name"><?= $patient_data->name; ?></h3>
				<label class="patient_phone"><a href="tel:<?= $patient_data->phone; ?>" target="_blank"><?= $patient_data->phone; ?></a></label>
				<label class="patient_email"><a href="mailto:<?= $patient_data->email; ?>" target="_blank" ><?= $patient_data->email; ?></label><br>
				<a class="btn btn-info" onclick="connectCall(this, '<?= $patient_data->phone; ?>')" title="Call" href="javascript:void(0);"><i class="fa fa-phone"></i></a>
				<a class="btn btn-secondary" onclick="showSendSmsModal(this,'<?= $patient_data->phone; ?>')" title="SMS" href="javascript:void(0);"><i class="fa fa-sms"></i></a>
				<a class="btn btn-primary" onclick="showSendEmailModal(this,'<?= $patient_data->email; ?>')" title="Email" href="javascript:void(0);"><i class="fa fa-envelope"></i></a>
				<br>
			</div>
		</div>
		<div class="row form-row">
			<div class="col-12">
				<p>Patient ID: <span class="pid"><?= $patient_data->id; ?></span></p>
				<p>Gender: <span class="psex"><?= $patient_data->sex; ?></span></p>
				<p>Date of Birth: <span class="pdob"><?= $patient_data->birthdate; ?></span></p>
				<p>Age: <span class="pdob"><?= floor(abs(strtotime(date("Y-m-d")) - strtotime($patient_data->birthdate)) / (365*60*60*24)); ?> years</span></p>
				<p>Blood Group: <span class="pbg"><?= $patient_data->bloodgroup; ?></span></p>
				<p>Address: <span class="paddress"><?= $patient_data->address; ?></span></p>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-9">
		<div class="card-body">
			<ul class="nav nav-tabs nav-tabs-top">
				<li class="nav-item"><a class="nav-link active" href="#appointment-tab1" data-toggle="tab">Appointment</a></li>
				<li class="nav-item"><a class="nav-link" href="#prescription-tab2" data-toggle="tab">Prescription</a></li>
				<li class="nav-item"><a class="nav-link" href="#medical-notes-tab3" data-toggle="tab">Medical Notes</a></li>
				<li class="nav-item"><a class="nav-link" href="#patient-symptoms-tab4" data-toggle="tab">Patient Symptoms</a></li>
				<li class="nav-item"><a class="nav-link" href="#lab-tab5" data-toggle="tab">Lab</a></li>
				<li class="nav-item"><a class="nav-link" href="#documents-tab6" data-toggle="tab">Documents</a></li>
				<li class="nav-item"><a class="nav-link" href="#medical-history-tab7" data-toggle="tab">Medical History</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="appointment-tab1">
					<div class="card card-table mb-0">
						<div class="card-body">
							<a class="btn btn-sm bg-info-light" id="addAppointment" style="margin: 5px 0px 0px 5px;"><i class="fa fa-plus"></i> Add New</a> 
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Doctor</th>
											<th>Appt Date Time</th>
											<th>Reason</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($appointments as $row){ 
											if($row->doctor == $doctor_data->id){ 
												if($row->status == 'Confirmed') $badge_color = 'success'; 
												elseif($row->status == 'Requested') $badge_color = 'warning'; 
												else $badge_color = 'danger'; ?>
											<tr>
												<td>
													<h2 class="table-avatar">
														<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" src="<?= $row->doctor_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $row->doctor_name; ?> Image">
														</a>
														<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>"><?= $row->doctor_name; ?> <span><?= substr($row->doctor_me, 0, 20); ?></span></a>
													</h2>
												</td>
												<td><?= date('d-m-Y', $row->date); ?> <span class="d-block text-info"><?= $row->time_slot; ?></span></td>
												<!--<td><?= date('d-m-Y', $row->registration_time); ?></td>-->
												<td><?= $row->remarks; ?></td>
												<td><span class="badge badge-pill bg-<?= $badge_color; ?>-light"><?= $row->status; ?></span></td>
												<td class="text-right">
													<div class="table-action">
														<?php if($row->status == 'Confirmed') {
															$sdslot = date('d-m-Y', $row->date) . ' ' . explode(' To ',$row->time_slot)[0];
															$edslot = date('d-m-Y', $row->date) . ' ' . explode(' To ',$row->time_slot)[1];
															if( (strtotime($sdslot)-900) < time() && (strtotime($edslot)+900) > time() ){ ?>
																<a class="btn btn-sm bg-danger-light mediaBtn" href="javascript:void(0);" data-message="Are you sure you want to start a live video meeting with this doctor?" data-ref="<?php echo base_url('meeting/liveChatApp?roomId='.$row->patient.'-'.$row->doctor.'&amp;type=1&amp;m=2'); ?>" title="<?= lang('live'); ?>">
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
															<a class="btn btn-sm bg-info-light"><i class="fa fa-star"></i> </a> 
														<?php } else { ?>
															<a class="btn btn-sm bg-warning-light"><i class="fa fa-star"></i></a> 
														<?php } ?>
													</div>
												</td>
											</tr>
											<?php } ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="prescription-tab2">
					<div class="card card-table mb-0">
						<div class="card-body">
							<a href="javascript:void(0);" onclick="popup_open('prescription-tab2', 'add')" class="btn btn-sm bg-info-light" style="margin: 5px 0px 0px 5px;"><i class="fa fa-plus"></i> Add New</a> 
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
													<a href="javascript:void(0);" onclick="popup_open('prescription-tab2', 'view', <?= $row->id; ?>)" class="btn btn-sm bg-info-light">
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
				<div class="tab-pane" id="medical-notes-tab3">
					<div class="card card-table mb-0">
						<div class="card-body">
							<a class="btn btn-sm bg-info-light" id="AddBodycharteditor" style="margin: 5px 0px 0px 5px;"><i class="fa fa-plus"></i> Add New</a> 
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Date </th>
											<th>Description</th>
											<th></th>
										</tr>     
									</thead>
									<tbody>
										<?php foreach ($treatment_notes as $row) { ?>
											<tr>
												<td><?= $row->id; ?></td>
												<td><?= date('d-m-Y', $row->add_date); ?></td>
												<td><?= $row->presenting_complaint; ?></td>
												<td class="text-right">
													<div class="table-action">
														<a href="javascript:void(0);" onclick="popup_open('medical-notes-tab3', 'view', <?= $row->id; ?>)" class="btn btn-sm bg-info-light">
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
				<div class="tab-pane" id="patient-symptoms-tab4">
					<div class="card card-table mb-0">
						<div class="card-body">
							<a class="btn btn-sm bg-info-light" id="documentRequest" style="margin: 5px 0px 0px 5px;"><i class="fa fa-plus"></i>  Add Patient Form</a> 
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Name</th>
											<th>Created Date</th>
											<th>Completed</th>
											<th>Submitted</th>
											<th></th>
										</tr>     
									</thead>
									<tbody>
										<?php foreach ($symptoms as $row) { $t = explode(" - ", $row->template); $tt = count($t) > 1 ? $t[0].'<br>'.$t[1] : $row->template; ?>
											<tr>
												<td><a href="<?= base_url('pf/?token='.$row->token); ?>" target="_blank"><?= $tt; ?></a></td>
												<td><?= date('d-m-Y', $row->created_at); ?></td>
												<td><?= $row->completed; ?></td>
												<td><?= !empty($row->submited_date)? date('d-m-Y', $row->submited_date):''; ?></td>
												<td class="text-right">
													<div class="table-action">
														<?php if($row->completed == 'No'){ ?>
														<a href="javascript:void(0);" class="btn btn-sm bg-warning-light copyBtn" title="Copy" data-action="<?= base_url('pf/?token='.$row->token); ?>"><i class="fa fa-clone"></i></a> 
														<?php } else { ?>
														<a href="javascript:void(0);" class="btn btn-sm bg-success-light ansBtn" title="Answer" data-token="<?= $row->token; ?>"><i class="fa fa-check"></i></a>
														<?php } ?>
														<a href="javascript:void(0);" class="btn btn-sm bg-primary-light SendSmsBtn" title="Send SMS" data-phone="<?= $row->phone; ?>" data-msg="Mr <?= $row->patient_name; ?>, can you please complete the form? Link: <?= base_url('pf/?token='.$row->token); ?>"><i class="fa fa-sms"></i></a>
														<a href="javascript:void(0);" class="btn btn-sm bg-info-light SendEmailBtn" title="Send Email" data-email="<?= $row->email; ?>" data-msg="Mr <?= $row->patient_name; ?>, can you please complete the form? Link: <?= base_url('pf/?token='.$row->token); ?>"><i class="fa fa-envelope"></i></a>
														<a href="javascript:void(0);" class="btn btn-sm bg-danger-light delbtn" title="Delete" data-ref="<?= $row->id; ?>" data-msg="Are you sure you want to delete this item?"><i class="fa fa-trash"></i> </a>
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
				<div class="tab-pane" id="lab-tab5">
					<div class="card card-table mb-0">
						<div class="card-body">
							<a class="btn btn-sm bg-info-light addLab" style="margin: 5px 0px 0px 5px;"><i class="fa fa-plus"></i> Add New</a> 
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
														<a href="javascript:void(0);" onclick="viewReportbtn(<?php echo $row->id; ?>)" class="btn btn-sm bg-info-light">
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
				<div class="tab-pane" id="documents-tab6">
					<div class="card card-table mb-0">
						<div class="card-body">
							<a class="btn btn-sm bg-info-light" id="addnewmaterial" style="margin: 5px 0px 0px 5px;"><i class="fa fa-plus"></i> Add New</a> 
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>ID</th>
											<th>Date</th>
											<th>Title</th>
											<th>Patient Name</th>
											<th>Symptoms</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($patient_materials as $row) { if($row->privacy == 'Private') continue; ?>
										<tr>
											<td><?= $row->id; ?></td>
											<td><?= date("d-m-Y", $row->date); ?></td>
											<td><a target="_blank" href="<?= $row->url; ?>"><?= $row->title != '' ? $row->title : 'No Title'; ?></a></td>
											<td><?= $row->patient_name; ?></td>
											<td><?= $row->symptoms; ?></td>
											<td>
												<?php
												$ext = pathinfo($row->url, PATHINFO_EXTENSION);
												$extensionImg = array("jpeg", "jpg", "png", "gif", "pdf" );
												$extensionVideo = array(  "mp4", "wav", "ogg", "avi","webm");
												?>
												<?php if(in_array($ext,$extensionImg)){ ?>
												<a href="<?php echo $row->url; ?>" target="_blank"><img style="height:60px; width:100px;" src="<?php echo $row->url; ?>" alt="image-1" /></a>
												<?php } ?>
												<?php if(in_array($ext,$extensionVideo)){ ?>
													<a class="example-image-link" href="<?=base_url($row->url)?>" target="_blank">
														<video width="100px" height="60px">
															<source src="<?=base_url($row->url) ?>" type="video/webm">
															<source src="<?=base_url($row->url) ?>" type="video/mp4">
															Sorry, your browser doesn't support embedded videos.
														</video>
													</a>
												<?php } ?>									
											</td>
											<td><a href="<?php echo $row->url; ?>" target="_blank" class="btn btn-sm bg-info-light">
													<i class="fas fa-eye"></i> View
												</a>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="medical-history-tab7">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="row" style="padding: 20px;">
								<?php $mh = explode(",", $patient_data->medicale_history); ?>
								<?php foreach($medicalHistoryLists as $row){ ?>
									<?php if(in_array($row->title, $mh)) { ?>
										<div class="col-12">
											<label><i class="far fa-star"></i> <?= $row->title; ?></label>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var selectedTab = "";
$('.closeajaxModal').click(function(){
	$(selectedTab).trigger('click')
	$('.patient_details_modal').modal('show');
})
$("#addAppointment").click(function () {
	switch_popup();
	var id = '<?= @$doctor_data->id; ?>';
	var pid = '<?= @$patient_data->id; ?>';
	$('#ajaxModal').data('id', id).modal('show');
	$('#ajaxModalLabel').html('Add Appointment');
	$.ajax({
		url: "<?=base_url('patient/edit_appointment')?>",
		dataType: "html",
		type: 'POST',
		data: { 'id': id, 'pid': pid},
		success: function (responce) {
			$('#ajaxModalContent').html(responce);
		}
	})
});

$("#medical-notes-tab3 #AddBodycharteditor").click(function () {
	switch_popup();
	selectedTab = '#medical-notes-tab3';
	var id = '';
	var pid = '<?=$patient_data->id?>';

	$('#ajaxModal').data('id', id).modal('show');
	$('#ajaxModalLabel').html('Add Medical Note');
	
	$.ajax({
		url: "<?=base_url('patient/add_medical_notes')?>",
		dataType: "html",
		type: 'POST',
		data: { 'id': id, 'pid': pid},
		success: function (responce) {
			$('#ajaxModalContent').html(responce);
		}
	})
});

$("#patient-symptoms-tab4 #documentRequest").click(function () {
	switch_popup();
	selectedTab = '#patient-symptoms-tab4';
	var id = '';
	var pid = '<?=$patient_data->id?>';

	$('#ajaxModal').data('id', id).modal('show');
	$('#ajaxModalLabel').html('Add New form for <?= $patient_data->name?>');

	$('#cmodal').modal('hide');
	$.ajax({
		url: "<?=base_url('patient/patient_form')?>",
		dataType: "html",
		type: 'GET',
		data: { 'id': id, 'pid': pid,'type':'document'},
		success: function (responce) {
			$('#ajaxModalContent').html(responce);
		}
	})
});

$("#lab-tab5 .addLab").click(function (event) {
	event.stopImmediatePropagation();
	popup('<?=base_url()?>lab/addLabView?type=1', 'Add Lab', (screen.width*80)/100 , screen.height);
});

function viewReportbtn(id) {
	popup('<?=base_url()?>lab/invoice?type=1&id='+id, 'Report', (screen.width*80)/100 , screen.height);
}

$("#documents-tab6 #addnewmaterial").click(function () {
	switch_popup();
	selectedTab = '#documents-tab6';
	var id = '';
	var pid = '<?=$patient_data->id?>';

	$('#ajaxModal').data('id', id).modal('show');
	$('#ajaxModalLabel').html('Add New form for <?=$patient->name?>')

	$('#cmodal').modal('hide');
	$.ajax({
		url: "<?=base_url('patient/add_document')?>",
		dataType: "html",
		type: 'POST',
		data: { 'id': id, 'pid': pid},
		success: function (responce) {
			$('#ajaxModalContent').html(responce);
		}
	});
});

$(document).on("click", ".BtnBodyChart", function (e) {
	var iid = $(this).attr('data-id');

	$('#TemplateModal').modal('show');
	$('#ajaxModal').modal('hide');
})


$(document).on("click", ".thumbnails", function (e) {
	var img = $(this).data('img');
	var template_id = $(this).data('template_id');
	popup('<?=base_url()?>prescription/bodycharteditor?template_id='+template_id, '',  (screen.width*95)/100, screen.height);
	$('#TemplateModal').modal('hide');
	$('#ajaxModal').modal('show');
});



$(document).on("click", ".crossBtn", function () {
	$('#bodychartModal').modal('hide');
	$('#ajaxModal').modal('show');
});

$(document).ready(function (){
	registerPhone();
});

function popup_open(tab, type, id=0){
	if(tab == 'prescription-tab2' && type == 'add')
		popup('<?=base_url()?>prescription/addPrescriptionView?type=1', '', (screen.width*80)/100, screen.height);
	else if(tab == 'prescription-tab2' && type == 'view' && id>0)
		popup('<?=base_url()?>prescription/viewPrescription?type=1&id='+id, '', (screen.width*80)/100, screen.height);
	else if(tab == 'medical-notes-tab3' && type == 'view' && id>0)
		popup('<?=base_url()?>prescription/bodychartview?id='+id, '', (screen.width*80)/100, screen.height);
}
function popup(url, title, width, height) {
	var left = (screen.width / 2) - (width / 2);
	var top =  (screen.height / 2) - (height / 2);
	var options = '';
	options += ',width=' + width;
	options += ',height=' + height;
	options += ',top=' + top;
	options += ',left=' + left;
	return window.open(url, title, options);
}

function setData(data) {
	console.log(454, 'setdata')
	// var strData = JSON.stringify(data);
	//  document.getElementById('retrievedData').innerHTML = strData;
	// alert(data)
	// var img = '<img src="'+data+'" class="img img-thumbnail" width="150">'
	// img += '<input type="hidden" name="template[]" value="'+data+'">'
	$('#bodyloader').append(data);

	//  alert(img)
}
</script>