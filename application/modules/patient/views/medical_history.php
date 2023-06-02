<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<!--sidebar end-->
<!--main content start-->
<?php date_default_timezone_set($localTimeZoneAbbr); ?>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-3" style="display: none;">
            <header class="panel-heading clearfix">
                <div class="">
                    <?php echo lang('patient'); ?> <?php echo lang('info'); ?> 
                </div>

            </header>


            <link rel="stylesheet" type="text/css" href="<?=base_url()?>common/snackbar/snackbar.css">
            <script src="<?=base_url()?>common/snackbar/snackbar.js"></script>

            <script>

                $(document).ready(function () {


                    var formHealth = $('#PatientmedicalHistoryForm');
                    formHealth.submit(function(event){

                        event.preventDefault();

                        $('#subnitBtn').prop('disabled', true);


                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'POST',
                            dataType:'html',
                            data: formHealth.serialize(),
                            success: function( response ) {

                            }
                        }).done(function(data){
                            $('#subnitBtn').prop('disabled', false);
                            alert('Record Successfully Saved.');
                            // Snackbar.show({ actionText: 'Save Successfully', });
                            // $.snackbar({content: "Save Successfully", timeout: 10000});

                        });
                    });
                });


            </script>

            <aside class="profile-nav">
                <section class="">
                    <div class="user-heading round">
                        <?php if (!empty($patient->img_url)) { ?>
                            <a href="#">
                                <img src="<?php echo $patient->img_url; ?>" alt="">
                            </a>
                        <?php } ?>
                        <h1> <?php echo $patient->name; ?> </h1>
                        <p> <?php echo $patient->email; ?> </p>
                        <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                            <button type="button" class="btn btn-info btn-xs btn_width editPatient" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $patient->id; ?>"><i class="fa fa-edit"> </i> <?php echo lang('edit'); ?></button>  
                        <?php } ?>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                      <!--  <li class="active"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?><span class="label pull-right r-activity"><?php echo $patient->name; ?></span></li> -->
                        <li>  <?php echo lang('patient_id'); ?> <span class="label pull-right r-activity"><?php echo $patient->id; ?></span></li>
                        <li>  <?php echo lang('gender'); ?><span class="label pull-right r-activity"><?php echo $patient->sex; ?></span></li>
                        <li>  <?php echo lang('birth_date'); ?><span class="label pull-right r-activity"><?php echo $patient->birthdate; ?></span></li>
                        <li>  <?php echo lang('phone'); ?><span class="label pull-right r-activity"><?php echo $patient->phone; ?></span></li>
                        <li>  <?php echo lang('email'); ?><span class="label pull-right r-activity"><?php echo $patient->email; ?></span></li>
                        <li style="height: 200px;">  <?php echo lang('address'); ?><span class="pull-right" style="height: 200px;"><?php echo $patient->address; ?></span></li>

                    </ul>

                </section>
            </aside>


        </section>





        <section class="col-md-12">
            <header class="panel-heading clearfix">
                <div class="col-md-7">
                    <?php echo lang('history'); ?> | <?php echo $patient->name; ?>
                </div>
                
            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#appointments"><?php echo lang('appointments'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#prescriptions"><?php echo lang('prescription'); ?></a>
                        </li>
                        <!--li class="">
                            <a data-toggle="tab" href="#case_history"><?php echo lang('case_history'); ?></a>
                        </li-->
                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                        <li class="">
                            <a data-toggle="tab" href="#bodycharteditor">Medical Notes</a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#patintForm">Patient Symptoms</a>
                        </li>
                        <?php } ?>
                        <li class="">
                            <a data-toggle="tab" href="#diagnostic">Diagnostic Tests</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#documents"><?php echo lang('documents'); ?></a>
                        </li>
                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                        <li class="">
                            <a data-toggle="tab" href="#contact"><?php echo lang('bed'); ?></a>
                        </li>
                        <?php } if ($this->ion_auth->in_group('Patient')) { ?>
                        <li class="">
                            <a data-toggle="tab" href="#medicalHistory">Medical History</a>
                        </li>
                        <?php } ?>
                        <li class="">
                            <a data-toggle="tab" href="#timeline"><?php echo lang('timeline'); ?></a> 
                        </li>
                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="appointments" class="tab-pane active">
                            <div class="">
                                <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#addAppointmentModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="<?php echo base_url() ?>frontend/searchdoctors">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('request_a_appointment'); ?> 
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="appointmentTable">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('time_slot'); ?></th>  
                                                <th> <?php echo 'Reasons'; ?></th>                                              
                                                <th><?php echo lang('status'); ?></th>
                                                <?php //if (!$this->ion_auth->in_group('Patient')) { ?>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                <?php //} ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
											foreach ($appointments as $appointment) { ?>
                                                <tr class="">
                                                    <td>
                                                        <?php echo '<a href="frontend/doctor_profile/'.@$appointment->doctor.'" target="_blank">'.$appointment->doctor_name.'</a>'; ?>
                                                    </td>
                                                    <td><?= date('d-m-Y', $appointment->date); ?></td>
                                                    <td><?php echo $appointment->time_slot; ?></td>                                                    
                                                    <td><?php echo $appointment->remarks; ?></td>
                                                    <td><?php echo $appointment->status; ?></td>
                                                    <td class="no-print">
                                                        <!-- <button type="button" class="btn btn-info btn-xs editAppointmentButton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $appointment->id; ?>"><i class="fa fa-edit"></i> </button> -->
                                                        <a href="<?= base_url("patient/viewInvoice/".$appointment->id); ?>" class="btn btn-success btn-xs" title="<?php echo lang('invoice'); ?>"><i class="fa fa-eye"></i> </a> 
														<?php if($appointment->review == 0){ ?>
                                                        <a href="<?= base_url("frontend/doctor_profile/".@$appointment->doctor."?review=".$appointment->id); ?>" class="btn btn-info btn-xs" title="Go to Review Page"><i class="fa fa-star"></i> </a> 
														<?php } else { ?>
                                                        <a class="btn btn-warning btn-xs" title="You give <?= $appointment->review; ?> star"><?= $appointment->review; ?><i class="fa fa-star"></i></a> 
														<?php } ?>
                                                        <?php if($appointment->status == 'Confirmed') {
                                                            $sdslot = date('d-m-Y', $appointment->date) . ' ' . explode(' To ',$appointment->time_slot)[0];
															$edslot = date('d-m-Y', $appointment->date) . ' ' . explode(' To ',$appointment->time_slot)[1];
															if( (strtotime($sdslot)-900) < time() && (strtotime($edslot)+900) > time() ){
                                                                echo '<a class="btn btn-info mediaBtn" href="javascript:void(0);" data-message="Are you sure you want to start a live video meeting with this doctor?" style="color: #fff;margin-right:5px;" data-ref="'.base_url().'meeting/liveChatApp?roomId='.$patient->id.'-'.$appointment->doctor.'&amp;type=1&amp;m=2"><i class="fa fa-headphones"></i> '.lang('live').'</a>';
                                                            }
                                                        } ?>
                                                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>  
                                                        <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="appointment/delete?id=<?php echo $appointment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- prescriptions -->
                        <div id="prescriptions" class="tab-pane"> 
							<div class="">
                                <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" href="prescription/addPrescriptionView">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>

                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th><?php echo lang('medicine'); ?></th>
                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($prescriptions as $prescription) { ?>
                                                <tr class="">
                                                    <td><?php echo date('m/d/Y', $prescription->date); ?></td>
                                                    <td><?= $prescription->doctor_name; ?></td>
                                                    <td>

                                                        <?php
                                                        if (!empty($prescription->medicine)) {
                                                            $medicine = explode('###', $prescription->medicine);

                                                            foreach ($medicine as $key => $value) {
                                                                $medicine_id = explode('***', $value);
                                                                $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                                                                if (!empty($medicine_details)) {
                                                                    $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
                                                                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                                                                    rtrim($medicine_name_with_dosage, ',');
                                                                    echo '<p>' . $medicine_name_with_dosage . '</p>';
                                                                }
                                                            }
                                                        }
                                                        ?>


                                                    </td>
                                                    <td class="no-print">
                                                        <a class="btn-xs green" href="prescription/viewPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-eye"> <?php echo lang('view'); ?> </i></a> 
                                                        <?php
                                                        if ($this->ion_auth->in_group('Doctor')) {
                                                            $current_user = $this->ion_auth->get_user_id();
                                                            $doctor_table_id = $this->doctor_model->getDoctorByIonUserId($current_user)->id;
                                                            if ($prescription->doctor == $doctor_table_id) {
                                                                ?>
                                                                <a type="button" class="btn-info btn-xs btn_width" data-toggle="modal" href="prescription/editPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>   
                                                                <a class="btn-info btn-xs btn_width delete_button" href="prescription/delete?id=<?php echo $prescription->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <a class="btn-xs invoicebutton" title="<?php echo lang('print'); ?>" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=<?php echo $prescription->id; ?>"target="_blank"> <i class="fa fa-print"></i> <?php echo lang('print'); ?></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
						<!-- case_history 
                        <div id="case_history" class="tab-pane">
                            <div class="">

                                <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                        </a>
                                    </div>
                                <?php } ?>

                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('title'); ?></th>
                                                <th><?php echo lang('description'); ?></th>
                                                <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($medical_histories as $medical_history) { ?>
                                                <tr class="">

                                                    <td><?php echo date('d-m-Y', $medical_history->date); ?></td>
                                                    <td><?php echo $medical_history->title; ?></td>
                                                    <td><?php echo $medical_history->description; ?></td>
                                                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                                        <td class="no-print">
                                                            <button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $medical_history->id; ?>"><i class="fa fa-edit"></i> </button>   
                                                            <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteCaseHistory?id=<?php echo $medical_history->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						-->
						
						<div  id="bodycharteditor" class="tab-pane">
                            <div class=" no-print">
                                <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#aAddBodycharteditor">
                                    <i class="fa fa-plus-circle"></i>  Add Medical Note
                                </a>
                            </div>
							<!--  
							<a  href="prescription/bodycharteditor" class="btn green btn-xs  ">
                                <i class="fa fa-plus-circle"></i>  Add Body Chart
                            </a>
							-->
                            <div class="adv-table editable-table  table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="">
                                    <thead>
                                    <tr>
                                        <th><?php echo lang('date'); ?></th>
                                        <th><?php echo lang('doctor'); ?></th>
                                        <th>Medical Notes</th>
                                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                            <th class="no-print"><?php echo lang('options'); ?></th>
                                        <?php } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($treatment_notes as $key=>$item) { ?>
                                        <tr class="">

                                            <td><?php echo date('d-m-Y', $item->add_date); ?></td>

                                            <td>
                                                <?php
                                                $doctor_details = $this->doctor_model->getDoctorByIonUserId($item->doctor);
                                                if (!empty($doctor_details)) {
                                                    $appointment_doctor = $doctor_details->name;
                                                } else {
                                                    $appointment_doctor = '';
                                                }
                                                echo $appointment_doctor;
                                                ?>
                                            </td>
                                            <td><?php echo $item->presenting_complaint; ?></td>
                                            <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                                <td class="no-print">
                                                    <button type="button" class="btn btn-info btn-xs btn_width viewTreatmentButton" title="<?php echo lang('view'); ?>" data-toggle="modal" data-id="<?php echo $item->id; ?>"><i class="fa fa-images"></i> </button>
                                                    <!--<button type="button" class="btn btn-info btn-xs btn_width editTreatmentButton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $item->id; ?>"><i class="fa fa-edit"></i> </button>-->
                                                    <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteTreatment?id=<?php echo $item->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="patintForm" class="tab-pane">
                                <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#aAddPatientForm">
                                        <i class="fa fa-plus-circle"></i>  Add Patient Form
                                    </a>
                                </div>
                                    <div class="adv-table editable-table table-responsive ">
                                        <table class="table table-striped table-hover table-bordered" id="">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Created Date</th>
                                                <th>Completed</th>
                                                <th>Submitted</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($patient_add_forms as $item) { ?>
                                                <tr class="">
                                                    <td><a href="<?=base_url('pf/?token='.$item->token)?>" target="_blank"><?php echo $item->template; ?></a> </td>
                                                    <td><?php echo date('m/d/Y', $item->created_at); ?></td>
                                                    <td><?php echo $item->completed; ?></td>

                                                    <td><?php echo date('m/d/Y', $item->submited_date); ?></td>
                                                    <td align="text-right">
                                                        <?php if($item->completed == 'No'){ ?>
                                                        <button class="btn btn-sm btn-default copyBtn" data-action="<?=base_url('pf/?token='.$item->token)?>">Copy link</button>
                                                        <?php } ?>
                                                        <?php if($item->answared == 'Yes'){ ?>
                                                            <button class="btn btn-sm btn-default ansBtn" data-token="<?=$item->token?>">Answer</button>
                                                        <?php } ?>
                                                         <a class="btn btn-primary  btn-sm " onclick="showSendSmsModal(this, '<?=$patient->phone;?>'  ,'Mr <?=$patient->name?>, can you please complete the form? Link: <?=base_url('pf/?token='.$item->token)?>' )"   style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-sms"></i> SMS</a>
                                                        <a class="btn btn-primary  btn-sm " onclick="showSendEmailModal(this, '<?=$patient->email;?>'  ,'Mr <?=$patient->name?>, can you please complete the form? Link: <?=base_url('pf/?token='.$item->token)?>' )"   style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-envelope"></i> Email</a>
                                                         <a  href="patient/delete_patient_form?id=<?php echo $item->id;?>&pid=<?=$patient->id?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger  btn-sm "><i class="fa fa-trash"></i> </a>

                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                        </div>


                        <div id="diagnostic" class="tab-pane"> 
							<div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('id'); ?></th>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th class="no-print"><?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($labs as $lab) { ?>
                                                <tr class="">
                                                    <td><?php echo $lab->id; ?></td>
                                                    <td><?php echo date('m/d/Y', $lab->date); ?></td>
                                                    <td><?= $lab->doctor_name; ?></td>
                                                    <td class="no-print">
                                                        <a class="btn btn-info btn-xs btn_width" href="lab/invoice?id=<?php echo $lab->id; ?>"><i class="fa fa-eye"> <?php echo lang('report'); ?> </i></a>   
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="documents" class="tab-pane"> <div class="">
                                <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal1">
                                        <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                    </a>
                                </div>
                                <div class="adv-table editable-table ">
                                    <div class="">
                                        <?php foreach ($patient_materials as $patient_material) { ?>
                                            <div class="panel col-md-3"  style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">

                                                <div class="post-info">
                                                    <?php
                                                    $ext = pathinfo($patient_material->url, PATHINFO_EXTENSION);
                                                    $extensionImg = array("jpeg", "jpg", "png", "gif", "pdf" );
                                                    $extensionVideo = array(  "mp4", "wav", "ogg", "avi","webm");
                                                    if(in_array($ext,$extensionImg)){ ?>
                                                    <a href=<?php echo $patient_material->url; ?>" data-lightbox="example-1">
                                                    <img class="example-image" src="<?php echo $patient_material->url; ?>" alt="image-1" height="100" width="100"/></a>
                                                    <?php }
                                                    if(in_array($ext,$extensionVideo)){ ?>
                                                        <a class="example-image-link" href="<?=base_url($patient_material->url)?>"  data-lightbox="example-1">
                                                            <video controls width="100%">

                                                                <source src="<?=base_url($patient_material->url) ?>"
                                                                        type="video/webm">

                                                                <source src="<?=base_url($patient_material->url) ?>"
                                                                        type="video/mp4">

                                                                Sorry, your browser doesn't support embedded videos.
                                                            </video>
                                                        </a>
                                                    <?php }?>

												<!--  <img src="<?php echo $patient_material->url; ?>" height="100" width="100">-->
                                                </div>
                                                <div class="post-info">
                                                    <?php
                                                    if (!empty($patient_material->title)) {
                                                        echo $patient_material->title;
                                                    }
                                                    ?>

                                                </div>
                                                <p></p>
                                                <div class="post-info">
                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $patient_material->url; ?>" download> <?php echo lang('download'); ?> </a>
                                                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                                        <a class="btn btn-info btn-xs btn_width" title="<?php echo lang('delete'); ?>" href="patient/deletePatientMaterial?id=<?php echo $patient_material->id; ?>"onclick="return confirm('Are you sure you want to delete this item?');"> X </a>
                                                    <?php } ?>

                                                </div>

                                                <hr>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
						
                        <div id="medicalHistory" class="tab-pane">
                            <div class="">
                                <div class="adv-table editable-table ">
                                    <form   id="PatientmedicalHistoryForm" action="<?=base_url()?>patient/SavePatientmedicalHistory" class="clearfix" method="post" enctype="multipart/form-data">

                                    <ul class="list">
                                        <?php
                                        $medicale_historyArr = @explode(',',$patient->medicale_history);
                                        $display_other_box = "";
                                        foreach ($medicalHistorySetups as $key=>$item){
                                        ?>
                                            <li><input type="checkbox" name="medicaleHistory[]" value="<?=$item->title?>" <?=(@in_array($item->title, $medicale_historyArr)?'checked':'')?> id="<?= $item->title ?>"> <?=$item->title?></li>
                                            <?php if(in_array('Other', $medicale_historyArr)){
                                                $display_other_box = "yes";
                                            } ?>
                                        <?php } ?>
                                    </ul>
                                    <div class="form-group other-history-section" <?php if($display_other_box =='yes'){}else{ ?> style="display: none;" <?php } ?>>
                                        <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="Enter Medical History" name="other_medical_history" value="<?php if($patient->other_medical_history !=''){ echo $patient->other_medical_history; } ?>"><br>
                                        <small>Note : Type & Press enter to add new medical history</small>
                                    </div>
                                        <input type="hidden" name="p_id" value="<?=$patient->id?>" >
                                        <section class="col-md-12">
                                            <button type="submit" name="submit" id="submitBtn" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                                        </section>

                                    </form>
                                </div>
                            </div>
                        </div>
						
						<div id="contact" class="tab-pane"> 
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModa3">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('bed_id'); ?></th>
                                                <th><?php echo lang('alloted_time'); ?></th>
                                                <th><?php echo lang('discharge_time'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>

                                        <?php foreach ($beds as $bed) { ?>
                                            <tr class="">
                                                <td><?php echo $bed->bed_id; ?></td>            
                                                <td><?php echo $bed->a_time; ?></td>
                                                <td><?php echo $bed->d_time; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
						<div id="timeline" class="tab-pane"> 
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">
                                            Timeline
                                        </header>
                                        <?php
                                        if (!empty($timeline)) {
                                            krsort($timeline);
                                            foreach ($timeline as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        ?>

                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </section>



    </section>
    <!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Patient Material Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('add'); ?> <?php echo lang('files'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterial" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->
<style>
.input-group{
  display: table;
  border-collapse: collapse;
  width: auto;
  margin-bottom: 5px;
}
.input-group > div{
  display: table-cell;
  border: 1px solid #ddd;
  vertical-align: middle;  /* needed for Safari */
}
.input-group-icon{
  background:#eee;
  color: #777;
  padding: 0 12px
}
.input-group-area{
  /*width:50%;*/
}
.input-group input{
  border: 0;
  display: block;
  width: 70px;
  padding: 8px;
  text-align: center;
}
</style>
<!-- Add bodychartModal Modal-->
<div class="modal fade" id="aAddBodycharteditor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;  ">
    <div class="modal-dialog">

            <div class="modal-body">
                <form role="form" action="patient/save_treatment_note" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="date" value='' placeholder="" readonly="" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Presenting complaint</label>
                        <input type="text" class="form-control form-control-inline input-medium" name="presenting_complaint" id="presenting_complaint" value='' placeholder=""  required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="">Past Medical/Surgical/Drugs History</label>
                        <div class="">
                            <textarea class="form-control" name="medical_history" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="">Others- Smoking, Alcohol, Drug abuse</label>
                        <div class="">
                            <textarea class="form-control" name="other_history" value="" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="">Vital Signs</label>
                        <div class="input-group">
                          <div class="input-group-icon">Pulse rate:</div>
                          <div class="input-group-area"><input type="text" name="vital_signs[]" value="" placeholder="0"></div>
                          <div class="input-group-icon">pulse/min</div>
                        </div>
                        
                        <div class="input-group">
                          <div class="input-group-icon">Respiratory rate:</div>
                          <div class="input-group-area"><input type="text" name="vital_signs[]" value="" placeholder="0"></div>
                          <div class="input-group-icon">breaths/min</div>
                        </div>
                        
                        <div class="input-group">
                          <div class="input-group-icon">Temperature:</div>
                          <div class="input-group-area"><input type="text" name="vital_signs[]" value="" placeholder="0"></div>
                          <div class="input-group-icon">degree Centigrade</div>
                        </div>
                        
                        <div class="input-group">
                          <div class="input-group-icon">Blood Pressure:</div>
                          <div class="input-group-area"><input type="text" name="vital_signs[]" value="" placeholder="0"></div>
                          <div class="input-group-icon">mmHg</div>
                        </div>
                        
                        <div class="input-group">
                          <div class="input-group-icon">Blood glucose level:</div>
                          <div class="input-group-area"><input type="text" name="vital_signs[]" value="" placeholder="0"></div>
                          <div class="input-group-icon">mmol/l</div>
                        </div>
                        
                        <!--<textarea class="form-control" name="medication" value="" rows="10" style="height: 118px !important;">
                            Pulse rate____pulse/min
                            Respiratory rate____breaths/min
                            Temperature____degree Centigrade
                            Blood Pressure____mmHg
                            Blood glucose level____mmol/l
                        </textarea>-->
                    </div>

                    <div class="form-group col-md-12">
                        <label class="">Assessments</label>
                        <div class="">
                            <textarea class="form-control" name="assessment" value="" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="">Differential Diagnosis &nbsp;&nbsp;&nbsp;&nbsp;<a href="https://termbrowser.nhs.uk/" target="_blank">https://termbrowser.nhs.uk</a></label>
                        <div class="">
                            <textarea class="form-control" name="differential_diagnosis" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="">Treatment Plan</label>
                        <div class="">
                            <textarea class="form-control" name="treatment_plan" value="" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="">Referral</label>
                        <div class="">
                            <textarea class="form-control" name="referral" value="" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="">Investigations</label>
                        <div class="">
                            <textarea class="form-control" name="investigations" value="" rows="10"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="">Prescriptions</label>
                        <div class="">
                            <textarea class="form-control" name="prescriptions" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
                    <div class="form-group col-md-12" id="bodyloader">
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary btn_width btn-xs BtnBodyChart" type="button"   data-id="<?php echo $patient->id; ?>">   <i class="fa fa-plus-circle"> </i>  Add body Chart</button>
                    </div>




                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-success submit_button pull-right">Save as Final</button>
                        <!--<button type="submit" name="submit" class="btn btn-info submit_button pull-right">Save as draft</button>-->
                    </div>
                </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add PatientFormModalModal Modal-->
<div class="modal fade" id="aAddPatientForm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;  ">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">   New form for <?=$patient->name?> </h4>
        </div>
        <div class="modal-body">
            <form role="form" action="patient/save_patient_form" class="clearfix row" method="post" enctype="multipart/form-data">

                <div class="form-group col-md-12">
                    <label for="formtemplate">Form Template</label>
                    <select  class="form-control form-control-inline input-medium" name="form_id" id="formtemplate"  required>
                        <option value="">--Select a Form Template--</option>
                        <?php
                        foreach($templateforms as $key=>$item){
                        ?>
                        <option value="<?=$item->id;?>"><?=$item->name;?></option>
                        <?php } ?>
                    </select>
                </div>
             <!--   <div class="form-group col-md-12">
                    <label  for="appointment">Appointment</label>
                    <div class="">
                        <select class="form-control form-control-inline input-medium" name="appointment_id" id="appointment_id"  >
                            <option value="">--Select Appointment--</option>
                            <?php
                /*                            foreach($appointments as $key=>$item){
                                                */?>
                                <option value="<?/*=$item->id;*/?>"><?/*=date('d/m/Y',$item->date);*/?> <?/*=$item->time_slot;*/?></option>
                            <?php /*} */?>
                        </select>
                    </div>
                </div>
-->


                <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                <input type="hidden" name="id" value=''>
                <div class="form-group col-md-12">
                    <button type="submit" name="submit" class="btn btn-success submit_button pull-right">Create Form</button>
                    <!--<button type="submit" name="submit" class="btn btn-info submit_button pull-right">Save as draft</button>-->
                </div>
            </form>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Add Medical History Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_case'); ?></h4>
            </div> 
            <div class="modal-body">
                <form role="form" action="patient/addMedicalHistory" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Add Medical History Modal-->
<!-- Edit Medical History Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_case'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="medical_historyEditForm" class="clearfix row" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
}
?>

<!-- Add Appointment Modal-->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('add_appointment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single pos_select" id="pos_select" name="patient" value=''> 
                            <option value="">Select .....</option>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->name; ?> </option>
                        </select>
                    </div>
                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" id="adoctors" name="doctor" value=''>  

                        </select>
                    </div>


                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" id="date" readonly="" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label> 
                        <select class="form-control m-bot15" name="time_slot" id="aslots" value=''> 

                        </select>
                    </div>

                    <div class="col-md-6 panel"> 
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>

                            <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                <option value="Pending Confirmation" <?php
                                ?> > <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>
                                <option value="Treated" <?php
                                ?> > <?php echo lang('treated'); ?> </option>
                                <option value="Cancelled" <?php ?> > <?php echo lang('cancelled'); ?> </option>
                            <?php } else { ?>
                                <option value="Requested" <?php ?> > <?php echo lang('requested'); ?> </option> 
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-8 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>




                    <div class="col-md-5 panel">
                        <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                    </div>

                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>

                    <input type="hidden" name="request" value='<?php
                    if ($this->ion_auth->in_group(array('Patient'))) {
                        echo 'Yes';
                    }
                    ?>'>

                    <div class="col-md-12 panel">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->

<!-- Edit Event Modal-->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('edit_appointment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editAppointmentForm" class="clearfix row" action="appointment/addNew" method="post" enctype="multipart/form-data">
                    <div class="col-md-4 panel"> 
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single pos_select patient" id="pos_select" name="patient" value=''> 
                            <option value="">Select .....</option>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->name; ?> </option>
                        </select>
                    </div>

                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label> 
                        <?php if ($this->ion_auth->in_group('Patient')) { ?>
                        <input type="hidden" name="doctor">
                        <select class="form-control m-bot15 doctor" id="adoctors1" name="doctor1" value='' disabled="disabled">  

                        </select>
                        <?php }else{ ?>
                        <select class="form-control m-bot15 doctor" id="adoctors1" name="doctor" value=''>  

                        </select>
                        <?php } ?>
                    </div>


                    <div class="col-md-4 panel"> 
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" readonly="" id="date1" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label> 
                        <select class="form-control m-bot15" name="time_slot" id="aslots1" value=''> 

                        </select>
                    </div>

                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        <select class="form-control m-bot15" name="status" value=''>
                            <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                <option value="Pending Confirmation" <?php ?> > <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>
                                <option value="Treated" <?php
                                ?> > <?php echo lang('treated'); ?> </option>
                                <option value="Cancelled" <?php ?> > <?php echo lang('cancelled'); ?> </option>
                            <?php } else { ?>
                                <option value="Requested" <?php ?> > <?php echo lang('requested'); ?> </option> 
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-8 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <?php if ($this->ion_auth->in_group('Patient')) { ?>
                        <div class="col-md-6 panel">
                            <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>>
                    <input type="hidden" name="id" id="appointment_id" value=''>

                    <div class="col-md-12 panel">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<!-- Edit Patient Modal-->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_patient'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editPatientForm" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('change'); ?><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
                    </div>



                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                        <select class="form-control m-bot15" name="sex" value=''>

                            <option value="Male" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Male') {
                                    echo 'selected';
                                }
                            }
                            ?> > Male </option>
                            <option value="Female" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Female') {
                                    echo 'selected';
                                }
                            }
                            ?> > Female </option>
                            <option value="Others" <?php
                            if (!empty($patient->sex)) {
                                if ($patient->sex == 'Others') {
                                    echo 'selected';
                                }
                            }
                            ?> > Others </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="" placeholder="" readonly="">      
                    </div>


                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                        <select class="form-control m-bot15" name="bloodgroup" value=''>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?php echo $group->group; ?>" <?php
                                if (!empty($patient->bloodgroup)) {
                                    if ($group->group == $patient->bloodgroup) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $group->group; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>

                    <div class="form-group col-md-6">    
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control js-example-basic-single doctor"  name="doctor" value=''> 
                            <option value=""> </option>
                            <?php foreach ($doctors as $doctor) { ?>                                        
                                <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>



                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!--
                    
                    <div class="form-group last col-md-6">
                        <div style="text-align:center;">
                            <video id="video" width="200" height="200" autoplay></video>
                            <div class="snap" id="snap">Capture Photo</div>
                            <canvas id="canvas" width="200" height="200"></canvas>
                            Right click on the captured image and save. Then select the saved image from the left side's Select Image button.
                        </div>
                    </div>
                    
                    -->








                    <div class="form-group col-md-6">
                        <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                    </div>

                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value='<?php
                    if (!empty($patient->patient_id)) {
                        echo $patient->patient_id;
                    }
                    ?>'>







                    <section class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<!-- Edit Patient Modal-->

<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  Send Message</h4>
            </div>
            <div class="modal-body" style="padding: 20px !important;">
                <input value="" id="to_number" type="hidden"/>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="message">Message</label>
                        <textarea class='form-control' id="message" placeholder="Type your message here"></textarea>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <button class="btn btn-primary" id="sendSms" onclick="sendSms()">Send SMS</button>
                    </div>
                </div>
                <div class="" id="info" style="display:none">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  Send Email</h4>
            </div>
            <div class="modal-body" style="padding: 20px !important;">
                <input value="" id="email" type="hidden"/>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="message">Email Message</label>
                        <textarea class='form-control' id="body" placeholder="Type your email here"></textarea>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <button class="btn btn-primary" id="sendEmail" onclick="sendEmail()">Send Email</button>
                    </div>
                </div>
                <div class="error" id="info" style="display:none">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>

<style>


    thead {
        background: #f1f1f1; 
        border-bottom: 1px solid #ddd; 
    }

    .btn_width{
        margin-bottom: 20px;
    }

    .tab-content{
        padding: 20px 0px;
    }

    .cke_editable {
        min-height: 1000px;
    }
    .bootstrap-tagsinput input
    {
        width: 255px;
    }
</style>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<!-- Bootstrap Tagsinput JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    function showSendEmailModal(sender,email, message)
    {
        event.preventDefault();
   
        $('#emailModal #email').val(email);
        $('#emailModal #body').val(message);
        $('#emailModal').modal('show');
    }

    function sendEmail()
    {
        var email = $('#emailModal #email').val();
        var message = $('#emailModal #body').val();

        $('#emailModal #sendEmail').attr('disabled','disabled');

        $.post('https://callgpnow.com/public/doctor/sendEmail',{
            email: email,
            body: message
        }).done(response=>{
            response = JSON.parse(response);
            if (!response.success){
                $('#emailModal #info').addClass('bg-danger');
            }else{
                $('#emailModal #info').addClass('bg-success');
                $('#emailModal #message').val('')
            }
            $('#emailModal #info').text(response.message);
            $('#emailModal #info').show();
            $('#emailModal #sendEmail').removeAttr('disabled');
        }).fail(error=>{
            $('#emailModal #message').val('')
            $('#emailModal #info').addClass('bg-danger');
            $('#emailModal #info').text(error.message);
            $('#emailModal #info').show();
            $('#emailModal #sendEmail').removeAttr('disabled');
        })
    }

    function popup(url, title, width, height) {
        var left = (screen.width / 2) - (width / 2);
        var top =  (screen.height / 2) - (height / 2);
        var options = '';
        options += ',width=' + width;
        options += ',height=' + height;
        options += ',top=' + top;
        options += ',left=' + left;
        return window.open(url, title, options);
    }

    $(document).ready(function () {
        $('body').on('click', ' .mediaBtn ', function (event) {
            if(!confirm($(this).data('message'))){
                return false
            }
            var url = $(this).data('ref');
            popup(url, '', (screen.width*80)/100, screen.height);
        })
    });

    $(document).ready(function () {
    $(".editbutton").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $('#myModal2').modal('show');
        $.ajax({
            url: 'patient/editMedicalHistoryByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            // Populate the form fields with the data returned from server
			response.medical_history.date = isNaN(response.medical_history.date) ? response.medical_history.date : response.medical_history.date * 1000;
			console.log(1543, response.medical_history.date);
            var date = new Date(response.medical_history.date);
			console.log(1545, date);
            var de = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
			console.log(1547, de);
            $('#medical_historyEditForm').find('[name="id"]').val(response.medical_history.id).end()
            $('#medical_historyEditForm').find('[name="date"]').val(de).end()
            $('#medical_historyEditForm').find('[name="title"]').val(response.medical_history.title).end()
            CKEDITOR.instances['editor'].setData(response.medical_history.description)
        });
    });

    $('#Other').click(function(){
        if($('#Other').is(':checked'))
        {
            $('.other-history-section').fadeIn('slow');
        }
        else
        {
            $('.other-history-section').fadeOut('slow');
        }
    });
});
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".editPrescription").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal5').modal('show');
            $.ajax({
                url: 'prescription/editPrescriptionByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#prescriptionEditForm').find('[name="id"]').val(response.prescription.id).end()
                $('#prescriptionEditForm').find('[name="patient"]').val(response.prescription.patient).end()
                $('#prescriptionEditForm').find('[name="doctor"]').val(response.prescription.doctor).end()

                CKEDITOR.instances['editor1'].setData(response.prescription.symptom)
                CKEDITOR.instances['editor2'].setData(response.prescription.medicine)
                CKEDITOR.instances['editor3'].setData(response.prescription.note)
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".editAppointmentButton").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var id = $(this).attr('data-id');

            $('#editAppointmentForm').trigger("reset");
            $('#editAppointmentModal').modal('show');
            $.ajax({
                url: 'appointment/editAppointmentByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var de = isNaN(response.appointment.date) ? response.appointment.date : response.appointment.date * 1000;
                var d = new Date(de);
                var da = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
                // Populate the form fields with the data returned from server
                $('#editAppointmentForm').find('[name="id"]').val(response.appointment.id).end()
                $('#editAppointmentForm').find('[name="patient"]').val(response.appointment.patient).end()
                //  $('#editAppointmentForm').find('[name="doctor"]').val(response.appointment.doctor).end()
                $('#editAppointmentForm').find('[name="date"]').val(da).end()
                $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                var option1 = new Option(response.doctor.name + '-' + response.doctor.id, response.doctor.id, true, true);
                $('#editAppointmentForm').find('[name="doctor"]').val(response.doctor.id);
                $('#editAppointmentForm').find('[name="doctor1"]').append(option1).trigger('change');
                // $('.js-example-basic-single.doctor').val(response.appointment.doctor).trigger('change');
                $('.js-example-basic-single.patient').val(response.appointment.patient).trigger('change');




                var date = $('#date1').val();
                var doctorr = $('#adoctors1').val();
                var appointment_id = $('#appointment_id').val();
                // $('#default').trigger("reset");
                $.ajax({
                    url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + appointment_id,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function (response) {
                    $('#aslots1').find('option').remove();
                    var slots = response.aslots;
                    $.each(slots, function (key, value) {
                        $('#aslots1').append($('<option>').text(value).val(value)).end();
                    });

                    $("#aslots1").val(response.current_value)
                            .find("option[value='" + response.current_value + "']").attr('selected', true);
                    //  $('#aslots1 option[value=' + response.current_value + ']').attr("selected", "selected");
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                    }
                    // Populate the form fields with the data returned from server
                    //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                });
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#adoctors").change(function () {
            // Get the record's ID via attribute  
            var iid = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
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
        var iid = $('#date').val();
        var doctorr = $('#adoctors').val();
        $('#aslots').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
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
        var iid = $('#date').val();
        var doctorr = $('#adoctors').val();
        $('#aslots').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
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

<script type="text/javascript">
    $(document).ready(function () {
        $("#adoctors1").change(function () {
            // Get the record's ID via attribute 
            var id = $('#appointment_id').val();
            var date = $('#date1').val();
            var doctorr = $('#adoctors1').val();
            $('#aslots1').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var slots = response.aslots;
                $.each(slots, function (key, value) {
                    $('#aslots1').append($('<option>').text(value).val(value)).end();
                });
                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                    $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });
        });
    });

    $(document).ready(function () {
        var id = $('#appointment_id').val();
        var date = $('#date1').val();
        var doctorr = $('#adoctors1').val();
        $('#aslots1').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var slots = response.aslots;
            $.each(slots, function (key, value) {
                $('#aslots1').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }
            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    });




    $(document).ready(function () {
        $('#date1').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
        })
                //Listen for the change even on the input
                .change(dateChanged1)
                .on('changeDate', dateChanged1);
    });

    function dateChanged1() {
        // Get the record's ID via attribute  
        var id = $('#appointment_id').val();
        var iid = $('#date1').val();
        var doctorr = $('#adoctors1').val();
        $('#aslots1').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + iid + '&doctor=' + doctorr + '&appointment_id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var slots = response.aslots;
            $.each(slots, function (key, value) {
                $('#aslots1').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }


            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    }




</script>

<script>
    function showSendSmsModal(sender, number, message)
    {
        event.preventDefault();

        $('#smsModal #to_number').val(number);
        $('#smsModal #message').val(message);
        $('#smsModal').modal('show');
    }

    function sendSms()
    {
        var phone = $('#smsModal #to_number').val();
        var message = $('#smsModal #message').val();

        $('#smsModal #sendSms').attr('disabled','disabled');

        $.post('https://callgpnow.com/public/doctor/sendMessage',{
            to: phone,
            body: message
        }).done(response=>{
            response = JSON.parse(response);
            if (!response.success){
                $('#smsModal #info').addClass('bg-danger');
            }else{
                $('#smsModal #info').addClass('bg-success');
                $('#smsModal #message').val('')
            }
            $('#smsModal #info').text(response.message);
            $('#smsModal #info').show();
            $('#smsModal #sendSms').removeAttr('disabled');
        }).fail(error=>{
            $('#smsModal #message').val('')
            $('#smsModal #info').addClass('bg-danger');
            $('#smsModal #info').text(error.message);
            $('#smsModal #info').show();
            $('#smsModal #sendSms').removeAttr('disabled');
        })
    }

    $(document).ready(function () {
        $('#appointmentTable').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1],
                    }
                },
            ],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": false,
            "language": {
                "lengthMenu": "_MENU_ records per page",
            }


        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {
        $(".editPatient").click(function () {
            //    e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editPatientForm').trigger("reset");
            $.ajax({
                url: 'patient/editPatientByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server

                $('#editPatientForm').find('[name="id"]').val(response.patient.id).end()
                $('#editPatientForm').find('[name="name"]').val(response.patient.name).end()
                $('#editPatientForm').find('[name="password"]').val(response.patient.password).end()
                $('#editPatientForm').find('[name="email"]').val(response.patient.email).end()
                $('#editPatientForm').find('[name="address"]').val(response.patient.address).end()
                $('#editPatientForm').find('[name="phone"]').val(response.patient.phone).end()
                $('#editPatientForm').find('[name="sex"]').val(response.patient.sex).end()
                $('#editPatientForm').find('[name="birthdate"]').val(response.patient.birthdate).end()
                $('#editPatientForm').find('[name="bloodgroup"]').val(response.patient.bloodgroup).end()
                $('#editPatientForm').find('[name="p_id"]').val(response.patient.patient_id).end()

                if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
                    $("#img").attr("src", response.patient.img_url);
                }


                $('.js-example-basic-single.doctor').val(response.patient.doctor).trigger('change');
                $('#infoModal').modal('show');
            });
        });
    });
</script>

<script>
    $(document).ready(function () {


        $("#adoctors").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
        $("#adoctors1").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

<!-- Edit Patient Modal-->
<div class="modal fade" id="TemplateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Add Template</h4>
            </div>
            <div class="modal-body row  ">

                <?php
                foreach ($template as $key => $item) {
                    ?>
                    <a href="javascript:;" data-template_id="<?=$item->id?>" data-img="<?= base_url('common/' . $item->image) ?>"
                       class="col-md-3 thumbnails text-center">
                        <img src="<?= base_url('common/' . $item->thumbnil) ?>"
                             class="img img-thumbnail img-responsive">
                        <h5> <?= $item->title; ?></h5>
                    </a>

                <?php } ?>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>
    function popup(url, title, width, height) {
        var left = (screen.width / 2) - (width / 2);
        var top =  (screen.height / 2) - (height / 2);
        var options = '';
        options += ',width=' + width;
        options += ',height=' + height;
        options += ',top=' + top;
        options += ',left=' + left;
        return window.open(url, title, options);
    }
    function setData(data) {
        var strData = JSON.stringify(data);
      //  document.getElementById('retrievedData').innerHTML = strData;
       // alert(data)
       // var img = '<img src="'+data+'" class="img img-thumbnail" width="150">'
       // img += '<input type="hidden" name="template[]" value="'+data+'">'
        $('#bodyloader').append(data);

     //  alert(img)
    }
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);

        $('.BtnBodyChart').click(function(){
            var iid = $(this).attr('data-id');

           // popup('<?=base_url()?>prescription/bodycharteditor', '', screen.width, screen.height);

            $('#TemplateModal').modal('show');
            $('#aAddBodycharteditor').modal('hide');


        })


        $(document).on("click", ".thumbnails", function (e) {
            var img = $(this).data('img');
            var template_id = $(this).data('template_id');
            popup('<?=base_url()?>prescription/bodycharteditor?template_id='+template_id, '', screen.width, screen.height);
            $('#TemplateModal').modal('hide');
            $('#aAddBodycharteditor').modal('show');
        });


        $(document).on("click", ".crossBtn", function () {
            $('#bodychartModal').modal('hide');
            $('#aAddBodycharteditor').modal('show');
        })

        $(document).on("click", ".viewTreatmentButton", function () {
            var iid = $(this).attr('data-id');
            popup('<?=base_url()?>prescription/bodychartview?id='+iid, 'Body Chart Template', screen.width , screen.height);
        })
        $(document).on("click", ".copyBtn", function () {

            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).data('action')).select();
            document.execCommand("copy");
            $temp.remove();
        })

        $(document).on("click", ".ansBtn", function () {
            var token = $(this).attr('data-token');
            popup('<?=base_url()?>patient/viewansware?token='+token, 'Answare', screen.width , screen.height);
        })



    });
</script>
