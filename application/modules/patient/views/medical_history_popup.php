
        <!-- page start-->
        <section class="col-md-3">
            <header class="panel-heading clearfix">
                <div class="">
                    <?php echo lang('patient'); ?> <?php echo lang('info'); ?> 
                </div>
              </header>
            <link rel="stylesheet" type="text/css" href="<?=base_url()?>common/snackbar/snackbar.css">
            <script src="<?=base_url()?>common/snackbar/snackbar.js"></script>


 

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
                            <button type="button" class="btn btn-info btn-xs btn_width " id="editPatient" title="<?php echo lang('edit'); ?>"  data-id="<?php echo $patient->id; ?>"><i class="fa fa-edit"> </i> <?php echo lang('edit'); ?></button>
                        <?php } ?>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                      <!--  <li class="active"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?><span class="label pull-right r-activity"><?php echo $patient->name; ?></span></li> -->
                        <li>  <?php echo lang('patient_id'); ?> <span class="label pull-right r-activity"><?php echo $patient->id; ?></span></li>
                        <li>  <?php echo lang('gender'); ?><span class="label pull-right r-activity"><?php echo $patient->sex; ?></span></li>
                        <li>  <?php echo lang('birth_date'); ?><span class="label pull-right r-activity"><?php echo $patient->birthdate; ?></span></li>
                        <li>  <?php echo lang('blood_group'); ?><span class="label pull-right r-activity"><?php echo $patient->bloodgroup; ?></span></li>
                        <li>  <?php echo lang('phone'); ?><span class="label pull-right r-activity"><?php echo $patient->phone; ?></span></li>
                        <li>  <?php echo lang('email'); ?><span class="label pull-right r-activity"><?php echo $patient->email; ?></span></li>
                        <li class="form-group col-md-12">

                            <label for="exampleInputAge"><?php echo lang('age'); ?></label>:
                            <span class="label pull-right r-activity">
                            <?php
                            $birthDate = strtotime($patient->birthdate);
                            $birthDate = date('m/d/Y', $birthDate);
                            $birthDate = explode("/", $birthDate);

                            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));

                            echo $age . ' Year(s)';

                            ?>
                            </span>
                        </li>
                        <li style="min-height: 50px;">  <?php echo lang('address'); ?><span class="pull-right" style="height: 200px;"><?php echo $patient->address; ?></span></li>

                    </ul>



                </section>
            </aside>


        </section>


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

            $(document).ready(function () {
            $('.mediapanel').on('click', ' .mediaBtn ', function (event) {
                if(!confirm($(this).data('message'))){
                    return false
                }
                var url = $(this).data('ref');
                popup(url, '', (screen.width*80)/100, screen.height);
            })
            })
    </script>

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

            function showSendSmsModal(sender,number,message='')
            {
                event.preventDefault();
                $('#smsModal #to_number').val(number);
                $('#smsModal #message').val(message);
                $('#smsModal').modal('show');
                $('#cmodal').modal('hide');
            }

            function sendSms()
            {
                var phone = $('#smsModal #to_number').val();
                var message = $('#smsModal #message').val();

                $('#smsModal #sendSms').attr('disabled','disabled');

                $.post('<?=base_url()?>doctor/sendMessage',{
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

            function showSendEmailModal(sender,email, message='')
            {
                event.preventDefault();
                $('#emailModal #body').val(message);
                $('#emailModal #email').val(email);
                $('#emailModal').modal('show');
                $('#cmodal').modal('hide');
            }

            function sendEmail()
            {
                var email = $('#emailModal #email').val();
                var message = $('#emailModal #body').val();

                $('#emailModal #sendEmail').attr('disabled','disabled');

                $.post('<?=base_url()?>doctor/sendEmail',{
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
                $.get('<?=base_url()?>doctor/getToken').done(response=>{
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



            $(document).ready(function (){
                registerPhone();
                $('.CloseModalBtn').click(function(){
                    $('#cmodal').modal('show');
                })

            })
        </script>

        <?php
        $current_user = $this->ion_auth->get_user_id();
        if ($this->ion_auth->in_group('Doctor')) {
            $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
        }
        ?>
        <section class="col-md-9">

            <header class="panel-heading clearfix">
                <div class="col-md-4">
                    <?php echo lang('history'); ?> | <?php echo $patient->name; ?>
                </div>
                <div class="col-md-8 mediapanel text-right">
                    <a class="btn btn-info mediaBtn" href="javascript:;" data-message="Are you sure you want to start a live voice meeting with this patient? Notification will be sent to the Patient phone." title="In App Voice Call" style="color: #fff;margin-right:5px;" data-ref="<?=base_url()?>meeting/liveChatApp?roomId=<?=$patient->id?>-<?=$doctor_id?>&amp;type=2&amp;m=2" target="_blank"><i class="fa fa-phone"></i> Voice Call</a>
                    <a class="btn btn-info mediaBtn" href="javascript:;" data-message="Are you sure you want to start a live video meeting with this patient? Notification will be sent to the Patient phone." title="In App Video Call" style="color: #fff;margin-right:5px;" data-ref="<?=base_url()?>meeting/liveChatApp?roomId=<?=$patient->id?>-<?=$doctor_id?>&amp;type=1&amp;m=2" target="_blank"><i class="fa fa-video"></i> Video Call</a>

                    <a class="btn btn-info" onclick="connectCall(this,'<?=$patient->phone?>')" title="" style="color: #fff;margin-right:5px;" href="javascript:;"><i class="fa fa-phone"></i> </a>
                    <a class="btn btn-primary" onclick="showSendSmsModal(this,'<?=$patient->phone?>')" title="" style="color: #fff;margin-right:5px;" href="#"><i class="fa fa-sms"></i> </a>
                    <a class="btn btn-primary" onclick="showSendEmailModal(this,'<?=$patient->email?>')" title="" style="color: #fff;" href="#"><i class="fa fa-envelope"></i> </a> </div>

            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#appointments" id="TabAppintment"><?php echo lang('appointments'); ?></a>
                        </li>
                        <!--li class="">
                            <a data-toggle="tab" href="#home"><?php echo lang('case_history'); ?></a>
                        </li-->
                        <li class="">
                            <a data-toggle="tab" href="#prescriptionPop" id="TabPrescription"><?php echo lang('prescription'); ?></a>
                        </li>
                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                        <li class="">
                            <a data-toggle="tab" href="#MedicalNote" id="TabMedicalNote">Medical Notes</a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#patintForm" id="TabPatintForm">Patient Symptoms</a>
                        </li>
                        <?php } ?>
                        <li class="">
                            <a data-toggle="tab" href="#labForm" id="TabLabForm"><?php echo 'Lab'; ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#profile" id="TabDocument"><?php echo lang('documents'); ?></a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#documentRequest"   id="TabDocumentRequest">Patient Document Request</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#bedTab" id="TabbedForm"><?php echo lang('bed'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#medicalhistory" id="TabMdicalHistory">Medical History</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#timelinePop"  id="TabTimelineForm"><?php echo lang('timeline'); ?></a>
                        </li>


                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">

                        <div id="medicalhistory" class="tab-pane">
                            <?php if(!empty($patient->medicale_history)) {?>
                                <div id="medicalHistory"  >
                                    <div class="">
                                        <div class="adv-table editable-table ">
                                            <h4>Medical History</h4>
                                            <ul class="list">
                                                <?php
                                                $medicale_historyArr = @explode(',',$patient->medicale_history);
                                                foreach ($medicale_historyArr as $key=>$item){
                                                    ?>
                                                    <li> <i class="fa fa-angel"></i> <?=$item?></li>
                                                <?php } ?>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div id="appointments" class="tab-pane active">
                            <div class="">
                                <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs"  id="addAppointment" href="javascript:;">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#addAppointmentModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('request_a_appointment'); ?> 
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered table-responsive" id="appointmentTable">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('date'); ?></th>
                                                <th><?php echo lang('time_slot'); ?></th>
                                                <th><?php echo lang('doctor'); ?></th>
                                                <th><?php echo lang('status'); ?></th>
                                                <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <style>
                            .modelWidth80{
                                width: 80%;
                            }

                            .modelWidth60{
                                width: 60%;
                            }
                        </style>




                        <script>
                            $(document).ready(function () {
                                selectedTab = '#TabAppintment';
                                var loader = '<div align="center"><img src="<?=base_url()?>common/img/input-spinner.gif"></div>';
                                $(document).on("click", "#editPatient", function () {
                                    var id = '';
                                    var pid = $(this).attr('data-id');




                                    $('#ajaxModalLabel').html('Edit Patient Information for <?=$patient->name?>');
                                    $('#ajaxModalContent').html(loader)
                                    $('#ajaxModal').data('id', id).modal('show');
                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: "<?=base_url('patient/editPatientPopup')?>",
                                        dataType: "html",
                                        type: 'POST',
                                        data: {'pid': pid },
                                        success: function (responce) {

                                            $('#ajaxModalContent').html(responce);
                                           // $('#ajaxModal').data('id', id).modal('show');
                                        }
                                    })
                                });

                                $('#appointmentTable').on('click', ' .liveCallBtn ', function (event) {
                                    var url = $(this).data('ref');
                                    popup(url, '', (screen.width*80)/100, screen.height);
                                })

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                $(document).on('click', ' .shortnav ', function () {
                                    ref = $(this).data('ref');
                                    title = $(this).data('title');
                                    id = $('input[name="select"]:checked').val();
                                    if(id == undefined){
                                        $.snackbar({content: "Select a Item", timeout: 10000});
                                        return false;
                                    }

                                    $('#ajaxModalLabel').html(title)
                                    $('#ajaxModalContent').html(loader)
                                    $('#ajaxModal').data('id', id).modal('show');
                                    $('#ajaxModal .modal-dialog').removeClass('modelWidth80');
                                    $.ajax({
                                        url: ref,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id},
                                        success: function (responce) {
                                            $('#ajaxModal .modal-dialog').addClass('modelWidth80');
                                            $('#ajaxModalContent').html(responce)

                                        }
                                    })

                                });




                                    var ApppointmentTable = $('#appointmentTable').DataTable({
                                        responsive: true,
                                        //   dom: 'lfrBtip',

                                        "processing": true,
                                        "serverSide": true,
                                        "searchable": true,
                                        "ajax": {
                                            url: "patient/appointmentsByPatientJson?id=<?=$patient->id?>",
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
                                                    columns: [0, 1, 2, 3, 4, 5],
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
                                            searchPlaceholder: "Search...",
                                            "url": "common/assets/DataTables/languages/english.json"
                                        },
                                    });
                                ApppointmentTable.buttons().container().appendTo('.custom_buttons');





                                $('#appointmentTable').on('click', ' .delAppbtn ', function (event) {
                                    event.stopImmediatePropagation();
                                    if(!confirm('Confirm delete?')){
                                        return false
                                    }
                                    var ref = $(this).data('ref');

                                    url ="<?=base_url('patient/delete_appointment')?>";

                                    $.ajax({
                                        url: url,
                                        dataType: "text",
                                        type: 'POST',
                                        data: { 'ref':ref },
                                        success: function( data ) {
                                            //this.parentNode.parentNode.remove(this.parentNode);
                                            $.snackbar({content: "Removed Successfully", timeout: 10000});
                                        }
                                    })
                                    ApppointmentTable.ajax.reload()
                                })

//////////////////////////Edit/////////////////////////////
                                $("#appointmentTable").on("click", ".editAppointmentBtn", function () {
                                    selectedTab = '#TabAppintment';
                                     var id = $(this).data('id');
                                     var pid = '<?=$patient->id?>';

                                     $('#ajaxModal').data('id', id).modal('show');
                                     url ="<?=base_url('patient/edit_appointment')?>";

                                    $('#ajaxModalLabel').html('Edit Appointment')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });

                                $("#appointments").on("click", "#addAppointment", function () {
                                    selectedTab = '#TabAppintment';
                                    var id = '';
                                    var pid = '<?=$patient->id?>';

                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/edit_appointment')?>";

                                    $('#ajaxModalLabel').html('Add Appointment')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });
////////////////////////reopen pre modal///////////////
                                $('.closeajaxModal').click(function(){
                                    $(selectedTab).trigger('click')
                                    $('#cmodal').modal('show');
                                })

                                $('#TabAppintment').click(function(){
                                    ApppointmentTable.ajax.reload()
                                })

/////////////////////////////////////////////////////////////////////////

                            });
                        </script>



                        <div id="prescriptionPop" class="tab-pane"> <div class="">
                                <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
                                    <div class=" no-print">
                                        <button type="button" class="btn btn-info btn_width btn-xs" id="addPrescriptionBtn">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                        </button>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered  table-responsive" style="100%;" id="prescriptionTable">
                                        <thead>
                                        <tr>

                                            <th><?php echo lang('date'); ?></th>
                                            <th><?php echo lang('doctor'); ?></th>
                                            <th><?php echo lang('medicine'); ?></th>
                                            <th class="no-print"><?php echo lang('options'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>



                        <script>
                            $(document).ready(function () {

                                var prescriptionTable = $('#prescriptionTable').DataTable({
                                    responsive: true,
                                    //   dom: 'lfrBtip',

                                    "processing": true,
                                    "serverSide": true,
                                    "searchable": true,
                                    "ajax": {
                                        url: "patient/prescriptionByPatientJson?id=<?=$patient->id?>",
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
                                                columns: [0, 1, 2, 3],
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
                                        searchPlaceholder: "Search...",
                                        "url": "common/assets/DataTables/languages/english.json"
                                    },
                                });
                                prescriptionTable.buttons().container().appendTo('.custom_buttons');


                                $('#prescriptionPop').on('click', ' .viewPrescriptionbtn ', function (event) {
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>prescription/viewPrescription?type=1&id='+id, '', (screen.width*80)/100, screen.height);
                                })


                                $('#prescriptionPop').on('click', ' .delPrescriptionbtn ', function (event) {
                                    event.stopImmediatePropagation();
                                    if(!confirm('Confirm delete?')){
                                        return false
                                    }
                                    var ref = $(this).data('ref');

                                    url ="<?=base_url('prescription/delete')?>?id="+ref;

                                    $.ajax({
                                        url: url,
                                        dataType: "text",
                                        type: 'POST',
                                        data: { 'ref':ref },
                                        success: function( data ) {
                                            //this.parentNode.parentNode.remove(this.parentNode);
                                            $.snackbar({content: "Removed Successfully", timeout: 10000});
                                        }
                                    })
                                    prescriptionTable.ajax.reload()
                                })

//////////////////////////Edit/////////////////////////////
                                $("#prescriptionPop").on("click", ".editPrescriptionBtn", function () {
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>prescription/editPrescription?type=1&id='+id, '', (screen.width*80)/100, screen.height);
                                });


                                $('#prescriptionPop').on('click', '#addPrescriptionBtn', function (event) {
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>prescription/addPrescriptionView?type=1', '', (screen.width*80)/100, screen.height);
                                })


                                $('#prescriptionPop').on('click', '.printPrescriptionbtn', function (event) {
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>prescription/viewPrescriptionPrint?type=1&id='+id, '', (screen.width*80)/100, screen.height);
                                })

                                $('#prescriptionPop').on('click', '.printPrescriptionbtn', function (event) {
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>prescription/viewPrescriptionPrint?type=1&id='+id, '', (screen.width*80)/100, screen.height);
                                })
////////////////////////reopen pre modal///////////////


                                $('#TabPrescription').click(function(){
                                    prescriptionTable.ajax.reload()
                                })

/////////////////////////////////////////////////////////////////////////


                            });
                        </script>









<div  id="MedicalNote" class="tab-pane">
                            <div class=" no-print">
                                <a class="btn btn-info btn_width btn-xs" id="AddBodycharteditor">
                                    <i class="fa fa-plus-circle"></i>  Add Medical Note
                                </a>
                            </div>
                          <!--  <a  href="prescription/bodycharteditor" class="btn green btn-xs  ">
                                <i class="fa fa-plus-circle"></i>  Add Body Chart
                            </a>
-->
                            <div class="adv-table editable-table  table-responsive">
                                <table class="table table-striped table-hover table-bordered" id="MedicalNoteTable">
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

                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <script>
                            $(document).ready(function () {

                                var medicalNoteTable = $('#MedicalNoteTable').DataTable({
                                    responsive: true,
                                    //   dom: 'lfrBtip',
                                    "processing": true,
                                    "serverSide": true,
                                    "searchable": true,
                                    "ajax": {
                                        url: "patient/medicalenoteByPatientJson?id=<?=$patient->id?>",
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
                                                columns: [0, 1, 2, 3 ],
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
                                        searchPlaceholder: "Search...",
                                        "url": "common/assets/DataTables/languages/english.json"
                                    },
                                });
                                medicalNoteTable.buttons().container().appendTo('.custom_buttons');


                                $('#MedicalNoteTable').on('click', '.viewTreatmentButton', function (event) {
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>prescription/bodychartview?id='+id, '', (screen.width*80)/100, screen.height);
                                })


                                $('#MedicalNoteTable').on('click', ' .delbtn ', function (event) {

                                    event.stopImmediatePropagation();
                                    if(!confirm('Confirm delete?')){
                                        return false
                                    }
                                    var ref = $(this).data('ref');

                                    url ="<?=base_url('patient/deleteTreatment')?>";

                                    $.ajax({
                                        url: url,
                                        dataType: "text",
                                        type: 'GET',
                                        data: { 'id':ref },
                                        success: function( data ) {
                                            //this.parentNode.parentNode.remove(this.parentNode);
                                            $.snackbar({content: "Removed Successfully", timeout: 10000});
                                        }
                                    })
                                    medicalNoteTable.ajax.reload()
                                })

//////////////////////////Edit/////////////////////////////
                                $("#MedicalNote").on("click", ".editBtn", function () {
                                    selectedTab = '#TabMedicalNote';
                                    var id = $(this).data('id');
                                    var pid = '<?=$patient->id?>';

                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/edit_appointment')?>";

                                    $('#ajaxModalLabel').html('Edit Medicale Note')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });

                                $("#MedicalNote").on("click", "#AddBodycharteditor", function () {
                                    selectedTab = '#TabMedicalNote';
                                    var id = '';
                                    var pid = '<?=$patient->id?>';

                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/add_medical_notes')?>";

                                    $('#ajaxModalLabel').html('Add Medical Note')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });
////////////////////////reopen pre modal///////////////

                                $('#TabMedicalNote').click(function(){
                                    medicalNoteTable.ajax.reload()
                                })

/////////////////////////////////////////////////////////////////////////


                            });
                        </script>




                        <div id="documentRequest" class="tab-pane">
                            <div class=" no-print">
                                <a class="btn btn-info btn_width btn-xs addBtn">
                                    <i class="fa fa-plus-circle"></i>  Add Patient Form
                                </a>
                            </div>
                            <div class="adv-table editable-table table-responsive ">
                                <table class="table table-striped table-hover table-bordered" id="docRequestTable">
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

                                    </tbody>
                                </table>
                            </div>
                        </div>




                        <script>
                            $(document).ready(function () {
                                $("#documentRequest").on("click", ".copyBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var $temp = $("<input>");
                                    $("body").append($temp);
                                    $("#documentRequest").append($temp);
                                    $temp.val($(this).data('action')).select();

                                    document.execCommand("copy");
                                    $temp.remove();
                                    $.snackbar({content: "URL copied!", timeout: 5000});
                                })

                                $('#documentRequest').on("click", ".ansBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var token = $(this).attr('data-token');
                                    popup('<?=base_url()?>patient/viewansware?token='+token, 'Answare', (screen.width*80)/100, screen.height);
                                })


                                var documentRequestTable = $('#docRequestTable').DataTable({
                                    responsive: true,
                                    //   dom: 'lfrBtip',
                                    "processing": true,
                                    "serverSide": true,
                                    "searchable": true,
                                    "ajax": {
                                        url: "patient/documentRequestByPatientJson?id=<?=$patient->id?>",
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
                                                columns: [0, 1, 2, 3, 5 ],
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
                                        searchPlaceholder: "Search...",
                                        "url": "common/assets/DataTables/languages/english.json"
                                    },
                                });
                                documentRequestTable.buttons().container().appendTo('.custom_buttons');



                                $('#documentRequest').on('click', ' .delbtn ', function (event) {

                                    event.stopImmediatePropagation();
                                    if(!confirm('Confirm delete?')){
                                        return false
                                    }
                                    var ref = $(this).data('ref');

                                    url ="<?=base_url('patient/delete_patient_form')?>";

                                    $.ajax({
                                        url: url,
                                        dataType: "text",
                                        type: 'GET',
                                        data: { 'id':ref },
                                        success: function( data ) {
                                            //this.parentNode.parentNode.remove(this.parentNode);
                                            $.snackbar({content: "Removed Successfully", timeout: 5000});
                                        }
                                    })
                                    documentRequestTable.ajax.reload()
                                })

//////////////////////////Edit/////////////////////////////
                                $("#documentRequest").on("click", ".SendSmsBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var id = $(this).data('id');
                                    var phone = $(this).data('phone');
                                    var msg = $(this).data('msg');
                                    showSendSmsModal(this, phone  , msg)
                                })

                                $("#documentRequest").on("click", ".SendEmailBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var id = $(this).data('id');
                                    var email = $(this).data('email');
                                    var msg = $(this).data('msg');
                                    showSendEmailModal(this, email  , msg)
                                })




                                $("#documentRequest").on("click", ".editBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    selectedTab = '#TabDocumentRequest';
                                    var id = $(this).data('id');
                                    var pid = '<?=$patient->id?>';

                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/edit_appointment')?>";

                                    $('#ajaxModalLabel').html('Edit Medical Note')

                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });

                                $("#documentRequest").on("click", ".addBtn", function () {
                                    selectedTab = '#TabDocumentRequest';
                                    var id = '';
                                    var pid = '<?=$patient->id?>';


                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/patient_form')?>";

                                    $('#ajaxModalLabel').html('Add New form for <?=$patient->name?>')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'GET',
                                        data: { 'id': id, 'pid': pid,'type':'document'},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });
////////////////////////reopen pre modal///////////////

                                $('#TabDocumentRequest').click(function(){
                                    documentRequestTable.ajax.reload()
                                })

/////////////////////////////////////////////////////////////////////////

                            });
                        </script>







                        <div id="patintForm" class="tab-pane">
                                <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs addBtn">
                                        <i class="fa fa-plus-circle"></i>  Add Patient Form
                                    </a>
                                </div>
                                    <div class="adv-table editable-table table-responsive ">
                                        <table class="table table-striped table-hover table-bordered" id="PatintFormTable">
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

                                            </tbody>
                                        </table>
                                    </div>
                        </div>




                        <script>
                            $(document).ready(function () {
                                $(document).on("click", ".copyBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var $temp = $("<input>");
                                  $("body").append($temp);
                                    $("#patintForm").append($temp);
                                    $temp.val($(this).data('action')).select();

                                    document.execCommand("copy");
                                    $temp.remove();
                                    $.snackbar({content: "URL copied!", timeout: 5000});
                                })

                                $('#patintForm').on("click", ".ansBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var token = $(this).attr('data-token');
                                    popup('<?=base_url()?>patient/viewansware?token='+token, 'Answare', (screen.width*80)/100 , screen.height);
                                })


                                var patintFormTable = $('#PatintFormTable').DataTable({
                                    responsive: true,
                                    //   dom: 'lfrBtip',
                                    "processing": true,
                                    "serverSide": true,
                                    "searchable": true,
                                    "ajax": {
                                        url: "patient/patintFormByPatientJson?id=<?=$patient->id?>",
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
                                                columns: [0, 1, 2, 3, 5 ],
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
                                        searchPlaceholder: "Search...",
                                        "url": "common/assets/DataTables/languages/english.json"
                                    },
                                });
                                patintFormTable.buttons().container().appendTo('.custom_buttons');



                                $('#patintForm').on('click', ' .delbtn ', function (event) {

                                    event.stopImmediatePropagation();
                                    if(!confirm('Confirm delete?')){
                                        return false
                                    }
                                    var ref = $(this).data('ref');

                                    url ="<?=base_url('patient/delete_patient_form')?>";

                                    $.ajax({
                                        url: url,
                                        dataType: "text",
                                        type: 'GET',
                                        data: { 'id':ref },
                                        success: function( data ) {
                                            //this.parentNode.parentNode.remove(this.parentNode);
                                            $.snackbar({content: "Removed Successfully", timeout: 5000});
                                        }
                                    })
                                    patintFormTable.ajax.reload()
                                })

//////////////////////////Edit/////////////////////////////
                                $("#patintForm").on("click", ".SendSmsBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var id = $(this).data('id');
                                    var phone = $(this).data('phone');
                                    var msg = $(this).data('msg');
                                    showSendSmsModal(this, phone  , msg)
                                })

                                $("#patintForm").on("click", ".SendEmailBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var id = $(this).data('id');
                                    var email = $(this).data('email');
                                    var msg = $(this).data('msg');
                                    showSendEmailModal(this, email  , msg)
                                })




                                    $("#patintForm").on("click", ".editBtn", function (event) {
                                        event.stopImmediatePropagation();
                                    selectedTab = '#TabPatintForm';
                                    var id = $(this).data('id');
                                    var pid = '<?=$patient->id?>';

                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/edit_appointment')?>";

                                    $('#ajaxModalLabel').html('Edit Medical Note')

                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });

                                $("#patintForm").on("click", ".addBtn", function () {
                                    selectedTab = '#TabPatintForm';
                                    var id = '';
                                    var pid = '<?=$patient->id?>';


                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/patient_form')?>";

                                    $('#ajaxModalLabel').html('Add New form for <?=$patient->name?>')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'GET',
                                        data: { 'id': id, 'pid': pid,'type':'symptoms'},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });
