<?php
$settings = $this->frontend_model->getSettings();
date_default_timezone_set('Asia/Dhaka');
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
				<div class="panel">
                    <div class="panel-heading custom-header-panel">
                        <h4 class="panel-title roboto">Congratulations, your appointment booking is saved successfully. Please select the payment method and complete the payment. Thank you...</h4>
                    </div>
                    <div class="panel-heading custom-header-panel">
                        <br>
                    </div>
                    <div class="panel-body">
                        <div class="row" style="text-align:center">
                            <div class="col-sm-6">
                                <form method="POST" action="<?= site_url('frontend/shurjoPay_payment'); ?>">
                                    <input type="hidden" name="patient_id" value="<?= $invoice[0]['patient']; ?>">
                                    <input type="hidden" name="doctor_id" value="<?= $invoice[0]['doctor']; ?>">
                                    <input type="hidden" name="amount" value="<?= $invoice[0]['amount']; ?>">
                                    <input type="hidden" name="patient_name" value="<?= $invoice[0]['patient_name']; ?>">
                                    <input type="hidden" name="patient_phone" value="<?= $invoice[0]['patient_phone']; ?>">
                                    <input type="hidden" name="patient_email" value="<?= $invoice[0]['patient_email']; ?>">
                                    <input type="hidden" name="patient_address" value="<?= $invoice[0]['patient_address']; ?>">
                                    <input type="hidden" name="doctor_name" value="<?= $invoice[0]['doctor_name']; ?>">
                                    <input type="hidden" name="doctor_phone" value="<?= $invoice[0]['doctor_phone']; ?>">
                                    <input type="hidden" name="doctor_city" value="<?= $invoice[0]['doctor_city']; ?>">
                                    <input type="hidden" name="inv_id" value="<?= $invoice[0]['id']; ?>">
                                    <button type="submit" class="btn btn-outline-success btn-block">
                                        <img src="https://sandbox.shurjopayment.com/assets/payment_icon/shurjopay-logo.png" data-holder-rendered="true" width="250px" height="75px">
                                    </button>
                                </form>
                                <br><br>
                                <a href="#" class="btn btn-outline-success btn-block">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/512px-Stripe_Logo%2C_revised_2016.svg.png?20210114172858" data-holder-rendered="true" width="250px" height="75px">
                                </a>
                            </div>
                            <div class="col-sm-6" style="border: 1px solid #ddd; text-align: left; font-size: 18px;">
                                <h3>Payment Summary</h3>
                                <pre>Doctor Name: <?= $invoice[0]['doctor_name']; ?></pre>
                                <pre>Patient Name: <?= $invoice[0]['patient_name']; ?></pre>
                                <pre>Payment Amount: <?= $invoice[0]['amount']; ?> BDT</pre>
                                <pre>Appointment Date: <?= date_format(date_create($invoice[0]['date']), "d F, Y"); ?></pre>
                                <pre>Payment Date: <?= date_format(date_create($invoice[0]['add_date']), "d F, Y"); ?></pre>
                            </div>
                        </div>
                        <div class="row">
                            <br><br>
                        </div>
                        <!-- <div class="form-group">
                            <div id="amount_error" class="amount_error" style="text-align: center;color: #fd0101;"></div>
                            <label class="col-sm-4 control-label" for="name">Amount <span class="requerido"> *</span></label>
                            <div class="col-sm-8">
                                
                                <input type="text" class="form-control amt" id="name" value="" oninvalid="this.setCustomValidity('Campo requerido')" oninput="setCustomValidity('')" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="customer_name_error" class="customer_name_error" style="text-align: center;color: #fd0101;"></div>
                            <label class="col-sm-4 control-label" for="name">Customer Name <span class="requerido"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control cus_name" id="name" value="" oninvalid="this.setCustomValidity('Campo requerido')" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="customer_phone_error" class="customer_phone_error" style="text-align: center;color: #fd0101;"></div>
                            <label class="col-sm-4 control-label" for="name">Customer Phone No <span class="requerido"> *</span></label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control cus_phone" id="name" value="<?= $invoice[0]['patient_phone']; ?>" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="customer_city_error" class="customer_city_error" style="text-align: center;color: #fd0101;"></div>
                                <label class="col-sm-4 control-label" for="name">Customer City <span class="requerido"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control cus_city" id="name" value="" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="customer_city_error" class="customer_add_error" style="text-align: center;color: #fd0101;"></div>
                            <label class="col-sm-4 control-label" for="name">Customer Address <span class="requerido"> *</span></label>
                            <div class="col-sm-8">
                                <textarea class="form-control cus_address" required=""><?= $invoice[0]['patient_address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="name">Customer Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control email" id="name" value="<?= $invoice[0]['patient_email']; ?>" required="">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div id="customer_city_error" class="curency_add_error" style="text-align: center;color: #fd0101;"></div>
                                
                            <label class="col-sm-4 control-label" for="name">currency <span class="requerido"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control currency" id="name" value="BDT" required="">
                            </div>
                        </div>
                        
                        <div class="form-group text-center">
                            <div type="submit" id="submit_btn" class="btn btn-success sub">PayNow</div>
                            <div id="default" class="btn btn-info default">Default</div>
                        </div> -->
                    </div>
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