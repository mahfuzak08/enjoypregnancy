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
						<li class="breadcrumb-item active" aria-current="page">Home Visit</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Book your appointment for Home Visit</h2>
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
						<form action="frontend/bookhomevisittnow" method="post" enctype="multipart/form-data">
						
							<!-- Personal Information -->
							<div class="info-widget">
								<h4 class="card-title">Personal Information</h4>
								<div class="row">
									<!-- <div class="col-md-6 col-sm-12">
										<div class="form-group card-label consult_div">
											<label>Consultation Type</label>
											<input class="form-control" type="text" name="consult_type" id="consult_type" required>
											<ul class="consult_ul">
												<li onclick="addvalueType('Audio')"> Audio </li>
												<li onclick="addvalueType('Video')"> Video </li>
												<li onclick="addvalueType('Chat')"> Chat </li>
											</ul>
										</div>
									</div> -->
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
									<div class="col-md-6 col-sm-12">										
										<div class="form-group card-label consult_div">
											<label>Preffered Time</label>
											<input class="form-control" type="text" name="preffered_time" id="consult_type">
											<ul class="consult_ul">
												<li onclick="addvalueType('AM')"> AM </li>
												<li onclick="addvalueType('PM')"> PM </li>
											</ul>
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
											<input class="form-control" type="date" name="date_of_birth" id="date_of_birth" value="<?php if(isset($patient_data->birthdate)){echo $patient_data->birthdate; } ?>">
										</div>
									</div>									
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Booking Date</label>
											<input class="form-control" type="date" min="<?= date('Y-m-d', strtotime(date('Y-m-d H:i:s'). ' +1 day' )); ?>" name="date" id="consult_date_input">
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
								
								<!-- Credit Card Payment 
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
								/Credit Card Payment -->
								
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
									<input type="hidden" name="appointment_for" id="appointment_for" value="<?php if(empty($patient_data)){ echo 2; }else{ echo 0; } ?>">
									<input type="hidden" name="hospital_id" value="<?php echo $hospital_data->id; ?>">
									<button type="submit" class="btn btn-light submit-btn" disabled >Book Appointment</button>
								</div>
								<!-- /Submit Section -->
								
							</div>
						</form>
						<!-- /Checkout Form -->
						
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
					<div class="text-center">
						<h2>COVID-19</h2>
						<p>If you have any of the symptoms listed below, please do not book a home visit appointment.</p>
						<p>Fever, cough, loss of smell &amp; taste, breathing difficulties, chest tightness &amp; wheezing.</p>
					</div>
					<br>
					<div class="text-center">
						<p><img src="<?php echo base_url() ?>new_assets/img/one.png" width="100px"></p>
						<p>Our highly experienced GPs will come straight to you for a doctor home visit.</p>
						<p>You don’t have to leave the comfort of your home, office, gym or wherever you may be. Simply let us know where to come and we’ll be there as soon as possible!</p>
					</div>
					<br>
					<div class="text-center">
						<p><img src="<?php echo base_url() ?>new_assets/img/two.png" width="100px"></p>
						<p>Our doctor home visits will be for a 20-minute consultation with you in which you will be given a prescription or referral accordingly free of charge. </p>
						<p>You will also be able to request a sick form or other documentation as appropriate.</p>
					</div>
					<br>
					<div class="text-center">
						<p><img src="<?php echo base_url() ?>new_assets/img/three.png" width="100px"></p>
						<p>Book your appointment down below or via the App.</p>
						<p>Once your booking is complete a member of the team will be in touch to schedule a specific time for you.</p>
					</div>
					<br>
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
								<img src="new_assets/img/contact-us-bg.jpeg" alt="User Image" class="thumbnail">
							</a>
							<div class="booking-info">
								<h4><a href="doctor-profile.html"><?php echo $hospital_data->name; ?></a></h4>
							</div>
						</div>
						<!-- Booking Doctor Info -->
						
						<div class="booking-summary">
							<div class="booking-item-wrap">
								<ul class="booking-date">
									<li>Booking Date <span id="consult_date_span">-- -- --</span></li>
									<!-- <li>Time <span>10:00 AM</span></li> -->
								</ul>
								<ul class="booking-fee">
									<li>Booking Fee <span>20-100</span></li>
								</ul>
								<div class="booking-total">
									<ul class="booking-total-list">
										<li>
											<span>Total</span>
											<span class="total-cost"></span>
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
$('#consult_date_input').on("change", function(){
	var datef = $('#consult_date_input').val();
	$('#consult_date_span').text(datef);
});
function addvalueType(val)
{
	$('#consult_type').val(val);
	$('.consult_ul').fadeOut('slow');
}
addvalueType('AM');
</script>