////////////////////////reopen pre modal///////////////

                                $('#TabPatintForm').click(function(){
                                    patintFormTable.ajax.reload()
                                })

/////////////////////////////////////////////////////////////////////////

                            });
                        </script>







                        <div id="labForm" class="tab-pane"> <div class="">
                                <div class=" no-print">
                                    <button class="btn btn-info btn_width btn-xs" id="addLab">
                                        <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?>
                                    </button>
                                </div>
                                <div class="adv-table editable-table table-responsive">
                                    <table class="table table-striped table-hover table-bordered" id="labFormTable">
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
                                                    <td>
                                                        <?php
                                                        $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
                                                        if (!empty($doctor_details)) {
                                                            $lab_doctor = $doctor_details->name;
                                                        } else {
                                                            $lab_doctor = '';
                                                        }
                                                        echo $lab_doctor;
                                                        ?>
                                                    </td>
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

                        <script>
                            $(document).ready(function () {
                                var labFormTable = $('#labFormTable').DataTable({
                                    responsive: true,
                                    //   dom: 'lfrBtip',
                                    "processing": true,
                                    "serverSide": true,
                                    "searchable": true,
                                    "ajax": {
                                        url: "patient/labFormByPatientJson?id=<?=$patient->id?>",
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
                                                columns: [0, 1, 2, 3  ],
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
                                        searchPlaceholder: "Search...",
                                        "url": "common/assets/DataTables/languages/english.json"
                                    },
                                });
                                labFormTable.buttons().container().appendTo('.custom_buttons');


//////////////////////////////////////////////////////Edit////////////////////////////////////////////////////

                                $('#labForm').on("click", ".viewReportbtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>lab/invoice?type=1&id='+id, 'Report', (screen.width*80)/100 , screen.height);
                                })


                                $('#labForm').on("click", "#addLab", function (event) {
                                    event.stopImmediatePropagation();
                                    var id = $(this).data('ref');
                                    popup('<?=base_url()?>lab/addLabView?type=1', 'Add Lab', (screen.width*80)/100 , screen.height);
                                })

/////////////////////////////////////////////////reopen pre modal///////////////////////////////////////////

                                $('#TabLabForm').click(function(){
                                    labFormTable.ajax.reload()
                                })

/////////////////////////////////////////////////////////////////////////
                                $("#profile").on("click", "#addDocument", function () {
                                    selectedTab = '#TabDocument';
                                    var id = '';
                                    var pid = '<?=$patient->id?>';


                                    $('#ajaxModal').data('id', id).modal('show');
                                    url ="<?=base_url('patient/add_document')?>";

                                    $('#ajaxModalLabel').html('Add New form for <?=$patient->name?>')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('#ajaxModalContent').html(responce);
                                        }
                                    })
                                });


                                $('#TabDocument').click(function(){
                                    selectedTab = '#TabDocument';
                                    var id = '';
                                    var pid = '<?=$patient->id?>';
                                    $.ajax({
                                        url: '<?=base_url('patient/document_list')?>',
                                        dataType: "html",
                                        type: 'POST',
                                        data: { 'id': id, 'pid': pid},
                                        success: function (responce) {
                                            $('.documentList').html(responce);
                                        }
                                    })

                                })
                                $("#profile").on("click", ".docDeleteBtn", function () {
                                    selectedTab = '#TabDocument';
                                    var id = '';
                                    var url = $(this).data('ref');


                                    $('#ajaxModal').data('id', id).modal('show');


                                    $('#ajaxModalLabel').html('Add New form for <?=$patient->name?>')


                                    $('#cmodal').modal('hide');
                                    $.ajax({
                                        url: url,
                                        dataType: "html",
                                        type: 'POST',
                                        success: function (responce) {

                                            $('#TabDocument').trigger('click');
                                            $('#cmodal').modal('show');
                                            $('#ajaxModal').modal('hide')
                                        }
                                    })
                                });

                            });
                        </script>

                        <div id="profile" class="tab-pane"> <div class="">
                                <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs" id="addDocument">
                                        <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                    </a>
                                </div>
                                <div class="adv-table editable-table ">
                                    <div class="documentList">

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div id="bedTab" class="tab-pane">
                            <div class="">
                                <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModa3">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="adv-table editable-table ">
                                    <table class="table table-striped table-hover table-bordered" id="bedFormTable">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('bed_id'); ?></th>
                                                <th><?php echo lang('alloted_time'); ?></th>
                                                <th><?php echo lang('discharge_time'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                var bedFormTable = $('#bedFormTable').DataTable({
                                    responsive: true,
                                    //   dom: 'lfrBtip',
                                    "processing": true,
                                    "serverSide": true,
                                    "searchable": true,
                                    "ajax": {
                                        url: "patient/bedFormByPatientJson?id=<?=$patient->id?>",
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
                                                columns: [0, 1, 2, 3  ],
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
                                        searchPlaceholder: "Search...",
                                        "url": "common/assets/DataTables/languages/english.json"
                                    },
                                });
                                bedFormTable.buttons().container().appendTo('.custom_buttons');


/////////////////////////////////////////////////reopen pre modal///////////////////////////////////////////

                                $('#TabbedForm').click(function(){
                                    bedFormTable.ajax.reload()
                                })
/////////////////////////////////////////////////////////////////////////

                                $('#timelinePop').on("click", ".timelineBtn", function (event) {
                                    event.stopImmediatePropagation();
                                    var url = $(this).data('ref');
                                    popup(url, 'Timeline', (screen.width*80)/100 , screen.height);
                                })
                            });
                        </script>


                        <div id="timelinePop" class="tab-pane">
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">
                                            Timeline
                                        </header>
                                        <!--
                                        <div class=" profile-activity" >
                                            <h5 class="pull-right">12 August 2013</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-shopping-cart"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel">
                                                        <div class="">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-clock-o"></i>
                                                            <h4>10:45 AM</h4>
                                                            <p>Purchased new equipments for zonal office setup and stationaries.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        -->

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










