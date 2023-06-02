<!--sidebar end--> 
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-6 row">
            <header class="panel-heading">
                <?php
                if (!empty($medicine->id))
                    echo lang('edit_medicine_category');
                else
                    echo lang('add_medicine_category');
                ?>
            </header>
            <div class="">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="medicine/addNewCategory" class="clearfix" method="post" enctype="multipart/form-data">
                                        <div class="form-group"> 
                                            <label for="exampleInputEmail1"> <?php  echo lang('category'); ?> <?php  echo lang('name'); ?> </label>
                                            <input type="text" class="form-control" name="category" id="exampleInputEmail1" value="<?php
                                            if (!empty($medicine->category_name)) {
                                                echo $medicine->category_name;
                                            }
                                            ?>" placeholder="" required="required">    
                                        </div>
                                       <!--  <div class="form-group">
                                            <label><input type="checkbox" name="subcategory_input" value="yes"> Make it subcategory </label>
                                        </div> -->
                                        <div class="form-group">
                                            <label>Select Parent Category</label>
                                            <select class="form-control" name="parent_category">
                                                <option value="">Select parent Category</option>
                                                <?php foreach($categories as $value){ if($medicine->id== $value->id){}else{ ?>
                                                    <option value="<?php echo $value->id ?>" <?php if (!empty($medicine->parent_id) and $medicine->parent_id==$value->id){ echo 'selected'; } ?>> <?php echo $value->category_name ?> </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Category Image</label>
                                                    <input type="file" name="category_img" class="form-control">
                                                    <input type="hidden" name="old_category_img" value="<?php if (!empty($medicine)){ echo $medicine->category_img; } ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <img src="./uploads/category_images/<?php echo $medicine->category_img;?>" onerror="this.src='uploads/defaultCC.jpg'" class="img-thumbnail">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <br>
                                                    <input type="radio" name="status" value="1" <?php if (!empty($medicine) and $medicine->status==1){ echo 'checked="checked"'; }elseif(empty($medicine)){ echo 'checked="checked"';} ?>> Active &nbsp; &nbsp;
                                                    <input type="radio" name="status" value="0" <?php if (!empty($medicine) and $medicine->status==0){ echo 'checked="checked"'; } ?>> Inactive
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <br>
                                                    <p>Mark as feature <input type="checkbox" name="is_feature" value="1" <?php if (!empty($medicine) and $medicine->is_feature==1){ echo 'checked="checked"'; } ?>> </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="exampleInputEmail1"> <?php  echo lang('description'); ?></label>
                                            <input type="text" class="form-control" name="description" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->description)) {
                                                echo $medicine->description;
                                            }
                                            ?>' placeholder="">
                                        </div> -->
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($medicine->id)) {
                                            echo $medicine->id;
                                        }
                                        ?>'>
                                        <button type="submit" name="submit" class="btn btn-info"> <?php  echo lang('submit'); ?></button>
                                    </form>
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
