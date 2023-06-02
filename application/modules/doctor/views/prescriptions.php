<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title d-flex justify-content-between">
				<span>Prescription List(s)</span> 
				<!--<a class="edit-link" data-toggle="modal" href="javascript:void(0);" onclick="prescription_form_ajax(0)"><i class="fa fa-plus-circle"></i> Add Prescription</a>-->
				<a class="edit-link" href="doctor/openPrescriptionForm"><i class="fa fa-plus-circle"></i> Add Prescription</a>
			</h4>
			<div class="card card-table mb-0">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-center mb-0">
							<thead>
								<tr>
									<th>Date </th>
									<th>Patient Name</th>									
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
											<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient avatar avatar-sm mr-2">
												<img class="avatar-img rounded-circle" src="<?= $row->patient_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $row->patient_name; ?> Image">
											</a>
											<a href="javascript:void(0);" data-id="<?= $row->patient_ion_user_id; ?>" class="view_patient"><?= $row->patient_name; ?> <span>PID#<?= $row->patient; ?></span></a>
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
											<a href="doctor/viewPrescription?id=<?= $row->id; ?>" class="btn btn-sm bg-info-light">
												<i class="far fa-eye"></i> View
											</a>
											<!--<a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
												<i class="fas fa-print"></i> Print
											</a>
											<a href="javascript:void(0);" class="btn btn-sm bg-warning-light">
												<i class="fas fa-edit"></i> Edit
											</a>-->
											<a href="doctor/delete_prescription?id=<?= $row->id; ?>" class="btn btn-sm bg-danger-light">
												<i class="fas fa-trash"></i> Delete
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
	</div>
</div>
<!-- / main page content in right side -->