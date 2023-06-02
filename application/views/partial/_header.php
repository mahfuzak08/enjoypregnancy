<?php
date_default_timezone_set($localTimeZoneAbbr);
$title = explode(' ', $settings->title);

$class = $this->uri->segment(1, 0);
$select_menu = $this->uri->segment(2, 0); 

$displaynone = ""; 
if ($this->ion_auth->in_group(array('Patient', 'Doctor'))) { 
	$displaynone = "style='display:none'"; 
	$icon_display = "style='display:block'";
	$ug = $this->ion_auth->in_group(array('Patient')) ? 'patient' : 'doctor';
} else { 
	$displaynone = "style='display:block'"; 
	$icon_display = "style='display:none'"; 
} 
?>
<!DOCTYPE html>
<html lang="en" class="logedin">

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
		<!-- Full Calander CSS -->
        <link rel="stylesheet" href="new_assets/plugins/fullcalendar/fullcalendar.min.css">
		
		
		<!-- Stripe -->
		<script src="https://checkout.stripe.com/checkout.js"></script>
		<style>
			#ring_div{
				display: none;
				position: fixed;
				z-index: 9999;
				background: #000;
				top: 0;
				width: 100%;
				color: #FFF;
				padding: 25px;
			}
			.ring_text{
				width: 200px;
				float: left;
			}
			.ring_btn_div{
				position: absolute;
				top: 10px;
				right: 10px;
			}
			.ring_btn_div .btn{
				border-radius: 50% !important;
				background: #090 !important;
				padding: 12px 17px;
				margin-right: 15px;
			}
			.ring_btn_div .btn.slash{
				padding: 12px 15px;
				background: #fd0202 !important;;
			}
		</style>
	</head>

