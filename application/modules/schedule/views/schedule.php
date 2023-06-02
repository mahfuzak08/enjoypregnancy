<!--sidebar end-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css"/>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('time_schedule'); ?> 
                <div class="col-md-4 clearfix pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_new'); ?> 
                            </button>
                        </div>
                    </a>  
                </div>
            </header>

            <div class="panel-body">
                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> <?php echo lang('doctor'); ?></th>
                                <th> <?php echo lang('weekday'); ?></th>
                                <!-- <th> <?php echo lang('start_time'); ?></th> -->
                                <!-- <th> <?php echo lang('end_time'); ?></th> -->
                                <th> <?php echo lang('duration'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                                    <th> <?php echo lang('options'); ?></th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                            $i = 0;
                            foreach ($schedules as $schedule) {
                                $i = $i + 1;
                                ?>
                                <tr class="">
                                    <td style=""> <?php echo $i; ?></td> 
                                    <td> <?php echo $this->doctor_model->getDoctorById($schedule->doctor)->name; ?></td>
                                    <td> <?php echo $schedule->weekday; ?></td> 
                                    <!-- <td><?php echo $schedule->s_time; ?></td> -->
                                    <!-- <td><?php echo $schedule->e_time; ?></td> -->
                                    <td><?php echo $schedule->duration.' '. 'Minutes'; //* 5 . ' ' . lang('minitues'); ?></td>
                                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                                        <td>
                                            
                                            <!-- <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="<?php echo $schedule->id; ?>" onclick="gettimeslots('<?php echo $schedule->id; ?>','<?php echo $schedule->doctor; ?>','<?php echo $schedule->weekday; ?>','<?php echo $schedule->duration; ?>','<?php echo $schedule->s_time_key ?>')"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>    -->
                                            <button type="button" class="btn btn-info btn-xs btn_width" data-toggle="modal" data-id="<?php echo $schedule->id; ?>" onclick="gettimeslots('<?php echo $schedule->id; ?>','<?php echo $schedule->doctor; ?>','<?php echo $schedule->weekday; ?>','<?php echo $schedule->duration; ?>','<?php echo $schedule->s_time_key ?>')"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>   
                                            
                                            <a class="btn btn-info btn-xs btn_width delete_button" href="schedule/deleteSchedule?id=<?php echo $schedule->id; ?>&doctor=<?php echo $schedule->doctor; ?>&weekday=<?php echo $schedule->weekday; ?>&all=all" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"> </i> <?php echo lang('delete'); ?></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
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

<!-- Add Time Slot Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add'); ?> <?php echo lang('schedule'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="schedule/addSchedule1" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15" id="doctorchoose" name="doctor" value='' required>
                            <?php if (!empty($prescription->doctor)) { ?>
                                <option value="<?php echo $doctors->id; ?>" selected="selected"><?php echo $doctors->name; ?> - <?php echo $doctors->id; ?></option>  
                            <?php } ?>
                            <?php
                            if (!empty($setval)) {
                                $doctordetails1 = $this->db->get_where('doctor', array('id' => set_value('doctor')))->row();
                                ?>
                                <option value="<?php echo $doctordetails1->id; ?>" selected="selected"><?php echo $doctordetails1->name; ?> - <?php echo $doctordetails1->id; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('appointment') ?> <?php echo lang('duration') ?> </label>
                        <select class="form-control m-bot15" name="duration" id="appointment_steps" value=''>

                            <option value="15" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '15') {
                                    echo 'selected';
                                }
                            }
                            ?> > 15 Minutes </option>

                            <option value="20" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '20') {
                                    echo 'selected';
                                }
                            }
                            ?> > 20 Minutes </option>

                            <option value="30" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '30') {
                                    echo 'selected';
                                }
                            }
                            ?> > 30 Minutes </option>

                            <option value="45" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '45') {
                                    echo 'selected';
                                }
                            }
                            ?> > 45 Minutes </option>

                            <option value="60" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '60') {
                                    echo 'selected';
                                }
                            }
                            ?> > 60 Minutes </option>

                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('weekday'); ?></label>
                        <select class="form-control m-bot15" id="weekday" name="weekday" value='' required> 
                            <option value="Friday"><?php echo lang('friday') ?></option>
                            <option value="Saturday"><?php echo lang('saturday') ?></option>
                            <option value="Sunday"><?php echo lang('sunday') ?></option>
                            <option value="Monday"><?php echo lang('monday') ?></option>
                            <option value="Tuesday"><?php echo lang('tuesday') ?></option>
                            <option value="Wednesday"><?php echo lang('wednesday') ?></option>
                            <option value="Thursday"><?php echo lang('thursday') ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                        <div class="">
                            <input type="text" class="form-control timepicker" name="s_time[]" id="" value='' required>                            
                        </div>
                    </div>
                    <div class="form-group bootstrap-timepicker col-md-3">
                        <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                        <div class="">
                            <input type="text" class="form-control timepicker" name="e_time[]" id="" value='' required>                            
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="moreslotsdiv"></div>
                        <a href="javascript:void(0)" onclick="addmoreslotadmin()"><i class="fa fa-plus"></i> <b>Add more</b></a>
                    </div>
                    <input type="hidden" name="redirect" value='schedule'>
                    <input type="hidden" name="id" value=''>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Time Slot Modal-->

