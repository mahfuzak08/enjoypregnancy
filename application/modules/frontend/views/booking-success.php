<?php
$settings = $this->frontend_model->getSettings();
?>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
						<!--<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>frontend/pharmacy">Pharmacy</a></li>-->
						<li class="breadcrumb-item active" aria-current="page">Invoice</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Invoice</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content success-page-cont">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<div class="invoice-content">
					<div class="invoice-item">
						<div class="row">
							<div class="col-md-6">
								<div class="invoice-logo">
									<?php
									if (!empty($settings->logo)) {
										echo '<img src=' . $settings->logo . ' alt="logo">';
									} else {
										echo $title[0] . '<span> ' . $title[1] . '</span>';
									}
									?>
								</div>
							</div>
							<div class="col-md-6">
								<p class="invoice-details">
									<strong>Order:</strong> #<?= $invoice[0]['id']; ?> <br>
									<strong>Issued:</strong> <?= explode(" ", $invoice[0]['add_date'])[0]; ?>
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
							<div class="col-md-6">
								<div class="invoice-info">
									<strong class="customer-text">Payment Method</strong>
									<p class="invoice-details invoice-details-two">
										Card No:<br><?= $invoice[0]['last4']; ?><br>
										TrnxID: <?= $invoice[0]['transaction_id']; ?><br>
									</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="invoice-info">
									<strong class="customer-text">Appointment Info</strong>
									<p class="invoice-details invoice-details-two">
										Date: <?= $invoice[0]['date']; ?><br>
										Status: <?= $invoice[0]['status']; ?><br>
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
												<td class="text-center">$0</td>
												<td class="text-right">$<?= $invoice[0]['amount'] > 0 ? $invoice[0]['amount'] : 0; ?></td>
											</tr>
											<tr>
												<td>Chat/ Audio/ Video Call Booking</td>
												<td class="text-center">1</td>
												<td class="text-center">$0</td>
												<td class="text-right">Free</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-6 col-xl-4 ml-auto">
								<div class="table-responsive">
									<table class="invoice-table-two table">
										<tbody>
										<tr>
											<th>Subtotal:</th>
											<td><span>$<?= $invoice[0]['amount'] > 0 ? $invoice[0]['amount'] : 0; ?></span></td>
										</tr>
										<tr>
											<th>Discount:</th>
											<td><span>0%</span></td>
										</tr>
										<tr>
											<th>Total Amount:</th>
											<td><span>$<?= $invoice[0]['amount'] > 0 ? $invoice[0]['amount'] : 0; ?></span></td>
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
			</div>
		</div>
	</div>
</div>		
<?php 
	if($this->session->flashdata('success_order'))
	{
		$this->frontend_model->deleteprescription();
	}
?>
<!-- /Page Content -->
<script type="text/javascript">
	var exdays = 30;
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = 'prod_ids' + "=;" + expires + ";path=/";
    document.cookie = 'presc_ids' + "=;" + expires + ";path=/";
</script>