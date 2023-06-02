<?php
date_default_timezone_set($localTimeZoneAbbr);
$title = explode(' ', $settings->title);
?>
<!DOCTYPE html>
<html lang="en">

<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
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
		<script src="new_assets/js/bootstrap.min.js"></script>
		<script src="new_assets/js/popper.min.js"></script>
		
		<!-- Stripe -->
		<script src="https://checkout.stripe.com/checkout.js"></script>
	</head>

<body class="<?= ($chatpage === true) ? 'chat-page' : ''; ?>">
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<!--Top Header -->
		<div class="header-top">
			<div class="left-top ">
				<ul>
					<li><a href="mailto:contact@maulaji.com"><i class="fas fa-envelope top-icon"></i><b>contact@maulaji.com</b></a></li>
					<!-- <li><a href="tel:+9203149908654"><i class="fas fa-envelope top-icon"></i> +9203149908654</a></li> -->
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
					<li><a href="docshare" class="symptchecker-color"><i class="fa fa-share-alt" style="color: ;"></i> <b>Doc Share</b></a></li>
					<li><a href="health-welness" target="" class="symptchecker-color"><img src="new_assets/img/heartgif.gif" width="25px"/> <b>Health A-Z</b></a></li>
					<li><a href="learn-medical"><i class="fa fa-graduation-cap"></i> <b>Learn Medical</b></a></li>
					<li><a class="" href="/#dowloadtheapp"><i class="fas fa-download"></i><b> Download the App Now</b></a></li>
				</ul>
			</div>
		</div>
		<!--/Top Header -->
		<!-- Header -->
		<header class="header">
			<nav class="navbar navbar-expand-lg header-nav">
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
                            	if(isset($maulaji_talk) and $maulaji_talk=='yes')
                            	{
                            		echo '<img src="uploads/maulajitalklogo.png" class="img-fluid">';
                            	}
                            	elseif(isset($maulaji_talk) and $maulaji_talk=='docshare')
                            	{
                            		echo '<img src="uploads/docshareLogo.png" class="img-fluid">';
                            	}
                            	elseif(isset($maulaji_talk) and $maulaji_talk=='drive')
                            	{
                            		echo '<img src="uploads/drivelogo.png" class="img-fluid">';
                            	}
                            	elseif(isset($maulaji_talk) and $maulaji_talk=='health')
                            	{
                            		echo '<img src="uploads/healthandwealthlogo.png" class="img-fluid">';
                            	}
                            	elseif(isset($maulaji_talk) and $maulaji_talk=='learn')
                            	{
                            		echo '<img src="uploads/learnmedicallogo.png" class="img-fluid">';
                            	}
                            	else{
                                	echo '<img src=' . $settings->logo . ' class="img-fluid">';
                            	}
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
					    <li>
					        <a href="<?php echo base_url() ?>">Home</a>
						</li>
						<li>
						    <a href="frontend/consult_urgent_docotrs">Urgent Consultation</a>
						</li>
						<li>
						    <a href="frontend/book_home_visit">Home Visit</a>
						</li>
						<li>
						    <a href="frontend/pharmacy">Pharmacy</a>
						</li>
						<li>
						    <a href="lab-test">Lab Test</a>
						</li>
						<!-- <li>
						    <a href="auth/hospital_register" id="appointment">Register Your Hospital or Clinic</a>
						</li> -->
						<li>
						    <a href="community"> Community </a>
						</li>
						<li>
						    <a href="https://news.maulaji.com"> News </a>
						</li>	
						<li>
						    <a href="frontend/contact"> Contact Us </a>
						</li>	
						<li class="login-link"><a href="frontend/symptomchecker" target="_blank" class="symptchecker-color"><i class="fa fa-check-circle"></i> Symptom Checker</a></li>	
						<!-- Other links -->
						<li class="login-link"><a href="talk" target="" class="symptchecker-color"><i class="fa fa-microphone" style="color: ;"></i> Talk</a></li>	
						<li class="login-link"><a href="drive" target="" class="symptchecker-color"><i class="fab fa-google-drive" style="color: ;"></i> Drive</a></li>
						<li class="login-link"><a href="docshare" class="symptchecker-color"><i class="fa fa-share-alt" style="color: ;"></i> Doc Share</a></li>	
						<li class="login-link"><a href="health-welness" target="" class="symptchecker-color"><i class="fa fa-heart" style="color: #f50000;"></i> Health A-Z</a></li>	
						<li class="login-link"><a class="downloadlink" href="/#dowloadtheapp">Download the App Now <i class="fas fa-download"></i></a></li>
						<li class="login-link">	<a href="auth/login">Login / Signup</a>
						</li>
					</ul>
				</div>
				<ul class="nav header-navbar-rht">
				<!-- User Menu -->
				<?php $displaynone = ""; if ($this->ion_auth->in_group(array('Patient'))) { $displaynone = "style='display:none'"; $icon_display = "style='display:block'";
				}else{ $displaynone = "style='display:block'"; $icon_display = "style='display:none'"; } ?>
					<li class="nav-item dropdown has-arrow logged-item" <?php echo $icon_display; ?>>
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img">
								<img class="rounded-circle" src="<?php echo $patient_data->img_url ?>" onerror="this.src='uploads/default.jpg'" width="31">
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="<?php echo $patient_data->img_url ?>" onerror="this.src='uploads/default.jpg'" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6><?php echo $patient_data->name ?></h6>
									<p class="text-muted mb-0">Patient</p>
								</div>
							</div>
							<a class="dropdown-item" href="patient/dashboard">Dashboard</a>
							<a class="dropdown-item" href="patient/profile">Profile Settings</a>
							<a class="dropdown-item" href="auth/logout">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					<li class="nav-item" <?php echo $displaynone; ?>>	
					<a class="nav-link header-login" href="auth/login">login / Signup </a>
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
		<!-- Breadcrumb -->
		<div class="breadcrumb-bar">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-md-12 col-12">
						<nav aria-label="breadcrumb" class="page-breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
							</ol>
						</nav>
						<h2 class="breadcrumb-title">Dashboard</h2>
					</div>
				</div>
			</div>
		</div>
		<!-- /Breadcrumb -->
		<!--main content start-->
		
		<!-- Page Content -->
		<div class="content">
			<div class="container-fluid">
				<div class="row">
				<!-- Profile Sidebar -->
				<?php $this->load->view("_profile_sidebar"); ?>
				<!-- / Profile Sidebar -->