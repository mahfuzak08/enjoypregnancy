<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
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
</style>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success'); } ?>
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('doctors'); ?>    
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_new'); ?>
                            </button>
                        </div>
                    </a>
                </div>
            </header>
            <div class="panel-body"> 
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('doctor'); ?> <?php echo lang('id'); ?></th>
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo lang('email'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <th><?php echo lang('department'); ?></th>
                                <th><?php echo 'Speciality'; ?></th>
                                <th class="no-print"><?php echo lang('options'); ?></th>
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



                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<script>

    function connectCall(sender,number)
    {
        event.preventDefault();
        if (window.onCall){
            window.onCall = false;
            window.phone.disconnectAll();
            $(sender).removeClass('btn-danger');
            $(sender).html('<i class="fa fa-phone"></i>');
            return;
        }

        window.phone.connect({
            number: number
        }).on('ringing',()=>{
            console.log("Connecting To Caller"+"Info")
        });
        window.onCall = true;
        $(sender).addClass('btn-danger');
        $(sender).html('<i class="fa fa-times"></i>');
    }

    function showSendSmsModal(sender,number)
    {
        event.preventDefault();
        $('#smsModal #to_number').val(number);
        $('#smsModal').modal('show');
    }

    function sendSms()
    {
        var phone = $('#smsModal #to_number').val();
        var message = $('#smsModal #message').val();

        $('#smsModal #sendSms').attr('disabled','disabled');

        $.post('<?php echo base_url() ?>doctor/sendMessage',{
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

    function showSendEmailModal(sender,email)
    {
        event.preventDefault();
        $('#emailModal #email').val(email);
        $('#emailModal').modal('show');
    }

    function sendEmail()
    {
        var email = $('#emailModal #email').val();
        var message = $('#emailModal #body').val();

        $('#emailModal #sendEmail').attr('disabled','disabled');

        $.post('<?php echo base_url() ?>doctor/sendEmail',{
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

    function registerPhone()
    {
        $.get('<?php echo base_url() ?>doctor/getToken').done(response=>{
            if ( !window.phone ){
                window.phone = new Twilio.Device(response,{ debug: true});
                console.log("Phone Ready");
                window.phone.on('connect',()=>{
                    console.log("Call Connected "+" Success");
                })
                window.phone.on('disconnect',()=>{
                    console.log("Call Disconnected"+"Info")
                })
            }

        }).fail(error=>{
            console.log(error);
        })
    }

    // function InAppVoiceCall(patient_doctor_id)
    // {

    //     console.log(patient_doctor_id);
    //     // window.open('https://api.callgpnow.com/voicecall?roomId='+patient_doctor_id);
    //     window.open('<?php echo base_url(); ?>meeting/liveChatApp?roomId='+patient_doctor_id);
    //     // event.preventDefault();
    // }
    // function InAppVideoCall(patient_doctor_id)
    // {

    //     console.log(patient_doctor_id);
    //     // window.open('https://api.callgpnow.com/call?roomId='+patient_doctor_id);
    //     window.open('<?php echo base_url(); ?>meeting/liveChatApp?roomId='+patient_doctor_id);
    //     // event.preventDefault();
    // }

    $(document).ready(function (){
        registerPhone();
    })
</script>


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


<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_new_doctor'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="doctor/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Country'; ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="country" onchange="countryval(this.value)" value=''>
                            <option value="">Select Country</option>
                            <?php foreach ($countires as $country_val) { ?>
                                <option value="<?php echo $country_val->country; ?>"> <?php echo $country_val->country; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'City'; ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="city" id="city" value=''>
                            <option value="">Select city</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="department" value=''>
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department->name; ?>"> <?php echo $department->name; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Speciality'; ?></label>
                        <!--<input type="text" class="form-control" name="profile" id="exampleInputEmail1" value='' placeholder="">-->
                        <select class="form-control m-bot15 js-example-basic-single" name="profile" value=''>
                            <?php foreach ($speciality as $specialityval) { ?>
                                <option value="<?php echo $specialityval->speciality; ?>"> <?php echo $specialityval->speciality; ?> </option>
                            <?php } ?> 
                        </select>
                        <!--Haseen code-->
                        <div class="form-group">
                        <label class="control-label">Identity Document</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select document</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="identitydoc"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
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
                        <!--Haseen Code-->
                        <div class="form-group">
                        <label class="control-label">Licence Document</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select licence document</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="doctor_lic_doc"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Accountant Modal-->


<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="editDoctorForm" class="clearfix" action="doctor/addNew" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="modal-title"> <?php echo lang('edit_doctor'); ?></h4>
                    </div>
                    <div class="col-md-4">
                        <label>Urgent Consult: </label>
                        <label class="switch">
                            <input type="checkbox" name="urgent_care" id="urgent_care" value="1">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label>Home Visit: </label>
                        <label class="switch">
                            <input type="checkbox" name="home_visit" id="home_visit" value="1">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>               
            </div>
            <div class="modal-body">
                
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Gender</label>
                        <select class="form-control" name="gender" required>
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Date of Birth</label>
                            <input type="text" class="form-control" id="date_of_birth" readonly name="date_of_birth" placeholder="Date of Birth" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label>Doctor Type</label><br>
                      <label><input type="radio" name="doctor_type" id="doctor_type1" value="0"> GP </label>&nbsp;&nbsp;&nbsp;
                      <label><input type="radio" name="doctor_type" id="doctor_type2" value="1"> Specialist </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo 'Speciality'; ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="profile" value=''>
                            <?php foreach ($speciality as $specialityval) { ?>
                                <option value="<?php echo $specialityval->speciality; ?>"> <?php echo $specialityval->speciality; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                  </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo 'Address Line 1'; ?></label>
                            <input type="text" class="form-control" name="address[]" id="address_line_1" value='' placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo 'Address Line 2'; ?></label>
                            <input type="text" class="form-control" name="address[]" id="address_line_2" value='' placeholder="">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo 'City'; ?></label>
                         <input type="text" class="form-control m-bot15 js-example-basic-single" name="city" id="city" value=''>
                        <!-- <select class="form-control m-bot15 js-example-basic-single" name="city" id="city2" value=''>
                            <option value="">Select city</option>
                        </select> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">State / Province</label>
                            <input class="form-control" name="state_province" placeholder="State / Province" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Country'; ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="country" onchange="editcountryval(this.value)" value=''>
                            <!--<option value="">Select Country</option>-->
                            <?php foreach ($countires as $country_val) { ?>
                                <option value="<?php echo $country_val->country; ?>"> <?php echo $country_val->country; ?> </option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Postal Code</label>
                            <input class="form-control" name="postal_code" placeholder="Postal Code" required>
                        </div>
                    </div>
                    <div class="col-md-6" style="display: none;">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single department" name="department" value=''>
                            <?php foreach ($departments as $department) { ?>
                                <option value="<?php echo $department->name; ?>" <?php
                                if (!empty($doctor->department)) {
                                    if ($department->name == $doctor->department) {
                                        echo 'selected';
                                    }
                                }
                                ?> > <?php echo $department->name; ?> </option>
                                    <?php } ?> 
                        </select>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Biography</label>
                            <textarea class="form-control" name="about_me" placeholder="Biography" rows="3" style="height: inherit !important;" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <div class="row">         
                        <div class="col-md-2">                        
                            <input type="radio" name="pricing" value="free" placeholder="Clinic Address" id="free_radio">
                            <label for="free_radio"> Free </label>
                        </div>
                        <div class="col-md-3"> 
                            <input type="radio" name="pricing" value="cust_price" placeholder="Clinic Address" id="notfree_radio">
                            <label for="notfree_radio"> Custom Price</label>
                            <div class="custom_price_fields" style="display: none;"> 
                                <input type="number" name="cust_price" class="form-control" placeholder="20" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Urgent Consultation Fee</label>
                                <input type="number" class="form-control" name="urgent_fee" placeholder="Urgent Consultation Fee" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Home Visit Fee</label>
                                <input type="number" class="form-control" name="home_fee" placeholder="Home Visit Fee" value="">
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                        <style type="text/css">
                            .bootstrap-tagsinput
                            {
                                display: block;
                            }
                        </style>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Services</label>
                                <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="Enter Services" name="services" value="Audio,Video,Chat">
                                <small>Note : Type & Press enter to add new services</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Specialization</label>
                                <input type="text" class="input-tags form-control" type="text" data-role="tagsinput" id="tags" placeholder="Enter Specialization" name="specialization" value="">
                                <small>Note : Type & Press enter to add new specialization</small>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="last col-md-6">
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
                        <!-- <div class="form-group">
                        <label class="control-label">Licence Document</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="licencedoc" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select licence document</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="doctor_lic_doc"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div> -->
                    </div>
                    <!-- <div class="col-md-6">                        
                        <div class="form-group">
                        <label class="control-label">Identity Document</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="identitydoc" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select document</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="identitydoc"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div> -->
                    

                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>               
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->


<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="modal-title"> <?php echo lang('doctor'); ?> <?php echo lang('info'); ?></h4>
                    </div>
                    <div class="col-md-8">
                        <label>Urgent Consult: <span class="badge bg-success urgent_badge_status"></span></label>&nbsp;&nbsp;
                        <label>Home Visit: <span class="badge bg-success home_badge_status"></span></label>                     
                    </div>
                    <!-- <div class="col-md-3">
                        
                    </div> -->
                </div> 
            </div>
            <div class="modal-body">
                <form role="form" id="editDoctorForm" class="clearfix" action="doctor/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group last col-md-6">
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img1" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <div class="nameClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <div class="emailClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <div class="addressClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <div class="phoneClass"></div>
                    </div>
                    <!-- <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <div class="departmentClass"></div>
                    </div> -->
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Speciality'; ?></label>
                        <div class="profileClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Doctor Type'; ?></label>
                        <div class="DoctorType"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Biography'; ?></label>
                        <div class="biography"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'City'; ?></label>
                        <div class="cityDiv"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'State Province'; ?></label>
                        <div class="state_province"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Country'; ?></label>
                        <div class="countrydiv"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Postal Code'; ?></label>
                        <div class="postal_codeDiv"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Urgent Consultation Fee'; ?></label>
                        <div class="urgent_feediv"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Home Visit Fee'; ?></label>
                        <div class="home_feediv"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Services'; ?></label>
                        <div class="servicesdiv"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Specialization'; ?></label>
                        <div class="specializationdiv"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Hospital / Clinic Info'; ?></label>
                        <div class="hospital_clinic_div"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Education'; ?></label>
                        <div class="educationdiv"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Experience'; ?></label>
                        <div class="experiencediv"></div>
                        <br>
                        <label for="exampleInputEmail1"><?php echo 'Awards'; ?></label>
                        <div class="awardsdiv"></div>
                    </div>

                    <!-- <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo 'Awards'; ?></label>
                        <div class="awardsdiv"></div>
                    </div> -->

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="disapprove_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo 'Reason'; ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" class="clearfix" action="doctor/disapprove" method="post">
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea class="form-control" name="reason" required style="height: 60px !important"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="d_id" id="d_id">
                        <input type="hidden" name="d_email" id="d_email">
                        <button type="submit" class="btn btn-info">Not Approve</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<!-- <script src="common/js/codearistos.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#free_radio').click(function(){
            $('.custom_price_fields').fadeOut('slow');
        });
        $('#notfree_radio').click(function(){
            $('.custom_price_fields').fadeIn('slow');
        });
        $(".table").on("click", ".editbutton", function () {
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $("#img").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
            $('#editDoctorForm').trigger("reset");
            $.ajax({
                url: 'doctor/editDoctorByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server               
                if(response.doctor.urgent_care_status==1)
                {
                    $('#urgent_care').prop('checked',true).end();
                }

                if(response.doctor.home_visit_status==1)
                {
                    $('#home_visit').prop('checked',true).end();
                }
                

                $('#editDoctorForm').find('[name="id"]').val(response.doctor.id).end()
                $('#editDoctorForm').find('[name="name"]').val(response.doctor.name).end()
                $('#editDoctorForm').find('[name="password"]').val(response.doctor.password).end()
                $('#editDoctorForm').find('[name="email"]').val(response.doctor.email).end();
                $('#editDoctorForm').find('[name="gender"]').val(response.doctor.gender).end();
                $('#editDoctorForm').find('[name="date_of_birth"]').val(response.doctor.date_of_birth).end();
                if(response.doctor.doctor_type==0)
                {
                    $('#doctor_type1').prop('checked',true);
                }
                else
                {
                    $('#doctor_type2').prop('checked',true);
                }
                $('#editDoctorForm').find('[name="state_province"]').val(response.doctor.state_province).end();
                $('#editDoctorForm').find('[name="postal_code"]').val(response.doctor.postal_code).end();
                $('#editDoctorForm').find('[name="about_me"]').text(response.doctor.about_me).end();
                $('#editDoctorForm').find('[name="urgent_fee"]').val(response.doctor.urgent_fee).end();
                $('#editDoctorForm').find('[name="home_fee"]').val(response.doctor.home_fee).end();
                if(response.doctor.pricing=='free' || response.doctor.pricing=='')
                {
                    $('#editDoctorForm').find('[name="cust_price"]').val('').end();
                    $('#editDoctorForm').find('#free_radio').prop('checked',true).end();
                }
                if(response.doctor.pricing > 0)
                {
                    $('#editDoctorForm').find('[name="cust_price"]').val(response.doctor.pricing).end();
                    $('#editDoctorForm').find('#notfree_radio').prop('checked',true).end();
                    $('.custom_price_fields').fadeIn();
                }

                $('#editDoctorForm').find('[name="services"]').tagsinput('add', response.doctor.services);
                $('#editDoctorForm').find('[name="specialization"]').tagsinput('add', response.doctor.specialization);
                // $('#editDoctorForm').find('[name="services"]').val(response.doctor.services).end();
                var address_parser = [];
                if(response.doctor.address != null)
                {
                    address_parser = JSON.parse(response.doctor.address);
                }
                $('#editDoctorForm').find('#address_line_1').val(address_parser[0]).end();
                $('#editDoctorForm').find('#address_line_2').val(address_parser[1]).end();
                
                $('#editDoctorForm').find('[name="phone"]').val(response.doctor.phone).end()
                $('#editDoctorForm').find('[name="department"]').val(response.doctor.department).end()
                $('[name="profile"]').select2();
                $('#editDoctorForm').find('[name="profile"]').val(response.doctor.profile).trigger('change').end()
                // $('#editDoctorForm').find('[name="country"]').val(response.doctor.country).end()
                $('[name="country"]').select2();
                $('#editDoctorForm').find('[name="country"]').val(response.doctor.country).trigger('change').end()
                $('#editDoctorForm').find('[name="city"]').val(response.doctor.city).end()

                if (typeof response.doctor.img_url != 'undefined' && response.doctor.img_url != '') {
                    $("#img").attr("src", response.doctor.img_url);
                }
                if (typeof response.doctor.identitydoc != 'undefined' && response.doctor.identitydoc != '') {
                    $("#identitydoc").attr("src", response.doctor.identitydoc);
                }
                if (typeof response.doctor.doctor_lic_doc != 'undefined' && response.doctor.doctor_lic_doc != '') {
                    $("#licencedoc").attr("src", response.doctor.doctor_lic_doc);
                }
                
                $('.js-example-basic-single.department').val(response.doctor.department).trigger('change');

                $('#myModal2').modal('show');

            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".inffo", function () {
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');

            $("#img1").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
            $('.nameClass').html("").end()
            $('.emailClass').html("").end()
            $('.addressClass').html("").end()
            $('.phoneClass').html("").end()
            $('.departmentClass').html("").end()
            $('.profileClass').html("").end()
            $('.DoctorType').html("").end()
            $('.biography').html("").end()
            $('.cityDiv').html("").end()
            $('.state_province').html("").end()
            $('.countrydiv').html("").end()
            $('.postal_codeDiv').html("").end()
            $('.urgent_feediv').html("").end()
            $('.home_feediv').html("").end()
            $('.servicesdiv').html("").end()
            $('.specializationdiv').html("").end()
            $('.hospital_clinic_div').html("").end()
            $('.educationdiv').html("").end()
            $('.experiencediv').html("").end()
            $('.awardsdiv').html("").end()
            $.ajax({
                url: 'doctor/editDoctorByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editDoctorForm').find('[name="id"]').val(response.doctor.id).end()
                $('.nameClass').append(response.doctor.name).end()
                $('.emailClass').append(response.doctor.email).end()
                var address_parser = [];
                if(response.doctor.address !=null)
                {
                    address_parser = JSON.parse(response.doctor.address);
                    $('.addressClass').append(address_parser[0]+' '+address_parser[1]).end()
                }
                
                
                $('.phoneClass').append(response.doctor.phone).end()
                // $('.departmentClass').append(response.doctor.department).end()
                $('.profileClass').append(response.doctor.profile).end()
                if(response.doctor.doctor_type==0)
                {
                    $('.DoctorType').append('GP').end()
                }
                else
                {
                    $('.DoctorType').append('Specialist').end()
                }

                if(response.doctor.urgent_care_status==1)
                {
                    $('.urgent_badge_status').text('Available');
                }
                else
                {
                    $('.urgent_badge_status').text('Not Available');
                }

                if(response.doctor.home_visit_status==1)
                {
                    $('.home_badge_status').text('Available');
                }
                else
                {
                    $('.home_badge_status').text('Not Available');
                }
                
                $('.biography').append(response.doctor.about_me).end()
                $('.cityDiv').append(response.doctor.city).end()
                $('.state_province').append(response.doctor.state_province).end()
                $('.countrydiv').append(response.doctor.country).end()
                $('.postal_codeDiv').append(response.doctor.postal_code).end()
                $('.urgent_feediv').append(response.doctor.urgent_fee).end()
                $('.home_feediv').append(response.doctor.home_fee).end()
                $('.servicesdiv').append(response.doctor.services).end()
                $('.specializationdiv').append(response.doctor.specialization).end()
                if(response.doctor.clinic_info !=null)
                {
                 var clinic_arr = JSON.parse(response.doctor.clinic_info);
                 console.log(clinic_arr);
                 // return;
                 for(i=0;i<clinic_arr.length;i++)
                 {
                    var name_i = "Name: "+clinic_arr[i].clinic_name+"<br>";
                    var clinic_address = "Address: "+clinic_arr[i].clinic_address+"<br>";
                    var clinic_day = [];
                    if(clinic_arr[i].clinic_day !=null){
                        clinic_day = JSON.parse(clinic_arr[i].clinic_day);
                    }
                    var from_clinic_time = [];
                    if(clinic_arr[i].from_clinic_time !=null){
                     from_clinic_time = JSON.parse(clinic_arr[i].from_clinic_time);
                    }
                    var to_clinic_time = [];
                    if(clinic_arr[i].to_clinic_time !=null){
                     to_clinic_time = JSON.parse(clinic_arr[i].to_clinic_time);
                    }
                    var time_data = "";
                    for(j=0;j<clinic_day.length;j++)
                    {
                        time_data += "<div class='badge bg-danger'>"+clinic_day[j]+"<br>"+from_clinic_time[j]+" - "+to_clinic_time[j]+"<br></div>";
                    }
                    var data_i = name_i+clinic_address+time_data;
                    console.log(clinic_day);
                    $('.hospital_clinic_div').append(data_i+"<br><hr>").end() 
                 }  
                }                  

                if(response.doctor.education !=null)
                {
                 var education_d = JSON.parse(response.doctor.education);  
                 for(i=0;i<education_d.length;i++){     
                    $('.educationdiv').append("Degree: "+education_d[i].degree+"<br>College Institute: "+education_d[i].college_institute+"<br>Year of Completion: "+education_d[i].degree_compl_year+"<hr>").end()
                 }
                }
                if(response.doctor.experience !=null)
                {
                 var experience_d = JSON.parse(response.doctor.experience);  
                 for(i=0;i<experience_d.length;i++){     
                    $('.experiencediv').append("Hospital / Clinic: "+experience_d[i].exp_hospital_name+"<br>From: "+experience_d[i].exp_from+"<br>To: "+experience_d[i].exp_to+"<br>Designation: "+experience_d[i].designation+"<hr>").end()
                 }
                }
                if(response.doctor.awards !=null)
                {
                 var awards_d = JSON.parse(response.doctor.awards);  
                 for(i=0;i<awards_d.length;i++){     
                    $('.awardsdiv').append("Award: "+awards_d[i].awards+"<br>Year: "+awards_d[i].award_year+"<hr>").end()
                 }
                }
                // awardsdiv
                if (typeof response.doctor.img_url !== 'undefined' && response.doctor.img_url != '') {
                    $("#img1").attr("src", response.doctor.img_url);
                }

                $('#infoModal').modal('show');

            });
        });
    });
</script>





<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "doctor/getDoctor",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },

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
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
            ],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: 100,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>




<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
    
    function adduseridtomodal(id,email)
    {
        $('#d_id').val(id);
        $('#d_email').val(email);
    }
    function countryval(val)
    {
        $.post('frontend/getcities2',{country_id:val},function(result){
            // console.log(result);
            $('#city').html(result);
        });
    }
    function editcountryval(val)
    {
        $.post('frontend/getcities2',{country_id:val},function(result){
            // console.log(result);
            $('#city2').html(result);
        });
    }
    
</script>

