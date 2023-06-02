<?php
$settings = $this->frontend_model->getSettings();
$title = explode(' ', $settings->title);
?>

<!DOCTYPE html>
<html lang="en" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>>
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="img/favicon.png">

        <title><?php echo $settings->title; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="front/css/bootstrap.min.css" rel="stylesheet">
        <link href="front/css/theme.css" rel="stylesheet">
        <link href="front/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="front/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-timepicker/compiled/timepicker.css">
        <link rel="stylesheet" href="front/css/flexslider.css"/>
        <link href="front/assets/bxslider/jquery.bxslider.css" rel="stylesheet" />
        <link href="front/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />

        <!--<link rel="stylesheet" href="front/assets/revolution_slider/css/rs-style.css" media="screen">-->
        <link rel="stylesheet" href="front/assets/revolution_slider/rs-plugin/css/settings.css" media="screen">

        <!-- Custom styles for this template -->
        <link href="front/css/style.css" rel="stylesheet">
        <link href="front/css/style-responsive.css" rel="stylesheet" />
        
        <link rel="stylesheet" type="text/css" href="common/slots_calendar/css/mark-your-calendar.css">
        <!--<link rel="stylesheet" href="common/slots_calendar/css/materialize.min.css">-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

        <style>

            .pad_bot{
                margin-bottom: 20px;
            }

            .modal-body{
                /*background: #009988;*/
                /*color: #fff;*/
                padding: 23px;
            }

            .appointment{
                padding: 0px 95px;
            }

            .panel{
                background: none;
            }

            /*label{*/
            /*    width: 100%;*/
            /*    line-height: 25px;*/
            /*    font-size: 14px;*/
            /*    font-weight: 400;*/
            /*    text-transform: uppercase;*/
            /*    font-family: 'Fjalla One', sans-serif;*/
            /*}*/

            .btn-info{
                line-height: 25px;
                font-size: 14px;
                font-weight: 400;
                text-transform: uppercase;
                font-family: 'Fjalla One', sans-serif;
            }

            .flashmessage{
                text-align: center;
                color: green;
                margin: 10px;
                font-size: 23px;
                font-weight: 500;
            }

        </style>


    </head>

    <body style="background-color: #EBEBEB;">
        <!--header start-->
        <header class="header-frontend">
            <div class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="fa fa-bars"></span>
                        </button>
                        <a class="navbar-brand" href="frontend">
                            <?php
                            if (!empty($settings->logo)) {
                                if (file_exists($settings->logo)) {
                                    echo '<img width="150" src=' . $settings->logo . '>';
                                } else {
                                    echo $title[0] . '<span> ' . $title[1] . '</span>';
                                }
                            } else {
                                echo $title[0] . '<span> ' . $title[1] . '</span>';
                            }
                            ?>
                        </a>
                    </div>
                    <style>
                    .dropdown-menu
                    {
                        right: 0;
                        left: inherit;
                    }
                    .dropdown-menu li
                    {
                        list-style-type: none;
                    }
                    .dropdown-menu li a
                    {
                        display: block;
                    }
                    .dropdown:hover .dropdown-menu
                    {
                        display: inline-block;
                    }
                    </style>
                    <div class="navbar-collapse collapse ">
                        <ul class="nav navbar-nav">
                            <li class=""><a href="frontend#">Home</a></li>
                            <li class="active"><a href="frontend/bookappointment">Urgent Consultation</a></li> 
                            <li><a href="https://pharmacy.callgpnow.com/main">Pharmacy</a></li> 
                            <li><a href="frontend/doctorvisit">Home Visit</a></li>
                            <li><a href="frontend#appointment">Register Your Hospital Software</a></li>
                            <?php $displaynone = ""; if ($this->ion_auth->in_group(array('Patient'))) { $displaynone = "style='display:none'"; $icon_display = "style='display:block'";}else{ $displaynone = "style='display:block'"; $icon_display = "style='display:none'"; } ?>
                            <li class="dropdown loggedli" <?php echo $icon_display; ?>><a href="javascript:void(0)" style="border:1px solid #797979; border-radius: 100px;"><i class="fa fa-user"></i></a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="patient/medicalHistory">My Appointments</a></li>
                                    <li><a href="profile">Profile</a></li>
                                    <li><a href="auth/logout">Logout</a></li>
                                </ul>
                            </div>
                            </li>
                            <li class="active loginli" <?php echo $displaynone; ?>><a href="auth/login"><i class="fa fa-sign-in"></i> Login / Signup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <style>
            .margin-div
            {
                width: 100%;
                margin: 0 auto;
                padding: 0px 0px 50px;
            }
            .form-div{
                background-color: #00aeef9e;
                padding: 15px 10px;
                border-radius: 5px;
            }
            .form-div input
            {
                height: 45px;
                text-indent: 15px;
                color: #555;
            }
            .form-div button
            {
                height: 45px;
            }
            .margin-div h1{
                color: #000;
                font-weight: bold;
                margin-bottom: 20px;
            }
            #countrylist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            
            .country_div
            {
                position: relative;
            }
            #citylist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            .list-group{
                height: 200px;
                overflow-y: auto;
            }
            
            .city_div
            {
                position: relative;
            }
            #hospitallist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            
            .hospital_div
            {
                position: relative;
            }
            #specialitylist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            .speciality_div
            {
                position: relative;
            }
            .list-group-item:hover
            {
                cursor: pointer;
                background: lightgrey;
            }
            
    
            .map-icon
            {
                position: absolute;
                top: 13px;
                left: 12px;
            }
            .card
            {
                background-color: #fff;
                margin-bottom: 30px;
                box-shadow: 0px 0px 10px #505050;
                border-radius: 6px;
            }
            .card-body
            {
                padding: 10px;
            }
            #exTab1 .tab-content {
              color : white;
              background-color: #428bca;
              padding : 5px 15px;
            }
            
            #exTab2 h3 {
              color : white;
              background-color: #428bca;
              padding : 5px 15px;
            }
            
            /* remove border radius for the tab */
            
            #exTab1 .nav-pills > li > a {
              border-radius: 0;
              display:block;
              text-align: center;
            }
            
            /* change border radius for the tab , apply corners on top*/
            
            #exTab3 .nav-pills > li > a {
              border-radius: 4px 4px 0 0 ;
            }
            
            #exTab3 .tab-content {
              color : white;
              background-color: #428bca;
              padding : 5px 15px;
            }
        </style>
        <!--header end--> 
        <!--Container start-->
        <br><br>
        <div class="container">
            <div class="row">
            <div class="col-md-12 text-right">
                <strong><?php echo count($doctors); ?> Results</strong>
            </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="margin-div">
                        <form action="frontend/searchdoctors" method="get" class="form-div">
                        <div class="row form-inputs">
                            <div class="col-md-12">
                                <div class="country_div">
                                <input type="text" name="country" id="country" class="form-control" placeholder="Search Country" autocomplete="off" value="<?php echo $_GET['country'] ?>">
                                <span class="map-icon"><i class="fa fa-map-marker"></i></span>
                                    <ul class="list-group" id="countrylist">
                                        <?php foreach($countires as $country_val){ ?>
                                        <li class="list-group-item" onclick="countryval('<?php echo $country_val->country ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $country_val->country ?> </li>
                                        <?php } ?>
                                    </ul> 
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <div class="city_div">
                                <input type="text" name="city" id="city" class="form-control" value="<?php echo $_GET['city']; ?>" placeholder="Search City" readonly autocomplete="off" style="background:#fff;">
                                <span class="map-icon"><i class="fa fa-map-marker"></i></span>
                                <ul class="list-group" id="citylist">
                                    
                                </ul> 
                            </div>
                            <br>
                            </div>
                            <div class="col-md-12">
                                <div class="hospital_div">
                                <input type="text" name="hospital" id="hospital" class="form-control" value="<?php echo $_GET['hospital'] ?>" placeholder="Search Hospital / Clinic" autocomplete="off">
                                <input type="hidden" name="hospital_id" id="hospital_id" class="form-control">
                                <span class="map-icon"><i class="fa fa-hospital-o"></i></span>
                                <ul class="list-group" id="hospitallist">
                                    <?php foreach($hospitals as $hosp){ ?>
                                    <li class="list-group-item" onclick="hospitalval('<?php echo $hosp->name ?>','<?php echo $hosp->id ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $hosp->name ?></li>
                                    <?php } ?>
                                </ul> 
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <div class="speciality_div">
                                <input type="text" name="speciality" id="speciality" class="form-control" value="<?php echo $_GET['speciality'] ?>" placeholder="Search Speciality" autocomplete="off">
                                <span class="map-icon"><i class="fa fa-stethoscope"></i></span>
                                <ul class="list-group" id="specialitylist">
                                    <?php foreach($speciality as $spec_val){ ?>
                                    <li class="list-group-item" onclick="specialityval('<?php echo $spec_val->speciality ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $spec_val->speciality ?></li>
                                    <?php } ?>
                                </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-success btn-block submitbtn"> Search </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <?php if(count($doctors)==0){ ?>
                        <h3 class="text-center">No Result found</h3>
                    <?php } foreach($doctors as $doc_val){ ?>
                    <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center" style="padding-right:0px;">
                            <img src="<?php if($doc_val->img_url==""){ echo './uploads/default.jpg';}else{ echo $doc_val->img_url; } ?>" width="115" class="" style="">
                        </div>
                        <div class="col-md-9">
                            <h4><?php echo $doc_val->name ?></h4>
                            <p><i class="fa fa-map-marker"></i> &nbsp;<?php echo $doc_val->address ?></p>
                            <p><i class="fa fa-bookmark"></i> &nbsp;<?php echo $doc_val->profile ?></p>
                            <br>
                            <p><a href="javascript:void(0)" id="book_app_<?php echo $doc_val->id ?>" onclick="showdoctorslots(<?php echo $doc_val->id ?>)" class="btn btn-info"> <i class="fa fa-calendar"></i>&nbsp; Book Appointment </a></p>
                        </div>
                        <div class="col-md-12 doctor_slots<?php echo $doc_val->id ?>" style="display:none">
                            <div class="picker<?php echo $doc_val->id ?>"></div>
                        </div>
                    </div>
                    </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!--container end-->

    <!--footer start-->
    <footer class="footer" id="contact">
        <p class="text-center">© 2020 Copyright CallGPNow. All Rights Reserved.</p>
        <div class="container" style="display:none">
            <div class="row">
                <div class="col-lg-3 col-sm-3">
                    <h1>contact info</h1>
                    <address>
                        <p>Address: <?php echo $settings->address; ?></p>

                        <p>Phone : <?php echo $settings->phone; ?></p>
                        <p>Email : <a href="javascript:;"><?php echo $settings->email; ?></a></p>
                    </address>
                </div>
                <div class="col-lg-5 col-sm-5">
                    <h1>latest tweet</h1>
                    <div class="tweet-box">
                        <i class="fa fa-twitter"></i>
                        <em>Please follow <a href="<?php echo $settings->twitter_id; ?>">@<?php echo $settings->twitter_username; ?></a> for all future updates of us! </em>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-lg-offset-1">
                    <h1>stay connected</h1>
                    <ul class="social-link-footer list-unstyled">
                        <li><a href="<?php echo $settings->facebook_id; ?>"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php echo $settings->google_id; ?>"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="<?php echo $settings->twitter_id; ?>"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="<?php echo $settings->skype_id; ?>"><i class="fa fa-skype"></i></a></li>
                        <li><a href="<?php echo $settings->youtube_id; ?>"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--footer end-->
    <!--Book appointment Modal-->
    <button data-toggle="modal" data-target="#BookAppointmentModal" id="showboomdal" style="display:none">open modal</button>
    <div class="modal fade" id="BookAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Book Appointment</h4>
            </div>
            <div class="modal-body">
                <div class="text-center loaderhere">
                    <img src="uploads/loader.gif" width='30'><br>Please Wait...
                </div>
                <div class="doctor_data" style="display:none">
                    dotor profile
                </div>
                <div class="login_form" style="display:none;">
                    <form action="javascript:void(0)" id="loginAjaxform" method="post">
                        <div class="form-group">
                            <label style="color:red;display:none;" id="login_err">Invalid Email or Password</label>
                        </div>
                        <div class="form-group">
                            <label>Phone number / Email-ID</label>
                            <input type="text" name="identity" class="form-control" placeholder="Enter Phone number or Email-ID" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-lg btn-login btn-block" type="submit" name="submit" value="submit"> Login <img src="uploads/loader.gif" width='20' class="login_loader" style="display:none"></button>
                        </div>
                    </form>
                </div>
                <div class="appointment_div" style="display:none;">
                <form role="form" action="javascript:void(0)" id="appointmentAjaxform" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="panel">
                        <label for="exampleInputEmail1"> Reason </label>
                        <textarea class="form-control" name="remarks" placeholder="Enter reason" rows="5" required></textarea>
                        <input type="hidden" name="patient" id="patient_id" value="">
                        <input type="hidden" name="redirect" id="redirect_url" value="">
                        <input type="hidden" name="request" value="Yes">
                        <input type="hidden" name="doctor" id="doctor_id" value="">
                        <input type="hidden" name="date" id="appointment_date" value="">
                        <input type="hidden" name="time_slot" id="appointment_time_slot" value="">
                        <input type="hidden" name="status" id="" value="Requested">
                    </div>
                    <div class="panel">
                        <input type="checkbox" name="sms" value="sms"> Send SMS<br>
                    </div>
                    <div class="col-md-12 panel">
                        <button type="submit" name="submit" class="btn btn-info pull-right btn-appointment"> Book Appointment <img src="uploads/loader.gif" width='20' class="book_app_loader" style="display:none"></button>
                    </div>
                </form>
                </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!--End here-->
    <!--Appointment Success Modal-->
    <!-- Modal HTML -->
    <style>
    .modal-confirm {		
	color: #434e65;
	width: 525px;
    }
    .modal-confirm .modal-content {
    	padding: 20px;
    	font-size: 16px;
    	border-radius: 5px;
    	border: none;
    }
    .modal-confirm .modal-header {
    	background: #47c9a2;
    	border-bottom: none;   
    	position: relative;
    	text-align: center;
    	margin: -20px -20px 0;
    	border-radius: 5px 5px 0 0;
    	padding: 35px;
    }
    .modal-confirm h4 {
    	text-align: center;
    	font-size: 36px;
    	margin: 10px 0;
    }
    .modal-confirm .form-control, .modal-confirm .btn {
    	min-height: 40px;
    	border-radius: 3px; 
    }
    .modal-confirm .close {
    	position: absolute;
    	top: 15px;
    	right: 15px;
    	color: #fff;
    	text-shadow: none;
    	opacity: 0.5;
    }
    .modal-confirm .close:hover {
    	opacity: 0.8;
    }
    .modal-confirm .icon-box {
    	color: #fff;		
    	width: 95px;
    	height: 95px;
    	display: inline-block;
    	border-radius: 50%;
    	z-index: 9;
    	border: 5px solid #fff;
    	padding: 15px;
    	text-align: center;
    }
    .modal-confirm .icon-box i {
    	font-size: 50px;
    	margin: 4px 0px 0 0px;
    }
    .modal-confirm.modal-dialog {
    	margin-top: 80px;
    }
    .modal-confirm .btn, .modal-confirm .btn:active {
    	color: #fff;
    	border-radius: 4px;
    	background: #eeb711 !important;
    	text-decoration: none;
    	transition: all 0.4s;
    	line-height: normal;
    	border-radius: 30px;
    	margin-top: 10px;
    	padding: 6px 20px;
    	border: none;
    }
    .modal-confirm .btn:hover, .modal-confirm .btn:focus {
    	background: #eda645 !important;
    	outline: none;
    }
    .modal-confirm .btn span {
    	margin: 1px 3px 0;
    	float: left;
    }
    .modal-confirm .btn i {
    	margin-left: 1px;
    	font-size: 16px;
    	float: right;
    }
    .trigger-btn {
    	display: none;
    }
    </style>
    <button data-target="#myAppSuccessModal" id="successModalBtn" class="trigger-btn"  data-toggle="modal">Click to Open Success Modal</button>
    <div id="myAppSuccessModal" class="modal fade">
    	<div class="modal-dialog modal-confirm">
    		<div class="modal-content">
    			<div class="modal-header justify-content-center">
    				<div class="icon-box">
    					<i class="fa fa-check"></i>
    				</div>
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    			</div>
    			<div class="modal-body text-center">
    				<h4>Thank You!</h4>	
    				<p>Your Appointment has been sent successfully. You will get a confirmation email / text soon.</p>
    				<button class="btn btn-success" data-dismiss="modal" id="myappointments"><span> My Appointments </span> &nbsp;<i class="fa fa-arrow-right"></i></button>
    			</div>
    		</div>
    	</div>
    </div> 
    <!--Success Modal End here-->
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="front/js/jquery.js"></script>
    <script src="front/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="front/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="front/js/hover-dropdown.js"></script>
    <script defer src="front/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="front/assets/bxslider/jquery.bxslider.js"></script>

    <script type="text/javascript" src="front/js/jquery.parallax-1.1.3.js"></script>

    <script src="front/js/jquery.easing.min.js"></script>
    <script src="front/js/link-hover.js"></script>

    <script src="front/assets/fancybox/source/jquery.fancybox.pack.js"></script>

    <script type="text/javascript" src="front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <!--common script for all pages-->
    <script src="front/js/common-scripts.js"></script>
    <script src="common/slots_calendar/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="common/slots_calendar/js/mark-your-calendar.js"></script>
    <script type="text/javascript">
        
        <?php foreach($doctors as $doc_val){ ?>
            (function($) {
            <?php 
                $Satday = array();
            	$Sunday = array();
            	$Monday = array();
            	$Tueday = array();
            	$Wedday = array();
            	$Thuday = array();
            	$Friday = array();
            	
            	$Satday_i = array();
            	$Sunday_i = array();
            	$Monday_i = array();
            	$Tueday_i = array();
            	$Wedday_i = array();
            	$Thuday_i = array();
            	$Friday_i = array();
            // 	$i=0;
            	$doctor_slots = $this->frontend_model->getAvailableSlotByDoctorByDate2($doc_val->id);
            	foreach($doctor_slots as $row)
            	{
            		if($row->weekday=="Saturday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Saturday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Satday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Satday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
    
            		if($row->weekday=="Sunday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Sunday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Sunday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Sunday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
    
            		if($row->weekday=="Monday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Monday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Monday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Monday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
    
            		if($row->weekday=="Tuesday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Tuesday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Tueday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Tueday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
    
            		if($row->weekday=="Wednesday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Wednesday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Wedday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Wedday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
    
            		if($row->weekday=="Thursday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Thursday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Thuday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Thuday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
    
            		if($row->weekday=="Friday")
            		{
            		    $date_s = date('d-m-Y', strtotime('Friday'));
            		    $s_time = $row->s_time.' To '.$row->e_time;
            		    $data_ar = array($date_s,$doc_val->id,$s_time);
            		    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
            		    if($slot_booked_res==0){
            			$Friday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		    }
            		    $Friday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doc_val->id;
            		}
            	}
            	$Satday = json_encode($Satday);
    			$Sunday = json_encode($Sunday);
    			$Monday = json_encode($Monday);
    			$Tueday = json_encode($Tueday);
    			$Wedday = json_encode($Wedday);
    			$Thuday = json_encode($Thuday);
    			$Friday = json_encode($Friday);
            // For all slots
                $Satday_i = json_encode($Satday_i);
    			$Sunday_i = json_encode($Sunday_i);
    			$Monday_i = json_encode($Monday_i);
    			$Tueday_i = json_encode($Tueday_i);
    			$Wedday_i = json_encode($Wedday_i);
    			$Thuday_i = json_encode($Thuday_i);
    			$Friday_i = json_encode($Friday_i);
            ?>
        	var Satday = <?php echo $Satday ?>;
			var Sunday = <?php echo $Sunday ?>;
			var Monday = <?php echo $Monday ?>;
			var Tueday = <?php echo $Tueday ?>;
			var Wedday = <?php echo $Wedday ?>;
			var Thuday = <?php echo $Thuday ?>;
			var Friday = <?php echo $Friday ?>;
// 			For all slots
            var Satday_i = <?php echo $Satday_i ?>;
			var Sunday_i = <?php echo $Sunday_i ?>;
			var Monday_i = <?php echo $Monday_i ?>;
			var Tueday_i = <?php echo $Tueday_i ?>;
			var Wedday_i = <?php echo $Wedday_i ?>;
			var Thuday_i = <?php echo $Thuday_i ?>;
			var Friday_i = <?php echo $Friday_i ?>;
			
			var doctor_id = <?php echo $doc_val->id ?>;
// 			var time_array_t = [Sunday,Monday,Tueday,Wedday,Thuday,Friday,Satday];
			var day_of_week = new Date().getDay();
			var list = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
            var sorted_list = list.slice(day_of_week).concat(list.slice(0,day_of_week));
            var final_time_array = [];
            var final_nav_time_array = [];
            var final_time_array_i = [];
            for(var i=0; i<sorted_list.length;)
            {
                if(sorted_list[i]=="Sun")
                {
                    final_time_array.push(Sunday);
                    final_time_array_i.push(Sunday_i);
                }
                if(sorted_list[i]=="Mon")
                {
                    final_time_array.push(Monday);
                    final_time_array_i.push(Monday_i);
                }
                if(sorted_list[i]=="Tue")
                {
                    final_time_array.push(Tueday);
                    final_time_array_i.push(Tueday_i);
                }
                if(sorted_list[i]=="Wed")
                {
                    final_time_array.push(Wedday);
                    final_time_array_i.push(Wedday_i);
                }
                if(sorted_list[i]=="Thu")
                {
                    final_time_array.push(Thuday);
                    final_time_array_i.push(Thuday_i);
                }
                if(sorted_list[i]=="Fri")
                {
                    final_time_array.push(Friday);
                    final_time_array_i.push(Friday_i);
                }
                if(sorted_list[i]=="Sat")
                {
                    final_time_array.push(Satday);
                    final_time_array_i.push(Satday_i);
                }
                i++;
            }
            console.log(final_time_array);
			//console.log(<?php //echo json_encode($slot_booked_res); ?>);
// 			var time_array = [Sunday,Monday,Tueday,Wedday,Thuday,Friday,Satday];
          $('.picker<?php echo $doc_val->id ?>').markyourcalendar({
            availability: 
            final_time_array,
            // isMultiple: true,
            startDate: new Date(),
            onClick: function(ev, data) {
                $('#showboomdal').click();
                $('.loaderhere').fadeIn('slow');
                var d = data[0].split(' ')[0];
                var t = data[0].split(' ')[1] +' '+ data[0].split(' ')[2] +' '+ data[0].split(' ')[3] +' ' + data[0].split(' ')[4] +' '+ data[0].split(' ')[5];
                var doc_id = data[0].split('_')[1];
                $('#doctor_id').val(doc_id);
                $('#appointment_date').val(d);
                $('#appointment_time_slot').val(t);
                $.post('frontend/checkthistimeslots',{date:d,time:t,docId:doc_id},function(result){
                    $('.loaderhere').fadeOut('slow');
                    var obj = JSON.parse(result);
                    if(obj['status']=='not_login')
                    {
                        $('.login_form').fadeIn('slow');
                        return;
                    }
                    else
                    {
                        if(obj['app_count'] > 0)
                        {
                            alert('Time slot already booked.');
                            $('.close').click();
                            $(this).removeClass('selected');
                        }
                        else
                        {
                            $('#patient_id').val(obj['p_id']);
                            $('.appointment_div').fadeIn('slow'); 
                        }
                    }
                });
              // data is a list of datetimes
              console.log(d,t,doc_id);
            },
            onClickNavigator: function(ev, instance) {
              var arr = 
                final_time_array_i
              instance.setAvailability(arr);
            }
          });
    //      
            })(jQuery);
            
          <?php } ?>
    </script>
    <script>
    $(document).ready(function(){
      $("#country").on("keyup focus", function() {
        $('#countrylist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#countrylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      $("#city").on("keyup focus", function() {
        if($("#country").val() !="")
        {
            $('#citylist').fadeIn('slow');
        }
        var value = $(this).val().toLowerCase();
        $("#citylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      $("#hospital").on("keyup focus", function() {
        $('#hospitallist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#hospitallist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      $("#speciality").on("keyup focus", function() {
        $('#specialitylist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#specialitylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
    });
    
    $(document).mouseup(function(e) 
    {
        var container = $(".country_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            $('#countrylist').hide();
        }
        var container1 = $(".city_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
        {
            $('#citylist').hide();
        }
        
        var container1 = $(".hospital_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
        {
            $('#hospitallist').hide();
        }
        
        var container1 = $(".speciality_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
        {
            $('#specialitylist').hide();
        }
        
    });
    $('#loginAjaxform').on('submit', function(e){
        e.preventDefault();
        $('.login_loader').fadeIn('slow');
        $('.btn-login').prop('disabled',true);
        var form = $('#loginAjaxform').serialize();
        $.post('frontend/userauthenticate',form,function(result){
            $('.login_loader').fadeOut('slow');
            $('.btn-login').prop('disabled',false);
            // console.log(result); return;
            var obj = JSON.parse(result);
            if(obj['status']=='loggedin')
            {
                $('#login_err').fadeOut('slow');
                $('.login_form').fadeOut('slow');
                $('.appointment_div').fadeIn('slow'); 
                $('#patient_id').val(obj['p_id']);
                $('.loggedli').fadeIn('slow');
                $('.loginli').fadeOut('slow');
            }
            else
            {
                //$this->ion_auth->user()->row()->user_id
                $('#login_err').fadeIn('slow');
                return;
                // console.log('Invalid data');
            }
            // $('#citylist').html(result);
        });
    });
    $('#appointmentAjaxform').on('submit', function(e){
        $('.book_app_loader').fadeIn('slow');
        $('.btn-appointment').prop('disabled', true);
        var form = $('#appointmentAjaxform').serialize();
        $.post('appointment/addNewApp',form,function(result){
            $('.book_app_loader').fadeOut('slow');
            $('.btn-appointment').prop('disabled', false);
            var obj = JSON.parse(result);
            if(obj['status']=='done')
            {
                if($('.close').click()){
                $('#successModalBtn').click();
                }
            }
            console.log(obj['status']);
        });
    });
    $('.close').on('click', function(e){
        $('.myc-available-time').removeClass('selected');
        $('.appointment_div').fadeOut('slow');
    });
    $(document).mouseup(function(e) 
    {
        var container = $(".modal-content");
    
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            $('.myc-available-time').removeClass('selected');
            $('.appointment_div').fadeOut('slow');
        }
    });
    $('#myappointments').on('click', function(){
       window.location.href = 'patient/medicalHistory'; 
    });
    <?php if($_GET['country'] !=""){ ?>
        $('#city').prop('readonly',false);
        countryval2('<?php echo $_GET['country']; ?>');
        function countryval2(val)
        {
            $.post('frontend/getcities',{country_id:val},function(result){
                $('#citylist').html(result);
            });
        }
    <?php } ?>
    function countryval(val)
    {
        $('#city').val('');
        $('#city').attr('placeholder','Please wait...');
        $.post('frontend/getcities',{country_id:val},function(result){
            $('#city').attr('placeholder','Search City');
            $('#citylist').html(result);
            $('#city').prop('readonly',false);
            $('#city').focus();
        });
        $('#country').val(val);
        $('#countrylist').hide();
    }
    function cityval(val)
    {
        $('#city').val(val);
        $('#citylist').hide();
    }
    function hospitalval(val,id)
    {
        $('#hospital').val(val);
        $('#hospital_id').val(id);
        $('#hospitallist').hide();
    }
    function specialityval(val)
    {
        $('#speciality').val(val);
        $('#specialitylist').hide();
    }
    
    function showdoctorslots(id)
    {
        $('#book_app_'+id).attr('onclick','hidedoctapp('+id+')');
        $('.doctor_slots'+id).fadeIn('slow');
    }
    function hidedoctapp(id)
    {
        $('#book_app_'+id).attr('onclick','showdoctorslots('+id+')');
        $('.doctor_slots'+id).fadeOut('slow');
    }
    
    </script>
</body>
</html>




