<?php
$settings = $this->frontend_model->getSettings();
$title = explode(' ', $settings->title);
?>
<!DOCTYPE html>
<html lang="en">

<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title><?php echo $settings->title; ?></title>
		<base href="<?php echo base_url(); ?>">
		<!-- Favicons -->
		<link type="image/x-icon" href="uploads/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="new_assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="new_assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="new_assets/plugins/fontawesome/css/all.min.css">

		<!-- Swiper CSS -->
		<link rel="stylesheet" href="new_assets/plugins/swiper/css/swiper.min.css">
		<link rel="stylesheet" href="new_assets/css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="new_assets/plugins/select2/css/select2.min.css">
		<!-- Main CSS -->
		<link rel="stylesheet" href="new_assets/css/style.css">
		<script src="<?php echo base_url() ?>common/slots_calendar/js/materialize.min.js"></script>
		<script src="new_assets/js/jquery.min.js"></script>
		<!-- Bootstrap Core JS -->
		<script src="new_assets/js/popper.min.js"></script>
		<script src="new_assets/js/bootstrap.min.js"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="new_assets/js/html5shiv.min.js"></script>
			<script src="new_assets/js/respond.min.js"></script>
		<![endif]-->
	
	</head>

<body>
<button class="btn btn-primary" type="button" data-toggle="modal" id="verification-modal" data-target="#exampleModalCenter" style="display: none;">Open verification modal</button> 
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document"> 	
	 <div class="modal-content">
	 	<form action="javascript:void(0)" method="post" id="verificationCode" class="login-wrap">
	  	<div class="modal-header">
	    	<h5 class="modal-title">Verification Code</h5>
	    	<button class="close" type="button" data-dismiss="modal" aria-label="Close" id="verification-modal-close"><span aria-hidden="true">×</span></button>
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
<button type="button" id="upload-prescrip-modal-btn" data-toggle="modal" data-target="#upload-prescription-modal"style="display: none;">upload pres...</button>
<div class="modal fade" id="upload-prescription-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
          	<div class="modal-header">
            	<h5 class="modal-title">Upload Prescription</h5>
            	<button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
          	</div>
          	<form action="" method="post" enctype="multipart/form-data" id="prescription_form">
          	<div class="modal-body">      
          		<div class="alert alert-danger prescriptimg_err" style="display: none;">Only JPG and PNG image are allowed.</div>   	
            	<div class="form-group">
            		<label>Upload Prescription</label>
            		<input type="file" name="prescriptimg" class="form-control" id="prescription_image" required>
            	</div>            	
          	</div>
          	<div class="modal-footer">
            	<button class="btn btn-secondary" type="button" data-dismiss="modal" data-original-title="" title="">Close</button>
            	<button class="btn btn-primary upload_presc_btn" type="submit" title="">Upload</button>
          	</div>
          	</form>
    	</div>
  	</div>
