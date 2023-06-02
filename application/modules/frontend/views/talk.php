<style type="text/css">
    .banner-header h2, .banner-header p{
        color: #fff;
    }
</style>
<!-- Home Banner -->
<section class="section text-center">    
    <div class="section-header" style="margin-bottom: 0px; margin-top: 60px;">
        <h2>Secure Encrypted end-to-end Audio and Video Chat</h2>
    </div><br><br>
    <div>
        <a href="https://talk.maulaji.com" class="btn btn-primary btn-lg" target="_blank"><i class="fa fa-microphone"></i> Try Maulaji Talk For Web</a>
        <span class="orclass">&nbsp; -or- &nbsp;</span>
        <div class="orclass2" style="display: none;">&nbsp; -or- &nbsp;</div>
        <a href="https://play.google.com/store/apps">
            <img src="new_assets/img/androidimage1.png" width="150">
        </a>
        <a href="https://www.apple.com/app-store/">
            <img src="new_assets/img/appstore1.png" width="150">
        </a>
    </div>
    <img src="<?php echo base_url() ?>new_assets/img/talkbgbanner.png" class="img-responsive" width="100%">
    
</section>

<!-- <section>
    <div class="section-header text-center" style="margin-bottom: 30px;">
        <h2>Health calculator is part of Maulaji Talk</h2><br>
    </div>
</section> -->

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
