<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
        <link rel="shortcut icon" href="uploads/favicon.png">

        <title>Login - <?php echo $this->db->get('settings')->row()->system_vendor; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <!--<link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />-->
        <!-- Custom styles for this template -->
        <link href="common/css/style.css" rel="stylesheet">
        <link href="common/css/style-responsive.css" rel="stylesheet" />
        <!-- The core Firebase JS SDK is always required and must be listed first -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
<style>
        #countrylist
        {
            display:none;
            position: absolute;
            top: 38px;
            left: 0;
            right: 0;
            z-index:9999;
        }
        
        .country_div
        {
            position: relative;
            display:none;
        }
        #citylist
        {
            display:none;
            position: absolute;
            top: 38px;
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
            display:none;
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
            display:none;
            
        }
        .list-group-item:hover
        {
            cursor: pointer;
            background: lightgrey;
        }
    </style>
    </head>

    <body class="login-body">

        <div class="container">

            <style>


                form{

                    padding: 0px;
                    border: none;


                }
                .email_err
                {
                    color: red;
                }
                .phone_err
                {
                    color: red;
                }


            </style>
            <div class="form-signin" id="scrolldiv">
            <h2 class="login form-signin-heading"><?php echo $this->db->get('settings')->row()->title; ?><br/><br/><img alt="" src="uploads/favicon.png"></h2>
            <div class="login-pills">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" id="login_btn" href="#login">Login</a></li>
                <li><a data-toggle="tab" id="register_btn" href="#registerdiv">Patient Register</a></li>
              </ul>
            </div>
            <div class="tab-content">
            <form id="login" class="tab-pane fade in active" method="post" action="auth/login">
                <div id="infoMessage"><?php echo $message; ?></div>
                <div class="login-wrap">
                    <div class="alert alert-success success_vrfy_msg" style="display:none;"></div>
                    <input type="text" class="form-control" name="identity" placeholder="Mobile number / User Email" autofocus>
                    <input type="password" class="form-control"  name="password" placeholder="Password">    
                          <label class="checkbox">
                              <input type="checkbox" value="remember-me"> Remember me
                              <span class="pull-right">
                                  <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
              
                              </span>
                          </label> 
                  
                    
                    
                    <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
  <style>
                        table, th, td {
                            border: 1px solid #f1f2f7;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 5px;
                            text-align: left;
                            font-size:12px;
                        }
                        .datepick
                        {
                            margin-bottom:0 !important;
                        }
                        /*td,th,h4{*/
                        /*    color:#aaa;*/
                            
                        /*}*/
                    </style>

                </div>

            </form>
            <!--Haseen code-->
            <div id="registerdiv" class="tab-pane fade">
            <form id="register" method="post" action="#" enctype="multipart/form-data">
                <div class="login-wrap">
                <h5 class="areyou text-right btn_doc">Are you a doctor? <a href="javascript:void(0)" id="doctor_register"><strong>Register here</strong></a></h5>
                <h5 class="areyou not_a_doc text-right" style="display:none;"> <a href="javascript:void(0)" id="not_a_doctor"><strong> Not a Doctor? </strong></a></h5>
                <div class="alert alert-danger reg_error_msg" style="display:none;"></div>
                <div class="patient_reg">
                <input type="text" class="form-control" name="name" placeholder="Name">
                <small class="email_err"></small>
                <input type="text" class="form-control" name="email" placeholder="Email" id="email_i">
                <small class="phone_err"></small>
                <div class="row">
                 <div class="col-md-5">
                     <?php
                     $ip = $_SERVER['REMOTE_ADDR'];
                     $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
                     ?>
                    <select name="phonecode" id="phonecode" class="form-control">
                        <option value="44">+44 (GBR)</option>
                        <option value="92">+92 (PAK)</option>
                     <?php foreach($country_codes as $country_code_val){ ?>
                     <option value="<?php echo $country_code_val->phonecode; ?>" <?php if($dataArray->geoplugin_countryName==$country_code_val->nicename){ echo "selected";} ?>><?php echo '+'.$country_code_val->phonecode.' ('.$country_code_val->iso3.')'; ?></option>
                     <?php } ?>
                    </select>
                 </div>
                 <div class="col-md-7">
                 <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number">
                 </div>
                </div>
                <input type="password" class="form-control"  name="password" placeholder="Create Password"> 
                </div>
                <!-- <div class="country_div">
                <input type="text" name="country" id="country" class="form-control" placeholder="Select Country" autocomplete="off">
                    <ul class="list-group" id="countrylist">
                        <?php foreach($countires as $country_val){ ?>
                        <li class="list-group-item" onclick="countryval('<?php echo $country_val->country ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $country_val->country ?> </li>
                        <?php } ?>
                    </ul> 
                </div> -->
                <!-- <div class="city_div">
                    <input type="text" name="city" id="city" class="form-control" placeholder="Select City" readonly autocomplete="off" style="background:#fff;">
                    <ul class="list-group" id="citylist">
                        
                    </ul> 
                </div> -->
                <!-- <div class="hospital_div">
                <select name="hospital_id" class="form-control">
                    <option value="">Select Hospital</option>
                    <?php foreach($hospitals as $hospt_val){ ?>
                    <option value="<?php echo $hospt_val->id ?>"> <?php echo $hospt_val->name ?> </option>
                    <?php } ?>
                </select>
                <br>
                </div> -->
                <!-- <div class="patient_reg">
                <input type="text" class="form-control" name="address" placeholder="Address">
                <select name="sex" class="form-control sex">
                    <option value="">Gender</option>
                    <option value="Male"> Male </option>
                    <option value="Female"> Female </option>
                    <option value="Others"> Others </option>
                </select>
                <br>
                <div class="datepickhere"><input class="form-control datepick" type="text" name="birthdate" value="" readonly placeholder="Birth Date" id="bdate" autocomplete="off"><br></div>
                
                </div> -->
               <!--  <div class="row">
                <div class="col-md-6">
                <input type="file" name="img_url" style="vesibility:hidden;height:0px; border:none !important;" class="img_url">
                <button type="button" class="btn btn-default uploadImg">Image Upload</button>
                </div>
                <div class="col-md-6">
                <img src="" width="100" class="imgdiv" height="100" style="display:none;">
                </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                <input type="file" name="identitydoc" style="vesibility:hidden;height:0px; border:none !important;" class="identity_doc_url">
                <button type="button" class="btn btn-default uploadIdentityDoc">Identity Document</button>
                </div>
                <div class="col-md-6">
                <img src="" width="100" class="identitydiv" height="100" style="display:none;">
                </div>
                </div> -->
                <!-- <div class="row doctor_lic_div" style="display:none;">
                <div class="col-md-6">
                <input type="file" name="doctor_lic_doc" style="vesibility:hidden;height:0px; border:none !important;" class="doctor_lic_doc">
                <button type="button" class="btn btn-default uploadLicenceDoc">Licence Document</button>
                </div>
                <div class="col-md-6">
                <img src="" width="100" class="licencediv" height="100" style="display:none;">
                </div>
                </div> -->
                <input type="hidden" name="support_input" value="0" id="support_input">
                <button class="btn btn-lg btn-login btn-block" type="submit" id="send_ptnt_otp">Send OTP</button>
                </div>
            </form>
            <form id="verificationCode" class="login-wrap" style="display:none">
                <div class="alert alert-success verf_msg">Verification code with 6-digits has been sent to your phone. Please enter verification code in input box.</div>
                <div class="alert alert-danger error_msg" style="display:none;"></div>
                <input class="form-control" type="text" id="verification_code" placeholder="Enter 6-digits verification code">
                <button class="btn btn-lg btn-login btn-block vrfy_btn" type="button" onclick="codeverify();">Verify code</button>
            </form>
            </div>
            </div>
        </div>
        </div>
