<style type="text/css">
.category-div .slick-next 
{
    right: -10px;
}
.profile-widget
{
	margin-bottom: 0px;
}
.slide-image
{
	padding: 0px;
}

.form-medicines
{
	background: #1e5c92;
	padding: 30px 20px;
	border-radius: 10px;
	margin-top: -50px;
	position: absolute;
	z-index: 1;
	left: 10%;
	right: 10%;
}
.doc-img
{
    z-index: inherit !important;
}
</style>
<!-- Home Banner -->
<div class="pharmacy-home-slider">
	<div class="swiper-container">
	    <div class="swiper-wrapper">
			<?php $slider_title=""; $slider_subtitle = ""; ?>
			<?php foreach($slides as $slide){
				$slider_title = ($slide->title != "") ? $slide->title : $slider_title;
				$slider_subtitle = ($slide->text1 != "") ? $slide->text1 : $slider_subtitle;
			?>
            <div class="swiper-slide">
                <img src="<?= $slide->img_url; ?>" alt="">
            </div>
			<?php } ?>
	    </div>
	    <!-- Add Arrows -->
	    <div class="swiper-button-next"></div>
	    <div class="swiper-button-prev"></div>
	    <div class="banner-wrapper">
			<div class="banner-header text-center">
				<h1><?= $slider_title; ?></h1>
                <p><?= $slider_subtitle; ?></p>
			</div>
		</div>
	</div>
	<!-- Add Pagination -->
	<!-- <div class="swiper-pagination"></div> -->
</div>
<!-- Search -->
<div class="product-widget">
<div class="form-medicines">
	<div class="row">
		<div class="col-md-6 search-div">
			<form action="<?php echo base_url(); ?>frontend/products" method="get">
			<div class="input-group">
              <input type="text" class="form-control" name="p" id="search-products" placeholder="Search products by name" autocomplete="off">
              <div class="input-group-append">
                <button class="btn btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </div>
            </form>
            <div class="products-div">
            <div class="card search-products">
            	<div class="card-body product-rows">
            		
            	</div>
            </div>
            </div>
		</div>
		<div class="col-md-3">
			<select class="form-control select2" id="search_category">
                 <option value="">Shop by category</option>
                 <?php 
                    $categories = $this->frontend_model->getallcategorieshere();
                    foreach($categories as $key => $value)
                    {
                 ?>                
                 <option value="<?php echo $value->category_name; ?>"> <?php echo $value->category_name; ?> </option>    
                 <?php } ?>   
             </select>
		</div>
		<div class="col-md-3">
			<select class="form-control select2-brand" id="search_brands">
                <option value="">Shop by brands</option>                                               
                <?php 
                    $brands = $this->frontend_model->getallbrandshere();
                    foreach($brands as $key => $value)
                    {
                 ?>                
                 <option value="<?php echo $value->vendor; ?>"> <?php echo $value->vendor; ?> </option>    
                 <?php } ?> 
            </select>
		</div>			
	</div>
</div>
</div>
<!-- /Search -->

<!-- health condition -->
<section class="section section-blogs category-div" style="padding: 120px 0px 40px 0;">
	<div class="container">
	    <h2 class="text-center">Health Conditions</h2><br><br>
	    <div class="row">
            <?php 
            $categories_15 = $this->frontend_model->get15categorieshere();
            foreach($categories_15 as $key => $value){ ?> 
                <!-- Doctor Widget -->
                <div class="col-md-3 per-category-div">
                    <div class="card">
                        <div class="card-body">
                            <div class="doc-img">
                                <a href="<?php echo base_url() ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name); ?>">
                                    <img class="" alt="<?php echo $value->category_name; ?>" src="<?php echo base_url() ?>uploads/category_images/<?php echo $value->category_img ?>" onerror="this.src='uploads/defaultCC.jpg'" style="width: 100%; height: 150px;">
                                </a>
                            </div>
                            <div class="pro-content">
                                <h3 class="title text-center">
                                    <a href="<?php echo base_url() ?>frontend/products?p_by_cond=<?php echo urlencode($value->category_name); ?>"><?php echo $value->category_name ?></a>	
                                </h3>
                            </div>
                        </div>
                    </div>
                </div> <?php 
            } ?>	
        </div>
        <br>
        <div class="text-center">
            <a href="frontend/by_conditions" class="btn btn-primary btn-lg"> View All </a>
        </div>
	</div>
