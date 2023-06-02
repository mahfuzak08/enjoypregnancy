<?php
// $settings = $this->frontend_model->getSettings();
// $title = explode(' ', $settings->title);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Complete Your Profile </title>
	<!-- Favicons -->
	<link type="image/x-icon" href="uploads/favicon.png" rel="icon">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="https://jquerypost.com/cdn/bs3/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>wizard-assets/css/material-bootstrap-wizard.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>common/assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<!-- <link href="<?php echo base_url(); ?>wizard-assets/css/demo.css" rel="stylesheet" /> -->
	

	<style>
	
	
	.round-img
	{
	  border-radius: 100%;
	  width: 180px;
	  height: 180px;
	  margin-bottom: 0px !important;
	  display: inline;
	} 
	.taginput_fields .bootstrap-tagsinput
	{
	  width: 100%;
	}
	.taginput_fields .bootstrap-tagsinput input
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

	.clinic_imagedivhere input[type="file"]
	{
		opacity: 1; 
		position:inherit;
	}

	li.ui-timepicker-selected, .ui-timepicker-list li:hover, .ui-timepicker-list .ui-timepicker-selected:hover {
    background: #00800091 !important;
    color: #fff;
}
	.form-group {
    padding-bottom: 7px;
    margin: 5px 0 0 0;
}
.image-container::before {
    content: "";
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: none;
    /*opacity: .3;*/
}
.list{
	padding: 0px;
	margin: 0px;
}
.list li{
	list-style-type: none;
}
	</style>

	<?php 
    if($this->ion_auth->in_group(array('Doctor')))
    {
        $ion_user_id = $this->ion_auth->get_user_id();
        $doctor_status = $this->profile_model->getdoctortbldata($ion_user_id);
        
        if($doctor_status->is_approved==0)
        {
            // echo "<div class='alert alert-warning'><strong><i class='fa fa-exclamation-triangle'></i> Incomplete profile:</strong> Please complete your profile and make request for approval.You will be able to see all features once admin approve your account.</div>";
        }
        elseif($doctor_status->is_approved==2)
        {
            // echo "<div class='alert alert-warning'><strong><i class='fa fa-exclamation-triangle'></i> Account Approval In Progress:</strong>You will be able to see all features once admin approve your account.</div>";   
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

</head>

<body>
	<div class="image-container set-full-height" style="">
	  	
	    <!--   Big container   -->
	    <div class="container">
	    	<div class="row">
	    		<div class="col-md-4"></div>
		  		<div class="col-md-4 text-center">
		  			<br>
		  			<a href="<?php echo base_url() ?>">
					  <?php
                        if (!empty($settings->logo)) {
                            echo '<img src=' . $settings->logo . ' width="265px">';
						} else {
                            echo $title[0] . '<span> ' . $title[1] . '</span>';
                        }
                        ?>
						<!-- <img src="<?php echo base_url() ?>uploads/logo3.png" width='265px'>  -->
					</a>		  			
		  		</div>
		  		<div class="col-md-4 text-right">
		  			<br>
		  			<a href="<?php echo base_url() ?>auth/logout" class="btn btn-success">Logout <i class="fa fa-sign-out"></i></a>
		  		</div>
		  	</div>
		  	
  			<?php if($doctor_status->is_approved==3){ ?>
  				<div class="alert alert-danger declinedalert text-center" style="margin-bottom: 0px; margin-top: 10px;"><strong>Oops!</strong>&nbsp; Your account has been declined please check your profile details and try again.</div>
  			<?php } ?>
	        <div class="row">
		        <div class="col-sm-12">
		            <!--      Wizard container        -->
		            <div class="wizard-container" style="padding-top: 30px;">
		                <div class="card wizard-card" data-color="green" id="wizardProfile">
		                    <form action="profile/addNew" method="post" enctype="multipart/form-data">
		                    	<?php if(!$this->ion_auth->in_group(array('Doctor'))){ ?>
		                    	<input type="hidden" name="pateint_here" value="yes">
		                    	<?php } ?>
		                <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->

		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">
		                        	   Complete Your Profile
		                        	</h3>
									<h5>Please complete your profile and make request for approval.You will be able to see all features <br> once admin approve your account. Also you can change these details later from profile module.</h5>
		                    	</div>
								<div class="wizard-navigation">
									<ul>
			                            <li><a href="#basicInfo" data-toggle="tab">Basic Info</a></li>
			                            <?php if($this->ion_auth->in_group(array('Patient'))){ ?>
			                            	<li><a href="#medical_history" data-toggle="tab">Medical History</a></li>
			                       	    <?php }else{ ?>
			                            <li><a href="#documents" data-toggle="tab">Documents</a></li>
			                            <li><a href="#contactinfo" data-toggle="tab">Contact Info</a></li>
			                            <li><a href="#pricing" data-toggle="tab">Pricing</a></li>
			                            <li><a href="#services" data-toggle="tab">Services</a></li>
			                            <li><a href="#hospital_and_clinic_info" data-toggle="tab">Hospital/Clinic Info</a></li>
			                            <li><a href="#education_tab" data-toggle="tab">Education</a></li>
			                            <li><a href="#awards_tab" data-toggle="tab">Awards</a></li>
			                        <?php } ?>
			                        </ul>
								</div>

		                        <div class="tab-content">
		                        	<!-- Basic Info Tab -->
		                            <div class="tab-pane" id="basicInfo">
		                            	 <div class="row">
		                            	 	<h4 class="info-text"> Let's start with the basic information</h4>
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
		                                        <input type="text" class="form-control" name="phone" id="" placeholder="" value="<?php
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
		                                        <input type="date" class="form-control" value="<?php echo date("Y-m-d", strtotime($date_of_birth)); ?>" name="date_of_birth" placeholder="" required>
		                                    </div>
		                                  </div>		                                  
		                                  <?php } if(!$this->ion_auth->in_group(array('Doctor','admin','superadmin'))){ ?>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Address</label>
		                                      <input class="form-control" name="address[]" placeholder="Address" value="<?php echo $address; ?>" required>
		                                    </div>
		                                  </div>
		                                  <!-- <div class="col-md-4">
		                                    
		                                  </div> -->
		                                  <!-- <div class="col-md-4">
		                                      
		                                  </div> -->
		                                  <?php } if($this->ion_auth->in_group(array('Doctor'))){ ?>		                                  
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
		                                          <!--
												  <div class="col-md-4">
		                                            <div class="form-group">
		                                              <label>Doctor Type</label><br>
		                                              <label><input type="radio" name="doctor_type" value="0" <?php if($doctor_status->doctor_type==0){ echo "checked";} ?>> GP </label>&nbsp;&nbsp;&nbsp;
		                                              <label><input type="radio" name="doctor_type" value="1" <?php if($doctor_status->doctor_type==1){ echo "checked";} ?>> Specialist </label>
		                                            </div>
		                                          </div>-->
		                                          <div class="col-md-8">
					                               <div class="form-group">
				                                    <label for="">About Me</label>
				                                    <textarea class="form-control" name="about_me" placeholder="" rows="1" style="height: inherit !important;" required><?php echo $doctor_status->about_me ?></textarea>
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
		                            </div>
		                            <?php if($this->ion_auth->in_group(array('Patient'))){ ?>	
		                            <!-- Medicalhistory Tab -->
		                            	<div class="tab-pane" id="medical_history">
		                            		<div class="row">
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
		                            			
		                            		</div>
		                            	</div>
		                        	<?php } ?>
		                            <!-- documnet Tab -->
		                            <div class="tab-pane" id="documents">
		                                <h4 class="info-text"> Upload your documents here. </h4>
		                                <div class="row">
		                                  <div class="col-md-2">
		                                    <div class="form-group">
		                                        <label for="" style="font-size:12px;">License registration</label>
		                                        <div class="" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->doctor_lic_doc==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
		                                          <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->doctor_lic_doc; ?>" target="_blank">
		                                            <img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->doctor_lic_doc; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="license_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;">
		                                          </a>
		                                        </div>
		                                        <input type="file" class="form-control" id="license_registeration" name="license_registeration" onchange="display_preview('license_prvw', this.files[0])">
		                                        <input type="hidden" name="sec_doctor_lic_doc" value="<?php echo $doctor_status->doctor_lic_doc; ?>">
												<small id="license_prvw_name" style="font-weight:900"></small>
		                                    </div>
		                                  </div>
		                                  <div class="col-md-2">
		                                    <div class="form-group">
		                                        <label for="" style="font-size:12px;">Identity document</label>
		                                        <div class="" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->identitydoc==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
		                                        <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->identitydoc; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->identitydoc; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="photoid_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;"></a>
		                                      </div>
		                                        <input type="file" class="form-control" id="identity_doc" name="identity_doc" onchange="display_preview('photoid_prvw', this.files[0])">
		                                        <input type="hidden" name="sec_identitydoc" value="<?php echo $doctor_status->identitydoc; ?>">
												<small id="photoid_prvw_name" style="font-weight:900"></small><br>
		                                        <small>Photo-ID (Driving license or passport or National ID)</small>
		                                    </div>
		                                  </div>
		                                  <div class="col-md-2">
		                                    <div class="form-group">
		                                        <label for="" style="font-size:12px;">Address proof</label>
		                                        <div class="" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->proof_of_address==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
		                                        <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->proof_of_address; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->proof_of_address; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="proofaddress_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;"></a>
		                                      </div>
		                                        <input type="file" class="form-control" id="proof_of_address" name="proof_of_address" onchange="display_preview('proofaddress_prvw', this.files[0])">
		                                        <input type="hidden" name="sec_proof_of_address" value="<?php echo $doctor_status->proof_of_address; ?>">
												<small id="proofaddress_prvw_name" style="font-weight:900"></small><br>
		                                        <small>Proof of address ( Bank statement, Bills etc)</small>
		                                    </div>
		                                  </div>
										  <div class="col-md-2">
		                                    <div class="form-group">
		                                        <label for="" style="font-size:12px;">Professional Insurance</label>
		                                        <div class="" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->professional_insurance_doc==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
		                                          <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->professional_insurance_doc; ?>" target="_blank">
		                                            <img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->professional_insurance_doc; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="professional_insurance_doc_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;">
		                                          </a>
		                                        </div>
		                                        <input type="file" class="form-control" id="professional_insurance_doc" name="professional_insurance_doc" onchange="display_preview('professional_insurance_doc_prvw', this.files[0])">
		                                        <input type="hidden" name="sec_professional_insurance_doc" value="<?php echo $doctor_status->professional_insurance_doc; ?>">
												<small id="professional_insurance_doc_prvw_name" style="font-weight:900"></small>
		                                    </div>
		                                  </div>
										  <div class="col-md-2">
		                                    <div class="form-group">
		                                        <label for="" style="font-size:12px;">Professional References (1)</label>
		                                        <div class="" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->professional_ref_doc1==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
		                                          <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->professional_ref_doc1; ?>" target="_blank">
		                                            <img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->professional_ref_doc1; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="professional_ref_doc1_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;">
		                                          </a>
		                                        </div>
		                                        <input type="file" class="form-control" id="professional_ref_doc1" name="professional_ref_doc1" onchange="display_preview('professional_ref_doc1_prvw', this.files[0])">
		                                        <input type="hidden" name="sec_professional_ref_doc1" value="<?php echo $doctor_status->professional_ref_doc1; ?>">
												<small id="professional_ref_doc1_prvw_name" style="font-weight:900"></small>
		                                    </div>
		                                  </div>
										  <div class="col-md-2">
		                                    <div class="form-group">
		                                        <label for="" style="font-size:12px;">Professional References (2)</label>
		                                        <div class="" data-toggle="tooltip" data-placement="top" title="<?php if($doctor_status->professional_ref_doc2==""){ echo 'No file selected';}else{ echo 'Preview Document';} ?>">
		                                          <a href="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->professional_ref_doc2; ?>" target="_blank">
		                                            <img src="<?php echo base_url() ?>assets/doctor_prop_data/<?php echo $doctor_status->professional_ref_doc2; ?>" class="thumbnail img-responsive" onerror="this.src='<?php echo base_url() ?>assets/doctor_prop_data/d0000000.png'" id="professional_ref_doc2_prvw" style="margin-bottom: 0px; height: 180px; display: inline-block;">
		                                          </a>
		                                        </div>
		                                        <input type="file" class="form-control" id="professional_ref_doc2" name="professional_ref_doc2" onchange="display_preview('professional_ref_doc2_prvw', this.files[0])">
		                                        <input type="hidden" name="sec_professional_ref_doc2" value="<?php echo $doctor_status->professional_ref_doc2; ?>">
												<small id="professional_ref_doc2_prvw_name" style="font-weight:900"></small>
		                                    </div>
		                                  </div>
		                                </div>
		                            </div>
		                            <!-- Contact Info Tab -->
		                            <div class="tab-pane" id="contactinfo">
		                                <h4 class="info-text"> Enter your contact informations here. </h4>
		                                <div class="row">
			                                <div class="col-md-6">  
			                                  <div class="form-group">
			                                      <label for="">Address Line 1</label>
			                                      <input class="form-control" name="address[]" placeholder="" value="<?php $address = json_decode($doctor_status->address); echo $address[0]; ?>" required>
			                                  </div>
			                                </div>
			                                <div class="col-md-6">
			                                  <div class="form-group">
			                                      <label for="">Address Line 2</label>
			                                      <input class="form-control" name="address[]" placeholder="" value="<?php echo $address[1]; ?>">
			                                  </div>
			                                </div>
			                                <div class="col-md-6">
			                                  <div class="form-group">
			                                      <label for="">City</label>
			                                      <input class="form-control" name="city" placeholder="" value="<?php echo $doctor_status->city ?>" required>
			                                  </div>
			                                </div>
			                                <div class="col-md-6">
			                                  <div class="form-group">
			                                      <label for="">State / Province</label>
			                                      <input class="form-control" name="state_province" placeholder="" value="<?php echo $doctor_status->state_province ?>" required>
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
			                                      <input class="form-control" name="postal_code" placeholder="" value="<?php echo $doctor_status->postal_code ?>" required>
			                                  </div>
			                                </div>
			                                </div>
		                            </div>
		                            <!-- Pricing Tab -->
		                            <div class="tab-pane" id="pricing">		                               
	                                    <h4 class="info-text"> Enter Pricing details here. </h4>		                                    
	                                    <div class="row">         
		                                  <div class="col-md-2">                        
		                                      <input type="radio" name="pricing" value="free" placeholder="Clinic Address" id="free_radio" <?php if($doctor_status->pricing=='free' or $doctor_status->pricing==''){ echo 'checked'; } ?>>
		                                      <label for="free_radio"> Free </label>
		                                  </div>
		                                  <div class="col-md-3"> 
		                                      <input type="radio" name="pricing" value="cust_price" id="notfree_radio" <?php if($doctor_status->pricing > 0){ echo 'checked'; } ?>>
		                                      <label for="notfree_radio"> Custom Price</label>
		                                      <div class="custom_price_fields" <?php if($doctor_status->pricing =='free' or $doctor_status->pricing ==''){ ?> style="display: none;" <?php } ?>>
		                                        <input type="number" name="cust_price" class="form-control" placeholder="20" value="<?php if($doctor_status->pricing > 0){ echo $doctor_status->pricing; } ?>">
		                                      </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                        <label for="">Urgent Consultation Fee</label>
		                                        <input type="number" class="form-control" name="urgent_fee" placeholder="0" value="<?php echo $doctor_status->urgent_fee ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-3">
		                                    <div class="form-group">
		                                        <label for="">Home Visit Fee</label>
		                                        <input type="number" class="form-control" name="home_fee" placeholder="0" value="<?php echo $doctor_status->home_fee ?>">
		                                    </div>
		                                  </div>
		                                </div>
		                            </div>
		                            <!-- Services Tab -->
		                            <div class="tab-pane" id="services">		                                
		                                <h4 class="info-text"> Enter Services and Specialization </h4>                                    
		                                <div class="row taginput_fields">
		                                <div class="col-md-6">
		                                  <div class="form-group">
		                                    <label>Services</label><br>
		                                    <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="" name="services" value="<?php if($doctor_status->services !=''){ echo $doctor_status->services; }else{ ?>Audio,Video,Chat<?php } ?>">
		                                    <br><small>Note : Type & Press enter to add new services</small>
		                                  </div>
		                              </div>
		                                <div class="col-md-6">
		                                  <div class="form-group">
		                                    <label>Specialization</label><br>
		                                    <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="Enter" name="specialization" value="<?php echo $doctor_status->specialization ?>">
		                                    <br><small>Note : Type & Press enter to add new specialization</small>
		                                  </div>
		                                </div>
		                              </div>
		                            </div>
		                           	<!-- Hospital and Clinic Tab -->
		                            <div class="tab-pane" id="hospital_and_clinic_info">
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
			                                      <input class="form-control" name="clinic_name[]" placeholder="" value="<?php echo $valdata->clinic_name ?>">
			                                    </div>
			                                  </div>
			                                  <div class="col-md-6">
			                                    <div class="form-group">
			                                      <label for="">Hospital / Clinic Address</label>
			                                      <input class="form-control" name="clinic_address[]" placeholder="" value="<?php echo $valdata->clinic_address ?>">
			                                  </div>
			                                  </div>
			                                  <div class="col-md-4">
			                                    <div class="clinic_imagedivhere">
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
		                            </div>
		                            <!-- education Tab -->
		                            <div class="tab-pane" id="education_tab">
		                            	<h4 class="info-text"> Enter Education and Experience </h4>   
		                            	<h4>Education Info</h4>
		                                <?php $education = json_decode($doctor_status->education);
		                                  if(empty($education)){
		                                ?>
		                                <div class="row">
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Degree</label>
		                                      <input class="form-control" name="degree[]" placeholder="MD - General Medicine" required="required">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">College/Institute</label>
		                                      <input class="form-control" name="college_institute[]" placeholder="Enter College/Institute" required="required">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Year of Completion</label>
		                                      <input class="form-control" name="degree_compl_year[]" placeholder="Enter Year of Completion e.g 1988" required="">
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
		                                      <input class="form-control" name="college_institute[]" placeholder="Enter College/Institute" value="<?php echo $val->college_institute ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Year of Completion</label>
		                                      <input class="form-control" name="degree_compl_year[]" placeholder="Enter Year of Completion e.g 1988" value="<?php echo $val->degree_compl_year ?>">
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

		                                <!-- Experience Div -->
		                                <h4>Experience</h4>
		                                <?php $experience = json_decode($doctor_status->experience);
		                                  if(empty($experience)){
		                                ?>
		                                <div class="row">
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Hospital Name</label>
		                                      <input class="form-control" name="exp_hospital_name[]" placeholder="" required>
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">From</label>
		                                      <input class="form-control" name="exp_from[]" placeholder="e.g 1988" required>
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">To</label>
		                                      <input class="form-control" name="exp_to[]" placeholder="e.g 1999" required>
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Designation</label>
		                                      <input class="form-control" name="designation[]" placeholder="" required>
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
		                                      <input class="form-control" name="exp_hospital_name[]" placeholder="" value="<?php echo $val->exp_hospital_name ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">From</label>
		                                      <input class="form-control" name="exp_from[]" placeholder="e.g 1988" value="<?php echo $val->exp_from ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">To</label>
		                                      <input class="form-control" name="exp_to[]" placeholder="e.g 1999" value="<?php echo $val->exp_to ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-4">
		                                    <div class="form-group">
		                                      <label for="">Designation</label>
		                                      <input class="form-control" name="designation[]" placeholder="" value="<?php echo $val->designation ?>">
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
		                            </div>
		                            <!-- Award Tab -->
		                            <div class="tab-pane" id="awards_tab">
		                                <h4 class="info-text"> Enter Award info here. </h4>
		                                <h4>Awards</h4>
                                		<?php $awards = json_decode($doctor_status->awards);
		                                  if(empty($awards)){
		                                ?>
		                                <div class="row">
		                                  <div class="col-md-6">
		                                    <div class="form-group">
		                                      <label for="">Awards</label>
		                                      <input class="form-control" name="awards[]" placeholder="">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-6">
		                                    <div class="form-group">
		                                      <label for="">Year</label>
		                                      <input class="form-control" name="award_year[]" placeholder="e.g 1988">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-6">
		                                    <div class="form-group">
		                                      <label for="">Short description</label>
		                                      <textarea class="form-control" name="award_description[]" placeholder=""></textarea>
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
		                                      <input class="form-control" name="awards[]" placeholder="" value="<?php echo $val->awards ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-6">
		                                    <div class="form-group">
		                                      <label for="">Year</label>
		                                      <input class="form-control" name="award_year[]" placeholder="e.g 1988" value="<?php echo $val->award_year ?>">
		                                    </div>
		                                  </div>
		                                  <div class="col-md-6">
		                                    <div class="form-group">
		                                      <label for="">Short description</label>
		                                      <textarea class="form-control" name="award_description[]" placeholder=""><?php echo $val->award_description ?></textarea>
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
		                                <?php //} ?>
		                                <!-- <div class="form-group">
		                                  <?php if($this->ion_auth->in_group(array('Doctor'))){ ?>
		                                    <input type="hidden" name="support_status" value="<?php echo $doctor_status->is_approved ?>">
		                                    <?php if($doctor_status->is_approved==0){ ?>
		                                    <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo 'Save and Request for Approval'; ?></button>
		                                    <?php }else{ ?>
		                                    <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo 'update'; ?></button>
		                                    <?php } }else{ ?>
		                                      <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo 'update'; ?></button>
		                                    <?php } ?>
		                                </div> -->
		                            </div>
		                            
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Next' />
		                                <!-- <input type='button' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finish' /> -->

		                                <?php if($this->ion_auth->in_group(array('Doctor'))){ ?>
	                                    <input type="hidden" name="support_status" value="<?php echo $doctor_status->is_approved ?>">
	                                    <?php if($doctor_status->is_approved==0 or $doctor_status->is_approved==3){ ?>
	                                    <button type="submit" name="submit" class="btn btn-finish btn-fill btn-success btn-wd"><?php echo 'Save and Request for Approval'; ?></button>
	                                    <?php }else{ ?>
	                                    <button type="submit" name="submit" class="btn btn-finish btn-fill btn-success btn-wd"><?php echo 'update'; ?></button>
	                                    <?php } }else{ ?>
	                                      <button type="submit" name="submit" class="btn btn-finish btn-fill btn-success btn-wd"><?php echo 'Save'; ?></button>
	                                    <?php } ?>
		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	        </div><!-- end row -->
	    </div> <!--  big container -->

	<br><br>
	</div>

</body>
	<!--   Core JS Files   -->
    <!-- <script src="https://jquerypost.com/cdn/jquery-1.12.4.min.js" type="text/javascript"></script> -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://jquerypost.com/cdn/bs3/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>wizard-assets/js/jquery.bootstrap.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="<?php echo base_url(); ?>wizard-assets/js/material-bootstrap-wizard.js"></script>

	<!-- Bootstrap Tagsinput JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="<?php echo base_url(); ?>wizard-assets/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.timepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip();
})
    $(document).ready(function () {
    	setTimeout(function(){
    		$('.declinedalert').fadeOut('slow');
    	},8000);
      // $("#countrychoose").select2({
      //   placeholder: 'Select your Country',
      //   allowClear: true,
      // });
      // $('#date_of_birth').val('<?php echo $doctor_status->date_of_birth; ?>');
      $('#date_of_birth').datepicker({
          format: "dd-mm-yyyy",
          autoclose: true
        });
      $( '.timepicker' ).timepicker({
            'timeFormat': 'h:i A',
            'step': 5,
            orientation: "auto"
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
          $('.addmoreClinic').append('<div class="removediv'+rand+'" style="position:relative;"><hr><div class="row"><div class="col-md-6"> <div class="form-group"><label>Hospital / Clinic Name</label><input class="form-control" name="clinic_name[]" required placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label for="">Hospital / Clinic Address</label><input class="form-control" name="clinic_address[]" required placeholder=""></div></div><div class="col-md-4"><div class="clinic_imagedivhere"><label for="">Hospital / Clinic Image</label><input type="file" class="form-control" name="clinic_image'+idhere+'[]" multiple></div></div> <div class="col-md-8"> <label for="">Hospital / Clinic Timing</label><div class="row"> <div class="col-md-5"> <select class="form-control" required name="clinic_day'+idhere+'[]"> <option value="">Select Day</option> <option value="Monday">Monday</option><option value="Tuesday">Tuesday</option> <option value="Wednesday">Wednesday</option> <option value="Thursday">Thursday</option><option value="Friday">Friday</option> <option value="Saturday">Saturday</option><option value="Sunday">Sunday</option> </select> </div><div class="col-md-3"><input type="text" class="form-control timepicker" placeholder="From Time" required name="from_clinic_time'+idhere+'[]"> </div> <div class="col-md-3"> <input type="text" class="form-control timepicker" placeholder="To Time" required name="to_clinic_time'+idhere+'[]"> </div> <div class="col-md-1"> <i class="fa fa-plus" title="Add more time" onclick="addmoreclinicTimeing('+idhere+')" style="margin-top: 12px;color:#45a049;cursor:pointer;"></i> </div></div><div class="addmoreClinicTiming'+idhere+'"></div> </div></div><i class="fa fa-times-circle remove-icon remove-icon'+rand+' firsticonremove'+idhere+'" onclick="removeClinicdiv('+rand+','+idhere+')"></i></div>');
        
            $( '.timepicker' ).timepicker({
                'timeFormat': 'h:i A',
                'step': 5,
                orientation: "auto"
            });
        });
        
        $('#addmoreEduBtn').on('click', function(){
          var rand = Math.floor((Math.random()*100)+1);
          $('.addmoreEdu').append('<div class="removediv'+rand+'" style="position:relative;"><div class="row"><div class="col-md-4"><div class="form-group"><label for="">Degree</label> <input class="form-control" name="degree[]" placeholder="MD - General Medicine"></div></div><div class="col-md-4"><div class="form-group"> <label for="">College/Institute</label><input class="form-control" name="college_institute[]" placeholder=" EnterCollege/Institute"></div></div><div class="col-md-4"><div class="form-group"><label for="">Year of Completion</label><input class="form-control" name="degree_compl_year[]" placeholder="Enter Year of Completion e.g 1988"></div></div></div><i class="fa fa-times-circle remove-icon remove-icon'+rand+'" onclick="removeEdudiv('+rand+')"></i></div>');
        });

        $('#addmoreExpBtn').on('click', function(){
          var rand = Math.floor((Math.random()*100)+1);
          $('.addmoreExp').append('<div class="removediv'+rand+'" style="position:relative;"><div class="row"><div class="col-md-4">                                    <div class="form-group">                                      <label for="">Hospital Name</label>                                     <input class="form-control" name="exp_hospital_name[]" placeholder="">                                   </div>                                  </div>                                  <div class="col-md-4">                                    <div class="form-group">                                      <label for="">From</label>                                      <input class="form-control" name="exp_from[]" placeholder="e.g 1988">                                   </div>                                  </div>                                  <div class="col-md-4">                                    <div class="form-group">                                      <label for="">To</label>                                      <input class="form-control" name="exp_to[]" placeholder="e.g 1999">                                   </div>                                  </div>                                  <div class="col-md-4">                                    <div class="form-group">                                      <label for="">Designation</label>                                     <input class="form-control" name="designation[]" placeholder="">                                   </div>                                  </div>                                </div><i class="fa fa-times-circle remove-icon remove-icon'+rand+'" onclick="removeEdudiv('+rand+')"></i></div>');
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
function display_preview(id, file){
	console.log(973, file);
	var ext = file.name.split('.').pop().toLowerCase();
	console.log(981, ext);
	var imgtype = ["jpeg", "jpg", "png", "gif"];
	var videotype = ["avi", "3gp", "mp4", "mov", "mkv", "m4v", "flv"];
	if(imgtype.indexOf(ext) > -1)
		document.getElementById(id).src = window.URL.createObjectURL(file);
	else if(ext == "pdf")
		document.getElementById(id).src = "new_assets/img/pdf.png";
	else if(ext == "doc" || ext == 'docx')
		document.getElementById(id).src = "new_assets/img/doc.png";
	else if(ext == "zip" || ext == "rar")
		document.getElementById(id).src = "new_assets/img/zip.png";
	else if(videotype.indexOf(ext) > -1)
		document.getElementById(id).src = "new_assets/img/video.png";
	else
		document.getElementById(id).src = "new_assets/img/other.png";
	
	document.getElementById(id + '_name').innerHTML = file.name;
}
</script>

</html>
