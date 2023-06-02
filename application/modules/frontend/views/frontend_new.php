<?php 
// require 'assets/ipInfo.inc.php';
// $ipInfo = new ipInfo ('AIzaSyDnUEGim3Z6VsndogcDOjee5wAf6p7xz34','json');   
// $userIP = $ipInfo->getIPAddress();    
// $rs = json_decode($ipInfo->getCountry($userIP));   
// // echo "<pre>";
// print_r($rs);
// exit; 
?>
<style type="text/css">
	.swiper-container
	{
		overflow: inherit;
	}
	.swiper-pagination
	{
		z-index: inherit;
	}
</style>
<!-- Home Banner -->
<div class="homepage pharmacy-home-slider">
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
            <style type="text/css">
            #countrylist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            
            .country_div
            {
                position: relative;
            }
            #citylist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            .list-group{
                max-height: 200px;
                overflow-y: auto;
            }
            
            .city_div
            {
                position: relative;
            }
            #hospitallist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            
            .hospital_div
            {
                position: relative;
            }
            #specialitylist
            {
                display:none;
                position: absolute;
                left: 0;
                right: 0;
                z-index:9999;
            }
            .speciality_div
            {
                position: relative;
            }
            .list-group-item:hover
            {
                cursor: pointer;
                background: lightgrey;
            }
            </style>
            <!-- Search -->
            <div class="search-box">
                <form action="frontend/searchdoctors" method="get" style="margin: 0 auto; max-width: 755px; width: 100%;">
                    <!-- <div class="form-group search-location">
                        <div class="country_div">
                        <input type="text" name="country" id="country" class="form-control" placeholder="Search by Country" autocomplete="off">
                            <ul class="list-group" id="countrylist">
                                <?php //foreach($countires as $country_val){ ?>
                                <li class="list-group-item" onclick="countryval('<?php //echo $country_val->country ?>')"><i class="fa fa-search"></i> &nbsp;<?php //echo $country_val->country ?> </li>
                                <?php //} ?>
                            </ul> 
                        </div>
                    </div> -->
                    <div class="form-group search-location">
                        <!-- <input type="text" class="form-control" placeholder="Search by City"> -->
                        <div class="city_div">                            
                            <?php
						        $ip = $_SERVER['REMOTE_ADDR'];
						        $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

                                // $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($dataArray->geoplugin_latitude).','.trim($dataArray->geoplugin_longitude).'&key=AIzaSyAT2zrRl1pjiErc88r1qMg19QZ3hw0Ukwg&sensor=false';
                                // $json = @file_get_contents($url);
                                // $data=json_decode($json);
                                // echo "<pre>";
                                // print_r($dataArray);
                                // echo "</pre>";
                                // $status = $data->status;
                                // $current_address = $data->results[0]->formatted_address;
						        // echo "<pre>";
						        // print_r($dataArray);
								// echo $dataArray->geoplugin_countryCode;
								// $citiesdata = $this->frontend_model->getcitiesdata($dataArray->geoplugin_countryName);
							?>
                            <!--<ul class="list-group" id="citylist">
                                <?php foreach($citiesdata as $value){ ?>
                                <li class="list-group-item" onclick="cityval('<?php echo $value->city_ascii ?>','<?php echo $value->city_ascii ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $value->city_ascii ?></li>
                                <?php } ?>
                            </ul>  -->
							<input type="hidden" name="country" id="country">
                            <input type="text" name="city" id="city" class="form-control" placeholder="Search Location" autocomplete="off" value="">
                            <span class="btn btn-light btn-sm" style="position: absolute; top: 15%; right: 9px;" onclick="getLocation()"><img src="assets/img/detect-location-icon.png" style="width: 20px"> <span id="wait-spn">Detect</span></span>
                        </div>
                    </div>
                    <!-- <div class="form-group search-info">
                        <div class="hospital_div">
                        <input type="text" name="hospital" id="hospital" class="form-control" placeholder="Search by Hospital / Clinic" autocomplete="off">
                        <input type="hidden" name="hospital_id" id="hospital_id" class="form-control">
                        <ul class="list-group" id="hospitallist">
                            <?php foreach($hospitals as $hosp){ ?>
                            <li class="list-group-item" onclick="hospitalval('<?php echo $hosp->name ?>','<?php echo $hosp->id ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $hosp->name ?></li>
                            <?php } ?>
                        </ul> 
                        </div>
                    </div> -->
                    <div class="form-group search-info">
                        <div class="speciality_div">
                        <input type="text" name="speciality_input" id="speciality" class="form-control" placeholder="Search by Speciality" autocomplete="off">
                        <ul class="list-group" id="specialitylist">
                            <?php foreach($speciality as $spec_val){ ?>
                            <li class="list-group-item" onclick="specialityval('<?php echo $spec_val->speciality ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $spec_val->speciality ?></li>
                            <?php } ?>
                        </ul> 
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary search-btn mt-0"><i class="fas fa-search"></i> <span>Search</span></button>
                </form>
            </div>
            <!-- /Search -->
        </div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<!-- /Home Banner -->
