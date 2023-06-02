<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7 row">
            <header class="panel-heading">
                <?php
                if (!empty($doctor->id))
                    echo lang('edit_doctor');
                else
                    echo lang('add_doctor');
                ?>
            </header> 
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <?php echo validation_errors(); ?>
                                <?php echo $this->session->flashdata('feedback'); ?>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="doctor/addNew" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('name');
                                }
                                if (!empty($doctor->name)) {
                                    echo $doctor->name;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                                <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('email');
                                }
                                if (!empty($doctor->email)) {
                                    echo $doctor->email;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                                <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                                <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('address');
                                }
                                if (!empty($doctor->address)) {
                                    echo $doctor->address;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo 'Country'; ?></label>
                                <select class="form-control m-bot15 js-example-basic-single" name="country" onchange="editcountryval(this.value)" value=''>
                                    <!--<option value="">Select Country</option>-->
                                    <?php foreach ($countires as $country_val) { ?>
                                        <option value="<?php echo $country_val->country; ?>"> <?php echo $country_val->country; ?> </option>
                                    <?php } ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo 'City'; ?></label>
                                <select class="form-control m-bot15 js-example-basic-single" name="city" id="city2" value=''>
                                    <option value="">Select city</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                                <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('phone');
                                }
                                if (!empty($doctor->phone)) {
                                    echo $doctor->phone;
                                }
                                ?>' placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('depaartment'); ?></label>
                                <select class="form-control m-bot15" name="department" value=''>
                                    <?php foreach ($departments as $department) { ?>
                                        <option value="<?php echo $department->name; ?>" <?php
                                        if (!empty($setval)) {
                                            if ($department->name == set_value('department')) {
                                                echo 'selected';
                                            }
                                        }
                                        if (!empty($doctor->department)) {
                                            if ($department->name == $doctor->department) {
                                                echo 'selected';
                                            }
                                        }
                                        ?> > <?php echo $department->name; ?> </option>
                                            <?php } ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo 'Speciality'; ?></label>
                                <!--<input type="text" class="form-control" name="profile" id="exampleInputEmail1" value='<?php
                                if (!empty($setval)) {
                                    echo set_value('profile');
                                }
                                if (!empty($doctor->profile)) {
                                    echo $doctor->profile;
                                }
                                ?>' placeholder="">-->
                                <select class="form-control m-bot15 js-example-basic-single" name="profile" value=''>
                                    <?php foreach ($speciality as $speciality) { ?>
                                        <option value="<?php echo $speciality->speciality; ?>" <?php if($doctor->profile== $speciality->speciality){ echo "selected";} ?>> <?php echo $speciality->speciality; ?> </option>
                                    <?php } ?> 
                                </select>
                            </div>
                            <!--Haseen code-->
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('image'); ?></label>
                                <input type="file" name="img_url">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo ('Identity Document'); ?></label>
                                <input type="file" name="identitydoc">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo ('Licence Document'); ?></label>
                                <input type="file" name="doctor_lic_doc">
                            </div>
                            <!--end here-->
                            <input type="hidden" name="id" value='<?php
                            if (!empty($doctor->id)) {
                                echo $doctor->id;
                            }
                            ?>'>
                            <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<script>
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