<form role="form" id="patientForm" onsubmit="return false;" action="" class="clearfix row" method="post" enctype="multipart/form-data">

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
    <input type="hidden" name="type" value='<?php echo $type; ?>'>
    <input type="hidden" name="patient_id" value='<?php echo $patient_id; ?>'>
    <input type="hidden" name="id" value=''>
    <div class="form-group col-md-12">
        <button type="submit" name="submit" id="subnitBtn" onclick="patient_form_submit()" class="btn btn-success submit_button pull-right">Create Form</button>
        <!--<button type="submit" name="submit" class="btn btn-info submit_button pull-right">Save as draft</button>-->
    </div>
</form>


<script type="text/javascript">
    $(document).ready(function () {
        var form = $('#patientForm');
        form.submit(function(event){

            event.preventDefault();
			return false;
		});
    });
	function patient_form_submit(){
		var id =  1;
		var form = $('#patientForm');
		$('#subnitBtn').prop('disabled', true);
		$.ajax({
			url: "patient/save_patient_form",
			type: 'POST',
			dataType:'html',
			data: form.serialize(),
			beforeSend: function(){console.log(42);},
			success: function( response ) {
				<?php if($template == 'doccure') { ?>
				patient_popup_ajax(<?= $patient->ion_user_id; ?>, '');
				<?php } else { ?>
				$('#cmodal').modal('show');
				$.snackbar({content: "Save Successfully", timeout: 5000});
				<?php } ?>
				
				$('#subnitBtn').prop('disabled', false);
				$('.close').trigger('click');
			}
		});
	}
</script>