</div>
<button type="button" id="login-modal-btn" data-toggle="modal" data-target="#upload-prescription-modal"style="display: none;">login</button>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
          	<div class="modal-header">
            	<h5 class="modal-title">Login</h5>
            	<button class="close" type="button" data-dismiss="modal" id="login-modal-close" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
          	</div>
          	<div class="modal-body">
             <form action="javascript:void(0)" method="post" id="login_form">								
				<div class="alert alert-danger reg_error_msg" style="display:none;"></div>
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
<!-- Main Wrapper -->
<div class="main-wrapper">
<!--Top Header -->
<div class="header-top">
	<div class="left-top ">
		<ul>
			<li><a href="mailto:contact@maulaji.com"><i class="fas fa-envelope top-icon"></i><b>contact@maulaji.com</b> </a></li>
			<li>
			    <div id="google_translate_element"></div>
			</li>
		</ul>
	</div>
	<div class="right-top ">
		<ul>			
		    <li><a href="frontend/symptomchecker" target="_blank" class="symptchecker-color"><i class="fa fa-check-circle"></i> <b>Symptom Checker</b></a></li>    
		    <!-- <li><a href="auth/pharmacy_register" class="blinking-color"><b>Register Your Pharmacy</b></a></li> -->					
			<li><a href="talk" target="" class="symptchecker-color"><i class="fa fa-microphone" style="color: ;"></i> <b>Talk</b></a></li>
			<li><a href="drive" target="" class="symptchecker-color"><i class="fab fa-google-drive" style="color: ;"></i> <b>Drive</b></a></li>
			<li><a href="docshare" class="symptchecker-color"><i class="fa fa-share-alt"></i> <b>Doc Share</b></a></li>
			<li><a href="health-welness" target="" class="symptchecker-color"><img src="new_assets/img/heartgif.gif" width="25px"/> <b>Health A-Z</b></a></li>
			<li><a href="learn-medical"><i class="fa fa-graduation-cap"></i> <b>Learn Medical</b></a></li>
			<li><a class="" href="/#dowloadtheapp"><i class="fas fa-download"></i><b> Download the App Now</b></a></li>

			<!-- <li> <a href="https://www.facebook.com/maulaji.telehealth" target="_blank"><i class="fab fa-facebook-f top-icons"></i></a></li>
			<li> <a href="https://twitter.com/maulajiT" target="_blank"><i class="fab fa-twitter top-icons"></i></a></li>
			<li> <a href="https://www.linkedin.com/in/maulaji-telehealth-1179a9202/" target="_blank"><i class="fab fa-linkedin-in top-icons"></i></a></li>
			<li> <a href="https://www.instagram.com/maulajitelehealth/" target="_blank"><i class="fab fa-instagram top-icons"></i></a></li>
			<li> <a href="https://www.youtube.com/channel/UCWu2brD2NzoXu-dPckwJxYg" target="_blank"><i class="fab fa-youtube top-icons"></i></a></li> -->
		</ul>
	</div>
