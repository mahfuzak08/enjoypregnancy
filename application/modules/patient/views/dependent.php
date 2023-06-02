<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-6">
					<h3 class="card-title">Dependent</h3>
				</div>
				<div class="col-sm-6">
					<div class="text-right">
						<a href="#modal_form" data-toggle="modal" class="btn btn-primary btn-sm add_dependent" tabindex="0">Add Dependent</a>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body ">

			<!-- Dependent Tab -->
			<div class="card card-table mb-0">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-center mb-0">
							<thead>
								<tr>
									<th>Dependent</th>
									<th>Relationship</th>
									<th>Gender</th>
									<th>Number</th>
									<th>Blood Group</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($dependents as $row) { ?>
								<tr>
									<td>
										<h2 class="table-avatar">
											<span class="avatar avatar-sm mr-2">
												<img class="avatar-img rounded-circle" src="<?= $row->dep_img; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
											</span>
											<?= $row->dep_name; ?>
										</h2>
									</td>
									<td><?= $row->relation; ?></td>
									<td><?= $row->dep_gender; ?></td>
									<td><?= $row->dep_number; ?></td>
									<td><?= $row->dep_blood_group; ?></td>
									<td>
										<div class="table-action">
											<a href="patient/dependent?edit_dep=<?= $row->id; ?>" class="btn btn-sm bg-info-light">	<i class="fas fa-edit"></i> Edit</a>
											<a href="patient/dependent?delete_dep=<?= $row->id; ?>" class="btn btn-sm bg-danger-light"><i class="fas fa-times"></i> Delete</a>
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /Dependent Tab -->

		</div>
	</div>
</div>
<!-- / main page content in right side -->