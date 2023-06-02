<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo 'Add Speciality'; ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">           
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="speciality/addNew" method="post" enctype="multipart/form-data">
                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo lang('name'); ?></label>
                                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                                if (!empty($setval)) {
                                                    echo set_value('name');
                                                }
                                                if (!empty($speciality->name)) {
                                                    echo $speciality->name;
                                                }
                                                ?>' required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo 'Image'; ?></label>
                                                <input type="file" class="form-control" name="image" id="" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> <?php echo 'Icon'; ?> </label>
                                                <input type="file" class="form-control" name="icon" id="" required>
                                            </div>
                                        </div>
                                        </div>
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($speciality->id)) {
                                            echo $speciality->id;
                                        }
                                        ?>'>
                                        <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
