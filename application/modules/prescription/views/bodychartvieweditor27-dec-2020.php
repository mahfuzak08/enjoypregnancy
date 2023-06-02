<!--sidebar end-->
<!--main content start-->


<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
    $doctordetails = $this->db->get_where('doctor', array('id' => $doctor_id))->row();
}
?>
<style>
    .ul
    {
        padding-left: 20px;
    }
    .ul li
    {
        list-style-type: square;
    }
    .ul b
    {
        color: #db133b;
    }
</style>

<section id="main-content">
    <section class="wrapperX  ">
        <!-- page start-->
        <section class="row">
            <header class="panel-heading">
                <?php
                    echo 'Medical Notes';
                ?>

            </header>
            <div class="panel col-md-12">
                <div class="col-md-3">
                    <br><br>
                    <?php if(isset($template->add_date)){?>
                    <div class="form-group">
                        <strong>Date:</strong>  <?=date('d/m/Y',$template->add_date)?>
                    </div>
                    <?php } ?>

                    <?php if(isset($template->presenting_complaint)){?>
                        <div class="form-group">
                            <strong>Presenting complaint:</strong> <p><?=$template->presenting_complaint?></p>
                        </div>
                    <?php } ?>

                    <!--<?php //if(isset($template->complaint_history)){?>
                        <div class="form-group">
                            <strong>Complaint history:</strong>
                            <p></p>
                        </div>
                    <?php //} ?> -->

                    <?php if(isset($template->medical_history)){?>
                        <div class="form-group">
                            <strong>Past Medical/Surgical/Drugs History:</strong> <p><?=$template->medical_history?></p>
                        </div>
                    <?php } ?>


                    <?php if(isset($template->medication)){?>
                        <!--<div class="form-group">-->
                        <!--    <strong>Medication:</strong> <p><?=$template->medication?></p>-->
                        <!--</div>-->
                    <?php } ?>
                    
                    <?php if(isset($template->other_history)){?>
                        <div class="form-group">
                            <strong> Others- Smoking, Alcohol, Drug abuse:</strong>  <p><?=$template->other_history?></p>
                        </div>
                    <?php } ?>
                    
                    <?php if(isset($template->vital_signs)){
                    $signs = json_decode($template->vital_signs);
                    ?>
                        <div class="form-group">
                            <strong> Vital Signs:</strong>  
                            <ul class="ul">
                                <li><b>Pulse rate:</b> <?= $signs[0] ?> pulse/min</li>
                                <li><b>Respiratory rate:</b> <?= $signs[1] ?> breaths/min</li>
                                <li><b>Temperature:</b> <?= $signs[2] ?> degree Centigrade</li>
                                <li><b>Blood Pressure:</b> <?= $signs[3] ?> mmHg</li>
                                <li><b>Blood glucose level:</b> <?= $signs[4] ?> mmol/l</li>
                            </ul>
                        </div>
                    <?php } ?>

                    <?php if(isset($template->assessment)){?>
                        <div class="form-group">
                            <strong>Assessments:</strong>  <p><?=$template->assessment?></p>
                        </div>
                    <?php } ?>
                    
                     <?php if(isset($template->treatment_plan)){?>
                        <div class="form-group">
                            <strong>Differential Diagnosis:</strong>  <p><?=$template->differential_diagnosis?></p>
                        </div>
                    <?php } ?>

                    <?php if(isset($template->treatment_plan)){?>
                        <div class="form-group">
                            <strong>Treatment Plan:</strong>  <p><?=$template->treatment_plan?></p>
                        </div>
                    <?php } ?>
                    
                    <?php if(isset($template->referral)){?>
                        <div class="form-group">
                            <strong>Referral:</strong>  <p><?=$template->referral?></p>
                        </div>
                    <?php } ?>
                    
                    <?php if(isset($template->investigations)){?>
                        <div class="form-group">
                            <strong>Investigations:</strong>  <p><?=$template->investigations?></p>
                        </div>
                    <?php } ?>
                    
                    <?php if(isset($template->prescriptions)){?>
                        <div class="form-group">
                            <strong>Prescriptions:</strong>  <p><?=$template->prescriptions?></p>
                        </div>
                    <?php } ?>


                </div>

                <div class="col-md-9">
                    <br><br>
                        <?php echo validation_errors(); ?>
                     <?php
                        foreach ($template_pic as $key=>$item){
                            ?>
                            <div class="col-md-4">
                                 <img src="<?=base_url().$item->body_pic?>" class="img img-rounded img-thumbnail">
                            </div>
                        <?php }   ?>

                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->



<style>

    form{
        border: 0px;
    }

    .med_selected{
        background: #fff;
        padding: 10px 0px;
        margin: 5px;
    }


    .select2-container--bgform .select2-selection--multiple .select2-selection__choice {
        clear: both !important;
    }

    label {
        display: inline-block;
        margin-bottom: 5px;
        font-weight: 500;
        font-weight: bold;
    }

    .medicine_block{
        background: #f1f2f7;
        padding: 50px !important;
    }


</style>


