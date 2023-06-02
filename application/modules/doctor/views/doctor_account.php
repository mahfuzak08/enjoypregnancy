<style>
.account-card {
    border-radius: 10px;
    margin-bottom: 30px;
    font-size: 16px;
    padding: 10px;
    text-align: center;
}
.account-card span {
    font-size: 24px;
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}
.info-list .title{
	font-weight: 700;
	border-bottom: 1px solid #DDD;
}
.info-list .text{
	min-height: 30px;
}
</style>
<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="row">
		<div class="col-lg-5 d-flex">
			<div class="card flex-fill">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<h3 class="card-title">Account</h3>
						</div>
						<div class="col-sm-6">
							<div class="text-right">
								<a title="Edit Profile" class="btn btn-primary btn-sm" href="#account_modal" data-toggle="modal"><i class="fas fa-pencil"></i> <?= empty($acc_info->account_no) ? 'Add ' : 'Edit '; ?>Details</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="profile-view-bottom">
						<div class="row">
							<div class="col-lg-6">
								<div class="info-list">
									<div class="title">Bank Name</div>
									<div class="text" id="bank_name"><?= $acc_info->bank_name; ?></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="info-list">
									<div class="title">Branch Name</div>
									<div class="text" id="branch_name"><?= $acc_info->branch_name; ?></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="info-list">
									<div class="title">Account Number</div>
									<div class="text" id="account_no"><?= $acc_info->account_no; ?></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="info-list">
									<div class="title">Account Name</div>
									<div class="text" id="account_name"><?= $acc_info->account_name; ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-7 d-flex">
			<div class="card flex-fill">
				<div class="card-body">
					<div class="row">
						<?php $earned = 0; $request = 0; $withdraw = 0;
						foreach($payment_history as $row) {
							if($row->amount > 0){
								$earned += $row->amount;
							}
							else{
								if($row->status == 0) 
									$request += -($row->amount);
								else
									$withdraw += -($row->amount);
							}
						}
						?>
						<div class="col-6">
							<div class="account-card bg-success-light">
								<span><?= $doctor_data->symbol; ?><?= number_format($earned, 2, '.', ','); ?></span> Earned
							</div>
						</div>
						<div class="col-6">
							<div class="account-card bg-warning-light">
								<span><?= $doctor_data->symbol; ?><?= number_format($request, 2, '.', ','); ?></span> Requested
							</div>
						</div>
						<div class="col-6">
							<div class="account-card bg-warning-light">
								<span><?= $doctor_data->symbol; ?><?= number_format($withdraw, 2, '.', ','); ?></span> Withdraw
							</div>
						</div>
						<div class="col-6">
							<div class="account-card bg-purple-light">
								<span><?= $doctor_data->symbol; ?><?= number_format($balance, 2, '.', ','); ?></span> Balance
							</div>

						</div>
						<div class="col-md-12 text-center">
							<a href="#payment_request_modal" class="btn btn-primary request_btn" data-toggle="modal">Payment Request</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
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
													<th>Date</th>
													<th>Discription</th>
													<th>Dr.</th>
													<th>Cr.</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($payment_history as $row) { ?>
													<tr>
														<td><?php $d = explode(' ', $row->createdat); echo $d[0]."<br>".$d[1]; ?></td>
														<td>
															<?php if($row->method == 'bank_transfer'){ ?>
																Payment request for withdraw<br>from the hospital.
															<?php } else { ?>
																Payment received from patient<br>as consultation fee.
															<?php } ?>
														</td>
														<td><?= $row->amount < 0 ? number_format(-$row->amount, 2, '.', ',') : "-"; ?></td>
														<td><?= $row->amount > 0 ? number_format($row->amount, 2, '.', ',') : "-"; ?></td>
														<td class="text-right">
															<div class="table-action">
																<?php if($row->status == 1){?>
																<span class="badge badge-pill bg-success-light">Payment Confirm</span>
																<?php } else { ?>
																<span class="badge badge-pill bg-warning-light">Request Pending</span>
																<?php } ?>
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
	</div>
</div>
<!-- / main page content in right side -->