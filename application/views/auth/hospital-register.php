<?php 
$firebase = $this->settings_model->get_api_info('firebase');
?>
<style type="text/css">
#infoMessage p
{
	margin-bottom: 0px;
}
.email_err
{
    display: none;
}
.phone_err
{
    display: none;
}
</style>
<div class="section-category content account-page">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-10 offset-md-1">
				
				<!-- Login Tab Content -->
				<div class="account-content">
					<div class="row align-items-center justify-content-center">
						<div class="col-md-7 col-lg-7 login-left">
							<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">	
						</div>
						<div class="col-md-12 col-lg-5 login-right">
							<div class="login-header">
								<h3>Register Your Hospital with <span>Maulaji</span></h3>
							</div>

							<?php if(isset($message)){ ?>
								<div id="infoMessage" class="alert alert-danger"><?php echo $message; ?></div>
							<?php } ?>
							<?php 
							if($this->session->flashdata('email_verified_msg')==true)
							{
								echo $this->session->flashdata('email_verified_msg');
							}
							?>
							<?php
			                $message = $this->session->flashdata('feedback');
			                if (!empty($message)) {
			                    ?>
			                    <div class="alert alert-success"> <?php echo $message; ?></div>

			                <?php } ?>
			                <div class="email_err"></div>
							<div class="phone_err"></div>
							<form role="form" action="request/addNewhospital" class="clearfix" id="register" method="post">
	                            <div class="clearfix reg_inputs">
	                                <!-- <div class="form-group">
	                                    <label for="exampleInputEmail1"> Hospital Name</label>
	                                    <input type="text" class="form-control pay_in" name="name" id="hosp_name" value='' placeholder="">
	                                </div> -->
	                                <div class="form-group form-focus simplenumberdiv">
										<input type="text" class="form-control floating" name="name" id="address" required>
										<label class="focus-label" id="identity-label">Hospital Name</label>
									</div>
	                                <!-- <div class="form-group">
	                                    <label for="exampleInputEmail1"> Hospital Address</label>
	                                    <input type="text" class="form-control pay_in" name="address" value='' placeholder="">
	                                </div> -->
	                                <div class="form-group form-focus simplenumberdiv">
										<input type="text" class="form-control floating" name="address" id="address" required>
										<label class="focus-label" id="identity-label">Hospital Address</label>
									</div>
	                                <!-- <div class="form-group">
	                                    <label for="exampleInputEmail1"> Hospital Email</label>
	                                    <input type="text" class="form-control pay_in" name="email" value='' placeholder="">
	                                </div> -->
	                                <div class="form-group form-focus simplenumberdiv">
										<input type="email" class="form-control floating" name="email" id="email_i" required>
										<label class="focus-label" id="identity-label">Hospital Email</label>
									</div>
	                                <!-- <div class="form-group">
	                                    <label for="exampleInputEmail1"> Hospital Phone</label>
	                                    <input type="text" class="form-control pay_in" name="phone" value='' placeholder="">
	                                </div> -->
	                                <div class="form-group form-focus otpnumberdiv">
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
										    <input type="text" class="form-control floating" name="phone" id="phone">
										    <label class="focus-label" style="text-indent: 58px;z-index: 9999;">Hospital Phone</label>
										</div>									
									</div>
									<div class="form-group form-focus">
    									<input type="password" class="form-control floating password-input" name="password" id="password" required>
    									<label class="focus-label">Password</label>
    									<i class="fa fa-eye show-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey;"></i>
    									<i class="fa fa-eye-slash hide-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey; display:none"></i>
    								</div>
	               </div>
                <div class="text-right">
                  <a class="forgot-link" href="auth/login">Already have an account?</a>
                </div>
	                            <input type="hidden" name="phonecode" id="phonecode" value="<?php echo '+'.$phonecode; ?>">
		                        <input type="hidden" name="language" value='english'>
		                        <input type="hidden" name="package" value=''>
		                        <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitformbtn" style="display: none;"> Submit </button>
		                        <button type="button" name="submit" class="btn btn-primary btn-block" id="submitbtn"> Submit </button>
	                     	</form>
						</div>
					</div>
				</div>
				<!-- /Login Tab Content -->
					
			</div>
		</div>

	</div>

 </div>	
 <button class="btn btn-primary" type="button" data-toggle="modal" id="verification-modal" data-target="#exampleModalCenter" style="display: none;">Open verification modal</button> 
</div>
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
	 </div>
	
</div>
</div>

<div id="recaptcha-container"></div>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script type="text/javascript">
$('#exampleModalCenter').on("shown.bs.modal", function() {
    $('#verification_code').focus();
});

$('#submitbtn').on('click',function(e){
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
        $('#submitbtn').text('Please Wait....');
        $('#submitbtn').attr('disabled',true);
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
            // $('#submitformbtn').click();
          }
          else
          {
              $('#submitbtn').text('Submit');
              $('#submitbtn').attr('disabled',false);
          }
          
        });
    }
    
});
</script>
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
<script type="text/javascript">
$('#loginviaOTP').click(function(e){
	if($(this).is(':checked'))
	{
		$('#password').prop('disabled',true);
		$('.simplenumberdiv').fadeOut('slow');
		$('.otpnumberdiv').fadeIn('slow');
		$('#otpnumber').prop('required',true);
		$('#identity').prop('required', false);
	}
	else
	{
		$('#password').prop('disabled',false);
		$('.simplenumberdiv').fadeIn('slow');
		$('.otpnumberdiv').fadeOut('slow');
		$('#otpnumber').prop('required',false);
		$('#identity').prop('required', true);
	}
});
$('#exampleModalCenter').on("shown.bs.modal", function() {
    $('#verification_code').focus();
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
window.onload=function () {
  render();
};
function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container',{
        'size': 'invisible'
    });
    recaptchaVerifier.render();
}
function phoneAuth(phonenumber) 
{    
    //get the number
    firebase.auth().settings.appVerificationDisabledForTesting = true;
    var number= '+'+phonenumber;
    //it takes two parameter first one is number,,,second one is recaptcha
    firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
        window.confirmationResult=confirmationResult;
        coderesult=confirmationResult;
        // console.log(coderesult);        
		// $('#phon_number').val(phonenumber);
        $('#verification-modal').click();        
        $('.loginbtn').text('Login');
		$('.loginbtn').prop('disabled', false);	
		$('.verf_msg').fadeIn('slow');	
    }).catch(function (error){
    	// console.log(error.message);
        $('.reg_error_msg').text(error.message);
        $('.reg_error_msg').fadeIn('slow');
        $('.loginbtn').text('Login');
		$('.loginbtn').prop('disabled', false);
    });
}
function codeverify() 
{
    var code=document.getElementById('verification_code').value;
    if(code=="")
    {
    	$('.verf_msg').fadeOut('slow');
        $('.error_msg').text('Please enter verification code.');
        $('.error_msg').fadeIn('slow');
    	$('#verification_code').css('border','1px solid red');
    	return;
    }
    $('.vrfy_btn').text('Please Wait....');
    $('.vrfy_btn').attr('disabled',true);
    coderesult.confirm(code).then(function (result) {
        var phoneNumber = result.phoneNumber;
        // $('#verificationCode').submit();
        $('#submitformbtn').click();
        // console.log(result);
    }).catch(function (error) {
        $('.verf_msg').fadeOut('slow');
        $('.error_msg').text(error.message);
        $('.error_msg').fadeIn('slow');
        $('#verification_code').css('border','1px solid red');
        $('.vrfy_btn').text('Verify code');
        $('.vrfy_btn').attr('disabled',false);
    });
}
</script>