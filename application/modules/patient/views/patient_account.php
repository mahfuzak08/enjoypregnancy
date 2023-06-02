<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body pt-0">
		
			<!-- Tab Menu -->
			<nav class="user-tabs mb-4">
				<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
					<li class="nav-item">
						<a class="nav-link active" href="#pat_card" data-toggle="tab">Card Paymnet</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#pat_cash" data-toggle="tab">Cash Paymnet</a>
					</li>
				</ul>
			</nav>
			<div class="tab-content pt-0">
				<!-- card payment -->
				<div id="pat_card" class="tab-pane fade show active">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Invoice No</th>
											<th>Doctor</th>
											<th>Amount</th>
											<th>Paid On</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($payment_history as $row) { ?>
											<tr>
												<td>
													<a href="<?= base_url("patient/viewInvoice/".$row->order_no); ?>">#INV-<?= $row->id; ?></a>
												</td>
												<td>
													<h2 class="table-avatar">
														<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>" class="avatar avatar-sm mr-2">
															<img class="avatar-img rounded-circle" src="<?= $row->doctor_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $row->doctor_name; ?> Image">
														</a>
														<a href="<?= 'frontend/doctor_profile/'.$row->doctor; ?>"><?= $row->doctor_name; ?></a>
													</h2>
												</td>
												<td>$<?= $row->amount; ?></td>
												<td><?= $row->createdat; ?></td>
												<td class="text-right">
													<div class="table-action">
														<a href="<?= base_url("patient/viewInvoice/".$row->order_no); ?>" class="btn btn-sm bg-info-light">
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
				<!-- /card payment -->
				
				<!-- cash payment -->
				<div id="pat_cash" class="tab-pane fade">
					<div class="card card-table mb-0">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Invoice No</th>
											<th>Doctor</th>
											<th>Amount</th>
											<th>Paid On</th>
											<th></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- / cash payment -->
			</div>
		</div>
	</div>
</div>
<!-- / main page content in right side -->