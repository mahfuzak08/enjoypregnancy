<?php 
$firebase = $this->settings_model->get_api_info('firebase');
?>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Contact Us</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content conatact-background">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 m-auto">
				<?php if($this->session->flashdata('msg_sent_success')){
					echo '<div class="alert alert-success">'.$this->session->flashdata('msg_sent_success').'</div>';
				} ?>
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 m-auto">
				<div class="card">
				<div class="card-header contact-card-header">
				<h2 class="text-center">Get in touch</h2>				
				<p class="text-center card-text">Thank you for your interest in partnering with Maulaji Health Services. We are always excited to meet those who share our vision of affordable and accessible healthcare.</p>
				</div>
				<div class="card-body">
					<form class="form" action="frontend/sendcontactrequest" method="post" id="contact_form" enctype="multipart/form-data">
						<div class="contact_form_input">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="First name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last name">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Email">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Contact Number</label>
									<!-- <div class="input-group mb-3">									 -->
									    <!-- <div class="input-group-prepend"> -->
									    <?php
									      //  $ip = $_SERVER['REMOTE_ADDR'];
									      //  $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));  

									      // foreach($country_codes as $country_code_val)
									      // {
									      //    if($dataArray->geoplugin_countryName==$country_code_val->nicename)
									      //    { 
									      //   	$phonecode = $country_code_val->phonecode; 
									      //    } 
									      // } 

									    ?>
									      <!-- <span class="input-group-text"><?php echo '+'.$phonecode; ?></span> -->
									    <!-- </div> -->
									    <input type="tel" class="form-control" name="contact_number" placeholder="Contact number">
									<!-- </div> -->
								</div>
							</div>
							</div>							
						</div>	
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Upload File</label>
									<input type="file" name="attachment" class="form-control" >
								</div>
							</div>
						</div>					

						<div class="form-group contact_form_input">
							<label>Your Message</label>
							<textarea name="message" class="form-control" placeholder="Enter your message here..."></textarea>
						</div>
					<!-- </div> -->
						<div class="form-group">
							<button type="button" id="contact_form_btn" class="btn btn-primary btn-lg">Submit</button>
						</div>
						<div class="form-group">
							<p class="">Your data will be stored as per our <a href="frontend/privacy_policy" target="_blank" style="color:#09E5AB;">Privacy policy</a>. This site is protected by Google reCAPTCHA and the <a href="frontend/privacy_policy" target="_blank" style="color:#09E5AB;">Privacy Policy</a> and <a href="frontend/terms_conditions" target="_blank" style="color:#09E5AB;">Terms & Conditions</a> apply. </p>
						</div>
					</form>
			  </div>
			 </div>
			</div>
		</div>
	</div>

</div>		
<!-- /Page Content -->
<div id="recaptcha-container"></div>
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
<script type="text/javascript">
	$('#contact_form_btn').on('click', function(e){
	   $('#contact_form_btn').prop('disabled',true);
	   $('#contact_form_btn').text('Please Wait...');
	    var isFormValid = true;
	    $('.contact_form_input :input').each(function(){
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
	    if(isFormValid==false)
	    {
	    	e.preventDefault(); 
	    	$('#contact_form_btn').prop('disabled',false);
	   		$('#contact_form_btn').text('Submit');
	    }
	    else
	    {
	    	$('#contact_form').append('<input type="hidden" name="contact_support" value="yes">');
	    	$('#contact_form').submit();
	    }
	});
</script>
