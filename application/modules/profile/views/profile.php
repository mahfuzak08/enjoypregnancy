<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css"/>

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 55px;
  height: 28px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
    width: 18px;
    left: 7px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.round-img
{
  border-radius: 100%;
  width: 180px;
  height: 180px;
  margin-bottom: 0px !important;
  display: inline;
} 
.bootstrap-tagsinput
{
  width: 100%;
}
.bootstrap-tagsinput input
{
  width: 130px;
}
.remove-icon{
  position: absolute;
  top: 0;
  right: 0;
  color: red;
  cursor: pointer;
}
.dow, .day
{
  width: 10px !important;
}
</style>
<!--sidebar end-->
<!-- Bootstrap CSS -->

<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <?php 
    if($this->ion_auth->in_group(array('Doctor')))
    {
        $ion_user_id = $this->ion_auth->get_user_id();
        $doctor_status = $this->profile_model->getdoctortbldata($ion_user_id);
        
        if($doctor_status->is_approved==0)
        {
            echo "<div class='alert alert-warning'><strong><i class='fa fa-exclamation-triangle'></i> Incomplete profile:</strong> Please complete your profile and make request for approval.You will be able to see all features once admin approve your account.</div>";
        }
        elseif($doctor_status->is_approved==2)
        {
            echo "<div class='alert alert-warning'><strong><i class='fa fa-exclamation-triangle'></i> Account Approval In Progress:</strong>You will be able to see all features once admin approve your account.</div>";   
        }
        
        if($this->session->flashdata('profile_success_msg'))
        {
            echo "<div class='alert alert-success'>Request submited successfully.</div>";
        }
        $gender = $doctor_status->gender;
        $date_of_birth = $doctor_status->date_of_birth;
    }
    else
    {
       $ion_user_id = $this->ion_auth->get_user_id();
       $p_status = $this->profile_model->getpatienttbldata($ion_user_id);
       $gender = strtolower($p_status->sex);
       $date_of_birth = $p_status->birthdate;
       $address = $p_status->address;
       $bloodgroup = $p_status->bloodgroup;
       $medicale_history = $p_status->medicale_history;
    }
    ?>
    <div class="row">
        <!-- page start-->
        <div class="col-md-9">
            <section class="panel">
             <form role="form" action="profile/addNew" method="post" enctype="multipart/form-data" style="padding-top: 0px;">
                <header class="panel-heading">
                  <div class="row">
                    <div class="col-md-4">
                        <?php echo lang('manage_profile'); 
                        if($this->ion_auth->in_group(array('Doctor'))){
                        if($doctor_status->is_approved==0)
                            {
                        ?>
                      <span class='badge bg-danger' style="border-radius:10px;" title="Acount not approved,Please complete you profile.">Not Approved</span>
                      <?php }elseif($doctor_status->is_approved==1){ ?>
                      <span class='badge bg-success' style="border-radius:10px;">Approved</span>
                      <?php }elseif($doctor_status->is_approved==2){ ?>
                      <span class='badge bg-warning' style="border-radius:10px;">Inprogress</span>
                      <?php } } ?>
                    </div>
                    <div class="col-md-8">
                      <?php if($this->ion_auth->in_group(array('Doctor'))){ ?>
                      <div class="row">
                          <div class="col-md-6 text-right">
                              <p style="margin-bottom: 0px;">Urgent Consult:&nbsp;
                              <!-- <label>OFF</label> -->
                              <label class="switch">
                                <input type="checkbox" name="urgent_care" value="1" <?php if($doctor_status->urgent_care_status==1){ echo "checked";} ?>>
                                <span class="slider round"></span>
                              </label>
                            </p>
                              <!-- <label>ON</label> -->
                          </div>
                          <div class="col-md-5 text-right">
                              <p style="margin-bottom: 0px;">Home Visit:&nbsp;
                              <!-- <label>OFF</label> -->
                              <label class="switch">
                                <input type="checkbox" name="home_visit" value="1" <?php if($doctor_status->home_visit_status==1){ echo "checked";} ?>>
                                <span class="slider round"></span>
                              </label>
                            </p>
                              <!-- <label>ON</label> -->
                          </div>
                      </div>
                    <?php } ?>
                    </div>                    
                  </div>                    
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">                     
                        <div class="clearfix">
                          <h4>Basic Information</h4>
                            <?php echo validation_errors(); ?>
                            <!-- <form role="form" action="profile/addNew" class="clearfix" method="post" enctype="multipart/form-data" style="padding-top: 0px;"> -->
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo lang('name'); ?></label>
                                        <input type="text" class="form-control" name="name" id="" value='<?php
                                        if (!empty($profile->username)) {
                                            echo $profile->username;
                                        }
                                        ?>' placeholder="">
                                    </div>                                    
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo lang('email'); ?></label>
                                        <input type="text" class="form-control" name="email" id="" value='<?php
                                        if (!empty($profile->email)) {
                                            echo $profile->email;
                                        }
                                        ?>'>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" id="" placeholder="Phone Number" value="<?php
                                        if (!empty($profile->phone)) {
                                            echo $profile->phone;
                                        }
                                        ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""><?php echo lang('change_password'); ?></label>
                                        <input type="password" class="form-control" name="password" id="" placeholder="********">
                                    </div>                                    
                                  </div> 
                                  <?php if(!$this->ion_auth->in_group(array('admin','superadmin'))){ ?>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <select class="form-control" name="gender" required>
                                          <option value="">Select</option>
                                          <option value="male" <?php if($gender=='male'){ echo "selected";} ?>>Male</option>
                                          <option value="female" <?php if($gender=='female'){ echo "selected";} ?>>Female</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Date of Birth</label>
                                        <input type="text" class="form-control" id="date_of_birth" value="<?php echo $date_of_birth; ?>" readonly name="date_of_birth" placeholder="Date of Birth" required>
                                    </div>
                                  </div>
                                  <?php } if(!$this->ion_auth->in_group(array('Doctor','admin','superadmin'))){ ?>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Address</label>
                                      <input class="form-control" name="address[]" placeholder="Address" value="<?php echo $address; ?>" required>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Blood Group</label>
                                      <!--<input class="form-control" name="bloodgroup" placeholder="Blood Group" value="<?php echo $bloodgroup; ?>" required>-->
                                      <select class="form-control m-bot15" name="bloodgroup" value=''>
                                            <?php foreach ($groups as $group) { ?>
                                                <option value="<?php echo $group->group; ?>" <?php
                                                if (!empty($bloodgroup)) {
                                                    if ($group->group == $bloodgroup) {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?> > <?php echo $group->group; ?> </option>
                                            <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Medical history</label>
                                        <ul class="list">
                                            <?php
                                            $medicale_historyArr = @explode(',',$medicale_history);
                                            foreach ($medicalHistorySetups as $key=>$item){
                                                ?>
                                                <li><input type="checkbox" name="medicaleHistory[]" value="<?=$item->title?>" <?=(@in_array($item->title, $medicale_historyArr)?'checked':'')?> > <?=$item->title?></li>
                                            <?php } ?>
                                        </ul>
                                      </div>
                                  </div>
                                  <?php } if($this->ion_auth->in_group(array('Doctor'))){ ?>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">License registration</label>
                                        <div class="text-center" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->doctor_lic_doc==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
                                          <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->doctor_lic_doc; ?>" target="_blank">
                                            <img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->doctor_lic_doc; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="license_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;">
                                          </a>
                                        </div>
                                        <input type="file" class="form-control" id="license_registeration" name="license_registeration" onchange="document.getElementById('license_prvw').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="sec_doctor_lic_doc" value="<?php echo $doctor_status->doctor_lic_doc; ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Identity document</label>
                                        <div class="text-center" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->identitydoc==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
                                        <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->identitydoc; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->identitydoc; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="photoid_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;"></a>
                                      </div>
                                        <input type="file" class="form-control" id="identity_doc" name="identity_doc" onchange="document.getElementById('photoid_prvw').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="sec_identitydoc" value="<?php echo $doctor_status->identitydoc; ?>">
                                        <small>Photo-ID (Driving license or passport or National ID)</small>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">&nbsp;</label>
                                        <div class="text-center" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->proof_of_address==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
                                        <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->proof_of_address; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->proof_of_address; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="proofaddress_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;"></a>
                                      </div>
                                        <input type="file" class="form-control" id="proof_of_address" name="proof_of_address" onchange="document.getElementById('proofaddress_prvw').src = window.URL.createObjectURL(this.files[0])">
                                        <input type="hidden" name="sec_proof_of_address" value="<?php echo $doctor_status->proof_of_address; ?>">
                                        <small>Proof of address (Bank statement, Bills etc)</small>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="row">
                                          <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Speciality</label>
                                                <select type="text" class="form-control" id="speciality" name="speciality" required>
                                                  <option value="">Select Speciality</option>
                                                  <?php foreach ($speciality as $speciality) { ?>
                                                    <option value="<?php echo $speciality->speciality; ?>" <?php if($doctor_status->profile== $speciality->speciality){ echo "selected";} ?>> <?php echo $speciality->speciality; ?> </option>
                                                <?php } ?> 
                                                </select>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Doctor Type</label><br>
                                              <label><input type="radio" name="doctor_type" value="0" <?php if($doctor_status->doctor_type==0){ echo "checked";} ?>> GP </label>&nbsp;&nbsp;&nbsp;
                                              <label><input type="radio" name="doctor_type" value="1" <?php if($doctor_status->doctor_type==1){ echo "checked";} ?>> Specialist </label>
                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                <?php } ?>
                                </div>
                                <input type="hidden" name="id" value='<?php
                                if (!empty($profile->id)) {
                                    echo $profile->id;
                                }
                                ?>'>
                                <?php 
                                if($this->ion_auth->in_group(array('Doctor'))){ 
                                    
                                    // echo "<pre>";
                                    // print_r($doctor_status);
                                    // echo "</pre>";
                                ?>                             
                                <h4>About Me</h4>                               
                                <div class="form-group">
                                    <label for="">Biography</label>
                                    <textarea class="form-control" name="about_me" placeholder="Biography" rows="3" style="height: inherit !important;" required><?php echo $doctor_status->about_me ?></textarea>
                                </div>
                                
                                <h4>Contact Details</h4>
                                <div class="row">
                                <div class="col-md-6">  
                                  <div class="form-group">
                                      <label for="">Address Line 1</label>
                                      <input class="form-control" name="address[]" placeholder="Address Line 1" value="<?php $address = json_decode($doctor_status->address); echo $address[0]; ?>" required>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Address Line 2</label>
                                      <input class="form-control" name="address[]" placeholder="Address Line 2" value="<?php echo $address[1]; ?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">City</label>
                                      <input class="form-control" name="city" placeholder="City" value="<?php echo $doctor_status->city ?>" required>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">State / Province</label>
                                      <input class="form-control" name="state_province" placeholder="State / Province" value="<?php echo $doctor_status->state_province ?>" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Country</label>
                                      <!-- <input class="form-control" name="country" placeholder="Country"> -->
                                      <select name="country" class="form-control" id="countrychoose" required>
                                        <option value="">Select your country</option>
                                        <?php foreach($countires as $country_val){ ?>
                                          <option value="<?php echo $country_val->country ?>" <?php if($doctor_status->country == $country_val->country){ echo "selected";} ?>> <?php echo $country_val->country ?> </option>
                                        <?php } ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Postal Code</label>
                                      <input class="form-control" name="postal_code" placeholder="Postal Code" value="<?php echo $doctor_status->postal_code ?>" required>
                                  </div>
                                </div>
                                </div>
                                <h4>Pricing</h4>
                                <div class="form-group">   
                                <div class="row">         
                                  <div class="col-md-2">                        
                                      <input type="radio" name="pricing" value="free" placeholder="Clinic Address" id="free_radio" <?php if($doctor_status->pricing=='free' or $doctor_status->pricing==''){ echo 'checked'; } ?>>
                                      <label for="free_radio"> Free </label>
                                  </div>
                                  <div class="col-md-3"> 
                                      <input type="radio" name="pricing" value="cust_price" placeholder="Clinic Address" id="notfree_radio" <?php if($doctor_status->pricing > 0){ echo 'checked'; } ?>>
                                      <label for="notfree_radio"> Custom Price</label>
                                      <div class="custom_price_fields" <?php if($doctor_status->pricing =='free' or $doctor_status->pricing ==''){ ?> style="display: none;" <?php } ?>>
                                        <input type="number" name="cust_price" class="form-control" placeholder="20" value="<?php if($doctor_status->pricing > 0){ echo $doctor_status->pricing; } ?>">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Urgent Consultation Fee</label>
                                        <input type="number" class="form-control" name="urgent_fee" placeholder="Urgent Consultation Fee" value="<?php echo $doctor_status->urgent_fee ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Home Visit Fee</label>
                                        <input type="number" class="form-control" name="home_fee" placeholder="Home Visit Fee" value="<?php echo $doctor_status->home_fee ?>">
                                    </div>
                                  </div>
                                </div>
                                </div>
                                <h4>Services and Specialization</h4>
                                <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Services</label>
                                    <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="Enter Services" name="services" value="<?php if($doctor_status->services !=''){ echo $doctor_status->services; }else{ ?>Audio,Video,Chat<?php } ?>">
                                    <small>Note : Type & Press enter to add new services</small>
                                  </div>
                              </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Specialization</label>
                                    <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="Enter Specialization" name="specialization" value="<?php echo $doctor_status->specialization ?>">
                                    <small>Note : Type & Press enter to add new specialization</small>
                                  </div>
                                </div>
                              </div>
                              
                              <h4>Hospital / Clinic Info</h4>
                              <?php $clinic_information = json_decode($doctor_status->clinic_info);
                                // echo "<pre>";
                                // print_r($clinic_information);
                              foreach($clinic_information as $key => $valdata){
                                $randnumber_i = (rand(9999,50)*100);
                               ?>
                               <div class="removediv<?php echo $randnumber_i ?>" style="position:relative;"><hr>
                                <div class="row">
                                  <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Hospital / Clinic Name</label>
                                      <input class="form-control" name="clinic_name[]" placeholder="Hospital / Clinic Name" value="<?php echo $valdata->clinic_name ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Hospital / Clinic Address</label>
                                      <input class="form-control" name="clinic_address[]" placeholder="Hospital / Clinic Address" value="<?php echo $valdata->clinic_address ?>">
                                  </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Hospital / Clinic Image</label>
                                      <input type="file" class="form-control" name="clinic_image<?php echo $key ?>[]" multiple>
                                  </div>
                                  </div>
                                  <div class="col-md-8">
                                    <label for="">Hospital / Clinic Timing</label>
                                    <?php $clinicday = json_decode($valdata->clinic_day);
                                     $from_clinic_time = json_decode($valdata->from_clinic_time);
                                     $to_clinic_time = json_decode($valdata->to_clinic_time);
                                      for($i=0;$i<count($clinicday);$i++){
                                     ?>
                                    <div class="row removeMoretimingdiv<?php echo $i.$key ?>">
                                        <div class="col-md-5">
                                        <select class="form-control" name="clinic_day<?php echo $key ?>[]">
                                            <option value="">Select Day</option>
                                            <option value="Monday" <?php if($clinicday[$i]=='Monday'){ echo 'selected';} ?>>Monday</option>
                                            <option value="Tuesday" <?php if($clinicday[$i]=='Tuesday'){ echo 'selected';} ?>>Tuesday</option>
                                            <option value="Wednesday" <?php if($clinicday[$i]=='Wednesday'){ echo 'selected';} ?>>Wednesday</option>
                                            <option value="Thursday" <?php if($clinicday[$i]=='Thursday'){ echo 'selected';} ?>>Thursday</option>
                                            <option value="Friday" <?php if($clinicday[$i]=='Friday'){ echo 'selected';} ?>>Friday</option>
                                            <option value="Saturday" <?php if($clinicday[$i]=='Saturday'){ echo 'selected';} ?>>Saturday</option>
                                            <option value="Sunday" <?php if($clinicday[$i]=='Sunday'){ echo 'selected';} ?>>Sunday</option>
                                        </select>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" class="form-control timepicker" placeholder="From Time" name="from_clinic_time<?php echo $key; ?>[]" value="<?php echo $from_clinic_time[$i] ?>">
                                      </div>
                                      <div class="col-md-3">
                                         <input type="text" class="form-control timepicker" placeholder="To Time" name="to_clinic_time<?php echo $key; ?>[]" value="<?php echo $to_clinic_time[$i] ?>">
                                      </div>
                                      <div class="col-md-1">                                       
                                         <?php if($i==0){ ?>
                                           <i class="fa fa-plus" title="Add more time" onclick="addmoreclinicTimeing(<?php echo $key ?>)" style="margin-top: 12px;color:#45a049;cursor:pointer;"></i>
                                          <?php }else{ ?>
                                            <i class="fa fa-times-circle" title="Remove" onclick="removeClinicTiming(<?php echo $i.$key ?>)" style="margin-top: 12px;cursor:pointer;color: red;"></i>
                                          <?php } ?>
                                      </div>
                                  </div>
                                <?php } ?>
                                  <div class="addmoreClinicTiming<?php echo $key ?>"></div>
                                  </div>
                              </div>
                              <?php if($key!=0){ ?>
                                <i class="fa fa-times-circle remove-icon remove-icon<?php echo $randnumber_i ?>" onclick="removeClinicdiv('<?php echo $randnumber_i ?>','<?php echo $key ?>')"></i>
                              <?php } ?>
                            </div>
                            <?php } ?>
                              <div class="addmoreClinic"></div>
                                <div class="form-group">
                                  <button type="button" class="btn btn-info" id="addmoreClinikBtn" value="<?php echo count($clinic_information); ?>"><i class="fa fa-plus"></i> Add More</button>
                                </div>
                                
                                <h4>Education</h4>
                                <?php $education = json_decode($doctor_status->education);
                                  if(empty($education)){
                                ?>
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Degree</label>
                                      <input class="form-control" name="degree[]" placeholder="MD - General Medicine">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">College/Institute</label>
                                      <input class="form-control" name="college_institute[]" placeholder="College/Institute">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Year of Completion</label>
                                      <input class="form-control" name="degree_compl_year[]" placeholder="Year of Completion">
                                    </div>
                                  </div>                                  
                                </div>
                                <?php }else{ $count_log = 1;                                  
                                  foreach($education as $val){ 
                                  $ii = (rand()*100)+1;                                   
                                 ?>
                                <div class="removediv<?php echo $ii; ?>" style="position:relative;">
                                 <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Degree</label>
                                      <input class="form-control" name="degree[]" placeholder="MD - General Medicine" value="<?php echo $val->degree ?>">
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">College/Institute</label>
                                      <input class="form-control" name="college_institute[]" placeholder="College/Institute" value="<?php echo $val->college_institute ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Year of Completion</label>
                                      <input class="form-control" name="degree_compl_year[]" placeholder="Year of Completion" value="<?php echo $val->degree_compl_year ?>">
                                    </div>
                                  </div>                                  
                                 </div>
                                 <?php if($count_log!=1){ ?>
                                    <i class="fa fa-times-circle remove-icon remove-icon<?php echo $ii; ?>" onclick="removeEdudiv('<?php echo $ii; ?>')"></i>
                                  <?php } ?>
                                </div>
                              <?php $count_log++; } } ?>
                                <div class="addmoreEdu"></div>
                                <div class="form-group">
                                  <button type="button" class="btn btn-info" id="addmoreEduBtn"><i class="fa fa-plus"></i> Add More</button>
                                </div>

                                <h4>Experience</h4>
                                <?php $experience = json_decode($doctor_status->experience);
                                  if(empty($experience)){
                                ?>
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Hospital Name</label>
                                      <input class="form-control" name="exp_hospital_name[]" placeholder="Hospital Name" required>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">From</label>
                                      <input class="form-control" name="exp_from[]" placeholder="From" required>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">To</label>
                                      <input class="form-control" name="exp_to[]" placeholder="To" required>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Designation</label>
                                      <input class="form-control" name="designation[]" placeholder="Designation" required>
                                    </div>
                                  </div>
                                 </div>
                                <?php }else{ $count_log1 = 1;                                     
                                  foreach($experience as $val){   
                                  $ii = (rand()*100)+1;                                 
                                 ?>
                                <div class="removediv<?php echo $ii; ?>" style="position:relative;">
                                 <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Hospital Name</label>
                                      <input class="form-control" name="exp_hospital_name[]" placeholder="Hospital Name" value="<?php echo $val->exp_hospital_name ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">From</label>
                                      <input class="form-control" name="exp_from[]" placeholder="From" value="<?php echo $val->exp_from ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">To</label>
                                      <input class="form-control" name="exp_to[]" placeholder="To" value="<?php echo $val->exp_to ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Designation</label>
                                      <input class="form-control" name="designation[]" placeholder="Designation" value="<?php echo $val->designation ?>">
                                    </div>
                                  </div>
                                 </div>
                                 <?php if($count_log1!=1){ ?>
                                   <i class="fa fa-times-circle remove-icon remove-icon<?php echo $ii; ?>" onclick="removeEdudiv('<?php echo $ii; ?>')"></i>
                                 <?php } ?>
                                </div>
                                <?php $count_log1++; } } ?>
                                <div class="addmoreExp"></div>
                                <div class="form-group">
                                  <button type="button" class="btn btn-info" id="addmoreExpBtn"><i class="fa fa-plus"></i> Add More</button>
                                </div>

                                <h4>Awards</h4>
                                <?php $awards = json_decode($doctor_status->awards);
                                  if(empty($awards)){
                                ?>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Awards</label>
                                      <input class="form-control" name="awards[]" placeholder="Awards">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Year</label>
                                      <input class="form-control" name="award_year[]" placeholder="Year">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Short description</label>
                                      <textarea class="form-control" name="award_description[]" placeholder="Award description"></textarea>
                                    </div>
                                  </div>
                                </div>
                                <?php }else{
                                  $count_log2 = 1;                                     
                                  foreach($awards as $val){   
                                  $ii = (rand()*100)+1; 
                                 ?>
                                 <div class="removediv<?php echo $ii; ?>" style="position:relative;">
                                 <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Awards</label>
                                      <input class="form-control" name="awards[]" placeholder="Awards" value="<?php echo $val->awards ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Year</label>
                                      <input class="form-control" name="award_year[]" placeholder="Year" value="<?php echo $val->award_year ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Short description</label>
                                      <textarea class="form-control" name="award_description[]" placeholder="Award description"><?php echo $val->award_description ?></textarea>
                                    </div>
                                  </div>
                                 </div>
                                 <?php if($count_log2!=1){ ?>
                                   <i class="fa fa-times-circle remove-icon remove-icon<?php echo $ii; ?>" onclick="removeEdudiv('<?php echo $ii; ?>')"></i>
                                 <?php } ?>
                                </div>
                                <?php $count_log2++; } } ?>
                                <div class="addmoreawards"></div>
                                <div class="form-group">
                                  <button type="button" class="btn btn-info" id="addmoreAwardBtn"><i class="fa fa-plus"></i> Add More</button>
                                </div>                                    
                                <?php } ?>
                                <div class="form-group">
                                  <?php if($this->ion_auth->in_group(array('Doctor'))){ ?>
                                    <input type="hidden" name="support_status" value="<?php echo $doctor_status->is_approved ?>">
                                    <?php if($doctor_status->is_approved==0){ ?>
                                    <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo 'Save and Request for Approval'; ?></button>
                                    <?php }else{ ?>
                                    <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo 'update'; ?></button>
                                    <?php } }else{ ?>
                                      <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo 'update'; ?></button>
                                    <?php } ?>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </form>
            </section>
        </div>
        <div class="col-md-3">
          <?php if($this->ion_auth->in_group(array('Doctor','Patient'))){
              if($this->ion_auth->in_group(array('Patient'))){
                $ion_user_id = $this->ion_auth->get_user_id();
                $patientData = $this->profile_model->getPatientprofileimage($ion_user_id);
                // echo "<pre>";
                // print_r($patientData);
                // exit;
                $profile_img = $patientData->img_url;
              }
              else{
                $profile_img = $doctor_status->img_url;
              }
           ?>
          <section class="panel">
              <header class="panel-heading">
                  Profile Image
              </header>
              <div class="panel-body">
                <br>
                <div class="text-center">
                  <img src="<?php echo $profile_img; ?>" onerror="this.src='uploads/default.jpg'" class="round-img thumbnail" id="preview_img">
                </div>
              <form action="profile/updatedoctorimage" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Change Profile Image</label>
                  <input type="file" name="profileimage" class="form-control" id="profile_img">
                  <small>Allowed JPG, GIF or PNG. Max size of 2MB</small>
                  <input type="hidden" name="old_profileimage" value="<?php echo $profile_img ?>">
                  <input type="hidden" name="doc_id" value="<?php echo $profile->id; ?>">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-info">Update Image</button>
                </div>
              </form>
              </div>
          </section>
        <?php } ?>
        </div>
    </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<!-- Bootstrap Tagsinput JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip();
})
    $(document).ready(function () {
      $("#countrychoose").select2({
        placeholder: 'Select your Country',
        allowClear: true,
      });
      // $('#date_of_birth').val('<?php echo $doctor_status->date_of_birth; ?>');
      $('#date_of_birth').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
        });
        $(".flashmessage").delay(3000).fadeOut(100);

        $('#free_radio').click(function(){
          $('.custom_price_fields').fadeOut('slow');
        });
        $('#notfree_radio').click(function(){
          $('.custom_price_fields').fadeIn('slow');
        });
        
        $('#addmoreClinikBtn').on('click', function(){
          var rand = Math.floor((Math.random()*100)+1);
          var idhere = $(this).val();
          if(idhere==0)
          {
              $('#addmoreClinikBtn').val(1);
          }
          if(idhere==1)
          {
              $('#addmoreClinikBtn').val(2);
          }
          if(idhere==2)
          {
              $('#addmoreClinikBtn').val(3);
          }
          if(idhere==3)
          {
              $('#addmoreClinikBtn').val(4);
          }
          if(idhere==4)
          {
              $('#addmoreClinikBtn').val(5);
          }
          
          if(idhere==5)
          {
              alert("You can only add 5 Hospital / Clinic info.");
              return;
          }
          
        //  console.log(idhere);
          $('.addmoreClinic').append('<div class="removediv'+rand+'" style="position:relative;"><hr><div class="row"><div class="col-md-6"> <div class="form-group"><label>Hospital / Clinic Name</label><input class="form-control" name="clinic_name[]" required placeholder="Hospital / Clinic Name"></div></div><div class="col-md-6"><div class="form-group"><label for="">Hospital / Clinic Address</label><input class="form-control" name="clinic_address[]" required placeholder="Hospital / Clinic Address"></div></div><div class="col-md-4"><div class="form-group"><label for="">Hospital / Clinic Image</label><input type="file" class="form-control" name="clinic_image'+idhere+'[]" multiple></div></div> <div class="col-md-8"> <label for="">Hospital / Clinic Timing</label><div class="row"> <div class="col-md-5"> <select class="form-control" required name="clinic_day'+idhere+'[]"> <option value="">Select Day</option> <option value="Monday">Monday</option><option value="Tuesday">Tuesday</option> <option value="Wednesday">Wednesday</option> <option value="Thursday">Thursday</option><option value="Friday">Friday</option> <option value="Saturday">Saturday</option><option value="Sunday">Sunday</option> </select> </div><div class="col-md-3"><input type="text" class="form-control timepicker" placeholder="From Time" required name="from_clinic_time'+idhere+'[]"> </div> <div class="col-md-3"> <input type="text" class="form-control timepicker" placeholder="To Time" required name="to_clinic_time'+idhere+'[]"> </div> <div class="col-md-1"> <i class="fa fa-plus" title="Add more time" onclick="addmoreclinicTimeing('+idhere+')" style="margin-top: 12px;color:#45a049;cursor:pointer;"></i> </div></div><div class="addmoreClinicTiming'+idhere+'"></div> </div></div><i class="fa fa-times-circle remove-icon remove-icon'+rand+' firsticonremove'+idhere+'" onclick="removeClinicdiv('+rand+','+idhere+')"></i></div>');
        
            $( '.timepicker' ).timepicker({
                'timeFormat': 'h:i A',
                'step': 5,
                orientation: "auto"
            });
        });
        
        $('#addmoreEduBtn').on('click', function(){
          var rand = Math.floor((Math.random()*100)+1);
          $('.addmoreEdu').append('<div class="removediv'+rand+'" style="position:relative;"><div class="row"><div class="col-md-4"><div class="form-group"><label for="">Degree</label> <input class="form-control" name="degree[]" placeholder="MD - General Medicine"></div></div><div class="col-md-4"><div class="form-group"> <label for="">College/Institute</label><input class="form-control" name="college_institute[]" placeholder="College/Institute"></div></div><div class="col-md-4"><div class="form-group"><label for="">Year of Completion</label><input class="form-control" name="degree_compl_year[]" placeholder="Year of Completion"></div></div></div><i class="fa fa-times-circle remove-icon remove-icon'+rand+'" onclick="removeEdudiv('+rand+')"></i></div>');
        });

        $('#addmoreExpBtn').on('click', function(){
          var rand = Math.floor((Math.random()*100)+1);
          $('.addmoreExp').append('<div class="removediv'+rand+'" style="position:relative;"><div class="row"><div class="col-md-4">                                    <div class="form-group">                                      <label for="">Hospital Name</label>                                     <input class="form-control" name="exp_hospital_name[]" placeholder="Hospital Name">                                   </div>                                  </div>                                  <div class="col-md-4">                                    <div class="form-group">                                      <label for="">From</label>                                      <input class="form-control" name="exp_from[]" placeholder="From">                                   </div>                                  </div>                                  <div class="col-md-4">                                    <div class="form-group">                                      <label for="">To</label>                                      <input class="form-control" name="exp_to[]" placeholder="To">                                   </div>                                  </div>                                  <div class="col-md-4">                                    <div class="form-group">                                      <label for="">Designation</label>                                     <input class="form-control" name="designation[]" placeholder="Designation">                                   </div>                                  </div>                                </div><i class="fa fa-times-circle remove-icon remove-icon'+rand+'" onclick="removeEdudiv('+rand+')"></i></div>');
        });

        $('#addmoreAwardBtn').on('click', function(){
          var rand = Math.floor((Math.random()*100)+1);
          $('.addmoreawards').append('<div class="removediv'+rand+'" style="position:relative;"><div class="row"><div class="col-md-6"><div class="form-group"><label for="">Awards</label> <input class="form-control" name="awards[]" placeholder=""> </div> </div><div class="col-md-6"><div class="form-group"><label for="">Year</label><input class="form-control" name="award_year[]" placeholder="e.g 1988"></div> </div> <div class="col-md-6"><div class="form-group"><label for="">Short description</label><textarea class="form-control" name="award_description[]" placeholder=""></textarea></div></div></div><i class="fa fa-times-circle remove-icon remove-icon'+rand+'" onclick="removeEdudiv('+rand+')"></i></div>');
        });

        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#preview_img').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
          }
        }

        $("#profile_img").change(function() {
          readURL(this);
        });
       
    });
