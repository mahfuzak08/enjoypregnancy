<style type="text/css">
    .swiper-container
    {
        overflow: inherit;
    }
    .swiper-pagination
    {
        z-index: inherit;
    }

    .banner-header h2, .banner-header p{
        color: #fff;
    }
    .pharmacy-home-slider img {
    max-width: 100%;
    width: 100%;
    height: 100%;
}
.pharmacy-home-slider .swiper-container::before
{
    background-color: transparent;
}
.pharmacy-home-slider .swiper-container
{
    height: auto;
}
</style>
<!-- Home Banner -->
<div class="pharmacy-home-slider">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="new_assets/img/slider/health22.jpg" alt="">                
            </div>
            <!-- <div class="swiper-slide">
                <img src="new_assets/img/slider/health4.jpg" alt="">                
            </div> -->
            <div class="swiper-slide">
                <img src="new_assets/img/slider/health1111.jpg" alt="">
            </div>          
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- <div class="banner-wrapper">
            <div class="banner-header text-center">
                <h1>Download Health & Wellness App</h1>
                <p>Available 24 / 7 Consultation</p> 
                <a href="https://play.google.com/store/apps" class="btn btn-primary btn-lg" target="_blank"><i class="fa fa-download"></i> Download the App Now </a>
            </div>
        </div> -->
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<!-- /Home Banner -->
<!-- <h1>Download Health & Wellness App</h1> -->
<!-- <p>Available 24 / 7 Consultation</p> -->
<!-- <section class="section text-center section-specialities">
    <div class="container">
        <a href="https://play.google.com/store/apps" class="btn btn-primary btn-lg" target="_blank"><i class="fa fa-download"></i> Download the Health & Wellness App Now </a>
    </div>
</section> -->
<section class="section section-specialities" style="background-color: transparent;">
    <div class="container">
        <div class="row">            
            <div class="col-md-6">
                <br><br><br><br>
                <div class="section-header">
                    <h2>Health & Wellness</h2>
                    <p class="sub-title" style="max-width: 680px;">Wellness is more than just physical health; it is holistic and multidimensional. It comprises six dimensions that include physical, intellectual, emotional, environmental, social, and spiritual wellness.</p><br>
                    <p class="">
                        <a href="https://play.google.com/store/apps" class="btn btn-primary btn-lg" target="_blank"><i class="fa fa-download"></i> Download the Health & Wellness App </a>
                    </p>
                </div>                
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo base_url() ?>new_assets/img/healthimageApple2.png" class="img-fluid" width="70%">
            </div>
        </div>
        <br>
    </div>
</section>

<section class="section home-tile-section" id="dowloadtheapp" style="height: 500px;">      
    <img src="<?php echo base_url() ?>new_assets/img/talkbg2.jpg" width="100%" height="100%" class="bgimagehere">
    <div class="download-app-div">
      <div class="row">
        <div class="col-md-12 m-auto">
            <div class="row">
                <div class="col-lg-7">
                    
                </div>
                <div class="col-lg-5 banner-header">
                    <!-- <h2>Health calculator is part of Maulaji Talk</h2> -->

                    <h2>Download the App Now</h2>
                    <p>Download Health & Wellness app on your phone.</p>
                    <p class="mt-3">
                        <a href="https://play.google.com/store/apps">
                            <img src="new_assets/img/androidimage1.png" width="150">
                        </a>
                        <a href="https://www.apple.com/app-store/">
                            <img src="new_assets/img/appstore1.png" width="150">
                        </a>
                    </p>
                    <br>
                    <h2 style="color: #fff;">Download Health Calculator App</h2>
                    <p>Download Health Calculator app on your phone.</p>
                    <p class="mt-3">
                        <a href="https://play.google.com/store/apps">
                            <img src="new_assets/img/androidimage1.png" width="150">
                        </a>
                        <a href="https://www.apple.com/app-store/">
                            <img src="new_assets/img/appstore1.png" width="150">
                        </a>
                    </p>

                </div>
            </div>
        </div>
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
</script>