</section>

<section class="section section-features" id="urgent-consultation">		
	<div class="container">
		<div class="row">                   
            <div class="col-md-5">
                <div class="section-header">
                    <h2 class="mt-2">Pharmacy</h2>
                    <p>Upload your prescription medicine and we will deliver your prescriptions to your door</p>
                </div>
                <div class="text-center" style="margin-bottom: 10px;">
                    <a href="" class="btn btn-primary btn-lg">Order Now</a>
                </div>
            </div>
            <div class="col-md-7 text-center">
               <iframe width="100%" height="358" src="https://www.youtube.com/embed/LBCuVcwx_us?rel=0&controls=0&showinfo=0&autoplay=0&mute=1&loop=1&playlist=LBCuVcwx_us" frameborder="0"></iframe>
            </div>
        </div>
	</div>   
</section>

<section class="section home-tile-section" id="dowloadtheapp">  
    <img class="dowloadtheappbg" src="new_assets/img/slider/appdownload.jpg" width="100%" height="100%">
    <div class="download-app-div">
      <div class="row">
        <div class="col-md-12 m-auto">
            <div class="row">
                <div class="col-lg-6">
                    
                </div>
                <div class="col-lg-5">
                    <h3>Download the App Now</h3>
                    <p>Access video consulation with top doctors on the Maulaji app. Connect with doctors online, available 24/7, from the comfort of your home.</p>
                    <!--<label><b>Get the link to download the app</b></label>  
                    <form action="javascript:void(0)" method="post" id="applinkform"> 
                    <div class="row">                
                    <div class="col-md-8">                                              
                    <div class="input-group mb-3">  
                        <?php
                          //  $ip = $_SERVER['REMOTE_ADDR'];
                          //  $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));  

                          // foreach($country_codes as $country_code_val)
                          // {
                          //    if($dataArray->geoplugin_countryName==$country_code_val->nicename)
                          //    { 
                          //       $phonecode = $country_code_val->phonecode; 
                          //    } 
                          // } 

                        ?>                                
                        <div class="input-group-prepend">
                          <span class="input-group-text">+<?php //echo $phonecode; ?></span>
                        </div>

                        <input type="hidden" name="phonecode" id="phonecode" value="<?php //echo $phonecode; ?>">
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter phone number" required="required">
                    </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary btn-md btn-block cendsmsbtn" style="padding: 10px;">Send SMS</button>
                    </div>                
                    </div>
                    </form>-->
                    <p class="mt-3">
                        <a href="">
                            <img src="new_assets/img/androidimage1.png" width="150">
                        </a>
                        <a href="">
                            <img src="new_assets/img/appstore1.png" width="150">
                        </a>
                    </p>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>
<script>
    $('#applinkform').on('submit', function(e){
        $('.cendsmsbtn').text('Please wait...');
        e.preventDefault();
        var phone_number = $('#phonecode').val() + $('#phone').val();
        // alert(phone_number); return;
        $.ajax({
            url:'frontend/sendapplink',
            method:'get',
            data:'phone_number='+phone_number,
            cache: false,
            success:function(result)
            {
                if(result==1)
                {
                    // $('.success-alert-msg').fadeIn('slow');
                    alert('Link successfully sent to your phone.');
                    $('.cendsmsbtn').text('Send SMS');
                    $('#phone').val('');
                }                
            }
        });
    });
</script>