            <div class="breadcrumb-bar">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-8 col-12">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Search Doctors (<?php echo count($doctors); ?> Results)</li>
                                </ol>
                            </nav>
                            <h2 class="breadcrumb-title">Book your appointment with top doctors</h2>
                        </div>
                        <div class="col-md-4 col-12 d-md-block d-none">
                            <div class="sort-by">
                                <!-- <span class="sort-title">Sort by</span> -->
                                <span class="sortby-fliter">
                                    <select class="form-control">
                                        <option>Sort by</option>
                                        <option class="sorting">Rating</option>
                                        <!-- <option class="sorting">Popular</option> -->
                                        <!-- <option class="sorting">Latest</option> -->
                                        <option class="sorting">Free</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->
            <style>        
            
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
                height: 200px;
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
            <!-- Page Content -->
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12 col-lg-5 col-xl-4 theiaStickySidebar">
                        
                            <!-- Search Filter -->
                            <div class="card search-filter">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Search Filter</h4>
                                </div>
                            </div>
                            <div class="card search-filter">
                                <!-- <div class="card-header">
                                    <h4 class="card-title mb-0">Search Filter</h4>
                                </div> -->
                                <div class="card-body">
                                <form action="frontend/searchdoctors" method="get" class="form-div">
                                <div class="filter-widget">                                
                                    <div class="row form-inputs">
                                        <div class="col-md-12">
                                            <div class="country_div">
                                            <input type="text" name="country" id="country" class="form-control" placeholder="Search by Country" autocomplete="off" value="<?php echo $_GET['country'] ?>">
                                                <ul class="list-group" id="countrylist">
                                                    <?php foreach($countires as $country_val){ ?>
                                                    <li class="list-group-item" onclick="countryval('<?php echo $country_val->country ?>')"> <?php echo $country_val->country ?> </li>
                                                    <?php } ?>
                                                </ul> 
                                            </div>
                                            <br>
                                        </div>
                                        <?php
                                            $ip = $_SERVER['REMOTE_ADDR'];
                                            $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
                                        ?>
                                        <div class="col-md-12">
                                            <div class="city_div">
                                            <input type="text" name="city" id="city" class="form-control" value="<?php echo $_GET['city']; ?>" placeholder="Search by City" autocomplete="off" style="background:#fff;">
                                            <span class="btn btn-light btn-sm" style="position: absolute; top: 15%; right: 9px;" onclick="getLocation()"><img src="assets/img/detect-location-icon.png" style="width: 20px"> <span id="wait-spn">Detect</span></span>
                                            <!-- <ul class="list-group" id="citylist">
                                                
                                            </ul>  -->
                                        </div>
                                        <br>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="by_name" id="" class="form-control" value="<?php echo $_GET['by_name'] ?>" placeholder="Search Doctor by Name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="hospital_div">
                                            <input type="text" name="hospital" id="hospital" class="form-control" value="<?php echo $_GET['hospital'] ?>" placeholder="Search Hospital / Clinic" autocomplete="off">
                                            <!--
                                            <input type="hidden" name="hospital_id" id="hospital_id" class="form-control">
                                            <ul class="list-group" id="hospitallist">
                                                <?php foreach($hospitals as $hosp){ ?>
                                                    <?php if($_GET['country'] != "" || $_GET['city'] != "") { ?>
														<?php if(strpos($hosp->name, 'Virtual') > -1) { ?>
														<li class="list-group-item" onclick="hospitalval('<?php echo $hosp->name ?>','<?php echo $hosp->id ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $hosp->name ?></li>
														<?php } ?>
													<?php } else { ?>
														<li class="list-group-item" onclick="hospitalval('<?php echo $hosp->name ?>','<?php echo $hosp->id ?>')"><i class="fa fa-search"></i> &nbsp;<?php echo $hosp->name ?></li>
													<?php } ?>
                                                <?php } ?>
                                            </ul> 
                                            -->
                                            </div>
                                        </div>
                                        
                                    </div>                                  
                                </div>
                                <div class="btn-search">
                                    <button type="submit" class="btn btn-block">Search</button>
                                </div>  
                                </form> 
                                <!-- <br>                               -->
                                                               
                               
                             </div>
                            </div>
                            <!--
                            <div class="card search-filter">
                            	<div class="card-body">
                            		<div class="filter-widget gender-filter-checkboxes">
                                    <h4>Gender</h4>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="gender_male" id="gender_male" value="male">
                                            <span class="checkmark"></span> Male Doctor
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="gender_female" id="gender_female" value="female">
                                            <span class="checkmark"></span> Female Doctor
                                        </label>
                                    </div>
	                                </div>
	                                <div class="filter-widget filter-checkboxes">
	                                    <h4>Select Specialist</h4>
                                        <?php //foreach($speciality as $spec_val){ ?>
	                                    <div>
	                                        <label class="custom_check">
	                                            <input type="checkbox" name="speciality" value="<?php echo str_replace(array(' ','/','(',')'),'-',$spec_val->speciality) ?>">
	                                            <span class="checkmark"></span> <?php echo $spec_val->speciality ?>
	                                        </label>
	                                    </div>
	                                	<?php //} ?>
	                                </div>
                            	</div>
                            </div>
                            -->
                            <!-- /Search Filter -->
                            
                        </div>
                        
                        <div class="col-md-12 col-lg-7 col-xl-8">
                            <?php if(count($doctors)==0){ ?>
                        <h3 class="text-center">No Result found</h3>
                    <?php } foreach($doctors as $value){ ?>
                            <!-- Doctor Widget -->
                            <div class="doctor-cards card <?php echo str_replace(' ','-',$value->gender); ?> <?php echo str_replace(array(' ','/','(',')'),'-',$value->profile); ?>">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img text-center">
                                                <a href="frontend/doctor_profile/<?php echo $value->id ?>">
                                                    <img src="<?php echo $value->img_url; ?>" class="img-fluid" alt="Doctor Image" onerror="this.src='uploads/default.jpg'">
                                                </a>
                                            </div>
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name"><a href="frontend/doctor_profile/<?php echo $value->id ?>">Dr. <?php echo $value->name ?></a></h4>
                                                <p class="doc-speciality">
                                                <?php $education = json_decode($value->education);
                                                $degree_here = "";
												foreach($education as $ky=>$val)
												{
													if($degree_here=="")
													{
														$degree_here .= $val->degree;
													}
													else
													{
														$degree_here .= ', '.$val->degree;
													}
												} 
												echo $degree_here;
                                                $speciality_icon = $this->frontend_model->getspecialityIcon($value->profile);
												?>													
												</p>
												<h5 class="<?= $value->medical_registration_verified == 1 ? 'text-success' : 'text-light'; ?>"><i class="fa fa-<?= $value->medical_registration_verified == 1 ? 'check-' : ''; ?>square"></i> Medical Registration Verified</h5>
                                                <h5 class="doc-department"><img src="<?php echo $speciality_icon; ?>" onerror="this.src='uploads/favicon.png'" class="img-fluid" alt="Speciality"><?php echo $value->profile ?></h5>
                                                <div class="rating">
													<?php $has_any = false; foreach($rating as $doctor_rat) { ?>
														<?php if($doctor_rat->product_id == $value->id) { $has_any = true; ?>
															<?php for($i=1; $i<=5; $i++) { ?>
																<?php if($doctor_rat->avg_rating > ($i-1) && $doctor_rat->avg_rating < $i){ ?>
																	<i class="fas fa-star-half-alt filled"></i>
																<?php } elseif($doctor_rat->avg_rating >= $i){ ?>
																	<i class="fas fa-star filled"></i>
																<?php } else { ?>
																	<i class="fas fa-star"></i>
																<?php } ?>
															<?php } ?>
															<span class="d-inline-block average-rating">(<?= $doctor_rat->total; ?>)</span>
														<?php } ?>
													<?php } ?>
													<?php if($has_any === false) { ?>
														<?php for($i=1; $i<=5; $i++) { ?>
															<i class="fas fa-star"></i>
														<?php } ?>
														<span class="d-inline-block average-rating">(0)</span>
													<?php } ?>
												</div>
                                                <div class="clinic-details">
                                                    <p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?php $address = json_decode($value->address); echo $address[0].' '.$address[1]; ?><br>
													<?php 
                                                    $cn = json_decode($value->clinic_info); 
                                                    $em = json_decode($value->experience); 
                                                    for($i=0; $i<count($cn); $i++)
                                                        echo "<i class='fas fa-hospital'></i> ". $cn[$i]->clinic_name. "<br>";
                                                    for($i=0; $i<count($em); $i++)
                                                        echo "<i class='fas fa-h-square'></i> ". $em[$i]->exp_hospital_name. "<br>";
                                                    ?></p>
                                                </div>
                                                <!-- <div class="clinic-services">
                                                    <span>Dental Fillings</span>
                                                    <span> Whitneing</span>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="doc-info-right">
                                            <div class="clini-infos">
                                                <ul>
                                                    <li><i class="far fa-thumbs-up"></i> 98%</li>
                                                    <li><i class="far fa-comment"></i> 17 Feedback</li>
                                                    <li><i class="fas fa-map-marker-alt"></i> <?php echo $address[0].' '.$address[1]; ?></li>
                                                    <li><i class="far fa-money-bill-alt"></i> <?php if($value->pricing !="" and $value->pricing > 0){ echo $value->symbol.' '.$value->pricing; }else{ echo 'Free';} ?> <i class="fas fa-info-circle" data-toggle="tooltip" title="Appointment Fee"></i> </li>
                                                </ul>
                                            </div>
                                            <div class="clinic-booking">
                                                <a class="view-pro-btn" href="frontend/doctor_profile/<?php echo $value->id ?>">View Profile</a>
                                                <a class="apt-btn" href="frontend/booknormalappointmentwithdoctor?doctor_id=<?php echo urlencode($value->id); ?>">Book Appointment</a>
                                                <!-- <a class="apt-btn" href="frontend/book_appointment/<?php echo urlencode($value->id); ?>">Book Appointment</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                            <!-- /Doctor Widget -->

                            <div class="load-more text-center">
                                <!-- <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>   -->
                            </div>  
                        </div>
                    </div>

                </div>

            </div>      
            <!-- /Page Content-->
<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
?>
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
    <script>
    $(document).ready(function(){
      // filter code
      // $('.gender-filter-checkboxes :input').click(function(e){
        // var ischecked_some1 = false;
        // $('.gender-filter-checkboxes :input').each(function(){
            // if($(this).is(':checked'))
            // {
                // var item = $(this).val();
                // console.log(item);
                // $("."+item).fadeIn('slow');
                // ischecked_some1 = true;
            // }
            // else
            // {
                // var item = $(this).val();
                // $("."+item).fadeOut('slow');
            // }
        // });
        // if(ischecked_some1==false)
        // {
            // $('.doctor-cards').fadeIn('slow');
        // }
        // // e.preventDefault();
        // // alert(123);
      // });
      // $('.filter-checkboxes :input').click(function(e){
        // var ischecked_some = false;
        // $('.filter-checkboxes :input').each(function(){
            // if($(this).is(':checked'))
            // {
                // var item = $(this).val();
                // console.log(item);
                // $("."+item).fadeIn('slow');
                // ischecked_some = true;
            // }
            // else
            // {
                // var item = $(this).val();
                // $("."+item).fadeOut('slow');
            // }
        // });
        // if(ischecked_some==false)
        // {
            // $('.doctor-cards').fadeIn('slow');
        // }
        // // e.preventDefault();
        // // alert(123);
      // });
      $("#country").on("keyup focus", function() {
        $('#countrylist').fadeIn('slow');
        var value = $(this).val().toLowerCase();
        $("#countrylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      $("#city").on("keyup focus", function() {
        if($("#country").val() !="")
        {
            $('#citylist').fadeIn('slow');
        }
        var value = $(this).val().toLowerCase();
        $("#citylist li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      
      // $("#hospital").on("keyup focus", function() {
        // $('#hospitallist').fadeIn('slow');
        // var value = $(this).val().toLowerCase();
        // $("#hospitallist li").filter(function() {
          // $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        // });
      // });
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
    $('#loginAjaxform').on('submit', function(e){
        e.preventDefault();
        $('.login_loader').fadeIn('slow');
        $('.btn-login').prop('disabled',true);
        var form = $('#loginAjaxform').serialize();
        $.post('frontend/userauthenticate',form,function(result){
            $('.login_loader').fadeOut('slow');
            $('.btn-login').prop('disabled',false);
            // console.log(result); return;
            var obj = JSON.parse(result);
            if(obj['status']=='loggedin')
            {
                $('#login_err').fadeOut('slow');
                $('.login_form').fadeOut('slow');
                $('.appointment_div').fadeIn('slow'); 
                $('#patient_id').val(obj['p_id']);
                $('.loggedli').fadeIn('slow');
                $('.loginli').fadeOut('slow');
            }
            else
            {
                //$this->ion_auth->user()->row()->user_id
                $('#login_err').fadeIn('slow');
                return;
                // console.log('Invalid data');
            }
            // $('#citylist').html(result);
        });
    });
    $('#appointmentAjaxform').on('submit', function(e){
        $('.book_app_loader').fadeIn('slow');
        $('.btn-appointment').prop('disabled', true);
        var form = $('#appointmentAjaxform').serialize();
        $.post('appointment/addNewApp',form,function(result){
            $('.book_app_loader').fadeOut('slow');
            $('.btn-appointment').prop('disabled', false);
            var obj = JSON.parse(result);
            if(obj['status']=='done')
            {
                if($('.close').click()){
                $('#successModalBtn').click();
                }
            }
            console.log(obj['status']);
        });
    });
    $('.close').on('click', function(e){
        $('.myc-available-time').removeClass('selected');
        $('.appointment_div').fadeOut('slow');
    });
    $(document).mouseup(function(e) 
    {
        var container = $(".modal-content");
    
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            $('.myc-available-time').removeClass('selected');
            $('.appointment_div').fadeOut('slow');
        }
    });
    $('#myappointments').on('click', function(){
       window.location.href = 'patient/medicalHistory'; 
    });
    <?php if($_GET['country'] !=""){ ?>
        $('#city').prop('readonly',false);
        countryval2('<?php echo $_GET['country']; ?>');
        function countryval2(val)
        {
            $.post('frontend/getcities',{country_id:val},function(result){
                $('#citylist').html(result);
            });
        }
    <?php } ?>
    function countryval(val)
    {
        $('#city').val('');
        $('#city').attr('placeholder','Please wait...');
        $.post('frontend/getcities',{country_id:val},function(result){
            $('#city').attr('placeholder','Search City');
            $('#citylist').html(result);
            $('#city').prop('readonly',false);
            $('#city').focus();
        });
        $('#country').val(val);
        $('#countrylist').hide();
    }
    function cityval(val)
    {
        $('#city').val(val);
        $('#citylist').hide();
    }
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
    
    function showdoctorslots(id)
    {
        $('#book_app_'+id).attr('onclick','hidedoctapp('+id+')');
        $('.doctor_slots'+id).fadeIn('slow');
    }
    function hidedoctapp(id)
    {
        $('#book_app_'+id).attr('onclick','showdoctorslots('+id+')');
        $('.doctor_slots'+id).fadeOut('slow');
    }
    
    </script>