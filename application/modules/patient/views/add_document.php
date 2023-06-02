<form role="form" action="patient/addPatientMaterial" id="addPatientMaterial" class="clearfix row" method="post" enctype="multipart/form-data">
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
    </div>
	<div class="form-group col-md-12">
        <label>Symptoms</label>
        <input type="text" class="form-control" name="symptoms" placeholder="">
    </div>
    <div class="form-group col-md-12">
        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
        <input type="file" name="user_file">
    </div>

    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>

    <div class="form-group col-md-12">
        <button type="submit" name="submit" id="docsubnitBtn" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
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


        var form = $('#addPatientMaterial');
        form.submit(function(event){

            event.preventDefault();

            var id =  1;
            $('#docsubnitBtn').prop('disabled', true);
            $('#docsubnitBtn').html('Uploadding....');
                formData = new FormData(),
                params   = form.serializeArray(),
                filesArr    = form.find('[name="user_file"]')[0].files;
            $.each(filesArr, function(i, file) {
                formData.append('user_file' , file);
            });

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });

            $.ajax({
                url: $(this).attr('action'),
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    dataType: "HTML",
                    data: formData,
					success: function( response ) {
						<?php if($template == 'doccure') { ?>
						patient_popup_ajax(<?= $patient->ion_user_id; ?>, '');
						<?php } else { ?>
						$('#cmodal').modal('show');
						$('#docsubnitBtn').prop('disabled', false);
						<?php } ?>
						$('.closeajaxModal').trigger('click');
						$.snackbar({content: "Save Successfully", timeout: 10000});
						
                }
            });
        });
    });

    function setData(data) {
        var strData = JSON.stringify(data);
        $('#bodyloader').append(data);

        //  alert(img)
    }

</script>