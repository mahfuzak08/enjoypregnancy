<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
        <nav aria-label="breadcrumb" class="page-breadcrumb product-breadcrumb">
            <ol class="breadcrumb">
                <li class=""><a href="<?php echo base_url() ?>">Home</a></li>
                <li> / </li>
                <li class=""><a href="<?php echo base_url() ?>frontend/pharmacy">Pharmacy</a></li>
                <li> / </li>                
                <li class="" aria-current="page">Medicines</li>
            </ol>
        </nav>
        <br>
        <div class="row">
            <div class="col-md-5 col-lg-3 col-xl-3 theiaStickySidebar">
                <form id="filterform" action="#" method="post">
                <!-- Search Filter -->
                <div class="card search-filter">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Filter</h4>
                    </div>
                    <div class="card-body">
                    
                    <div class="filter-widget filter-widget-input">                        
                        <!-- <input type="hidden" name="filtertype" value="yes"> -->
                        <h4>Medicine Type</h4>
                        <div class="form-group medicine_type">
                            <?php 
                                $types = array();
                                foreach($products as $key => $value)
                                {
                                    if(in_array($value->product_type, $types)==false)
                                    {
                                        array_push($types,$value->product_type);
                                    }
                                }
                                for($i=0;$i<count($types);$i++){
                            ?>
                                <label><input type="checkbox" name="type[]" value="<?php echo $types[$i]; ?>"> <?php echo ucwords($types[$i]) ?></label><br>
                            <?php } ?>
                        
                         </div>
                        <h4>Categories</h4>
                        <div class="form-group categories">
                            <?php 
								if(! isset($_GET['p_by_cond'])){
									$category_arr = array();
									foreach($products as $key => $value)
									{
										if(in_array($value->cat_id, $category_arr)==false)
										{
											array_push($category_arr,$value->cat_id);
										}
									}
                                }
                                foreach($category as $row){
									if($row->subcategory == $_GET['p_by_cond']){ ?>
										<label><input type="checkbox" name="category[]" value="<?= $row->id; ?>" checked > <?= ucwords($row->subcategory); ?></label><br>
									<?php }
									if(! isset($_GET['p_by_cond']) && in_array($row->id, $category_arr)){ ?>
										<label><input type="checkbox" name="category[]" value="<?= $row->id; ?>" checked > <?= ucwords($row->subcategory); ?></label><br>
									<?php }
								} ?>
                        
                         </div>
                         <h4>Brands</h4>
                         <div class="form-group brands">
                            <?php 
                                $vendor_arr = array();
                                foreach($products as $key => $value)
                                {
                                    if(in_array($value->vendor, $vendor_arr)==false)
                                    {
                                        array_push($vendor_arr,$value->vendor);
                                    }
                                }
                                for($i=0;$i<count($vendor_arr);$i++){
                            ?>
                                <label><input type="checkbox" name="brand[]" value="<?php echo $vendor_arr[$i] ?>" <?php if(isset($_GET['p_by_brand']) and $vendor_arr[$i]==$_GET['p_by_brand']){ echo "checked"; } ?> > <?php echo ucwords($vendor_arr[$i]) ?></label><br>
                            <?php } ?>
                         
                        </div>                        
                        </div>                        
                    </div>
                </div>
                </form>
                <!-- /Search Filter -->
                
            </div>
            
            <div class="col-md-7 col-lg-9 col-xl-9">

                <div class="row align-items-center pb-3">   
                    <div class="col-md-6 col-12 d-md-block d-none custom-short-by">
                        <h3 class="title pharmacy-title"><?php echo $title_here; ?></h3>
                    </div>
                    <div class="col-md-6 col-12 d-md-block d-none custom-short-by">
                        <div class="sort-by pb-3">
                            <span class="sort-title">Result <span id="total_product"><?php echo count($products); ?></span> products found</span>
                        </div>
                    </div>
                </div>
                <?php if(count($products)==0){
                    echo "<h4 class='text-center'>So Sorry No Result Found</h4>";
                } ?>
                <div class="row products-row">
                <?php foreach($products as $key => $value){ ?>
                    <?php //echo $value->category; ?>
                    <div class="col-md-12 col-lg-4 col-xl-4 product-custom" id="pid<?= $value->id; ?>">
                        <div class="profile-widget">
                            <div class="doc-img">
                                <a href="<?php echo base_url(); ?>frontend/product_description/<?php echo $value->id ?>" tabindex="-1">
                                    <img class="img-fluid" alt="Medicine img" src="<?php echo base_url(); ?>assets/images/image/<?php echo $value->image ?>.jpg" onerror="this.src = '<?php echo base_url(); ?>assets/images/default_image.jpg';">
                                    <!-- <img class="img-fluid" alt="Medicine img" src="<?php echo base_url(); ?>assets/images/<?php if($value->category=='Personal Care'){ echo 'Personal_Care/';}elseif($value->category=='Wellbeing & Fitness'){ echo 'Wellbeing_Fitness/';}elseif($value->category=='Medical Devices'){ echo 'Medical_Devices/';}else{ echo 'Medicines/';} echo $value->image ?>.jpg" onerror="this.src = '<?php echo base_url(); ?>assets/images/default_image.jpg';"> -->
                                </a>
                                <a href="javascript:void(0)" class="fav-btn" tabindex="-1">
                                    <i class="far fa-bookmark"></i>
                                </a>
                            </div>
                            <div class="pro-content">
                                <h3 class="title pb-4">
                                    <a href="<?php echo base_url(); ?>frontend/product_description/<?php echo $value->id ?>" tabindex="-1"><?php echo $value->name ?></a> 
                                </h3>
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <span class="price"><?php echo $value->price ?></span>
                                        <!-- <span class="price-strike">$45.00</span> -->
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <a href="javascript:void(0)" onclick="addtocart(<?php echo $value->id ?>)" class="cart-icon addcart_cart_btn<?php echo $value->id ?>"><i class="fas fa-shopping-cart cart-iconhere<?php echo $value->id ?>"></i> <img src="assets/img/loader-image.gif" width="30" style="display: none;" id="car-loader-img<?php echo $value->id ?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>                   
                <?php } ?>
                 </div>
                 <div class="col-md-12 text-center">
                    <!-- <a href="#" class="btn book-btn1 mb-4">Load More</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<script type="text/javascript">
    $('body').on('click','.filter-widget-input input', function(){
		if($('input[name="category[]"]:checked').length > 0){
			setTimeout(function(){
				var form_data = $('#filterform').serialize();
				$.ajax({
					url:'frontend/getfilteredData',
					method:'post',
					data: form_data,
					cache:false,
					success: function(result)
					{
						result = JSON.parse(result);
						console.log(result);
						$(".col-md-12.text-center").text("");
						$(".product-custom").hide();
						if(result.length > 0){
							$("#total_product").text(result.length);
							for(let i=0; i<result.length; i++){
								$("#pid" + result[i].id).fadeIn("slow");
							}
						}else{
							$("#total_product").text(result.length);
							$(".col-md-12.text-center").text("So Sorry No Result Found");
						}
						// $('.products-row').html(result);
					}
				});
			},500);
		}else{
			alert("Please select atlist one category");
		}
    });
    
</script>