<style type="text/css">
    .banner-header h1, .banner-header h2, .banner-header p{
        color: #fff !important;
    }
    .section-search
    {
        background: #f9f9f9 url(<?php echo base_url() ?>new_assets/img/drivebgbanner.jpeg) no-repeat bottom center;
        background-size: auto;
        min-height: ;
        background-size: 100% 100%;
        position: relative;
        background-blend-mode: Darken;
        padding: 250px 0;
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
        <h2>Securely Access your files on any device, from anywhere free</h2><br>
        <!-- <p>Securely Access your files on any device, from anywhere free.</p><br> -->
        <div>
            <a href="https://drive.maulaji.com/" class="btn btn-primary btn-lg" target="_blank"><i class="fab fa-google-drive"></i> Try Maulaji Drive For Web</a>
            <span class="orclass">&nbsp; -or- &nbsp;</span>
            <div class="orclass2" style="display: none;">&nbsp; -or- &nbsp;</div>
            <a href="https://play.google.com/store/apps">
                <img src="new_assets/img/androidimage1.png" width="150">
            </a>
            <a href="https://www.apple.com/app-store/">
                <img src="new_assets/img/appstore1.png" width="150">
            </a>
        </div>
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
<section class="section section-features" style="background-color: #15558d; padding: 30px 0px;">
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
                                See your stuff anywhere
                            </h3>
                            <p>Maulaji Secure Drive can be reached from any smartphone, tablet, or computer.</p>
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
                                Share files and folders
                            </h3>
                            <p>Invite others to view, download, and collaborate on all the files you want.</p>
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
                                Store any file
                            </h3>
                            <p>Keep photos, stories, designs, drawings, recordings, videos, and more.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end here -->

<section class="section section-features" id="urgent-consultation">
    <div class="container">
        
        <div class="row">
            <div class="col-md-6">
                <div class="section-header">
                    <h2 class="mt-2">Keep your files safe</h2>
                    <div class="line"></div>
                    <p>If something happens to your device, you don't have to worry about losing your files or photos – they're in your Maulaji Drive. And Maulaji Drive is encrypted using SSL.</p>
                    <p>We make secure cloud storage simple and convenient. Create a free Maulaji Secure Drive account today!</p>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo base_url() ?>new_assets/img/driversecure121.jpg" class="img-thumbnail img-responsive">
            </div>
            
        </div>                  
    </div>
</section>

<!-- Home Banner -->
<section class="section text-center" style="display: none;">    
    <div class="section-header" style="margin-bottom: 0px; margin-top: 60px;">
        <h2>Securely Access your files on any device, from anywhere free</h2>
    </div><br><br>
    <div>
        <a href="https://drive.maulaji.com/" class="btn btn-primary btn-lg" target="_blank"><i class="fab fa-google-drive"></i> Try Maulaji Drive For Web</a>
        <span class="orclass">&nbsp; -or- &nbsp;</span>
        <div class="orclass2" style="display: none;">&nbsp; -or- &nbsp;</div>
        <a href="https://play.google.com/store/apps">
            <img src="new_assets/img/androidimage1.png" width="150">
        </a>
        <a href="https://www.apple.com/app-store/">
            <img src="new_assets/img/appstore1.png" width="150">
        </a>
    </div>
    <br><br><br>
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
