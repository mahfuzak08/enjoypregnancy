<form role="form" onsubmit="return false;" id="save_medical_note" class="clearfix row" method="post" enctype="multipart/form-data">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
        <input type="<?= $template == 'doccure' ? 'date' : 'text'; ?>" class="form-control form-control-inline input-medium default-date-picker" name="date" id="date2" value='' placeholder="" <?= $template == 'doccure' ? '' : 'readonly'; ?> required>
    </div>
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1">Presenting complaint</label>
        <input type="text" class="form-control form-control-inline input-medium" name="presenting_complaint" id="presenting_complaint" value='' placeholder=""  required>
    </div>
    <div class="form-group col-md-12">
        <label class="">Past Medical/Surgical/Drugs History</label>
        <div class="">
            <textarea class="form-control" name="medical_history" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Others- Smoking, Alcohol, Drug abuse</label>
        <div class="">
            <textarea class="form-control" name="other_history" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Vital Signs</label>
        <div class="input-group">
            <div class="input-group-icon">Heart rate:</div>
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
            <textarea class="form-control" name="assessment" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Differential Diagnosis &nbsp;&nbsp;&nbsp;&nbsp;<a href="https://termbrowser.nhs.uk/" target="_blank">https://termbrowser.nhs.uk</a></label>
        <div class="">
            <textarea class="form-control" name="differential_diagnosis" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Treatment Plan</label>
        <div class="">
            <textarea class="form-control" name="treatment_plan" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Referral</label>
        <div class="">
            <textarea class="form-control" name="referral" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Investigations</label>
        <div class="">
            <textarea class="form-control" name="investigations" value="" rows="2"></textarea>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label class="">Prescriptions</label>
        <div class="">
            <textarea class="form-control" name="prescriptions" value="" rows="2"></textarea>
        </div>
    </div>

    <input type="hidden" name="patient_id" value="<?php echo $patient->id; ?>">
    <div class="form-group col-md-12" id="bodyloader">
    </div>
    <div class="form-group col-md-6">
        <button class="btn btn-primary btn_width btn-xs BtnBodyChart" type="button"   data-id="<?php echo $patient->id; ?>">   <i class="fa fa-plus-circle"> </i>  Add body Chart</button>
    </div>




    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
    <input type="hidden" name="id" value=''>
    <div class="form-group col-md-6">
        <button type="submit" id="subnitBtn" onclick="save_m_note()" name="submit" class="btn btn-success submit_button pull-right" style="<?= $template == 'doccure' ? 'float: right;' : ''; ?>">Save as Final</button>
        <!--<button type="submit" name="submit" class="btn btn-info submit_button pull-right">Save as draft</button>-->
    </div>
</form>



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


<script>

    $(document).ready(function () {
        $('#date2').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
        })

        var form = $('#save_medical_note');
        form.submit(function(event){
            event.preventDefault();
			return false;
		})
            // var id =  1;


            // $('#subnitBtn').prop('disabled', true);

            // $.ajax({
                // url: $(this).attr('action'),
                // type: 'POST',
                // dataType:'html',
                // data: form.serialize(),
                // success: function( response ) {

                // }
            // }).done(function(data){
				// <?php if($template == 'doccure') { ?>
				// patient_popup_ajax(<?= $patient->ion_user_id; ?>, '');
				// <?php } else { ?>
                // $('#cmodal').modal('show');
                // $.snackbar({content: "Save Successfully", timeout: 10000});
				// <?php } ?>
				// $('#subnitBtn').prop('disabled', false);
                // $('.closeajaxModal').trigger('click')
            // });
        // });
    });
	
	function save_m_note(){
		var form = $('#save_medical_note');
		var id =  1;


		$('#subnitBtn').prop('disabled', true);

		$.ajax({
			url: "patient/save_treatment_note",
			type: 'POST',
			dataType:'html',
			data: form.serialize(),
			success: function( response ) {

			}
		}).done(function(data){
			<?php if($template == 'doccure') { ?>
			patient_popup_ajax(<?= $patient->ion_user_id; ?>, '');
			<?php } else { ?>
			$('#cmodal').modal('show');
			$.snackbar({content: "Save Successfully", timeout: 10000});
			<?php } ?>
			$('#subnitBtn').prop('disabled', false);
			$('.closeajaxModal').trigger('click')
		});
	}

    function setData(data) {
		console.log(196, 'setdata')
        // var strData = JSON.stringify(data);
        //  document.getElementById('retrievedData').innerHTML = strData;
        // alert(data)
        // var img = '<img src="'+data+'" class="img img-thumbnail" width="150">'
        // img += '<input type="hidden" name="template[]" value="'+data+'">'
        $('#bodyloader').append(data);

        //  alert(img)
    }

</script>