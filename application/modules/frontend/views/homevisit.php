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

        </style>


    </head>

    <body>
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
                            <li><a href="frontend/bookappointment">Urgent Consultation</a></li> 
                            <li><a href="https://pharmacy.callgpnow.com/main">Pharmacy</a></li> 
                            <li class="active"><a href="javascript:void(0)">Home Visit</a></li>
                            <li><a href="frontend#appointment">Register Your Hospital Software</a></li>
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
                            <li class="active" <?php echo $displaynone; ?>><a href="auth/login"><i class="fa fa-sign-in"></i> Login / Signup</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!--header end--> 
        <style>
                    .margin-div
                    {
                        width: 100%;
                        margin: 0 auto;
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
                    .fullwidthbanner-container
                    {
                        background: rgba(0, 0, 0, 0) url("uploads/doctors-home-visit.jpg") no-repeat scroll 50% 0px;
                        padding: 50px 0px 50px 0px;
                        background-position: center;
                        position: relative;
                    }
                    .bgoverlay
                    {
                        content: "";
                        background: #00adee;
                        position: absolute;
                        top:0;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        opacity: 0.7;
                    }
                    .danger
                    {
                        color: red;
                    }
                    .home-form{
                        background: #00adee;
                        padding: 25px;
                        color: #FFF;
                        border-radius: 50px;
                    }
                    .home-form input, select
                    {
                        color: #000 !important;
                    }
                    input[type="date"]
                    {
                        line-height: inherit !important;
                    }
                </style>
        <!-- revolution slider start -->
        <div class="fullwidthbanner-container">
          <div class="container" style="z-index: 1;position: relative;">
              <h1 class="text-center" style="color: #fff;font-weight: bold;">Doctor Home Visit</h1>
              <p class="text-center" style="color: #fff;font-weight: bold;"><a href="frontend">Home</a> / Doctor Home Visit</p>
            <div class="margin-div">
            </div>
          </div>
          <div class="bgoverlay"></div>
        </div>
        <!-- revolution slider end -->

        <!--container start-->
        <div class="container">
            <br>
            <h2 class="text-center">COVID-19</h2>
            <p class="text-center">If you have any of the symptoms listed below, please do not book a home visit appointment.</p>
            <p class="text-center">Fever, cough, loss of smell & taste, breathing difficulties, chest tightness & wheezing.</p>
            <br>
            <div class="text-center home-visit-steps">
                <p><img src="uploads/one.png" width="120"></p>
                <p>Our highly experienced GPs will come straight to you for a doctor home visit. </p>
                <p>You don’t have to leave the comfort of your home, office, gym or wherever you may be. Simply let us know where to come and <br>we’ll be there as soon as possible!</p>
            </div>
            <br>
            <div class="text-center home-visit-steps">
                <p><img src="uploads/two.png" width="120"></p>
                <p>Our doctor home visits will be for a 20-minute consultation with you in which you will be given a <br>prescription or referral accordingly free of charge. </p>
                <p>You will also be able to request a sick form or other documentation as appropriate.</p>
            </div>
            <br>
            <div class="text-center home-visit-steps" id="msgid">
                <p><img src="uploads/three.png" width="120"></p>
                <p>Book your appointment down below or via the App.</p>
                <p>Once your booking is complete a member of the team will be in touch to schedule a specific time for you.</p>
            </div>
            <br>
            <?php if($this->session->flashdata("appointment_success")==true){ ?>
            <div class="alert alert-success"><span class="badge badge-success">Alert!</span> Your Appointment has been successfully sent. You will get a confirmation Email shortly.</div>
            <?php } ?>
            <form role="form" action="request/homevisit" class="clearfix home-form" method="post">
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Reason For Booking <span class="danger">*</span></label>
                            <input type="text" class="form-control pay_in" name="reason" placeholder="Reason For Booking" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Hospital / Clinic <span class="danger">*</span></label>
                            <select name="hospital_id" class="form-control">
                                <option value="">Select Hospital / Clinic</option>
                                <?php foreach($hospitals as $value){ ?>
                                <option value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Date Of Birth <span class="danger">*</span></label>
                            <input type="date" class="form-control pay_in" name="birth_date" placeholder="Full Name" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Full Name <span class="danger">*</span></label>
                            <input type="text" class="form-control pay_in" name="fullname" placeholder="Full Name" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Email <span class="danger">*</span></label>
                            <input type="email" class="form-control pay_in" name="email" placeholder="Email" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="clearfix">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Phone Number <span class="danger">*</span></label>
                            <input type="text" class="form-control pay_in" name="phone" placeholder="Phone Number" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Date <span class="danger">*</span></label>
                            <input type="date" class="form-control pay_in" name="appointment_date" placeholder="Date" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Preferred Time <span class="danger">*</span></label>
                            <select name="preferredtime" class="form-control">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="clearfix">
                        <div class="col-md-12 payment pad_bot">
                            <label for="exampleInputEmail1"> Address <span class="danger">*</span></label>
                            <input type="text" class="form-control pay_in" name="address" placeholder="Address" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <br>
                    <input type="hidden" name="p_id" value="13">
                    <button type="submit" name="submit" class="btn btn-success btn-lg"> <?php echo 'Book Appointment'; ?></button>
                </div>
            </form>
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

    <script src="front/js/revulation-slide.js"></script>


    <script>
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
        $(window).load(function () {
            $('[data-zlname = reverse-effect]').mateHover({
                position: 'y-reverse',
                overlayStyle: 'rolling',
                overlayBg: '#fff',
                overlayOpacity: 0.7,
                overlayEasing: 'easeOutCirc',
                rollingPosition: 'top',
                popupEasing: 'easeOutBack',
                popup2Easing: 'easeOutBack'
            });
        });
        $(window).load(function () {
            $('.flexslider').flexslider({
                animation: "slide",
                start: function (slider) {
                    $('body').removeClass('loading');
                }
            });
        });
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




