<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height" style="padding: 24px 30px !important;">
        <!-- page start-->
        <section class="panel-body col-md-9">
            <header class="panel-heading">
                <?php
                if (!empty($medicine->id))
                    echo lang('edit_medicine');
                else
                    echo lang('add_medicine');
                ?>
            </header>
            <div class="row">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-md-12">
                            <section class="panel row">
                                <div class = "panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="medicine/addNewMedicine" class="clearfix" method="post" enctype="multipart/form-data">
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->name)) {
                                                echo $medicine->name;
                                            }
                                            ?>' placeholder="" required="required">
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo 'Type'; ?></label>
                                            <input type="text" class="form-control" name="type" value="<?php if(!empty($medicine->product_type)){ echo $medicine->product_type; } ?>" id="exampleInputEmail1" required="required">
                                            <!-- <option value="">Select Type</option>
                                            <option value="drops" <?php if(!empty($medicine->product_type) and $medicine->product_type=='drops'){ echo 'selected'; } ?>> Drops </option>
                                            <option value="syrup/suspension" <?php if(!empty($medicine->product_type) and $medicine->product_type=='syrup/suspension'){ echo 'selected'; } ?>> Syrup/suspension </option>
                                            <option value="tablets" <?php if(!empty($medicine->product_type) and $medicine->product_type=='tablets'){ echo 'selected'; } ?>> Tablets </option>
                                            <option value="injection" <?php if(!empty($medicine->product_type) and $medicine->product_type=='injection'){ echo 'selected'; } ?>> Injection </option>
                                            <option value="powder/sachets" <?php if(!empty($medicine->product_type) and $medicine->product_type=='powder/sachets'){ echo 'selected'; } ?>> Powder/sachets </option>
                                            <option value="face wash" <?php if(!empty($medicine->product_type) and $medicine->product_type=='face wash'){ echo 'selected'; } ?>> Face wash </option>
                                            <option value="cream" <?php if(!empty($medicine->product_type) and $medicine->product_type=='cream'){ echo 'selected'; } ?>> Cream </option>
                                            <option value="soap/shampoo" <?php if(!empty($medicine->product_type) and $medicine->product_type=='soap/shampoo'){ echo 'selected'; } ?>> Soap/shampoo </option>
                                            <option value="gel" <?php if(!empty($medicine->product_type) and $medicine->product_type=='gel'){ echo 'selected'; } ?>> Gel </option>
                                            <option value="capsules" <?php if(!empty($medicine->product_type) and $medicine->product_type=='capsules'){ echo 'selected'; } ?>> Capsules </option>
                                            <option value="consumer" <?php if(!empty($medicine->product_type) and $medicine->product_type=='consumer'){ echo 'selected'; } ?>> Consumer </option>
                                            <option value="spray" <?php if(!empty($medicine->product_type) and $medicine->product_type=='spray'){ echo 'selected'; } ?>> Spray </option>
                                            <option value="ointment" <?php if(!empty($medicine->product_type) and $medicine->product_type=='ointment'){ echo 'selected'; } ?>> Ointment </option>
                                            <option value="solution" <?php if(!empty($medicine->product_type) and $medicine->product_type=='solution'){ echo 'selected'; } ?>> Solution </option>
                                            <option value="inhaler" <?php if(!empty($medicine->product_type) and $medicine->product_type=='inhaler'){ echo 'selected'; } ?>> Inhaler </option>
                                            <option value="medical equipments" <?php if(!empty($medicine->product_type) and $medicine->product_type=='medical equipments'){ echo 'selected'; } ?>> Medical equipments </option>
                                            <option value="glucose strips" <?php if(!empty($medicine->product_type) and $medicine->product_type=='glucose strips'){ echo 'selected'; } ?>> Glucose strips </option>
                                            <option value="steamer" <?php if(!empty($medicine->product_type) and $medicine->product_type=='steamer'){ echo 'selected'; } ?>> Steamer </option>
                                            <option value="nebulizer" <?php if(!empty($medicine->product_type) and $medicine->product_type=='nebulizer'){ echo 'selected'; } ?>> Nebulizer </option>
                                            </select> -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('category'); ?></label>
                                            <?php      
                                            if(!empty($medicine))
                                            {
                                            	$categorynamee = $medicine->subcategory; 
                                            }
                                            else
                                            {
                                            	$categorynamee = ''; 
                                            }
                                            // echo $categorynamee; exit;
                                                  	
				                		        function getcategories($parent_id = 0, $add_mark = '', $categorynamee)
				                		        {
				                		        	// echo $categorynamee; exit;
				                		            $dbHost     = "localhost";
				                                    $dbUsername = "maulajic_db";
				                                    $dbPassword = "L*5m,RiQsG3q";
				                                    $dbName     = "maulajic_db";
				                                    // Create database connection
				                                    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
				                		          //  global $db;
				                		            $get_categories = $db->query("SELECT * FROM mp_category WHERE parent_id = '$parent_id' ORDER BY id ASC");
				                		            while($row = $get_categories->fetch_assoc())
				                		            {
				                		                $categories_count_q = $db->query("SELECT * FROM mp_category WHERE parent_id = '".$row['id']."' ORDER BY id ASC");
				                		                $count_all = $categories_count_q->num_rows;
				                		                if($count_all>0){ $disabled = "disabled"; }else{ $disabled = ""; }
				                		                if($categorynamee==$row['category_name']){ $selectedi = "selected"; }else{ $selectedi = ""; }
				                		                // echo $medicine->subcategory;
				                                        echo '<option value="'.$row['id'].'" '.$disabled.' '.$selectedi.'>'.$add_mark.' '.$row['category_name'].'</option>';
				                                        getcategories($row['id'], $add_mark.'---', $categorynamee);
				                                    }
				                		        } 
				                		        ?>
											<select name="category" class="form-control select2" id="category_id"  style="width: 100%;" required="required">
			                		            <option value="">Select Category</option>
			                		        <?php getcategories($parent_id = 0, $add_mark = '', $categorynamee); ?>
			                		        </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('p_price'); ?></label>
                                            <input type="text" class="form-control" name="p_price" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->p_price)) {
                                                echo $medicine->p_price;
                                            }
                                            ?>' placeholder="" required="required">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('s_price'); ?></label>
                                            <input type="text" class="form-control" name="s_price" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->price)) {
                                                echo $medicine->price;
                                            }
                                            ?>' placeholder="" required="required">
                                        </div>
                                        <!--<div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php //echo lang('store_box'); ?></label>
                                            <input type="text" class="form-control" name="box" id="exampleInputEmail1" value='<?php
                                            // if (!empty($medicine->box)) {
                                            //     echo $medicine->box;
                                            // }
                                            ?>' placeholder="">
                                        </div>-->
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('quantity'); ?></label>
                                            <input type="text" class="form-control" name="quantity" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->quantity)) {
                                                echo $medicine->quantity;
                                            }
                                            ?>' placeholder="" required="required">
                                        </div>
                                        <!--<div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('generic_name'); ?></label>
                                            <input type="text" class="form-control" name="generic" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->generic)) {
                                                echo $medicine->generic;
                                            }
                                            ?>' placeholder="">
                                        </div>-->
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo 'Vendor'; ?></label>
                                            <input type="text" class="form-control" name="company" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->vendor)) {
                                                echo $medicine->vendor;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('effects'); ?></label>
                                            <input type="text" class="form-control" name="effects" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->effects)) {
                                                echo $medicine->effects;
                                            }
                                            ?>' placeholder="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="exampleInputEmail1"> <?php echo lang('expiry_date'); ?></label>
                                            <input type="text" class="form-control default-date-picker" name="e_date" id="exampleInputEmail1" value='<?php
                                            if (!empty($medicine->e_date)) {
                                                echo $medicine->e_date;
                                            }
                                            ?>' placeholder="" readonly="">
                                        </div>
                                        
                                        <div class="form-group col-md-5">
                                            <label for=""> <?php echo 'Image'; ?></label>
                                            <input type="file" class="form-control" name="image" value='' placeholder="">
                                            <?php
                                            if (!empty($medicine->image)) {
                                                echo "<input type='hidden' name='old_image' value=".$medicine->image.">";
                                            }
                                            ?>
                                            <img src="<?php echo base_url() ?>assets/images/image/<?php echo $medicine->image; ?>" class="img-thumbnail" onerror="this.src = '<?php echo base_url() ?>assets/images/default_image.jpg';">
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label><input type="checkbox" name="prescription_req" value="yes" <?php if($medicine->prescription_required=="yes"){ echo "checked"; } ?>> Prescription required</label>
                                        </div>
                                        </div>
                                        
                                        <div class="form-group col-md-7">
                                            <label for=""> <?php echo 'Descriptions'; ?></label>
                                            <textarea id="editor1" class="form-control ckeditor" name="descriptions"><?php echo $medicine->description; ?></textarea>
                                        </div>
                                        
                                        <input type="hidden" name="id" value='<?php
                                        if (!empty($medicine->id)) {
                                            echo $medicine->id;
                                        }
                                        ?>'>
                                        <div class="form-group col-md-12">
                                            <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                                        </div>
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


<style>
    .wrapper{
        padding: 24px 30px;
    }
</style>
<script type="text/javascript">
$(document).ready(function () {
	$("#category_id").select2({
        placeholder: 'Select Category',
        allowClear: true
        // ajax: {
        //     url: 'doctor/getDoctorInfo',
        //     type: "post",
        //     dataType: 'json',
        //     delay: 250,
        //     data: function (params) {
        //         return {
        //             searchTerm: params.term // search term
        //         };
        //     },
        //     processResults: function (response) {
        //         return {
        //             results: response
        //         };
        //     },
        //     cache: true
        // }
    });
});
</script>