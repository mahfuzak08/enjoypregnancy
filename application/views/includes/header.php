<?php
$settings = $this->frontend_model->getSettings();
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
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="new_assets/js/html5shiv.min.js"></script>
			<script src="new_assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

<body>
	
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<!--Top Header -->
		<div class="header-top">
			<div class="left-top ">
				<ul>
					<li><a href="mailto:<?= $settings->email; ?>"><i class="fas fa-envelope top-icon"></i><b><?= $settings->email; ?></b></a></li>
				</ul>
			</div>
			<div class="right-top ">
				<ul>
					<li><div id="google_translate_element"></div></li>
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
                            echo '<img src=' . $settings->logo . ' class="img-fluid">';
						} else {
                            echo $title[0] . '<span> ' . $title[1] . '</span>';
                        }
                        ?>
					</a>
					<a href="#" class="dropdown-toggle nav-link xs-top-right" data-toggle="dropdown">
						<span class="user-img">
							<img class="rounded-circle" src="uploads/default.jpg" onerror="this.src='uploads/default.jpg'" width="31">
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="auth/login">Login</a>
					</div>
				</div>
				<div style="flex: 1;"></div>
				<div class="main-menu-wrapper">
					<div class="menu-header">
						<a href="<?php echo base_url() ?>" class="menu-logo">
							<img src="<?= $settings->logo; ?>" class="img-fluid" alt="Logo">
						</a>
						<a id="menu_close" class="menu-close" href="javascript:void(0);">	<i class="fas fa-times"></i>
						</a>
					</div>
					<ul class="main-nav">
					    <li><a href="<?php echo base_url() ?>">Home</a></li>
						<li><a href="frontend/searchdoctors">Doctor Lists</a></li>
						<li><a href="blogs"> Blogs </a></li>
						<li><a href="frontend/contact"> Contact Us </a></li>	
						<?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
							<li class="login-link">	<a href="patient/dashboard">Dashboard</a></li>
						<?php } elseif ($this->ion_auth->in_group(array('Doctor'))) { ?>
							<li class="login-link">	<a href="doctor/dashboard">Dashboard</a></li>
						<?php } else { ?>
							<li class="login-link">	<a href="auth/login">Login / Signup</a></li>
						<?php } ?>
					</ul>
				</div>
				<ul class="nav header-navbar-rht">
				<!-- User Menu -->
				<?php 
				$displaynone = ""; 
				if ($this->ion_auth->in_group(array('Patient'))) { 
					$displaynone = "style='display:none'"; 
					$icon_display = "style='display:block'";
					$patient_ion_id = $this->ion_auth->get_user_id();
					$user_data = $this->frontend_model->getpatiendatabyId($patient_ion_id);
					$ug = 'patient';
				} elseif($this->ion_auth->in_group(array('Doctor'))){
					$displaynone = "style='display:none'"; 
					$icon_display = "style='display:block'";
					$patient_ion_id = $this->ion_auth->get_user_id();
					$user_data = $this->doctor_model->getDoctorByIonUserId($patient_ion_id);
					$ug = 'doctor';
				} else { 
					$displaynone = "style='display:block'"; 
					$icon_display = "style='display:none'"; 
				} ?>
					<li class="nav-item dropdown has-arrow logged-item" <?php echo $icon_display; ?>>
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img">
								<img class="rounded-circle" src="<?php echo $user_data->img_url ?>" onerror="this.src='uploads/default.jpg'" width="31">
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="<?php echo $user_data->img_url ?>" onerror="this.src='uploads/default.jpg'" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6><?php echo $user_data->name ?></h6>
									<p class="text-muted mb-0"><?= ucfirst($ug); ?></p>
								</div>
							</div>
							<a class="dropdown-item" href="<?= $ug; ?>/dashboard">Dashboard</a>
							<a class="dropdown-item" href="<?= $ug; ?>/profile">Profile Settings</a>
							<a class="dropdown-item" href="auth/logout">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					<li class="nav-item" <?php echo $displaynone; ?>>	
						<a class="nav-link header-login" href="auth/login">Login / Signup</a>
					</li>
				</ul>
			</nav>
		</header>
		<!-- /Header -->