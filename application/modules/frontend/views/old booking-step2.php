<?php 
$stripe = $this->settings_model->get_api_info('stripe');
$squareup = $this->settings_model->get_api_info('squareup');
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
	.req{
		color: red;
		font-size: 20px;
		line-height: 0px;
	}
	.terms-accept{
		margin-top: 10px;
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
						<li class="breadcrumb-item" aria-current="page"><a onclick="javascript:history.go(-2)" style="cursor:pointer;">Docotrs List</a></li>
						<li class="breadcrumb-item active" aria-current="page">Personal Information</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Book your appointment</h2>
				<p class="mb-0" style="color: #fff;">Once your booking is complete a member of the team will be in touch with you.</p>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->
<?php 
	if(date("d-m-Y") == $appointment_data['appointment_date'])
		$doctor_fee = $doctor_profile_data->urgent_fee != "" && $doctor_profile_data->urgent_fee != 'free' ? $doctor_profile_data->urgent_fee : 0 ;
	else
		$doctor_fee = $doctor_profile_data->pricing != "" && $doctor_profile_data->pricing != 'free' ? $doctor_profile_data->pricing : 0 ;
	
?>
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
											<label><span class="req">*</span>Consultation Type</label>
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
											<label><span class="req">*</span>Full Name</label>
											<input class="form-control" type="text" name="full_name" value="<?php echo $patient_data->name ?>" required>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label><span class="req">*</span>Email</label>
											<input class="form-control" type="email" name="email" id="pateint_email" value="<?php echo $patient_data->email ?>" required>
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
											<label><span class="req">*</span>Phone</label>
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
											<input class="form-control datetimepicker" type="text" name="date_of_birth" id="date_of_birth" value="<?php if(isset($patient_data->birthdate)){echo $patient_data->birthdate; } ?>">
										</div>
									</div>									
									<div class="col-md-6 col-sm-12">
										<div class="form-group card-label">
											<label>Any Allergy History</label>
											<input type="text" class="form-control" name="allergy_history">
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
								<?php if($doctor_fee > 0) { ?>
								<h4 class="card-title">Payment Method</h4>
								<div class="payment-list">
									<input type="hidden" id="payment_method" name="payment_method" value="">
									<input type="hidden" name="card_name" id="card_name" value="">
									<div class="row">
										<!-- Pay by Stripe -->
										<?php if(! empty($stripe)) { ?>
										<div class="col-md-6">
											<button type="button" onclick="payByStripe()" class="btn btn-block btn-outline-info payment-status">
												<span class="fab fa-stripe-s mr-2"></span>Pay Now with Stripe
											</button>
										</div>
										<?php } ?>
										<?php if(! empty($squareup)) { ?>
										<div class="col-md-6">
											<button type="button" onclick="payBySquareup()" class="btn btn-block btn-outline-secondary payment-status">
												<span class="far fa-square mr-2"></span>Pay Now with Squareup
											</button>
										</div>
										<?php } ?>
										<!-- Pay by Stripe -->
										<!--<div class="col-md-6">
											<button type="button" class="btn btn-block btn-outline-warning" disabled>
												<span class="fab fa-paypal mr-2"></span>Pay Now with Paypal
											</button>
										</div>-->
										<!--<div>
											  <a target="_blank" href="https://checkout.square.site/merchant/MLKSNXSWXFC89/checkout/XRHSGJWDUNXZ2MT75JRDHQBL" style="display: inline-block;font-size: 18px;line-height: 48px;height: 48px;color: #ffffff;min-width: 212px;background-color: #000000;text-align: center;box-shadow: 0 0 0 1px rgba(0,0,0,.1) inset;">Pay now</a>
										</div>-->
									</div>
								</div>
								<?php } ?>
								<!-- Terms Accept -->
								<div class="terms-accept">
									<div class="custom-checkbox">
									   <input type="checkbox" id="terms_accept" required>
									   <label for="terms_accept">I have read and accept <a href="terms-and-consitions" target="_blank">Terms &amp; Conditions</a></label>
									</div>
								</div>
								<input type="hidden" id="token_id" name="token_id" value=0>
								<input type="hidden" id="trans_id" name="trans_id" value=0>
								<input type="hidden" id="card_tab_id" name="card_tab_id" value=0>
								<!-- /Terms Accept -->
								
								<!-- Submit Section -->
								<div class="submit-section mt-4">
									<input type="hidden" name="redirect" id="redirect_url" value="">
                                    <input type="hidden" name="request" value="Yes">
                                    <input type="hidden" name="date" id="appointment_date" value="<?php echo $appointment_data['appointment_date'] ?>">
                                    <input type="hidden" name="time_slot" id="appointment_time_slot" value="<?php echo $appointment_data['appointment_time_slot'] ?>">
                                    <input type="hidden" name="status" id="" value="Requested">
                                    <input type="hidden" name="pay_amount" id="pay_amount" value="<?= $doctor_fee; ?>">
									
									<input type="hidden" name="pateint_id" id="patient_id" value="<?php if(empty($patient_data->id)){ echo 0; }else{ echo $patient_data->id; } ?>">
									<input type="hidden" name="doct_id" id="doctor_id" value="<?php echo $appointment_data['doctor_id'] ?>">
									<input type="hidden" name="appointment_for" id="appointment_for" value="<?= empty($patient_data) ? 2 : 0; ?>">
									<input type="hidden" name="doct_name" value="<?php echo $doctor_profile_data->name; ?>">
									<input type="hidden" name="hospital_id" value="<?php echo $doctor_profile_data->hospital_id; ?>">
									<button type="submit" class="btn btn-light submit-btn" disabled >Book Appointment</button>
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
								<img src="<?php echo $doctor_profile_data->img_url; ?>" alt="User Image" class="thumbnail">
							</a>
							<div class="booking-info">
								<h4><a href="doctor-profile.html"><?php echo $doctor_profile_data->name; ?></a></h4>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="d-inline-block average-rating">35</span>
								</div>
								<div class="clinic-details">
									<p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?php $address = json_decode($doctor_profile_data->address); echo $address[0].' '.$address[1]; ?></p>
								</div>
							</div>
						</div>
						<!-- Booking Doctor Info -->
						
						<div class="booking-summary">
							<div class="booking-item-wrap">
								<ul class="booking-date">
									<li>Consulting Date <span id="consult_date_span"><?php echo $appointment_data['appointment_date'] ?></span></li>
									<!-- <li>Time <span>10:00 AM</span></li> -->
								</ul>
								<ul class="booking-fee">
									<?php 
									if(date("d-m-Y") == $appointment_data['appointment_date'])
										$fee = $doctor_profile_data->urgent_fee != "" && $doctor_profile_data->urgent_fee != 'free' ? $doctor_profile_data->symbol.' '.$doctor_profile_data->urgent_fee : "Free" ;
									else
										$fee = $doctor_profile_data->pricing != "" && $doctor_profile_data->pricing != 'free' ? $doctor_profile_data->symbol.' '.$doctor_profile_data->pricing : "Free" ;
									?>
									<li>Consulting Fee <span><?= $fee; ?></span></li>
									<!-- <li>Booking Fee <span>$10</span></li> -->
									<!-- <li>Video Call <span>$50</span></li> -->
								</ul>
								<div class="booking-total">
									<ul class="booking-total-list">
										<li>
											<span>Total</span>
											<span class="total-cost"><?= $fee; ?></span>
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
</div>

<button type="button" id="login-modal-btn" data-toggle="modal" data-target="#login-modal"style="display: none;">login</button>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Login to Book your Appointment</h5>
				<!-- <button class="close" type="button" data-dismiss="modal" id="login-modal-close" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button> -->
			</div>
			<div class="modal-body">
			 <form action="javascript:void(0)" method="post" id="login_form">                               
				<div class="reg_error_msg" style="display:none;"></div>
				<div class="form-group form-focus simplenumberdiv">
					<input type="text" class="form-control floating" name="identity" id="identity" required>
					<label class="focus-label" id="identity-label">Email / Phone number</label>
				</div>
				<div class="form-group form-focus otpnumberdiv" style="display: none;">
					<div class="input-group mb-3">                                  
						<div class="input-group-prepend">
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
						<span class="input-group-text"><?php echo '+'.$phonecode; ?></span>
						</div>
						<input type="hidden" name="phonecode" id="phonecode" value="<?php echo '+'.$phonecode; ?>">
						<input type="text" class="form-control floating" name="" id="otpnumber">
						<label class="focus-label" style="text-indent: 58px;z-index: 9999;">Phone number</label>
					</div>                                  
				</div>
				<div class="form-group form-focus">
					<input type="password" class="form-control floating" name="password" id="password" required>
					<label class="focus-label">Password</label>
				</div>
				<div class="">
					<label><input type="checkbox" name="remember-me" value="remember-me"> Remember me</label>
				</div>
				<div class="">
					<label><input type="checkbox" name="loginviaOTP" id="loginviaOTP"> Login with OTP instead of password</label>
				</div>              
				<button class="btn btn-primary btn-block btn-lg login-btn loginbtn" type="submit">Login</button>    
				<div class="row">
					<div class="col-md-8">
						<div class="dont-have">
							Don’t have an account? <a href="auth/register" target="_blank">Register</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="text-right">
							<a class="forgot-link" href="auth/forgot_password" target="_blank">Forgot Password ?</a>
						</div>
					</div>
				</div>  
			</form>
			</div>
		</div>
	</div>
</div>
<!--  -->
<?php if(empty($patient_data)){ ?>
    <script type="text/javascript">
        $('#login-modal-btn').click();
    </script>
<?php } ?>
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

function addvalueType(val)
{
	$('#consult_type').val(val);
	$('.consult_ul').fadeOut('slow');
}

function payByStripe() {
	let amount = $("#pay_amount").val() * 100;
    var handler = StripeCheckout.configure({
      key: "<?= $stripe->key1; ?>",
      locale: 'auto',
      token: function (token) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
        console.log('Token Created!!');
        console.log(424, token)
		$("#payment_method").val("by_stripe");
		$('#token_id').val(token.id);
		$('#card_name').val(token.card.name);
		$('.payment-status').text('Payment verified').attr('disabled', 'disabled');
      }
    });
   
    handler.open({
		name: 'Maulaji',
		email: $('#pateint_email').val(),
		description: 'Docotrs Payment',
		amount: amount,
		currency: 'usd',
		zipCode: true,
		billingAddress: true,
		shippingAddress: true
    });
}

function payBySquareup(){
	window.open("http://localhost/mj/frontend/sq_up?base=<?= $doctor_profile_data->currency_code; ?>&baseamt=<?= $doctor_fee; ?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=500,width=400,height=400");
}
function setSQdata(token){
	console.log(464, token);
	$("#payment_method").val("by_squareup");
	$("#token_id").val(token.token);
	$("#card_name").val(token.name);
	$('.payment-status').text('Payment verified').attr('disabled', 'disabled');
}
</script>