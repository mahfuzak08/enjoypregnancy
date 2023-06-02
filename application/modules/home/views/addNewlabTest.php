
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7 row">
            <header class="panel-heading">
                <?php
                if (!empty($hospital->id)) {
                    if($this->session->userdata('is_hospital')==1)
                    {
                        echo 'Edit Pharmacy';
                    }
                    elseif($this->session->userdata('is_hospital')==2)
                    {
                        echo 'Edit Laboratory';
                    }
                    else
                    {
                        echo lang('edit_hospital');
                    }
                    
                } else {
                    if($this->session->userdata('is_hospital')==1)
                    {
                        echo 'Add New Pharmacy';
                    }
                    elseif($this->session->userdata('is_hospital')==2)
                    {
                        echo 'Add New Laboratory';
                    }
                    else
                    {
                        echo lang('add_new_hospital');
                    }
                    
                }
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    
                    <form role="form" action="home/addnewlabTestpost" method="post" enctype="multipart/form-data">

                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                if (!empty($labtest->name)) {
                                    echo $labtest->name;
                                }
                                ?>' placeholder="" required="required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Price</label>
                                <input type="text" class="form-control" name="price" id="exampleInputEmail1" value='<?php
                                if (!empty($labtest->price)) {
                                    echo $labtest->price;
                                }
                                ?>' required="required">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Sample Required</label>
                                <input type="text" class="form-control" name="sample_required" value='<?php
                                if (!empty($labtest->sample_required)) {
                                    echo $labtest->sample_required;
                                }
                                ?>'>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Image</label>
                                        <input type="file" class="form-control" name="lab_test_image" id="exampleInputEmail1" placeholder="">
                                        <input type="hidden" name="old_lab_test_image" value="<?php if(!empty($labtest->image)){ echo $labtest->image; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img src="<?php echo base_url().'assets/lab_test_images/'.$labtest->image; ?>" onerror="this.src='assets/img/default.jpg'" class="img-thumbnail img-responsive">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo 'Description'; ?></label>
                                <textarea type="text" id="editor1" class="form-control ckeditor" name="description" placeholder="" required="required"><?php if(!empty($labtest->description)){ echo $labtest->description; } ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                <input type="checkbox" name="is_feature" value='1' <?php if(!empty($labtest->is_feature) and $labtest->is_feature==1) { echo 'checked'; } ?>> Mark as feature</label>
                            </div>
                        </div>

                        <input type="hidden" name="id" value='<?php
                        if (!empty($labtest->id)) {
                            echo $labtest->id;
                        }
                        ?>'>
                        <div class="panel col-md-12">
                            <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                        </div>
                    </form>


                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<script src="common/js/codearistos.min.js"></script>


<script>
    $(document).ready(function () {
<?php
if (!empty($hospital->id)) {
    if (empty($hospital->package)) {
        ?>
                $('.pos_client').show();
    <?php } else { ?>
                $('.pos_client').hide();
        <?php
    }
} else {
    ?>
            $('.pos_client').hide();
<?php } ?>
        $(document.body).on('change', '#pos_select', function () {

            var v = $("select.pos_select option:selected").val()
            if (v == '') {
                $('.pos_client').show();
            } else {
                $('.pos_client').hide();
            }
        });

    });
</script>