<!-- Clinic and Specialities -->
<section class="section section-specialities" style="background-color: transparent;">
    <div class="container">
        <div class="section-header text-center" style="margin-bottom: 10px;">
            <h2>Browse by Specialities</h2>
            <p class="sub-title">Concern top doctors online for any health concern. Private online consultations with verified doctors in all specialities</p>
        </div>
		
		<?php 
		$sn = ceil(count($speciality)/3); 
		$col=1; 
		if(!empty($speciality)){
            foreach($speciality as $value){
				if($col == 1) { ?> 
					<div class="doctor-slider slider"> <?php 
				} ?>
						<div class="profile-widget" style="margin-bottom: 0px;">
							<div class="doc-img">
								<a href="frontend/searchdoctors?speciality=<?php echo $value->speciality ?>">
									<img class="img-fluid" alt="User Image" src="<?php echo $value->image ?>">
								</a>
							</div>
							<div class="pro-content text-center">
								<h3 class="title">
									<a href="frontend/searchdoctors?speciality=<?php echo $value->speciality ?>"><?php echo $value->speciality ?></a> 
								</h3>                                
							</div>
						</div><?php 
				if($col == $sn) { 
				$col = 0; ?> 
					</div> <?php 
				}
				$col++; 
			} 
		} 
		if(count($speciality) % 3 != 0) { ?>
			</div> <?php 
		} 
		?>
    </div>
</section>
<style type="text/css">
    @media only screen and (max-width: 768px) {
    #first {
        order: 2;
    }
    #second {
        order: 1;
    }
}
</style>
<!-- Availabe Features -->
<section class="section section-features" id="urgent-consultation">
	<div class="container">
		<div class="row">
			<div class="col-md-7 text-center">
				<iframe width="100%" height="358" src="https://www.youtube-nocookie.com/embed/I0anXK7gY5w?rel=0&controls=0&showinfo=0&autoplay=0&mute=1&loop=1&playlist=I0anXK7gY5w" frameborder="0"></iframe>
			</div>
			<div class="col-md-5">
				<div class="section-header">
					<h2 class="mt-2">Urgent Consultation</h2>
					<p>An online consultation gives you fast, easy access to our network of doctors. </p>
					<p>We would be delighted to advise you about the right specialist for a telemedical consultation and support, and organise an appointment for you.</p>
				</div>
				<div class="text-center">
					<a href="" class="btn btn-primary btn-lg">Book Now</a>
				</div>
			</div>
		</div>
		<br><br><br>
		<div class="row">					
			<div class="col-md-5" id="first">
				<div class="section-header">
					<h2 class="mt-2">Home Visit</h2>
					<p>Hassle free doctor home visits! Maulaji automatically finds the nearest Doctors based on your location.</p>
					<p>Tell us your health concern and we will assign you a top doctor.</p>
				</div>
				<div class="text-center">
					<a href="" class="btn btn-primary btn-lg">Book Now</a>
				</div>
			</div>
			<div class="col-md-7 text-center" id="second">
				<iframe width="100%" height="358" src="https://www.youtube-nocookie.com/embed/PnlrmbQA_VY?rel=0&controls=0&showinfo=0&autoplay=0&mute=1&loop=1&playlist=PnlrmbQA_VY" frameborder="0"></iframe>
			</div>
		</div>	
		<br><br><br>
		<div class="row">
			<div class="col-md-7 text-center">
				<iframe width="100%" height="358" src="https://www.youtube-nocookie.com/embed/LBCuVcwx_us?rel=0&controls=0&showinfo=0&autoplay=0&mute=1&loop=1&playlist=LBCuVcwx_us" frameborder="0"></iframe>
			</div>
			<div class="col-md-5">
				<div class="section-header">
					<h2 class="mt-2">Pharmacy</h2>
					<p>Upload your prescription medicine and we will deliver your prescriptions to your door</p>
				</div>
				<div class="text-center" style="margin-bottom: 20px;">
					<a href="" class="btn btn-primary btn-lg">Order Now</a>
				</div>
			</div>
		</div>			
	</div>