</div>
<!--/Top Header -->
<!-- Header -->
<header class="header">
	<nav class="navbar navbar-expand-lg header-nav" style="z-index: 9999;">
		<div class="navbar-header">
			<a id="mobile_btn" href="javascript:void(0);">	<span class="bar-icon">
				<span></span>
				<span></span>
				<span></span>
				</span>
			</a>
			<a href="<?php echo base_url() ?>" class="navbar-brand logo">
				<!-- <img src="new_assets/img/logo.png" class="img-fluid" alt="Logo"> -->
				<?php
                if (!empty($settings->logo)) {
                    if (file_exists($settings->logo)) {
                        echo '<img src=' . $settings->logo . ' class="img-fluid">';
                    } else {
                        echo $title[0] . '<span> ' . $title[1] . '</span>';
                    }
                } else {
                    echo $title[0] . '<span> ' . $title[1] . '</span>';
                }
                ?>
			</a>
		</div>
		<div style="flex: 1;"></div>
		<div class="main-menu-wrapper">
			<div class="menu-header">
				<a href="<?php echo base_url() ?>" class="menu-logo">
					<img src="new_assets/img/logo1.png" class="img-fluid" alt="Logo">
				</a>
				<a id="menu_close" class="menu-close" href="javascript:void(0);">	<i class="fas fa-times"></i>
				</a>
			</div>
			<ul class="main-nav">
				<li><a href="<?php echo base_url() ?>">Home</a></li>
				<li class="has-submenu"><a href="javascript:void(0)">Medicines <i class="fas fa-chevron-down"></i></a>
					<ul class="submenu">
						<li><a href="frontend/by_conditions">By Conditions</a>
						</li>
						<li><a href="frontend/by_brands">By Brand</a>
						</li>							
					</ul>
				</li>
				<?php $parent_categories = $this->frontend_model->getallParentcategories();
					foreach($parent_categories as $pcvalue){
						if($pcvalue->category_name=='Medicines'){}else{
				?>
				<li class="has-submenu"><a href="javascript:void(0)"><?php echo $pcvalue->category_name; ?> <i class="fas fa-chevron-down"></i></a>
					<ul class="submenu">
						<?php 
							$categories = $this->frontend_model->getallcategoriesByname($pcvalue->id);
							// echo "<pre>";
							// print_r($categories);
							// echo "</pre>";
							// exit();
							foreach($categories as $key => $value){
						?>
							<li><a href="<?php echo base_url() ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name); ?>"><?php echo $value->category_name ?></a></li>
						<?php } ?>
					</ul>
				</li>
				<?php } } ?>
				<!-- <li class="has-submenu"><a href="javascript:void(0)">Wellbeing & Fitness <i class="fas fa-chevron-down"></i></a>
					<ul class="submenu">
						<?php 
							$categories = $this->frontend_model->getallcategoriesByname('Wellbeing & Fitness');
							// echo "<pre>";
							// print_r($categories);
							// echo "</pre>";
							// exit();
							foreach($categories as $key => $value){
						?>
							<li><a href="<?php echo base_url() ?>frontend/products?p_by_cond=<?php echo urlencode($value->subcategory); ?>"><?php echo $value->subcategory ?></a></li>
						<?php } ?>
					</ul>
				</li>
				<li class="has-submenu"><a href="javascript:void(0)">Medical devices <i class="fas fa-chevron-down"></i></a>
					<ul class="submenu">
						<?php 
							$categories = $this->frontend_model->getallcategoriesByname('Medical devices');
							// echo "<pre>";
							// print_r($categories);
							// echo "</pre>";
							// exit();
							foreach($categories as $key => $value){
						?>
							<li><a href="<?php echo base_url() ?>frontend/products?p_by_cond=<?php echo urlencode($value->subcategory); ?>"><?php echo $value->subcategory ?></a></li>
						<?php } ?>
					</ul>	
				</li> -->

				<li><a href="javascript:void(0)" <?php //if($this->ion_auth->in_group(array('Patient'))){ ?> data-toggle="modal" data-target="#upload-prescription-modal">Upload Prescription</a></li>	
				<li class="login-link"><a href="frontend/symptomchecker" target="_blank" class="symptchecker-color"><i class="fa fa-check-circle"></i> Symptom Checker</a></li>	
				<li class="login-link">	<a href="auth/login">Login / Signup</a> </li>				
			</ul>	
		</div>
		<!-- <div style="flex: 1;"></div> -->
		<ul class="nav header-navbar-rht">
		<!-- User Menu -->
		<?php $displaynone = ""; if ($this->ion_auth->in_group(array('Patient'))) { $displaynone = "style='display:none'"; $icon_display = "style='display:block'";
			$patient_ion_id = $this->ion_auth->get_user_id();
			$patient_data = $this->frontend_model->getpatiendatabyId($patient_ion_id);
		}else{ $displaynone = "style='display:block'"; $icon_display = "style='display:none'"; } ?>
			<li class="nav-item dropdown has-arrow logged-item" <?php echo $icon_display; ?>>
				<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
					<span class="user-img">
						<img class="rounded-circle" src="<?php echo $patient_data->img_url ?>" width="31" alt="Darren Elder">
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<div class="user-header">
						<div class="avatar avatar-sm">
							<img src="<?php echo $patient_data->img_url ?>" alt="User Image" class="avatar-img rounded-circle">
						</div>
						<div class="user-text">
							<h6><?php echo $patient_data->name ?></h6>
							<p class="text-muted mb-0">Patient</p>
						</div>
					</div>
					<a class="dropdown-item" href="patient/medicalHistory">Dashboard</a>
					<a class="dropdown-item" href="profile">Profile Settings</a>
					<a class="dropdown-item" href="auth/logout">Logout</a>
				</div>
			</li>
			<!-- /User Menu -->
			<li class="nav-item login-signup-btn" <?php echo $displaynone; ?>>	
			<a class="nav-link header-login" style="padding: 5px 8px !important;" href="auth/login">login/signup</a>
			</li>
			<li class="nav-item view-cart-header">
			<a href="#" class="" id="cart"><i class="fas fa-shopping-cart"></i> <small class="unread-msg1" id="cartbadge">0</small></a>		
			<!-- Shopping Cart -->
				<div class="shopping-cart">
					<ul class="shopping-cart-items list-unstyled">				
						
					</ul>
					<div class="booking-summary pt-3">
						<div class="booking-item-wrap">
							<ul class="booking-date">
								<!-- <li>Subtotal <span>$5,877.00</span></li>
								<li>Shipping <span>$25.00</span></li>
								<li>Tax <span>$0.00</span></li> -->
								<li>Total <span id="cart-price">Rs.0</span></li>
							</ul>
							<div class="booking-total">
								<ul class="booking-total-list text-align">
									<li>
										<div class="clinic-booking pt-4">
											<a class="apt-btn" href="frontend/cart">View Cart</a>
										</div>
									</li>
									<li>
										<div class="clinic-booking pt-4">
											<a class="apt-btn" href="frontend/checkout">Checkout</a>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- /Shopping Cart -->	
			</li>
		</ul>
	</nav>
</header>
<!-- /Header -->