<!-- Edit Time Slot Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('edit'); ?>  <?php echo lang('time_slot'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editTimeSlotForm" action="schedule/editSchedule1" method="post" enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="doctor" id="doctor_id" value='' required>  
                            <option value="">Select .....</option>
                            <?php foreach ($doctors as $doctor) { ?>
                                <option value="<?php echo $doctor->id; ?>"<?php
                                if (!empty($schedule->doctor)) {
                                    if ($schedule->doctor == $doctor->id) {
                                        echo 'selected';
                                    }
                                }
                                ?>><?php echo $doctor->name; ?> </option>
                                    <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('appointment') ?> <?php echo lang('duration') ?> </label>
                        <select class="form-control m-bot15" name="duration" id="appointment_steps1" value=''>

                            <option value="15" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '15') {
                                    echo 'selected';
                                }
                            }
                            ?> > 15 Minutes </option>

                            <option value="20" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '20') {
                                    echo 'selected';
                                }
                            }
                            ?> > 20 Minutes </option>

                            <option value="30" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '30') {
                                    echo 'selected';
                                }
                            }
                            ?> > 30 Minutes </option>

                            <option value="45" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '45') {
                                    echo 'selected';
                                }
                            }
                            ?> > 45 Minutes </option>

                            <option value="60" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '60') {
                                    echo 'selected';
                                }
                            }
                            ?> > 60 Minutes </option>

                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Week Day</label>
                            <input type="text" class="form-control" id="weekday1" name="weekday" readonly required>
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="slotseditdiv"></div>                   
                        <div class="moreslotsdiv1"></div>
                        <a href="javascript:void(0)" onclick="addmoreslotadmin1()"><i class="fa fa-plus"></i> <b>Add more</b></a>
                    </div>
                                        
                    </div>
                    
                    <input type="hidden" name="redirect" value='schedule'>
                    <!-- <input type="hidden" name="id" value=''>                     -->
                    <!-- <input type="hidden" name="doctor" value='<?php echo $doctorr; ?>'> -->
                    <input type="hidden" name="redirect" id="redirect_id" value=''>
                    <input type="hidden" name="id" id="schedule_id" value=''>
                    <input type="hidden" name="s_time_key" id="s_time_key" value=''>
                    <br>
                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Time Slot Modal-->



<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $(".editbutton").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $('#editTimeSlotForm').trigger("reset");
        $('#myModal2').modal('show');
        $.ajax({
            url: 'schedule/editScheduleByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            $('#editTimeSlotForm').find('[name="id"]').val(response.schedule.id).end()
            $('#editTimeSlotForm').find('[name="s_time"]').val(response.schedule.s_time).end()
            $('#editTimeSlotForm').find('[name="e_time"]').val(response.schedule.e_time).end()
            $('#editTimeSlotForm').find('[name="weekday"]').val(response.schedule.weekday).end()
        });
    });
});
function gettimeslots(schedule_id, doctor_id, weekday, duration, s_time_key)
{
    $('#weekday1').val(weekday);
    $('#doctor_id').val(doctor_id).trigger("change");;
    $('#appointment_steps1').val(duration);
    $('#schedule_id').val(schedule_id);
    $('#s_time_key').val(s_time_key);
    $('#redirect_id').val('schedule');
    $('.moreslotsdiv1').html('');
    // alert(weekday);
    $.ajax({
        url:'<?php echo base_url() ?>schedule/geteditslotsbyAjax',
        method: 'get',
        data:'schedule_id='+schedule_id+'&doctor_id='+doctor_id+'&weekday='+weekday,
        cache: false,
        success: function(result)
        {
            var obj = JSON.parse(result);
            var i = 0;
            var html_content = "";
            while(i<obj.length)
            {
                // console.log(obj[i].s_time);
                // return;
                html_content += '<div class="row slotdiv'+i+'"> <div class="col-md-6 form-group"> <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label> <div class=""> <input type="text" class="form-control timepicker1" name="s_time[]" id="" value="'+obj[i].s_time+'" required></div> </div> <div class=" col-md-5 form-group"> <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label> <div class=""> <input type="text" class="form-control timepicker1" name="e_time[]" id="" value="'+obj[i].e_time+'" required> </div> </div> <i class="fa fa-times" style="color:red; cursor: pointer;" onclick="removeslotdiv('+i+')"></i></div>';
                i++;
            }
            $('.slotseditdiv').html(html_content);
            $('.timepicker1').timepicker('remove');
            $( '.timepicker1' ).timepicker({
                'timeFormat': 'h:i A',
                'step':duration,
                orientation: "auto"
            });
            // console.log(obj.length); 
            // return;      
            $('#myModal2').modal('show');      
        }
    });
    
}
</script>

<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
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
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
            ],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },

        });

        table.buttons().container()
                .appendTo('.custom_buttons');
    });
</script>


<script>
    $(document).ready(function () {

        $("#patientchoose").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
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
        $("#doctorchoose").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorinfo',
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
        $("#doctorchoose1").select2({
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
