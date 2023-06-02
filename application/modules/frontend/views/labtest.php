<?php //echo "<div style='text-align:center; margin-top: 50px;'><h1>Coming Soon!</h1></div>"; exit; ?>
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
    left: 25%;
    right: 25%;
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
        <div class="col-md-12 search-div">
            <form action="<?php echo base_url(); ?>frontend/searchlabtest" method="get">
            <div class="input-group">
              <input type="text" class="form-control" name="lab_test_name" id="search-products" placeholder="Search Lab Test" autocomplete="off">
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
    </div>
</div>
</div>

<style type="text/css">
    .doctor-slider .slick-slide{
        width: 345px;
    }
    .test-ul{
        padding: 0px;
        margin: 0px;
    }
    .test-ul li{
        border-bottom: 1px solid #f0f0f0;
        list-style-type: none;
        padding: 10px 0px; 
    }
</style>
<br>
<section class="section section-specialities" style="background-color: transparent;">
    <div class="container">
        <div class="section-header">
            <h2>Top booked Medical tests</h2>
            <div class="line"></div>           
        </div>
        <div class="row">
            <?php foreach($labtests as $key => $value){ ?>
            <div class="col-md-4">
                <div class="card text-center doctor-book-card">
                    <img src="<?php echo base_url() ?>assets/lab_test_images/<?php echo $value->image ?>" alt="" class="" height="250px" width="100%">
                    <div class="doctor-book-card-content tile-card-content-1">
                        <div>
                            <h3 class="card-title mb-0"><?php echo $value->name ?></h3>
                            <br>
                            <h2 style="color: #fff;"><?php echo 'PKR '.$value->price ?></h2>   
                            <a href="javascript:void(0)" onclick="showlabtestdetails('<?php echo $value->id; ?>')" class="btn btn-dark px-3 py-2 mt-3 viewdetailbtn<?php echo $value->id; ?>" tabindex="0"><i class="fas fa-eye"></i> View Details</a>
                            <a href="javascript:void(0)" onclick="addtocart('<?php echo $value->id; ?>')" class="btn btn-secondary px-3 py-2 mt-3" tabindex="0"><i class="fas fa-shopping-cart"></i> Add To Cart</a> 
                                                    
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <?php } ?>
        </div>
        <br><br>
        <div class="text-center">
            <a href="frontend/viewallLabTest" class="btn btn-primary">View All Lab Tests</a>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
    setInterval(function(){
        $('.swiper-button-next').click();
    },10000);

    
    });
</script>

<script type="text/javascript">
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
    $('.bgimagehere').fadeOut();
    $('.home-tile-section').css('height','230px');
}
else
{
    $('.bgimagehere').fadeIn();
}

function showlabtestdetails(val)
{
    $.ajax({
        url:'frontend/getlabtestdetails',
        method: 'get',
        data:'id='+val,
        cache:false,
        beforeSend: function()
        {
            $('.viewdetailbtn'+val).html('Please Wait...');
        },
        success: function(result)
        {
            console.log(result);
            $('.viewdetailbtn'+val).html('<i class="fas fa-eye"></i> View Details');
            $('.labtestdetails_div').html(result);
            $('#myModal2').modal('show');
        }
    })
}
</script>
