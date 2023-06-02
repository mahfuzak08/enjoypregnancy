<style type="text/css">
    .banner-header h1, .banner-header h2, .banner-header p{
        color: #fff !important;
    }
    .section-search
    {
        background: #f9f9f9 url(<?php echo base_url() ?>new_assets/img/slider/health4.jpg) no-repeat bottom center;
        background-size: auto;
        min-height: 380px;
        background-size: 100% 100%;
        position: relative;
        background-blend-mode: Darken;
        padding: 258px 0;
    }

    .post-thumb{
        width: 50px;
        font-size: 30px;
        color: #fff;
        height: 75px;
    }
   .post-info h3, .post-info p{
        color: #fff;
    }
    .post-info {
        margin-left: 30px;
        color: #fff;
    }
</style>

<section class="section" style="margin-top: 50px;">
    <div class="section-header text-center">
        <h2>Secure Collaborate & Share Docs - a safe home for all your data</h2>
        <!-- <p>Secure Collaborate & Share Docs - a safe home for all your data.</p> -->
        <p><a href="https://docshare.maulaji.com" class="btn btn-primary btn-lg" target="_blank"><i class="fa fa-share-alt"></i> Try Doc Share For Web</a></p>
    </div>
</section>
<!-- Home Banner -->
<section class="section section-search">
    <div class="container-fluid">
        <div class="banner-wrapper">
            <div class="banner-header text-center">
                
            </div>
            
        </div>
    </div>
</section>
<!-- /Home Banner -->

<!-- red section -->
<section class="section section-features" style="background: linear-gradient(-45deg,#ec5252,#6e1a52); padding: 30px 0px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <ul class="latest-posts">
                    <li>
                        <div class="post-thumb">
                            <i class="fa fa-dot-circle"></i>
                        </div>
                        <div class="post-info">
                            <h3>
                                Secure Collaborate & Share
                            </h3>
                            <p>Protect your communication</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="latest-posts">
                    <li>
                        <div class="post-thumb">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="post-info">
                            <h3>
                                Digital imaging viewer
                            </h3>
                            <p>DICOM viewer available in Doc share for medical professionals</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="latest-posts">
                    <li>
                        <div class="post-thumb">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div class="post-info">
                            <h3>
                                Secure file exchange
                            </h3>
                            <p>Making easy to secure share files</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end here -->

<!-- Home Banner -->
<!-- <section class="section text-center section-features">    
    <div class="section-header" style="margin-bottom: 0px; margin-top: 60px;">
        
    </div>
</section> -->

<!-- Availabe Features -->
<section class="section section-features" id="urgent-consultation">
    <div class="container">
        
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="<?php echo base_url() ?>new_assets/img/collaborate.png" class="img-thumbnail img-responsive">
            </div>
            <div class="col-md-6">
                <div class="section-header">
                    <h2 class="mt-2">Secure Collaborate and Share</h2>
                    <div class="line"></div>
                    <p>Maulaji talk protects your communication better than other team collaboration platforms like Microsoft Teams or Slack, making sure your data stays on your servers.</p>
                    <p>Maulaji Talk goes further than other encrypted communication technologies by keeping even metadata from leaking.</p>
                    <p>This ensures you stay in complete control of communications.</p>
                </div>
                <!-- <div class="text-center">
                    <a href="" class="btn btn-primary btn-lg">Book Now</a>
                </div> -->
            </div>
        </div>
        <br><br><br>
        <div class="row">                   
            <div class="col-md-6" id="first">
                <div class="section-header">
                    <h2 class="mt-2">Maulaji Secure Files Exchange</h2>
                    <div class="line"></div>
                    <p>Makes it easy to sync, share and collaborate on your files.</p>
                    <p>A modern and easy-to-use web interface, desktop clients and mobile apps.</p>
                    <p>Real-time collaboration and instant access to all data from any device, anywhere!</p>
                    <p>Powerful encryption capabilities and a built-in rule-based File Access Control.</p>
                    <p>Complemented by strong password policies, brute-force protection, ransomware protection and more.</p>
                </div>
                <!-- <div class="text-center">
                    <a href="" class="btn btn-primary btn-lg">Book Now</a>
                </div> -->
            </div>
            <div class="col-md-6 text-center" id="second">
                <img src="<?php echo base_url() ?>new_assets/img/docshareimage222.jpeg" class="img-thumbnail img-responsive">
            </div>
        </div>                   
    </div>
</section>
<!-- /Availabe Features -->

<section class="section section-features" id="urgent-consultation" style="background-color: transparent;">
  <div class="container">
    <div class="section-header text-center">
        <h2 class="mt-2">Digital Imaging for Medicine in Maulaji</h2>
        <p>DICOM viewer in Maulaji Doc Share, can be used to review Radiography or Tomography  images easily and,<br> more importnantly, securely</p>
    </div>
    <div class="row">            
        <div class="col-md-6">
             <img src="<?php echo base_url() ?>new_assets/img/medical.JPG" class="img-thumbnail img-responsive" style="height: 308px;">
        </div>

        <div class="col-md-6 text-center">
            <video class="img-thumbnail" width="100%" height="300" name="Video Name" src="<?php echo base_url() ?>new_assets/img/docsharevideo2.mov" autoplay="true" loop="true" style="height: 308px;"></video>

        </div>
    </div> 
 </div> 
</section>

<script type="text/javascript">
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
    $('.orclass').fadeOut();
    $('.orclass2').fadeIn();
    $('.bgimagehere').fadeOut();
    $('.home-tile-section').css('height','215px');
    $('.banner-header h2, .banner-header p').css('color','#272b41');
}
else
{
    $('.orclass').fadeIn();
    $('.orclass2').fadeOut();
    $('.bgimagehere').fadeIn();
}
</script>
