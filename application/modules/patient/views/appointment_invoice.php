<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="invoice-content" id="print_invoice_content">
		<div class="invoice-item">
			<div class="row">
				<div class="col-md-6">
					<div class="invoice-logo">
						<img src="<?= $settings->logo; ?>" alt="logo">
					</div>
				</div>
				<div class="col-md-6">
					<p class="invoice-details">
						<strong>Order:</strong> #<?= $invoice[0]['id']; ?> <br>
						<strong>Issued:</strong> <?= date("Y-m-d"); ?>
					</p>
				</div>
			</div>
		</div>
		
		<!-- Invoice Item -->
		<div class="invoice-item">
			<div class="row">
				<div class="col-md-6">
					<div class="invoice-info">
						<strong class="customer-text">Invoice From</strong>
						<p class="invoice-details invoice-details-two">
							<?= $invoice[0]['doctor_name']; ?> <br>
							<?= $invoice[0]['doctor_phone']; ?><br>
							<?= $invoice[0]['doctor_email']; ?><br>
							<?= $invoice[0]['doctor_city']; ?>, <?= $invoice[0]['doctor_country']; ?>.<br>
						</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="invoice-info invoice-info2">
						<strong class="customer-text">Invoice To</strong>
						<p class="invoice-details">
							<?= $invoice[0]['patient_name']; ?> <br>
							<?= $invoice[0]['patient_phone']; ?> <br>
							<?= $invoice[0]['patient_address']; ?> <br>
							<strong>Gender: </strong><?=  strtoupper($invoice[0]['patient_gender']); ?> <br>
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- /Invoice Item -->
		
		<!-- Invoice Item -->
		<?php if(! empty($invoice[0]['transaction_id'])){ ?>
		<div class="invoice-item">
			<div class="row">
				<div class="col-md-12">
					<div class="invoice-info">
						<strong class="customer-text">Payment Method</strong>
						<p class="invoice-details invoice-details-two">
							Card <br>
							XXXXXXXXXXXX-<?= $invoice[0]['last4']; ?><br>
							<?= $invoice[0]['transaction_id']; ?><br>
						</p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<!-- /Invoice Item -->
		
		<!-- Invoice Item -->
		<div class="invoice-item invoice-table-wrap">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="invoice-table table table-bordered">
							<thead>
								<tr>
									<th>Description</th>
									<th class="text-center">Quantity</th>
									<th class="text-center">VAT</th>
									<th class="text-right">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>General Consultation</td>
									<td class="text-center">1</td>
									<td class="text-center"><?= $settings->currency; ?> 0</td>
									<td class="text-right"><?= $settings->currency; ?> <?= $invoice[0]['amount'] > 0 ? $invoice[0]['amount'] : 0; ?></td>
								</tr>
								<!--<tr>
									<td>Video Call Booking</td>
									<td class="text-center">1</td>
									<td class="text-center">$0</td>
									<td class="text-right">$250</td>
								</tr>-->
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-4 col-xl-4 ml-auto">
					<div class="table-responsive">
						<table class="invoice-table-two table">
							<tbody>
							<tr>
								<th>Subtotal:</th>
								<td><span><?= $settings->currency; ?> <?= $invoice[0]['amount'] > 0 ? $invoice[0]['amount'] : 0; ?></span></td>
							</tr>
							<tr>
								<th>Discount:</th>
								<td><span>0%</span></td>
							</tr>
							<tr>
								<th>Total Amount:</th>
								<td><span><?= $settings->currency; ?> <?= $invoice[0]['amount'] > 0 ? $invoice[0]['amount'] : 0; ?></span></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /Invoice Item -->
		
		<!-- Invoice Information -->
		<div class="other-info">
			<h4>Other information</h4>
			<p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex. Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum, eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p>
		</div>
		<!-- /Invoice Information -->
		
	</div>
	<div class="row">
		<div class="col-xl-5">
			<a href="#" onclick="history.back(); return false;" class="btn btn-flat btn-block btn-primary">Back</a>
		</div>
		<div class="col-xl-2"><br></div>
		<div class="col-xl-5">
			<a href="javascript:window.print();" class="btn btn-flat btn-block btn-info"><i class="fas fa-print"></i> Print</a>
		</div>
		<br><br>
	</div>
</div>
<!-- / main page content in right side -->