</section>
<!-- /Availabe Features -->

<!-- Blog Section -->
<section class="section section-blogs" <?php if(empty($blogs)){ echo "style='display:none'"; } ?>>
    <div class="container-fluid">
        <!-- Section Header -->
        <div class="section-header text-center">
            <h2>Blogs and News</h2>
            <p class="sub-title">Read top articles from health experts</p>
        </div>
        <!-- /Section Header -->
        <div class="row blog-grid-row row-flex">
            <?php foreach($blogs as $key => $value){ 
                $this->db->select('img_url');
                $this->db->where('id', $value->doc_id);
                $doc_img = $this->db->get('doctor')->row();
                // echo "<pre>";
                // print_r($doc_img->img_url);
                // echo "</pre>";
            ?>
            <div class="col-md-6 col-lg-3 col-sm-12" style="height:100%;">
                <!-- Blog Post -->
                <div class="blog grid-blog">
                    <div class="blog-image">
                        <a href="blog-details/<?php echo $value->page_url ?>">
                            <img class="img-fluid" src="assets/images/post_img/<?php echo $value->og_banner ?>" alt="Post Image">
                        </a>
                    </div>
                    <div class="blog-content">
                        <ul class="entry-meta meta-item">
                            <li>
                                <div class="post-author">
                                    <a href="javascript:void(0)">
                                        <img src="<?php echo $doc_img->img_url; ?>" onerror="this.src='new_assets/img/doctors/doctor-thumb-01.jpg';" style="height: 28px;"> <span><?php echo $value->author ?></span>
                                    </a>
                                </div>
                            </li>
                            <li><i class="far fa-clock"></i> <?php echo date('d M, Y',strtotime($value->dateandtime)); ?></li>
                        </ul>
                        <h3 class="blog-title"><a href="blog-details/<?php echo $value->page_url ?>"><?php echo $value->title ?></a></h3>
                        <p class="mb-0"><?php echo $value->description ?></p>
                    </div>
                </div>
                <!-- /Blog Post -->
            </div>
            <?php } ?>
        </div>
        <div class="view-all text-center">  <a href="blogs" class="btn btn-primary">View All</a>
        </div>
    </div>
</section>
<!-- /Blog Section -->

