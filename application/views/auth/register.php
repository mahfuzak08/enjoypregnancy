<?php 
$firebase = $this->settings_model->get_api_info('firebase');
?>
<style type="text/css">
.email_err
{
    display: none;
}
.phone_err
{
    display: none;
}
</style>
<!-- Page Content -->
<div class="content section-category account-page">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-10 offset-md-1">
					
				<!-- Register Content -->
				<div class="account-content">
					<div class="row align-items-center justify-content-center">
						<div class="col-md-7 col-lg-7 login-left">
							<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">	
						</div>
						<div class="col-md-12 col-lg-5 login-right">
							<div class="login-header">
								<h3>Patient Register <a href="auth/doctor_register">Are you a Doctor?</a></h3>
							</div>
							<div class="email_err"></div>
							<div class="phone_err"></div>
							<div class="reg_error_msg"></div>
							<!-- Register Form -->
							<form action="" id="register" method="post">
								<div class="form-group form-focus reg_inputs">
									<input type="text" class="form-control floating" name="name">
									<label class="focus-label">Name</label>
								</div>
								<div class="form-group form-focus reg_inputs">
									<input type="email" class="form-control floating" name="email" id="email_i">
									<label class="focus-label">Email</label>
								</div>
								<div class="form-group form-focus">
									<div class="input-group mb-3 reg_inputs">									
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
									    <input type="text" class="form-control floating" name="phone" id="phone">
									    <label class="focus-label" style="text-indent: 58px;z-index: 9999;">Phone number</label>
									</div>	
									<input type="hidden" name="phonecode" value="<?php echo '+'.$phonecode; ?>" id="phonecode">								
								</div>
								<input type="hidden" name="hospital_id" value="477">
								<!-- <div class="form-group reg_inputs" style="display:none;">
									<select class="form-control" name="">
									    <option value="">Select Hospital</option>
									    <?php foreach($hospitals as $hosp){
									    echo "<option value='".$hosp->id."'>".$hosp->name."</option>";
									    }?>
									</select>
								</div> -->
								<div class="form-group form-focus reg_inputs">
									<input type="password" class="form-control floating password-input" name="password">
									<label class="focus-label">Create Password</label>
									<i class="fa fa-eye show-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey;"></i>
									<i class="fa fa-eye-slash hide-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey; display:none"></i>
								</div>
								<div class="text-right">
									<a class="forgot-link" href="auth/login">Already have an account?</a>
								</div>
								<input type="hidden" name="support_input" value="0" id="support_input">
								<button class="btn btn-primary btn-block btn-lg login-btn" type="submit" id="send_ptnt_otp">Signup</button>	
								<!--
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								<div class="row form-row social-login">
									<div class="col-12">
										<a href="auth/hospital_register" class="btn btn-block btn-outline-info"> Register Your Hospital/Clinic</a>
										<a href="auth/pharmacy_register" class="btn btn-block btn-outline-primary" style="font-size: 1rem;">Register Your Pharmacy</a>
										<a href="auth/labortary_register" class="btn btn-block btn-outline-secondary">Register Your Laboratory</a>
									</div>
								</div>							
									-->
							</form>
							<!-- /Register Form -->
						</div>
					</div>
				</div>
				<!-- /Register Content -->
					
			</div>
		</div>

	</div>

