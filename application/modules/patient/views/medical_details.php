<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title float-left">Medical details</h4>
					<a href="#modal_medical_form" class="btn btn-primary float-right" data-toggle="modal">Add Details</a>
				</div>
				<div class="card-body">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Vaccine</th>
											<th class="text-center">Heart Rate</th>
											<th class="text-center">Respiratory Rate</th>
											<th class="text-center">Blood Pressure</th>
											<th class="text-center">Temperature</th>
											<th class="text-center">Glucose Level</th>
											<th>BMI</th>
											<th>Weight</th>
											<th>Date</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($patientMedicalHistory as $row) { ?>
											<tr>
												<td><?= $row->id; ?></td>
												<td><?= $row->name; ?></td>
												<td><?= $row->vaccine; ?></td>
												<td class="text-center"><?= $row->heart_rate; ?></td>
												<td class="text-center"><?= $row->res_rate; ?></td>
												<td class="text-center"><?= $row->blood_pressure; ?></td>
												<td class="text-center"><?= $row->temperature; ?></td>
												<td class="text-center"><?= $row->fbc; ?></td>
												<td><?= $row->bmi; ?></td>
												<td><?= $row->weight; ?>Kg</td>
												<td><?= $row->date; ?></td>
												<td>
													<div class="table-action">
														<!--<a href="#edit_medical_form" class="btn btn-sm bg-info-light" data-toggle="modal">
															<i class="fas fa-edit"></i> Edit
														</a>-->
														<a href="patient/medical_details?delete=<?= $row->id; ?>" class="btn btn-sm bg-danger-light">
															<i class="fas fa-trash-alt"></i> Delete
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
	</div>
</div>
<!-- / main page content in right side -->