<!--end here-->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="auth/forgot_password">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Forgot Password ?</h4>
                        </div>

                        <div class="modal-body">
                            <p>Enter your e-mail address below to reset your password.</p>
                            <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                            <input class="btn detailsbutton" type="submit" name="submit" value="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- js placed at the end of the document so the pages load faster -->
        <script src="common/js/jquery.js"></script>
        <script src="common/js/bootstrap.min.js"></script>
        <!--Haseen code-->
        <link rel="stylesheet" type="text/css" href="common/css/bootstrap-datepicker.css">
        <script type="text/javascript" src="common/js/bootstrap-datepicker.min.js"></script>
        <script>
            $(document).ready(function(){
              $(".nav-tabs a").click(function(){
                $(this).tab('show');
              });
            });
            $( '#bdate' ).datepicker( {
                format: "dd-mm-yyyy",
                autoclose: true,
                orientation: "auto"
            } );
            $('#bdate').on('click',function(){
                $('#bdate').datepicker('setDate', new Date());
            });
            
            $('.uploadImg').on('click',function(){
                $('.img_url').click();
            });
            $('.uploadIdentityDoc').on('click',function(){
                $('.identity_doc_url').click();
            });
            $('.uploadLicenceDoc').on('click',function(){
                $('.doctor_lic_doc').click();
            });
            
            $('.img_url').on('change',function(){
                readURL(this,1);
                $('.imgdiv').fadeIn('slow');
            });
            $('.identity_doc_url').on('change',function(){
                readURL(this,2);
                $('.identitydiv').fadeIn('slow');
            });
            $('.doctor_lic_doc').on('change',function(){
                readURL(this,3);
                $('.licencediv').fadeIn('slow');
            });
            $('#register').on('submit',function(e){
                e.preventDefault();
                
                // var input = $('#register').find('input').val();
                var isFormValid = true;
                $('.patient_reg :input').each(function(){
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
                        $('.email_err').fadeIn('slow');
                        $('.email_err').text('Account already exists with this email please try another email.');
                      }
                      else
                      {
                        $('#email_i').css('border','');
                        $('.email_err').fadeOut('slow');
                      }
                      if(obj[1] > 0)
                      {
                        // $('#send_ptnt_otp').prop('disabled',true);
                        $('#phone').css('border','1px solid red');
                        $('.phone_err').fadeIn('slow');
                        $('.phone_err').text('Account already exists with this phone number please try another phone.');
                      }
                      else
                      {
                        $('#phone').css('border','');
                        $('.phone_err').fadeOut('slow');
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
                          scrolltopfnc();
                      }
                      
                    });
                }
                else
                {
                    scrolltopfnc();
                }
                
            });
            
            $('#doctor_register').on('click', function(){
                $('.patient_reg :input').each(function(){
                    $(this).css('border','');
                });
                $('#register').fadeOut('slow').fadeIn('slow');
                $('.btn_doc').fadeOut('slow');
                $('.not_a_doc').fadeIn('slow');
                $('.doctor_lic_div').fadeIn('slow');
                $('#support_input').val(1);
                $('.sex').html('');
                $('.sex').html('<option value="">Speciality</option><?php foreach($speciality as $value){ ?> <option value="<?php echo $value->speciality ?>"> <?php echo $value->speciality ?> </option> <?php } ?>');
                $('.datepickhere').html('');
                $('.country_div').addClass('patient_reg');
                $('.city_div').addClass('patient_reg');
                $('.country_div').fadeIn('slow');
                $('.city_div').fadeIn('slow');
                $('.hospital_div').addClass('patient_reg');
                $('.hospital_div').fadeIn('slow');
            });
            $('#not_a_doctor').on('click',function(){
                $('.patient_reg :input').each(function(){
                    $(this).css('border','');
                });
                $('.country_div').removeClass('patient_reg');
                $('.city_div').removeClass('patient_reg');
                $('.hospital_div').removeClass('patient_reg');
                $('.hospital_div').fadeOut('slow');
                $('.country_div').fadeOut('slow');
                $('.city_div').fadeOut('slow');
                $('#register').fadeOut('slow').fadeIn('slow');
                $('.btn_doc').fadeIn('slow');
                $('.not_a_doc').fadeOut('slow');
                $('.doctor_lic_div').fadeOut('slow');
                $('#support_input').val(0);
                $('.sex').html('');
                $('.sex').html('<option value="">Sex</option><option value="Male"> Male </option><option value="Female"> Female </option><option value="Others"> Others </option>');
                $('.datepickhere').html('<input class="form-control datepick" type="text" name="birthdate" value="" readonly placeholder="Birth Date" id="bdate" autocomplete="off"><br>');
                $('#bdate').on('click',function(){
                $('#bdate').datepicker('setDate', new Date());
            });
                $('#bdate').datepicker('refresh');
            });
            $("#country").on("keyup focus", function() {
        $('#countrylist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#countrylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      $("#city").on("keyup focus", function() {
          var country_i = $("#country").val();
         if(country_i !=""){
        $('#citylist').fadeIn('slow');
         }
        var value = $(this).val().toLowerCase();
        $("#citylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
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
        
    });
    
    function countryval(val)
    {
        $('#city').val('');
        $('#city').attr('placeholder','Please wait...');
        $.post('frontend/getcities',{country_id:val},function(result){
            $('#city').attr('placeholder','Select City');
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
            function readURL(input,val) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
            
                    reader.onload = function (e) {
                        if(val==1){
                        $('.imgdiv').attr('src', e.target.result);
                        }
                        if(val==2)
                        {
                            $('.identitydiv').attr('src', e.target.result);
                        }
                        if(val==3)
                        {
                            $('.licencediv').attr('src', e.target.result);
                        }
                    }
            
                    reader.readAsDataURL(input.files[0]);
                }
            }
            function scrolltopfnc()
            {
                $('html, body').animate({
                    scrollTop: $('#scrolldiv').offset().top
                }, 500);
            }
        </script>
        <div id="recaptcha-container"></div>
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
        <!-- TODO: Add SDKs for Firebase products that you want to use
             https://firebase.google.com/docs/web/setup#available-libraries -->
        
        <script>
          // Your web app's Firebase configuration
          var firebaseConfig = {
            apiKey: "AIzaSyCUUvykdOlvQsGPKXWTugJtVU5lQLGJz9w",
            authDomain: "callgpnow.firebaseapp.com",
            databaseURL: "https://callgpnow.firebaseio.com",
            projectId: "callgpnow",
            storageBucket: "callgpnow.appspot.com",
            messagingSenderId: "644330715635",
            appId: "1:644330715635:web:46d9dbed9b4cbbe04fba86"
          };
          // Initialize Firebase
          firebase.initializeApp(firebaseConfig);
        </script>
        <script src="common/js/NumberAuthentication.js" type="text/javascript"></script>
<!--end here-->
    </body>
</html>