<?php if(count($clinic_information)==0){  ?>
  // console.log(123);
  $(window).on('load',function(){
    $('#addmoreClinikBtn').click();
      $('.firsticonremove0').remove();
  });    
<?php } ?>
function removeEdudiv(id)
{
  $('.removediv'+id).remove();
}

function removeClinicdiv(id, addId)
{
    $('.removediv'+id).remove();
    $('#addmoreClinikBtn').attr('data-gnid',addId);
    $('#addmoreClinikBtn').val(addId);
}

function addmoreclinicTimeing(val)
{
    var rand_v = Math.floor(Math.random()*100);
    $('.addmoreClinicTiming'+val).append('<div class="row removeMoretimingdiv'+rand_v+'"><div class="col-md-5"><select class="form-control" required name="clinic_day'+val+'[]"><option value="">Select Day</option> <option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option> <option value="Thursday">Thursday</option>  <option value="Friday">Friday</option> <option value="Saturday">Saturday</option> <option value="Sunday">Sunday</option> </select>  </div> <div class="col-md-3"> <input type="text" class="form-control timepicker" required placeholder="From Time" name="from_clinic_time'+val+'[]"> </div> <div class="col-md-3"><input type="text" class="form-control timepicker" required placeholder="To Time" name="to_clinic_time'+val+'[]"> </div> <div class="col-md-1"> <i class="fa fa-times-circle" title="Add more time" onclick="removeClinicTiming('+rand_v+')" style="margin-top: 12px;cursor:pointer;color: red;"></i> </div> </div>');

    $( '.timepicker' ).timepicker({
        'timeFormat': 'h:i A',
        'step': 5,
        orientation: "auto"
    });
}

function removeClinicTiming(val)
{
    $('.removeMoretimingdiv'+val).remove();
}
</script>