<body class="<?= ($chatpage === true) ? 'chat-page' : ''; ?>">
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
				<div class="navbar-header dropdown">
					<a id="mobile_btn" href="javascript:void(0);">	<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
						</span>
					</a>
					<a href="<?php echo base_url() ?>" class="navbar-brand logo">
						<?php
                        if (!empty($settings->logo)) {
                            if (file_exists($settings->logo)) {
                            	echo '<img src=' . $settings->logo . ' class="img-fluid bal">';
                            } else {
                                echo $title[0] . '<span> ' . $title[1] . '</span>';
                            }
                        } else {
                            echo $title[0] . '<span> ' . $title[1] . '</span>';
                        }
                        ?>
					</a>
					
					<a href="#" class="dropdown-toggle nav-link xs-top-right" data-toggle="dropdown">
						<span class="user-img">
							<img class="rounded-circle" src="<?= $patient_data->img_url ? $patient_data->img_url : $doctor_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" width="31">
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="user-header">
							<div class="avatar avatar-sm">
								<img src="<?= $patient_data->img_url ? $patient_data->img_url : $doctor_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" class="avatar-img rounded-circle">
							</div>
							<div class="user-text">
								<h6><?= $patient_data->name ? $patient_data->name : $doctor_data->name; ?></h6>
								<p class="text-muted mb-0"><?= ucfirst($ug); ?></p>
							</div>
						</div>
						<a class="dropdown-item" href="<?= $ug; ?>/dashboard">Dashboard</a>
						<a class="dropdown-item" href="<?= $ug; ?>/profile">Profile Settings</a>
						<a class="dropdown-item" href="auth/logout">Logout</a>
					</div>
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
					    <li class="lg-menu"><a href="<?php echo base_url() ?>">Home</a></li>
						<li class="lg-menu"><a href="frontend/searchdoctors">Doctor Lists</a></li>
						<li class="lg-menu"><a href="frontend/blogs"> Blogs </a></li>
						<li class="lg-menu"><a href="frontend/contact"> Contact Us </a></li>	
						<?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
							<li class="login-link">	<a href="patient/dashboard">Dashboard</a></li>
						<?php } elseif ($this->ion_auth->in_group(array('Doctor'))) { ?>
							<li class="login-link">	<a href="doctor/dashboard">Dashboard</a></li>
						<?php } else { ?>
							<li class="login-link">	<a href="auth/login">Login / Signup</a></li>
						<?php } ?>
						
						<!-- After login menu -->
						<?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
							<li class="after-login <?= $select_menu == 'dashboard' ? 'active': ''; ?>">
								<a href="<?= $class; ?>/dashboard">
									<i class="fas fa-columns"></i>
									<span>Dashboard</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'favourites' ? 'active': ''; ?>">
								<a href="patient/favourites">
									<i class="fas fa-bookmark"></i>
									<span>Favourites</span>
								</a>
							</li> 
							<li class="after-login <?= $select_menu == 'dependent' ? 'active': ''; ?>">
								<a href="patient/dependent">
									<i class="fas fa-users"></i>
									<span>Dependent</span>
								</a>
							</li> 
							<?php $total = $this->chat_model->totalUnreadMessages($patient_data->ion_user_id); ?>
							<li class="after-login <?= $select_menu == 'open' ? 'active': ''; ?>">
								<a href="chat/open/all">
									<i class="fas fa-comments"></i>
									<span>Message</span>
									<small class="unread-msg"><?= $total > 0 ? $total : ''; ?></small>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'accounts' ? 'active': ''; ?>">
								<a href="<?= $class; ?>/accounts">
									<i class="fas fa-file-invoice-dollar"></i>
									<span>Accounts</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'medical_records' ? 'active': ''; ?>">
								<a href="patient/medical_records">
									<i class="fas fa-clipboard"></i>
									<span>Add Medical Records</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'medical_details' ? 'active': ''; ?>">
								<a href="patient/medical_details">
									<i class="fas fa-file-medical-alt"></i>
									<span>Medical Details</span>
								</a>
							</li><?php 
						} ?>
						
						
						<?php if ($this->ion_auth->in_group(array('Doctor')) && $doctor_data->is_approved == 1) { ?>
							<li class="after-login <?= $select_menu == 'dashboard' ? 'active': ''; ?>">
								<a href="<?= $class; ?>/dashboard">
									<i class="fas fa-columns"></i>
									<span>Dashboard</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'appointments' ? 'active': ''; ?>">
								<a href="doctor/appointments">
									<i class="fas fa-calendar-check"></i>
									<span>Appointments</span>
								</a>
							</li> 
							<li class="after-login <?= $select_menu == 'my_patients' ? 'active': ''; ?>">
								<a href="doctor/my_patients">
									<i class="fas fa-user-injured"></i>
									<span>My Patients</span>
								</a>
							</li> 
							<?php $total = $this->chat_model->totalUnreadMessages($doctor_data->ion_user_id); ?>
							<li class="after-login <?= $select_menu == 'open' ? 'active': ''; ?>">
								<a href="chat/open/all">
									<i class="fas fa-comments"></i>
									<span>Message</span>
									<small class="unread-msg"><?= $total > 0 ? $total : ''; ?></small>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'schedule_timing' ? 'active': ''; ?>">
								<a href="doctor/schedule_timing">
									<i class="fas fa-hourglass-start"></i>
									<span>Schedule Timings</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'prescriptions' ? 'active': ''; ?>">
								<a href="doctor/prescriptions">
									<i class="fas fa-prescription"></i>
									<span>Prescriptions</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'bodycharttemplate' ? 'active': ''; ?>">
								<a href="doctor/bodycharttemplate">
									<i class="fas fa-bone-break"></i>
									<span>Body Chart Template</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'accounts' ? 'active': ''; ?>">
								<a href="<?= $class; ?>/accounts">
									<i class="fas fa-file-invoice-dollar"></i>
									<span>Accounts</span>
								</a>
							</li>
							<li class="after-login <?= $select_menu == 'blogs' ? 'active': ''; ?>">
								<a href="doctor/blogs">
									<i class="fas fa-file-invoice"></i>
									<span>Blogs</span>
								</a>
							</li><?php 
						} ?>
						
						<li class="after-login <?= $select_menu == 'profile' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/profile">
								<i class="fas fa-user-cog"></i>
								<span>Profile Settings</span>
							</a>
						</li>
						<li class="after-login <?= $select_menu == 'change_password' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/change_password">
								<i class="fas fa-lock"></i>
								<span>Change Password</span>
							</a>
						</li>
						<li class="after-login">
							<a href="auth/logout">
								<i class="fas fa-sign-out-alt"></i>
								<span>Logout</span>
							</a>
						</li>
					</ul>
				</div>
				<ul class="nav header-navbar-rht">
				<!-- User Menu -->
				
					<li class="nav-item dropdown has-arrow logged-item" <?php echo $icon_display; ?>>
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img">
								<img class="rounded-circle" src="<?= $patient_data->img_url ? $patient_data->img_url : $doctor_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" width="31">
							</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="<?= $patient_data->img_url ? $patient_data->img_url : $doctor_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
									<h6><?= $patient_data->name ? $patient_data->name : $doctor_data->name; ?></h6>
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
						<a class="nav-link header-login" href="auth/login">login / Signup </a>
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
								<li class="breadcrumb-item"><a href="<?= $class; ?>/dashboard">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
							</ol>
						</nav>
						<h2 class="breadcrumb-title"><?= $page_title; ?></h2>
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
				<?php $this->load->view("partial/_profile_sidebar"); ?>
				<!-- / Profile Sidebar -->