<?php 
if ($this->ion_auth->in_group(array('Patient')))
{ 
    $patient_ion_id = $this->ion_auth->get_user_id();
    $patient_data = $this->frontend_model->getpatiendatabyId($patient_ion_id);
}
?>
<!--Breadcrumb -->
            <div class="breadcrumb-bar">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-12 col-12">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>frontend/pharmacy">Pharmacy</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                                </ol>
                            </nav>
                            <h2 class="breadcrumb-title">Checkout</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->
            
            <!-- Page Content -->
            <div class="content">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6 col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Billing details</h3>
                                </div>
                                <div class="card-body">
                                
                                    <!-- Checkout Form -->
                                    <form action="<?php echo base_url() ?>appointment/addNewApp" method="post" id="">
                                    <input type="hidden" name="patient" id="patient_id" value="<?php echo $patient_data->id ?>">
                                    <input type="hidden" name="redirect" id="redirect_url" value="">
                                    <input type="hidden" name="request" value="Yes">
                                    <input type="hidden" name="doctor" id="doctor_id" value="<?php echo $appointment_data['doctor_id'] ?>">
                                    <input type="hidden" name="date" id="appointment_date" value="<?php echo $appointment_data['appointment_date'] ?>">
                                    <input type="hidden" name="time_slot" id="appointment_time_slot" value="<?php echo $appointment_data['appointment_time_slot'] ?>">
                                    <input type="hidden" name="status" id="" value="Requested">                                    
                                    <!-- Personal Information -->
                                    <div class="info-widget">
                                        <h4 class="card-title">Personal Information</h4>
                                        <div class="form-group card-label mb-0">
                                            <label class="pl-0 ml-0 mb-2">Reason</label>
                                            <textarea rows="5" class="form-control" name="remarks" placeholder="Type here" autofocus="on" required="required"></textarea>
                                        </div>                                      
                                    </div>
                                    <!-- /Personal Information -->
                                        <button type="submit" class="btn btn-primary btn-block btn-lg">Confirm Appointment</button>
                                    </form>
                                    <!-- /Checkout Form -->
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-6 col-lg-5 theiaStickySidebar">
                        
                            <!-- Booking Summary -->
                            <div class="card booking-card">
                                <div class="card-header">
                                    <h3 class="card-title">Doctor Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="booking-doc-info">
                                        <a href="doctor-profile.html" class="booking-doc-img">
                                            <img src="<?php echo base_url().$doctor_profile_data->img_url ?>" alt="User Image">
                                        </a>
                                        <div class="booking-info">
                                            <h4><a href="doctor-profile.html">Dr. <?php echo $doctor_profile_data->name ?></a></h4>
                                            <div class="rating">
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star"></i>
                                                <span class="d-inline-block average-rating">35</span>
                                            </div>
                                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> <?php $address = json_decode($doctor_profile_data->address); echo $address[0].' '.$address[1]; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Booking Summary -->
                            
                        </div>
                    </div>

                </div>

            </div>      
            <!-- /Page Content-->
</div>
            <button type="button" id="login-modal-btn" data-toggle="modal" data-target="#login-modal"style="display: none;">login</button>
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login to Book your Appointment</h5>
                        <!-- <button class="close" type="button" data-dismiss="modal" id="login-modal-close" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button> -->
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
<!--  -->
<?php if(empty($patient_data)){ ?>
    <script type="text/javascript">
        $('#login-modal-btn').click();
    </script>
<?php } ?>
