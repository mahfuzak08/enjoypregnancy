<?php 
if ($this->ion_auth->in_group(array('Patient')))
{ 
	$patient_ion_id = $this->ion_auth->get_user_id();
	$patient_data = $this->frontend_model->getpatiendatabyId($patient_ion_id);}

?>
<style type="text/css">
	.consult_ul
	{
		display: none;
		background: #fff;
		border: 1px solid lightgray;
		padding: 0px;
		border-radius: 5px;
		position: absolute;
		left: 15px;
		right: 15px;
		z-index: 9999;
	}
	.consult_ul li
	{
		list-style-type: none;
		padding: 10px 10px;
		border-bottom: 1px solid lightgray;
		cursor: pointer;
	}
	.consult_ul li:hover
	{
		color: #09dca4;
	}
	.consult_ul li:nth-last-child(1)
	{
		border-bottom: none;
	}
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar contact-card-header">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
						<li class="breadcrumb-item" aria-current="page"><a href="frontend/consult_urgent_docotrs">Docotrs List</a></li>
						<li class="breadcrumb-item active" aria-current="page">Urgent Consultation</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Book your appointment for Urgent Consultation</h2>
				<p class="mb-0" style="color: #fff;">Once your booking is complete a member of the team will be in touch with you.</p>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container">

		<div class="row">
			<div class="col-md-7 col-lg-8">
				<div class="card">
					<div class="card-body">
					
						<!-- Checkout Form -->
						<form action="frontend/bookconsultnow" method="post" enctype="multipart/form-data">
						
							<!-- Personal Information -->
							<div class="info-widget">
								<h4 class="card-title">Personal Information</h4>
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label consult_div">
											<label>Consultation Type</label>
											<input class="form-control" type="text" name="consult_type" id="consult_type" required>
											<ul class="consult_ul">
												<li onclick="addvalueType('Audio')"> Audio </li>
												<li onclick="addvalueType('Video')"> Video </li>
												<li onclick="addvalueType('Chat')"> Chat </li>
											</ul>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Full Name</label>
											<input class="form-control" type="text" name="full_name" value="<?php echo $patient_data->name ?>" required>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Email</label>
											<input class="form-control" type="email" name="email" value="<?php echo $patient_data->email ?>" required>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
									<?php
								       $ip = $_SERVER['REMOTE_ADDR'];
								       $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));  

								      foreach($country_codes as $country_code_val)
								      {
								         if($dataArray->geoplugin_countryName==$country_code_val->nicename)
								         { 
								        	$phonecode = $country_code_val->phonecode; 
								         } 
								      } 

								    ?>
										<div class="form-group card-label">
											<label>Phone</label>
											<input class="form-control" type="text" <?php if(isset($patient_data->email)){ ?>value="<?php echo $patient_data->phone ?>"<?php }else{ ?> value="+<?php echo $phonecode; ?> "  <?php } ?> name="phone" required>
										</div>
									</div>
									<?php if(!empty($patient_data)){ ?>
										<div class="booking-some-else col-md-12 col-sm-12">
											<div class="custom-checkbox">
											   <input type="checkbox" id="booking_some_else" value="<?php if(empty($patient_data)){ echo 2; }else{ echo 0; } ?>">
											   <label for="booking_some_else"> Booking on behalf of someone else </label>
											</div>
										</div>
									<?php } ?>
									<div class="col-md-12 col-sm-12 some_else_booking" style="display: none;">
									  <div class="row">
										<div class="col-md-6 col-sm-12">
											<div class="form-group card-label">
												<label>Full Name</label>
												<input class="form-control" type="text" name="someone_full_name" value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group card-label">
												<label>Email</label>
												<input class="form-control" type="email" name="someone_email" value="">
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group card-label">
											<label>Phone</label>
											<input class="form-control" type="text" value="+<?php echo $phonecode; ?> " name="someone_phone">
											</div>
										</div>
									  </div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Date Of Birth</label>
											<input class="form-control datetimepicker" type="text" name="date_of_birth" id="date_of_birth" value="<?php if(isset($patient_data->birthdate)){echo date('d/m/Y',strtotime($patient_data->birthdate)); } ?>">
										</div>
									</div>									
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Consultation Date</label>
											<input class="form-control datetimepicker" type="text" name="date" id="consult_date_input">
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Any Allergy History</label>
											<textarea class="form-control" name="allergy_history"></textarea>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Reason For Booking</label>
											<textarea class="form-control" name="reason"></textarea>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Address</label>
											<textarea class="form-control" name="address"></textarea>
										</div>
									</div>
								</div>
								<?php if(empty($patient_data)){ ?>
									<div class="exist-customer">Existing Customer? <a href="auth/login">Click here to login</a></div>
								<?php } ?>
							</div>
							<!-- /Personal Information -->
							
							<div class="payment-widget">
								<h4 class="card-title">Payment Method</h4>
								
								<!-- Credit Card Payment -->
								<div class="payment-list">
									<label class="payment-radio credit-card-option">
										<input type="radio" name="radio" value="by_card">
										<span class="checkmark"></span>
										Credit card
									</label>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group card-label">
												<label for="card_name">Name on Card</label>
												<input class="form-control" id="card_name" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group card-label">
												<label for="card_number">Card Number</label>
												<input class="form-control" id="card_number" placeholder="1234  5678  9876  5432" type="text">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group card-label">
												<label for="expiry_month">Expiry Month</label>
												<input class="form-control" id="expiry_month" placeholder="MM" type="text">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group card-label">
												<label for="expiry_year">Expiry Year</label>
												<input class="form-control" id="expiry_year" placeholder="YY" type="text">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group card-label">
												<label for="cvv">CVV</label>
												<input class="form-control" id="cvv" type="text">
											</div>
										</div>
									</div>
								</div>
								<!-- /Credit Card Payment -->
								
								<!-- Paypal Payment -->
								<div class="payment-list">
									<label class="payment-radio paypal-option">
										<input type="radio" name="radio" checked value="by_hand">
										<span class="checkmark"></span>
										Pay by Cash
									</label>
								</div>
								<!-- /Paypal Payment -->
								
								<!-- Terms Accept -->
								<div class="terms-accept">
									<div class="custom-checkbox">
									   <input type="checkbox" id="terms_accept" required>
									   <label for="terms_accept">I have read and accept <a href="terms-and-consitions" target="_blank">Terms &amp; Conditions</a></label>
									</div>
								</div>
								<!-- /Terms Accept -->
								
								<!-- Submit Section -->
								<div class="submit-section mt-4">
									<input type="hidden" name="pateint_id" value="<?php if(empty($patient_data->id)){ echo 0; }else{ echo $patient_data->id; } ?>">
									<input type="hidden" name="doct_id" value="<?php echo $doctor_id; ?>">
									<input type="hidden" name="appointment_for" id="appointment_for" value="<?php if(empty($patient_data)){ echo 2; }else{ echo 0; } ?>">
									<input type="hidden" name="doct_name" value="<?php echo $doctor_data->name; ?>">
									<button type="submit" class="btn btn-primary submit-btn">Book Appointment</button>
								</div>
								<!-- /Submit Section -->
								
							</div>
						</form>
						<!-- /Checkout Form -->
						
					</div>
				</div>
				
			</div>
			
			<div class="col-md-5 col-lg-4 theiaStickySidebar">
			
				<!-- Booking Summary -->
				<div class="card booking-card">
					<div class="card-header">
						<h4 class="card-title">Booking Summary</h4>
					</div>
					<div class="card-body">
					
						<!-- Booking Doctor Info -->
						<div class="booking-doc-info">
							<a href="doctor-profile.html" class="booking-doc-img">
								<img src="<?php echo $doctor_data->img_url; ?>" alt="User Image" class="thumbnail">
							</a>
							<div class="booking-info">
								<h4><a href="doctor-profile.html">Dr. <?php echo $doctor_data->name; ?></a></h4>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="d-inline-block average-rating">35</span>
								</div>
								<div class="clinic-details">
									<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?php $address = json_decode($doctor_data->address); echo $address[0].' '.$address[1]; ?></p>
								</div>
							</div>
						</div>
						<!-- Booking Doctor Info -->
						
						<div class="booking-summary">
							<div class="booking-item-wrap">
								<ul class="booking-date">
									<li>Consulting Date <span id="consult_date_span">-- -- --</span></li>
									<!-- <li>Time <span>10:00 AM</span></li> -->
								</ul>
								<ul class="booking-fee">
									<li>Consulting Fee <span><?php if($doctor_data->urgent_fee =="" or $doctor_data->urgent_fee =="free"){ ?> Free <?php }else{ ?>Rs.<?php echo $doctor_data->urgent_fee; } ?></span></li>
									<!-- <li>Booking Fee <span>$10</span></li> -->
									<!-- <li>Video Call <span>$50</span></li> -->
								</ul>
								<div class="booking-total">
									<ul class="booking-total-list">
										<li>
											<span>Total</span>
											<span class="total-cost"><?php if($doctor_data->urgent_fee =="" or $doctor_data->urgent_fee =="free"){ ?> Rs.0 <?php }else{ ?>Rs.<?php echo $doctor_data->urgent_fee; } ?></span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Booking Summary -->
				
			</div>
		</div>

	</div>

</div>		
<!-- /Page Content -->

<script type="text/javascript">
$(document).mouseup(function(e) 
{
    var container = $(".consult_div");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('.consult_ul').hide();
    }
    
});
$("#consult_type").on("keyup focus", function() {
	$('.consult_ul').fadeIn('slow');
});

$('#booking_some_else').click(function(){
	if($('#booking_some_else').is(':checked'))
	{
		$('.some_else_booking').fadeIn('slow');
		$('#appointment_for').val(1);
		$('#date_of_birth').val('');
	}
	else
	{
		$('.some_else_booking').fadeOut('slow');
		$('#appointment_for').val($(this).val());
		$('#date_of_birth').val('<?php echo date('d/m/Y',strtotime($patient_data->birthdate)) ?>');
	}
});
$('#consult_date_input').focusout(function(){
	var datef = $('#consult_date_input').val();
	$('#consult_date_span').text(datef);
});
function addvalueType(val)
{
	$('#consult_type').val(val);
	$('.consult_ul').fadeOut('slow');
}
</script>