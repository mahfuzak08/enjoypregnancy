<form role="form" id="addPatientForm" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">

    <div class="form-group col-md-6">
        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?=$patient->name?>' placeholder="">
    </div>

    <div class="form-group col-md-6">
        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?=$patient->email?>' placeholder="">
    </div>

    <div class="form-group col-md-6">
        <label for="exampleInputEmail1"><?php echo lang('change'); ?><?php echo lang('password'); ?></label>
        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="">
    </div>



    <div class="form-group col-md-6">
        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?=$patient->address?>' placeholder="">
    </div>
    <div class="form-group col-md-6">
        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?=$patient->phone?>' placeholder="">
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
        <input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate" value="<?=$patient->birthdate?>" placeholder="" readonly="">
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




    <div class="form-group last col-md-6">
        <label class="control-label">Image Upload</label>
        <div class="">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="<?=(!empty($patient->img_url)? base_url($patient->img_url) : '//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' )?>" id="img" alt="" />
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
    <div class="form-group last col-md-6">
        <label>Medical history</label>
        <ul class="list">
            <?php
            $medicale_historyArr = @explode(',',$patient->medicale_history);
            foreach ($medicalHistorySetups as $key=>$item){
                ?>
                <li><input type="checkbox" name="medicaleHistory[]" value="<?=$item->title?>" <?=(@in_array($item->title, $medicale_historyArr)?'checked':'')?> > <?=$item->title?></li>
            <?php } ?>
        </ul>
    </div>


    <div class="form-group col-md-6">
        <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
    </div>


    <input type="hidden" name="id" value='<?=$patient->id?>'>
    <input type="hidden" name="p_id" value="<?=$patient->patient_id?>" >







    <section class="col-md-12">
        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
    </section>

</form>

<script>

    $(document).ready(function () {
        $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

        var form = $('#addPatientForm');
        form.submit(function(event){
            event.stopImmediatePropagation();
            event.preventDefault();

            var id =  1;
            $('#subnitBtn').prop('disabled', true);
            formData = new FormData(),
                params   = form.serializeArray(),
                filesArr    = form.find('[name="img_url"]')[0].files;
            $.each(filesArr, function(i, file) {
                formData.append('img_url' , file);
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

                }
            }).done(function(data){

               // $('#cmodal').modal('show');
                $('#subnitBtn').prop('disabled', false);
                $.snackbar({content: "Save Successfully", timeout: 10000});
                $("a[data-pid='<?=$patient->id?>']").trigger('click');

                 $('.closeajaxModal').trigger('click')
            });
        });
    });

    function setData(data) {
        var strData = JSON.stringify(data);
        $('#bodyloader').append(data);

        //  alert(img)
    }

</script>