<section class="section home-tile-section" id="dowloadtheapp">  
    <img src="new_assets/img/slider/appdownload.jpg" width="100%" height="100%"  class="dowloadtheappbg">
    <div class="download-app-div">
      <div class="row">
        <div class="col-md-12 m-auto">
            <div class="row">
                <div class="col-lg-6">
                    
                </div>
                <div class="col-lg-5">
                    <h3>Download the App Now</h3>
                    <p>Access video consulation with top doctors on the Maulaji app. Connect with doctors online, available 24/7, from the comfort of your home.</p>
                    <!-- <label><b>Click on the below image to download the app</b></label>  -->
                    <!-- <form action="javascript:void(0)" method="post" id="applinkform"> 
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
                    </form> -->
                    <p class="mt-3">
                        <a href="https://play.google.com/store/apps/details?id=com.telemedicine.maulaji&hl=en_GB&gl=US">
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
<!-- AIzaSyAT2zrRl1pjiErc88r1qMg19QZ3hw0Ukwg -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAT2zrRl1pjiErc88r1qMg19QZ3hw0Ukwg&libraries=places"></script>
<script>
function getLocation() {
// $('#city').val('<?php //echo $dataArray->geoplugin_city; ?>');
    $('#wait-spn').text('Load...');
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(savePosition, positionError);
  } else {
      //Geolocation is not supported by this browser
  }
}
// getLocation();
// handle the error here
function positionError(error)
{
    $('#wait-spn').text('Detect');
  var errorCode = error.code;
  var message = error.message;
  alert(message);
}

function savePosition(position)
{    
    // alert(123);
    $.post("<?php echo base_url() ?>frontend/current_Address", {lat: position.coords.latitude, lng: position.coords.longitude}, function(data, status){
        data = JSON.parse(data);
        console.log(data);
        $('#wait-spn').text('Detect');
        $('#country').val(data.country);
        $('#city').val(data.city);
    });
}
// start********
function initialize()
{
  var input = document.getElementById('city');
  var options = {
       types: ['(cities)'],
       componentRestrictions: {country: '<?php echo $dataArray->geoplugin_countryCode; ?>'}
    };
  new google.maps.places.Autocomplete(input,options);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script type="text/javascript">
    $(document).ready(function(){
    setInterval(function(){
        $('.swiper-button-next').click();
    },10000);

    
    });
</script>
 <script>
    $(document).ready(function(){
      $("#country").on("keyup focus", function() {
        $('#countrylist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#countrylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      // $("#city").on("keyup focus", function() {
      //   $('#citylist').fadeIn('slow');
      //   var value = $(this).val().toLowerCase();
      //   $("#citylist li").filter(function() {
      //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      //   });
      // });
      
      $("#hospital").on("keyup focus", function() {
        $('#hospitallist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#hospitallist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      $("#speciality").on("keyup focus", function() {
        $('#specialitylist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#specialitylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
    });
    
    $(document).mouseup(function(e) 
    {
        var container = $(".country_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            $('#countrylist').hide();
        }
        var container1 = $(".city_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
        {
            $('#citylist').hide();
        }
        
        var container1 = $(".hospital_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
        {
            $('#hospitallist').hide();
        }
        
        var container1 = $(".speciality_div");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
        {
            $('#specialitylist').hide();
        }
        
    });
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
    // function countryval(val)
    // {
    //     $('#city').val('');
    //     $('#city').attr('placeholder','Please wait...');
    //     $.post('frontend/getcities',{country_id:val},function(result){
    //         $('#city').attr('placeholder','Search City');
    //         $('#citylist').html(result);
    //         $('#city').prop('readonly',false);
    //         $('#city').focus();
    //     });
    //     $('#country').val(val);
    //     $('#countrylist').hide();
    // }
    // function cityval(val)
    // {
    //     $('#city').val(val);
    //     $('#citylist').hide();
    // }
    function hospitalval(val,id)
    {
        $('#hospital').val(val);
        $('#hospital_id').val(id);
        $('#hospitallist').hide();
    }
    function specialityval(val)
    {
        $('#speciality').val(val);
        $('#specialitylist').hide();
    }
    
    </script>
<script>
// $(document).ready(function(){
//     if(navigator.geolocation){
//         navigator.geolocation.getCurrentPosition(showLocation);
//     }else{ 
//         // $('#location').html('Geolocation is not supported by this browser.');
//     }
// });

function showLocation(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $.ajax({
        type:'POST',
        url:'<?php echo base_url() ?>frontend/getvisitorlocation',
        data:'latitude='+latitude+'&longitude='+longitude,
        processData: false,
        cache: false,
        success:function(msg){
            console.log(msg);
            if(msg){
               $("#city").val(msg);
            }else{
                $("#city").val('Not Available');
            }
        }
    });
}
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
