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
        <!--<link rel="stylesheet" href="front/css/flexslider.css"/>-->
        <!--<link href="front/assets/bxslider/jquery.bxslider.css" rel="stylesheet" />-->
        <link href="front/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />

        <!--<link rel="stylesheet" href="front/assets/revolution_slider/css/rs-style.css" media="screen">-->
        <!--<link rel="stylesheet" href="front/assets/revolution_slider/rs-plugin/css/settings.css" media="screen">-->

        <!-- Custom styles for this template -->
        <link href="front/css/style.css" rel="stylesheet">
        <link href="front/css/style-responsive.css" rel="stylesheet" />
        <script src="front/js/jquery.js"></script>
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
                background: #009988;
                color: #fff;
                padding: 23px;
            }

            .appointment{
                padding: 0px 95px;
            }

            .panel{
                background: none;
            }

            label{
                width: 100%;
                line-height: 25px;
                font-size: 14px;
                font-weight: 400;
                text-transform: uppercase;
                font-family: 'Fjalla One', sans-serif;
            }

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
            
            .header-frontend
            {
                padding: 0px 25px;
            }

        </style>


    </head>

    <body>
        <!--header start-->
        <header class="header-frontend">
            <div class="navbar navbar-default navbar-static-top">
                <div class="container-fluid">
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
                    
                    div#google_translate_element select.goog-te-combo {
                        max-width: 111px !important;
                        /*background: #fff;*/
                        font-weight: 700;
                        background: #f7f7f7;
                        padding: 6px 8px !important;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                    }
                    .goog-te-banner-frame.skiptranslate {
                        display: none !important;
                    }
                    body {
                        top: 0px !important;
                    }
                    div#google_translate_element select.goog-te-combo {
                        max-width: ;
                        background: #fff;
                        font-weight: 700;
                        font-family: Nunito, apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    }
                    </style>
                    <div class="navbar-collapse collapse ">
                        <ul class="nav navbar-nav">
                            <li class=""><a href="frontend#">Home</a></li>
                            <li><a href="frontend/bookappointment">Urgent Consultation</a></li> 
                            <li><a href="https://pharmacy.callgpnow.com/main">Pharmacy</a></li> 
                            <li><a href="frontend/doctorvisit">Home Visit</a></li>
                            <li><a href="javascript:void(0)" id="appointment">Register Your Hospital or Clinic</a></li>
                            <!--<li><a href="frontend#contact">Contact</a></li>-->
                            <?php $displaynone = ""; if ($this->ion_auth->in_group(array('Patient'))) { $displaynone = "style='display:none'"; $icon_display = "style='display:block'";}else{ $displaynone = "style='display:block'"; $icon_display = "style='display:none'"; } ?>
                            <li class="dropdown" <?php echo $icon_display; ?>><a href="javascript:void(0)" style="border:1px solid #797979; border-radius: 100px;"><i class="fa fa-user"></i></a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="patient/medicalHistory">My Appointments</a></li>
                                    <li><a href="profile">Profile</a></li>
                                    <li><a href="auth/logout">Logout</a></li>
                                </ul>
                            </div>
                            </li>
                            <li>
                                <div id="google_translate_element" style="padding-right: 15px;"></div>
                                <script type="text/javascript">
                                function googleTranslateElementInit() {
                                    // var userLang = navigator.language || navigator.userLanguage;
                                    // console.log(userLang);
                                  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
                                }
                                function changeLanguageText() 
                                {
                                    if ($('.goog-te-combo option:first-child').text() == "Select Language") 
                                    {    
                                        $(".goog-logo-link").empty();
                                        $('.goog-te-gadget').html($('.goog-te-gadget').children());
                                        // $('.goog-te-gadget').css('display','none').children();
                                        $('.goog-te-combo').css("color","");
                                        // $('.goog-te-combo').prepend("<option value='' selected>Language</option>");
                                        $('.goog-te-combo option:first-child').text('Languages');
                                    } 
                                    else
                                    {
                                        setTimeout(changeLanguageText, 50);
                                    }
                                }
                                changeLanguageText();
                                </script>
                                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                            </li>
                            <li class="active" <?php echo $displaynone; ?>><a href="auth/login"><i class="fa fa-sign-in"></i> Login / Signup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!--header end--> 



        <!-- revolution slider start -->
        <div class="fullwidthbanner-container">
            <div class="fullwidthabnner" style="position:relative">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="uploads/bannerimg11.jpg" alt="First slide">
                        <!--<div class="carousel-caption">-->
                        <!--    <h3>-->
                        <!--        First slide</h3>-->
                        <!--    <p>-->
                        <!--        Nulla vitae elit libero, a pharetra augue mollis interdum.</p>-->
                        <!--</div>-->
                    </div>
                    <div class="item">
                        <img src="uploads/phoneappoint11.jpg" alt="Second slide">
                    </div>
                    <div class="item">
                        <img src="uploads/tabletappoint11.jpg" alt="Third slide">
                    </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control"
                                href="#carousel-example-generic" data-slide="next"><span class="glyphicon glyphicon-chevron-right">
                                </span></a>
                    </div>
                    <div class="appointment-form hidden-xs">
                        <div class="">
                        <h1 class="text-center form-heading">Find Doctors 24 / 7 Consultation</h1>
                        <!--<h4 class="text-center">Lorem Ipsum is simply dummy text of the printing</h4>-->
                        <br>
                        <form action="frontend/searchdoctors" method="get" class="form-div">
                            <div class="row form-inputs">
                            <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="country_div">
                                    <input type="text" name="country" id="country" class="form-control" placeholder="Search Country" autocomplete="off">
                                    <span class="map-icon"><i class="fa fa-map-marker"></i></span>
                                        <ul class="list-group" id="countrylist">
                                            <?php foreach($countires as $country_val){ ?>
                                            <li class="list-group-item" onclick="countryval('<?php echo $country_val->country ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $country_val->country ?> </li>
                                            <?php } ?>
                                        </ul> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="city_div">
                                    <input type="text" name="city" id="city" class="form-control" placeholder="Search City" readonly autocomplete="off" style="background:#fff;">
                                    <span class="map-icon"><i class="fa fa-map-marker"></i></span>
                                    <ul class="list-group" id="citylist">
                                        
                                    </ul> 
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="hospital_div">
                                    <input type="text" name="hospital" id="hospital" class="form-control" placeholder="Search Hospital / Clinic" autocomplete="off">
                                    <input type="hidden" name="hospital_id" id="hospital_id" class="form-control">
                                    <span class="map-icon"><i class="fa fa-hospital-o"></i></span>
                                    <ul class="list-group" id="hospitallist">
                                        <?php foreach($hospitals as $hosp){ ?>
                                        <li class="list-group-item" onclick="hospitalval('<?php echo $hosp->name ?>','<?php echo $hosp->id ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $hosp->name ?></li>
                                        <?php } ?>
                                    </ul> 
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-7">
                                <div class="speciality_div">
                                <input type="text" name="speciality" id="speciality" class="form-control" placeholder="Search Speciality" autocomplete="off">
                                <span class="map-icon"><i class="fa fa-stethoscope"></i></span>
                                <ul class="list-group" id="specialitylist">
                                    <?php foreach($speciality as $spec_val){ ?>
                                    <li class="list-group-item" onclick="specialityval('<?php echo $spec_val->speciality ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $spec_val->speciality ?></li>
                                    <?php } ?>
                                </ul> 
                                </div>
                            </div>
                                <div class="col-md-5">
                                <button type="submit" class="btn btn-success btn-block submitbtn"> Search </button>
                            </div>
                            </div>
                            </div>
                        </div>
                        </form>
                    <div class="appstore-icon-div">
                        <h4 class=" form-heading">Download The App</h4>
                        <a href="#"><img src="uploads/androidimage1.png" width="120"></a> &nbsp;
                        <a href="#"><img src="uploads/appstore1.png" width="120"></a>
                    </div>
                    </div>
                    </div>
                <!--<div id="myCarousel" class="carousel slide" data-ride="carousel">-->
                      
                      <!-- Wrapper for slides -->
                      <!--<div class="carousel-inner">-->
                      <!--  <div class="item active">-->
                      <!--    <img src="uploads/bannerimg.jpg" alt="Los Angeles">-->
                      <!--  </div>-->
                    
                      <!--  <div class="item">-->
                      <!--    <img src="uploads/phoneappoint.jpg" alt="Chicago">-->
                      <!--  </div>-->
                    
                      <!--  <div class="item">-->
                      <!--    <img src="uploads/tabletappoint.jpg" alt="New York">-->
                      <!--  </div>-->
                      <!--</div>-->
                    
                      <!-- Left and right controls -->
                      
                      
                   
                      
                    <!--</div>-->
                <!--<ul id="revolutionul" style="display:none;">-->
                    <!-- 1st slide -->
                    <style>
                        .margin-div
                        {
                            width: 100%;
                            margin: 0 auto;
                            padding: 100px 0px 165px;
                        }
                        .form-div{
                            background-color: #00aeef9e;
                            padding: 28px 15px;
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
                            max-height: 200px;
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
                    </style>
                    <!--<style>
                    /*    .slide_item_left{*/
                    /*        top: 0px !important;*/
                    /*        left: 0px !important;*/
                    /*        background-size: contain !important;*/
                    /*        position: absolute;*/
                    /*        top: 0;*/
                    /*        left: 0;*/
                    /*        right: 0;*/
                    /*        bottom: 0;*/
                    /*        background-image: url("path/to/img");*/
                    /*        background-repeat: no-repeat;*/
                    /*        background-size: contain;*/
                    /*    }*/
                    /*    .slide_item_left img{*/
                    /*        background-size: cover !important;*/
                    /*    }*/
                    /*</style> */-->
                    

                    <?php
                    // foreach ($slides as $slide) {
                    //     if ($slide->status == 'Active') {
                            ?>
                            <!--<li data-transition="fade" data-slotamount="8" data-masterspeed="700" data-delay="5000" data-thumb="">-->
                            <!--    <div class="caption lfl slide_item_left"-->
                            <!--         data-x="10"-->
                            <!--         data-y="70"-->
                            <!--         data-speed="400"-->
                            <!--         data-start="0"-->
                            <!--         data-easing="easeOutBack">-->
                            <!--        <img src="<?php echo $slide->img_url; ?>" alt="Image 1">-->
                            <!--    </div>-->
                            <!--    <div class="caption lfr slide_title"-->
                            <!--         data-x="670"-->
                            <!--         data-y="120"-->
                            <!--         data-speed="400"-->
                            <!--         data-start="0"-->
                            <!--         data-easing="easeOutExpo">-->
                            <!--             <?php echo $slide->text1; ?>-->
                            <!--    </div>-->

                            <!--    <div class="caption lfr slide_subtitle dark-text"-->
                            <!--         data-x="670"-->
                            <!--         data-y="190"-->
                            <!--         data-speed="400"-->
                            <!--         data-start="500"-->
                            <!--         data-easing="easeOutExpo">-->
                            <!--             <?php echo $slide->text2; ?>-->
                            <!--    </div>-->
                            <!--    <div class="caption lfr slide_desc"-->
                            <!--         data-x="680"-->
                            <!--         data-y="260"-->
                            <!--         data-speed="400"-->
                            <!--         data-start="500"-->
                            <!--         data-easing="easeOutExpo">-->
                            <!--             <?php echo $slide->text3; ?>-->
                            <!--    </div>-->
                            <!--</li>-->

                            <?php
                    //     }
                    // }
                    ?>

                    <!-- 2nd slide  -->




                <!--</ul>-->
                <!--<div class="tp-bannertimer tp-top"></div>-->
            </div>
        </div>
        <!-- revolution slider end -->

        <!--container start-->
        <div class="container">
            <div class="row">
                <!--feature start-->
                <div class="padd_div text-center">
                    <h1><?php echo $settings->title; ?></h1>
                    <p><?php echo $settings->block_1_text_under_title; ?></p>
                </div>
                <?php
                $message = $this->session->flashdata('feedback');
                if (!empty($message)) {
                    ?>
                    <div class="flashmessage col-md-12"> <?php echo $message; ?></div>

                <?php } ?>
                <div class="col-lg-3 col-sm-4">
                    <section>
                        <a href="frontend/bookappointment">
                        <div class="f-box">
                            <i class=" fa fa-phone"></i>
                            <h2> Urgent Consultation <?php //echo $settings->emergency; ?> </h2>
                        </div>
                        <p class="f-text"></p>
                        </a>
                    </section>
                </div>
                <div class="col-lg-3 col-sm-4">
                    <section>
                        <a href="#">
                        <div class="f-box">
                            <i class=" fa fa-calendar-o"></i>
                            <h2> Book an Appointment <?php //echo $settings->emergency; ?> </h2>
                        </div>
                        <p class="f-text"></p>
                        </a>
                    </section>
                </div>
                <div class="col-lg-3 col-sm-4">
                    <section>
                        <a href="frontend/doctorvisit">
                        <div class="f-box">
                            <i class=" fa fa-home"></i>
                            <h2> Home Visit <?php //echo $settings->emergency; ?> </h2>
                        </div>
                        <p class="f-text"></p>
                        </a>
                    </section>
                </div>
                <!--<div class="col-lg-3 col-sm-4">-->
                <!--    <section>-->
                <!--        <div class="f-box active">-->

                <!--            <a id="appointment" class="btn btn-danger purchase-btn" target="_blank"> <i class=" fa fa-calendar-o"></i> Register Your Hospital</a>-->
                <!--        </div>-->

                <!--    </section>-->
                <!--</div>-->
                <div class="col-lg-3 col-sm-4">
                    <section>
                        <a href="https://pharmacy.callgpnow.com/main"> 
                        <div class="f-box">
                            <i class="fa fa-heart-o"></i>
                            <h2>Pharmacy</h2>
                        </div>
                        </a>
                    </section>
                </div>




                <!--feature end-->
            </div>




            <div class="row appointment" style="display: none;">


                <!-- Add Appointment Modal-->

                <div class="modal-body">
                    <form role="form" action="request/addNew" class="clearfix" method="post">
                        <div class="col-md-6">
                            <div class="clearfix">
                                <div class="col-md-12 payment pad_bot pull-right">
                                    <label for="exampleInputEmail1"> Hospital Name</label>
                                    <input type="text" class="form-control pay_in" name="name" id="hosp_name" value='' placeholder="">
                                </div>
                                <div class="col-md-12 payment pad_bot pull-right">
                                    <label for="exampleInputEmail1"> Hospital Address</label>
                                    <input type="text" class="form-control pay_in" name="address" value='' placeholder="">
                                </div>
                                <div class="col-md-12 payment pad_bot pull-right">
                                    <label for="exampleInputEmail1"> Hospital Email</label>
                                    <input type="text" class="form-control pay_in" name="email" value='' placeholder="">
                                </div>
                                <div class="col-md-12 payment pad_bot pull-right">
                                    <label for="exampleInputEmail1"> Hospital Phone</label>
                                    <input type="text" class="form-control pay_in" name="phone" value='' placeholder="">
                                </div>

                                <div class="col-md-12 payment pad_bot pull-right">
                                    <label for="exampleInputEmail1"> Language </label>
                                    <select class="form-control m-bot15" name="language" value=''>
                                        <option value="arabic" <?php
                                        if (!empty($settings->language)) {
                                            if ($settings->language == 'arabic') {
                                                echo 'selected';
                                            }
                                        }
                                        ?>><?php echo lang('arabic'); ?> 
                                        </option>
                                        <option value="english" <?php
                                        if (!empty($settings->language)) {
                                            if ($settings->language == 'english') {
                                                echo 'selected';
                                            }
                                        }
                                        ?>><?php echo lang('english'); ?> 
                                        </option>
                                        <option value="spanish" <?php
                                        if (!empty($settings->language)) {
                                            if ($settings->language == 'spanish') {
                                                echo 'selected';
                                            }
                                        }
                                        ?>><?php echo lang('spanish'); ?>
                                        </option>
                                        <option value="french" <?php
                                        if (!empty($settings->language)) {
                                            if ($settings->language == 'french') {
                                                echo 'selected';
                                            }
                                        }
                                        ?>><?php echo lang('french'); ?>
                                        </option>
                                        <option value="italian" <?php
                                        if (!empty($settings->language)) {
                                            if ($settings->language == 'italian') {
                                                echo 'selected';
                                            }
                                        }
                                        ?>><?php echo lang('italian'); ?>
                                        </option>
                                        <option value="portuguese" <?php
                                        if (!empty($settings->language)) {
                                            if ($settings->language == 'portuguese') {
                                                echo 'selected';
                                            }
                                        }
                                        ?>><?php echo lang('portuguese'); ?>
                                        </option>
                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="col-md-12 panel"> 
                                <label for="exampleInputEmail1">  Package </label>
                                <select class="form-control m-bot15 js-example-basic-single" id="" name="package" value=''>  
                                    <?php foreach ($packages as $package) { ?>
                                        <option value="<?php echo $package->id; ?>"><?php echo $package->name; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>



                            <div class="col-md-12 panel">
                                <label for="exampleInputEmail1"> Remarks </label>
                                <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                            </div>

                        </div>

                        <input type="hidden" name="request" value=''>

                        <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                    </form>
                </div>
            </div>
        </div>



        <div class="gray-box mbot50" id="service" style="display:none">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="text-center feature-head">
                            <h1> Our Services </h1>
                            <p><?php echo $settings->service_block__text_under_title; ?></p>
                        </div>
                        <?php foreach ($services as $service) { ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="content" style="text-align: center; margin: 50px 0px;">
                                    <span class="clearfix"><img style="height: 100px; border-radius: 100px; margin-bottom: 25px;" src="<?php
                                        if (!empty($service->img_url)) {
                                            echo $service->img_url;
                                        } else {
                                            echo 'uploads/default-image.png';
                                        }
                                        ?>"></span>
                                    <h3 class="title"><?php echo $service->title; ?></h3>
                                    <p><?php echo $service->description; ?></p>
                                </div>
                            </div>  

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container" id="doctors" style="display:none">
        <div class="row">
            <div class="text-center feature-head">
                <h1> Package </h1>
                <p><?php echo $settings->doctor_block__text_under_title; ?></p>
            </div>
            <?php
            foreach ($packages as $package) {
                $all_packages[] = $package;
            }


            //   $packages1 = ksort($all_packages);
            if (!empty($all_packages)) {
                foreach ($all_packages as $package1) {
                    if ($package1->show_in_frontend == 'Yes') {
                        ?>
                        <div class="col-lg-3 col-sm-3">
                            <div class="pricing-table">
                                <div class="pricing-head">
                                    <h1> <?php echo $package1->name; ?> </h1>
                                    <h2>
                                        <span class="note">$</span><?php echo $package1->price; ?> </h2>
                                </div>
                                <?php $modules = explode(',', $package1->module) ?>
                                <ul class="list-unstyled">
                                    <?php foreach ($modules as $module) { ?>
                                        <li style="text-transform: capitalize; font-size: 16px;"> <?php echo $module; ?> </li>
                                    <?php } ?>
                                </ul>
                                <div class="price-actions">
                                    <a id="appointment" class="btn" href="frontend#appointment">Get Now</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>




    <!--container end-->

    <!--footer start-->
    <footer class="footer" id="contact">
        <div class="container">
            <p class="text-center">© 2020 Copyright CallGPNow. All Rights Reserved.</p>
            <div class="row" style="display:none">
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








    <!-- js placed at the end of the document so the pages load faster -->
    
    <script src="front/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="front/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="front/js/hover-dropdown.js"></script>
    <!--<script defer src="front/js/jquery.flexslider.js"></script>-->
    <script type="text/javascript" src="common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <!--<script type="text/javascript" src="front/assets/bxslider/jquery.bxslider.js"></script>-->

    <!--<script type="text/javascript" src="front/js/jquery.parallax-1.1.3.js"></script>-->

    <!--<script src="front/js/jquery.easing.min.js"></script>-->
    <!--<script src="front/js/link-hover.js"></script>-->

    <!--<script src="front/assets/fancybox/source/jquery.fancybox.pack.js"></script>-->

    <!--<script type="text/javascript" src="front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>-->
    <!--<script type="text/javascript" src="front/assets/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>-->

    <!--common script for all pages-->
    <script src="front/js/common-scripts.js"></script>

    <!--<script src="front/js/revulation-slide.js"></script>-->

    <script>
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
	if (isMobile) {
  		$('.navbar-brand').find('img').css('width','115px');
	}
        $('.default-date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });


        $('#date').on('changeDate', function () {
            $('#date').datepicker('hide');
        });

        $('#date1').on('changeDate', function () {
            $('#date1').datepicker('hide');
        });


    </script>

    <script>
        $(document).ready(function () {
            $('.timepicker-default').timepicker({defaultTime: 'value'});

        });
    </script>

    <script>

        // RevSlide.initRevolutionSlider();
        // $(window).load(function () {
        //     $('[data-zlname = reverse-effect]').mateHover({
        //         position: 'y-reverse',
        //         overlayStyle: 'rolling',
        //         overlayBg: '#fff',
        //         overlayOpacity: 0.7,
        //         overlayEasing: 'easeOutCirc',
        //         rollingPosition: 'top',
        //         popupEasing: 'easeOutBack',
        //         popup2Easing: 'easeOutBack'
        //     });
        // });
        // $(window).load(function () {
        //     $('.flexslider').flexslider({
        //         animation: "slide",
        //         start: function (slider) {
        //             $('body').removeClass('loading');
        //         }
        //     });
        // });
        //    fancybox
        jQuery(".fancybox").fancybox();
        $(function () {
            $('a[href*=#]:not([href=#])').click(function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top
                        }, 1000);
                        return false;
                    }
                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            $('.pos_client').hide();
            $('.pos_client_id').hide();
            $(document.body).on('change', '#pos_select', function () {

                var v = $("select.pos_select option:selected").val()
                if (v == 'add_new') {
                    $('.pos_client').show();
                    $('.pos_client_id').hide();
                } else if (v == 'patient_id') {
                    $('.pos_client_id').show();
                    $('.pos_client').hide();
                } else {
                    $('.pos_client_id').hide();
                    $('.pos_client').hide();

                }
            });
        });


    </script>


    <script>
        $(document).ready(function () {
            $('.appointment').hide();
            $(document.body).on('click', '#appointment', function () {

                if ($('.appointment').is(":hidden")) {
                    $('.appointment').show();
                    $('html, body').animate({
                        scrollTop: $(".appointment").offset().top
                     }, 1000);
                } else {
                    $('.appointment').hide();

                }
            });
        });


    </script>






    <script type="text/javascript">
        $(document).ready(function () {
            $("#adoctors").change(function () {
                // Get the record's ID via attribute  
                var id = $('#appointment_id').val();
                var date = $('#date').val();
                var doctorr = $('#adoctors').val();
                $('#aslots').find('option').remove();
                // $('#default').trigger("reset");
                $.ajax({
                    url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    var slots = response.aslots;
                    $.each(slots, function (key, value) {
                        $('#aslots').append($('<option>').text(value).val(value)).end();
                    });
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                    }
                    // Populate the form fields with the data returned from server
                    //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                });
            });

        });

        $(document).ready(function () {
            var id = $('#appointment_id').val();
            var date = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });

                $("#aslots").val(response.current_value)
                        .find("option[value=" + response.current_value + "]").attr('selected', true);

                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });

        });




        $(document).ready(function () {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            })
                    //Listen for the change even on the input
                    .change(dateChanged)
                    .on('changeDate', dateChanged);
        });

        function dateChanged() {
            // Get the record's ID via attribute  
            var id = $('#appointment_id').val();
            var date = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + date + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });
                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }


                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });

        }

    </script>

    <script>

        $(document).ready(function () {
            $('.caption img').removeAttr('style');

            var windowH = $(window).width();
            $('.caption img').css('width', (windowH) + 'px');
            $('.caption img').css('height', '500px');

        });

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
        $('#citylist').fadeIn('slow');
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
    
    // $('.form-div').on('submit',function(e){
    //     var isFormValid = true;
    //     $('.form-inputs :input').each(function(){
    //         var input = $(this).val();
    //         if($.trim($(this).val()).length == 0)
    //         {
    //             $(this).css('border','1.5px solid red');
    //             // $(window).scrollTop($(this))
    //             isFormValid = false;
    //         }
    //         else
    //         {
    //             $(this).css('border','');
    //         }
    //     });
    //     if(isFormValid)
    //     {
    //         $('.submitbtn').text('Please Wait...');
    //         $('.form-div').submit();
    //     }
    //     e.preventDefault();
    // });
    
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
    
    </script>

</body>
</html>




