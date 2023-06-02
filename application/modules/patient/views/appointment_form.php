<style>
.popup-row{margin-top:5px}
</style>
<div class="<?= $template == 'doccure' ? 'col-md-12' : 'row'; ?>">
    <form role="form" id="editAppointmentForm" action="appointment/addNew" class="clearfix" method="post"
          enctype="multipart/form-data">
		<?= $template == 'doccure' ? '<div class="row popup-row">' : ''; ?>
        <div class="col-md-6 panel">
            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
            <select class="form-control m-bot15  pos_select patient" id="pos_selectPop" name="patient" value=''>
                <option value="<?php echo $patient->id; ?>"><?php echo $patient->name; ?></option>
            </select>
        </div>

        <div class="col-md-6 panel">
            <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label>
            <select class="form-control m-bot15" id="adoctorsPop" name="doctor" >
                <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?> </option>
            </select>
        </div>
		<?= $template == 'doccure' ? '</div><div class="row popup-row">' : ''; ?>
        <div class="col-md-6 panel">
            <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
            <input type="<?= $template == 'doccure' ? 'date' : 'text'; ?>" class="form-control default-date-picker" <?= $template == 'doccure' ? '' : 'readonly'; ?> id="date1Pop" name="date" value="<?=(!empty($appointment->date))?date('d-m-Y', $appointment->date):''?>" placeholder="">
        </div>
        <div class="col-md-6 panel">
            <label for="exampleInputEmail1">Available Slots</label>
            <select class="form-control m-bot15" name="time_slot" id="aslotsPop" >

            </select>
        </div>
		<?= $template == 'doccure' ? '</div><div class="row popup-row">' : ''; ?>
        <div class="col-md-6 panel">
            <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?><?php echo lang('status'); ?></label>
            <select class="form-control m-bot15" name="status" >
                <option value="Pending Confirmation" <?=($appointment->status == 'Pending Confirmation')? 'selected="selected"': ''?>  > <?php echo lang('pending_confirmation'); ?> </option>
                <option value="Confirmed"  <?=($appointment->status == 'Confirmed')? 'selected="selected"': ''?>  > <?php echo lang('confirmed'); ?> </option>
                <option value="Treated"   <?=($appointment->status == 'Treated')? 'selected="selected"': ''?>  > <?php echo lang('treated'); ?> </option>
                <option value="Cancelled"  <?=($appointment->status == 'Cancelled')? 'selected="selected"': ''?>  > <?php echo lang('cancelled'); ?> </option>
            </select>
        </div>

        <div class="col-md-6 panel">
            <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value="<?=$appointment->remarks?>" placeholder="">
        </div>
		<?= $template == 'doccure' ? '</div><div class="row popup-row">' : ''; ?>
        <!--    <div class="col-md-6 panel">
                            <label> <?php echo lang('send_sms'); ?> ? </label> <br>
                            <input type="checkbox" name="sms" class="" value="sms">  <?php echo lang('yes'); ?>
                        </div> -->
        <input type="hidden" name="id" id="appointment_id" value="<?=$appointment->id?>">

        <div class="col-md-5 panel">
            <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
        </div>
        <input type="hidden" name="request" value='<?php
        if ($this->ion_auth->in_group(array('Patient'))) {
            echo 'Yes';
        }
        ?>'>
        <div class="col-md-12 panel">
            <button type="submit" name="submit" class="btn btn-info pull-right" id="subnitBtn"> <?php echo lang('submit'); ?></button>
        </div>
		<?= $template == 'doccure' ? '</div>' : ''; ?>
    </form>

</div>
<?php
  $current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#adoctorsPop").select2({
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
        /////////////////////////////////////////////////////////////////////////////////////////////////
        $("#adoctorsPop").change(function () {

            var iid = $('#date1').val();
            var doctorr = $('#adoctorsPop').val();

            $('#aslotsPop').find('option').remove();

            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
				success: function (response) {
					var slots = response.aslots;
					$.each(slots, function (key, value) {
						$('#aslotsPop').append($('<option selected="selected">').text(value).val(value)).end();
					});
					//   $("#default-step-1 .button-next").trigger("click");
					if ($('#aslotsPop').has('option').length == 0) {                    //if it is blank.
						$('#aslotsPop').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
					}
					// Populate the form fields with the data returned from server
					//  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
				}
            });
        });

        $("#adoctorsPop").trigger('change');

        /*$("#pos_select").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOption',
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

        });*/




//////////////////////////////////////////////////////////////////////////////
        var form = $('#editAppointmentForm');
        form.submit(function(event){

            event.preventDefault();
            var id =  1;


            $('#subnitBtn').prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType:'html',
                data: form.serialize(),
                success: function( response ) {
				
                }
            }).done(function(data){
				<?php if($template == 'doccure') { ?>
				// $('.patient_details_modal').modal('show');
				patient_popup_ajax(<?= $patient->ion_user_id; ?>, '');
				<?php } else { ?>
                $('#cmodal').modal('show');
                $.snackbar({content: "Save Successfully", timeout: 10000});
				<?php } ?>
				$('#subnitBtn').prop('disabled', false);
                $('.closeajaxModal').trigger('click')
            });
        });
        $("#pos_selectPop").select2()
    });
</script>





<script type="text/javascript">
    $(document).ready(function () {
        $("#adoctorsPop").change(function () {
            // Get the record's ID via attribute
            var iid = $('#date1').val();
            var doctorr = $('#adoctorsPop').val();
            $('#aslotsPop').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
				success: function (response) {
					var slots = response.aslots;
					$.each(slots, function (key, value) {
						$('#aslotsPop').append($('<option>').text(value).val(value)).end();
					});
					//   $("#default-step-1 .button-next").trigger("click");
					if ($('#aslotsPop').has('option').length == 0) {                    //if it is blank.
						$('#aslotsPop').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
					}
					// Populate the form fields with the data returned from server
					//  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
				}
            });
        });

    });

    $(document).ready(function () {
        var iid = $('#date1').val();
        var doctorr = $('#adoctorsPop').val();
        $('#aslotsPop').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
            method: 'GET',
            data: '',
            dataType: 'json',
			success: function (response) {
				var slots = response.aslots;
				$.each(slots, function (key, value) {
					$('#aslotsPop').append($('<option>').text(value).val(value)).end();
				});
				//   $("#default-step-1 .button-next").trigger("click");
				if ($('#aslotsPop').has('option').length == 0) {                    //if it is blank.
					$('#aslotsPop').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
				}
				// Populate the form fields with the data returned from server
				//  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
			}
        });

    });




    $(document).ready(function () {
        $('#date1Pop').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
        })
            //Listen for the change even on the input
            .change(dateChanged)
            .on('changeDate', dateChanged);
    });

    function dateChanged() {
        // Get the record's ID via attribute
        var iid = $('#date1').val();
        var doctorr = $('#adoctorsPop').val();
        $('#aslotsPop').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
            method: 'GET',
            data: '',
            dataType: 'json',
			success: function (response) {
				var slots = response.aslots;
				$.each(slots, function (key, value) {
					$('#aslotsPop').append($('<option>').text(value).val(value)).end();
				});
				//   $("#default-step-1 .button-next").trigger("click");
				if ($('#aslotsPop').has('option').length == 0) {                    //if it is blank.
					$('#aslotsPop').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
				}


				// Populate the form fields with the data returned from server
				//  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
			}
        });

    }


</script>