</div>		
<!-- /Page Content -->
</div>
<button class="btn btn-primary" type="button" data-toggle="modal" id="verification-modal" data-target="#exampleModalCenter" style="display: none;">Open verification modal</button>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document"> 	
	 <div class="modal-content">
	 	<form action="auth/loginViaOtp" method="post" id="verificationCode" class="login-wrap">
	  	<div class="modal-header">
	    	<h5 class="modal-title">Verification Code</h5>
	    	<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	  	</div>
	  	<div class="modal-body">	    	
            <div class="alert alert-success verf_msg" style="display: none;">Verification code with 6-digits has been sent to your phone. Please enter verification code here to verify your phone number.</div>
            <div class="alert alert-danger error_msg" style="display:none;"></div>
            <input class="form-control" type="text" id="verification_code" placeholder="Enter 6-digits verification code" autofocus>             
            <input class="form-control" type="hidden" id="phon_number" name="identity">
            <!-- <label style="display: none;"><input type="checkbox" name="remember-me" value="remember-me" id="remember_me"> Remember me</label>              -->
	  	</div>
	  	<div class="modal-footer">
	    	<!-- <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button> -->
	    	<!-- <button class="btn btn-primary" type="button" data-original-title="" title="">Save changes</button> -->
	    	<button class="btn btn-primary vrfy_btn" type="button" onclick="codeverify();">Verify code</button>
	  	</div>	 
	  	</form> 
	  	<div class="congrats_msg" style="display: none">
	  		<div class="success-cont card-body">
				<i class="fas fa-check"></i>
				<h3>Thank You!</h3>
				<p class="mb-4 success_vrfy_msg"></p>
				<a href="auth/login" class="btn btn-primary">Click here to Login</a>
			</div>
	  	</div>	
	 </div>
	
</div>
</div>
<div id="recaptcha-container"></div>
<script type="text/javascript">
$('#exampleModalCenter').on("shown.bs.modal", function() {
    $('#verification_code').focus();
});

$('#register').on('submit',function(e){
    e.preventDefault();    
    // var input = $('#register').find('input').val();
    var isFormValid = true;
    $('.reg_inputs :input').each(function(){
        var input = $(this).val();
        if($.trim($(this).val()).length == 0)
        {
            $(this).css('border','1px solid red');
            // $(window).scrollTop($(this))
            isFormValid = false;
        }
        else
        {
            $(this).css('border','');
        }
        // return isFormValid;
    });
    if(isFormValid)
    {
        $('#send_ptnt_otp').text('Please Wait....');
        $('#send_ptnt_otp').attr('disabled',true);
        var phonenumber = $('#phonecode').val()+$('#phone').val();
        $.post( "auth/checkphoneEemail",{ phone: phonenumber, email: $('#email_i').val() }, function( data ) {
          var obj = JSON.parse(data);
          console.log(obj);
          if(obj[0] > 0)
          {
            // $('#send_ptnt_otp').prop('disabled',true);
            $('#email_i').css('border','1px solid red');
            $('.email_err').fadeIn('slow').addClass('alert, alert-danger');
            $('.email_err').text('Account already exists with this email please try another email.');
          }
          else
          {
            $('#email_i').css('border','');
            $('.email_err').fadeOut('slow').removeClass('alert, alert-danger');
          }
          if(obj[1] > 0)
          {
            // $('#send_ptnt_otp').prop('disabled',true);
            $('#phone').css('border','1px solid red');
            $('.phone_err').fadeIn('slow').addClass('alert, alert-danger');
            $('.phone_err').text('Account already exists with this phone number please try another phone.');
          }
          else
          {
            $('#phone').css('border','');
            $('.phone_err').fadeOut('slow').removeClass('alert, alert-danger');
          }
          if(obj[0] == 0 && obj[1] == 0)
          {
            // $('#send_ptnt_otp').prop('disabled',true);
            // var phonenumber = $('#phonecode').val()+$('#phone').val();
            phoneAuth(phonenumber);
          }
          else
          {
              $('#send_ptnt_otp').text('Send OTP');
              $('#send_ptnt_otp').attr('disabled',false);
          }
          
        });
    }
    
});
$('.show-password').click(function(){
    $(this).fadeOut('slow');
    $('.hide-password').fadeIn('slow');
    $('.password-input').prop('type', 'text');
});

$('.hide-password').click(function(){
    $(this).fadeOut('slow');
    $('.show-password').fadeIn('slow');
    $('.password-input').prop('type', 'password');
});
</script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "<?= $firebase->key1; ?>",
    authDomain: "<?= $firebase->key3; ?>",
    databaseURL: "<?= $firebase->key5; ?>",
    projectId: "<?= $firebase->key4; ?>",
    storageBucket: "<?= $firebase->key4; ?>.appspot.com",
    messagingSenderId: "<?= $firebase->key6; ?>",
    appId: "<?= $firebase->key2; ?>"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
<script src="common/js/NumberAuthentication.js" type="text/javascript"></script>