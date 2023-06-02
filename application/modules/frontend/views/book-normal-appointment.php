<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/slots_calendar/css/mark-your-calendar.css">
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html">Home</a></li>
						<li class="breadcrumb-item" aria-current="page"><a onclick="javascript:history.go(-1)" style="cursor:pointer;">Docotrs List</a></li>
						<li class="breadcrumb-item active" aria-current="page">Docotr Available Slots</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Booking</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container">
	
		<div class="row">
			<div class="col-12">
			
				<div class="card">
					<div class="card-body">
						<div class="booking-doc-info">
							<a href="doctor-profile.html" class="booking-doc-img">
								<img src="<?php echo base_url().$doctor_profile_data->img_url ?>" alt="User Image">
							</a>
							<div class="booking-info">
								<h4><a href="doctor-profile.html"><?php echo $doctor_profile_data->name ?></a></h4>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star"></i>
									<span class="d-inline-block average-rating">35</span>
								</div>
								<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> <?php $address = json_decode($doctor_profile_data->address); echo $address[0].' '.$address[1]; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-4 col-md-6">
						<h4 class="mb-1">Available Slots</h4>
					</div>
                </div>
				<!-- Schedule Widget -->
				<div class="card booking-schedule schedule-widget">
				
					<!-- Schedule Header -->
					<!-- <div class="schedule-header">
						<div class="row">
							<div class="col-md-12"> -->
							
								<!-- Day Slot -->
								<!-- <div class="day-slot">
									<ul>
										<li class="left-arrow">
											<a href="">
												<i class="fa fa-chevron-left"></i>
											</a>
										</li>
										<li>
											<span>Mon</span>
											<span class="slot-date">11 Nov <small class="slot-year">2019</small></span>
										</li>
										<li>
											<span>Tue</span>
											<span class="slot-date">12 Nov <small class="slot-year">2019</small></span>
										</li>
										<li>
											<span>Wed</span>
											<span class="slot-date">13 Nov <small class="slot-year">2019</small></span>
										</li>
										<li>
											<span>Thu</span>
											<span class="slot-date">14 Nov <small class="slot-year">2019</small></span>
										</li>
										<li>
											<span>Fri</span>
											<span class="slot-date">15 Nov <small class="slot-year">2019</small></span>
										</li>
										<li>
											<span>Sat</span>
											<span class="slot-date">16 Nov <small class="slot-year">2019</small></span>
										</li>
										<li>
											<span>Sun</span>
											<span class="slot-date">17 Nov <small class="slot-year">2019</small></span>
										</li>
										<li class="right-arrow">
											<a href="">
												<i class="fa fa-chevron-right"></i>
											</a>
										</li>
									</ul>
								</div> -->
								<!-- /Day Slot -->
								
							<!-- </div>
						</div>
					</div> -->
					<!-- /Schedule Header -->
					
					<!-- Schedule Content -->
					<div class="schedule-cont">
						<div class="row">
							<div class="col-md-12">
								<div class="picker"></div>
								<!-- Time Slot -->
								<!-- <div class="time-slot">
									<ul class="clearfix">
										<li>
											<a class="timing" href="#">
												<span>9:00</span> <span>AM</span>
											</a>
											<a class="timing" href="#">
												<span>10:00</span> <span>AM</span>
											</a>
											<a class="timing" href="#">
												<span>11:00</span> <span>AM</span>
											</a>
										</li>
									</ul>
								</div> -->
								<!-- /Time Slot -->
								
							</div>
						</div>
					</div>
					<!-- /Schedule Content -->
					
				</div>
				<!-- /Schedule Widget -->
				
				<!-- Submit Section -->
				<div class="submit-section proceed-btn text-right">
					<form action="frontend/booknormalappointmentwithdoctor" method="get">
						<input type="hidden" name="doctor_id" id="doctor_id" value="<?= $doctor_profile_data->id; ?>">
						<input type="hidden" name="appointment_date" id="appointment_date">
						<input type="hidden" name="appointment_time_slot" id="appointment_time_slot">
						<button type="submit" class="btn btn-primary submit-btn">Next</button>
						<!-- <button type="submit" class="btn btn-primary submit-btn">Proceed</button> -->
					</form>
				</div>
				<!-- /Submit Section -->
				
			</div>
		</div>
	</div>

</div>		
<!-- /Page Content -->
<?php
$hd = array();
foreach($holidays as $row){
	$rd = explode(" - ", $row->date);
	$hd[] = date('d-m-Y', strtotime($rd[0]));
	$rd[1] = date('d-m-Y', strtotime($rd[1]));
	if($rd[0] != $rd[1]){
		$rsd = $rd[0];
		while($rsd != $rd[1]){
			$rsd = date('d-m-Y', strtotime($rsd . ' +1 day'));
			$hd[] = $rsd;
		}
	}
}
$hd = json_encode($hd);
?>
<!-- <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>common/slots_calendar/js/mark-your-calendar.js"></script>
<script type="text/javascript">
(function($) {
	var holidays = <?= $hd; ?>;
<?php 
	    $Satday = array();
		$Sunday = array();
		$Monday = array();
		$Tueday = array();
		$Wedday = array();
		$Thuday = array();
		$Friday = array();
		
		$Satday_i = array();
		$Sunday_i = array();
		$Monday_i = array();
		$Tueday_i = array();
		$Wedday_i = array();
		$Thuday_i = array();
		$Friday_i = array();
	// 	$i=0;
		$doctor_slots = $this->frontend_model->getAvailableSlotByDoctorByDate2($doctor_profile_data->id);
		foreach($doctor_slots as $row)
		{
			if(isset($_GET["type"]) && $_GET["type"] == "urgent" && $row->weekday != date("l")) continue;
			
			if($row->weekday=="Saturday")
			{
			    $date_s = date('d-m-Y', strtotime('Saturday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Satday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Satday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}

			if($row->weekday=="Sunday")
			{
			    $date_s = date('d-m-Y', strtotime('Sunday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Sunday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Sunday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}

			if($row->weekday=="Monday")
			{
			    $date_s = date('d-m-Y', strtotime('Monday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Monday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Monday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}

			if($row->weekday=="Tuesday")
			{
			    $date_s = date('d-m-Y', strtotime('Tuesday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Tueday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Tueday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}

			if($row->weekday=="Wednesday")
			{
			    $date_s = date('d-m-Y', strtotime('Wednesday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Wedday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Wedday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}

			if($row->weekday=="Thursday")
			{
			    $date_s = date('d-m-Y', strtotime('Thursday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Thuday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Thuday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}

			if($row->weekday=="Friday")
			{
			    $date_s = date('d-m-Y', strtotime('Friday'));
			    $s_time = $row->s_time.' To '.$row->e_time;
			    $data_ar = array($date_s,$doctor_profile_data->id,$s_time);
			    $slot_booked_res = $this->frontend_model->checkBookedslot($data_ar);
			    if($slot_booked_res==0){
				$Friday[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			    }
			    $Friday_i[] = $row->s_time.' To '.$row->e_time.'_ID_'.$doctor_profile_data->id;
			}
		}
		$Satday = json_encode($Satday);
		$Sunday = json_encode($Sunday);
		$Monday = json_encode($Monday);
		$Tueday = json_encode($Tueday);
		$Wedday = json_encode($Wedday);
		$Thuday = json_encode($Thuday);
		$Friday = json_encode($Friday);
	// For all slots
	    $Satday_i = json_encode($Satday_i);
		$Sunday_i = json_encode($Sunday_i);
		$Monday_i = json_encode($Monday_i);
		$Tueday_i = json_encode($Tueday_i);
		$Wedday_i = json_encode($Wedday_i);
		$Thuday_i = json_encode($Thuday_i);
		$Friday_i = json_encode($Friday_i);
	?>
	var Satday = <?php echo $Satday ?>;
	var Sunday = <?php echo $Sunday ?>;
	var Monday = <?php echo $Monday ?>;
	var Tueday = <?php echo $Tueday ?>;
	var Wedday = <?php echo $Wedday ?>;
	var Thuday = <?php echo $Thuday ?>;
	var Friday = <?php echo $Friday ?>;
	// 			For all slots
	var Satday_i = <?php echo $Satday_i ?>;
	var Sunday_i = <?php echo $Sunday_i ?>;
	var Monday_i = <?php echo $Monday_i ?>;
	var Tueday_i = <?php echo $Tueday_i ?>;
	var Wedday_i = <?php echo $Wedday_i ?>;
	var Thuday_i = <?php echo $Thuday_i ?>;
	var Friday_i = <?php echo $Friday_i ?>;

	var doctor_id = <?php echo $doctor_profile_data->id ?>;
	// 			var time_array_t = [Sunday,Monday,Tueday,Wedday,Thuday,Friday,Satday];
	var day_of_week = new Date().getDay();
	var list = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
	var sorted_list = list.slice(day_of_week).concat(list.slice(0,day_of_week));
	var final_time_array = [];
	var final_nav_time_array = [];
	var final_time_array_i = [];
	for(var i=0; i<sorted_list.length; i++)
	{
	    if(sorted_list[i]=="Sun")
	    {
	        final_time_array.push(Sunday);
	        final_time_array_i.push(Sunday_i);
	    }
	    if(sorted_list[i]=="Mon")
	    {
	        final_time_array.push(Monday);
	        final_time_array_i.push(Monday_i);
	    }
	    if(sorted_list[i]=="Tue")
	    {
	        final_time_array.push(Tueday);
	        final_time_array_i.push(Tueday_i);
	    }
	    if(sorted_list[i]=="Wed")
	    {
	        final_time_array.push(Wedday);
	        final_time_array_i.push(Wedday_i);
	    }
	    if(sorted_list[i]=="Thu")
	    {
	        final_time_array.push(Thuday);
	        final_time_array_i.push(Thuday_i);
	    }
	    if(sorted_list[i]=="Fri")
	    {
	        final_time_array.push(Friday);
	        final_time_array_i.push(Friday_i);
	    }
	    if(sorted_list[i]=="Sat")
	    {
	        final_time_array.push(Satday);
	        final_time_array_i.push(Satday_i);
	    }
	}
	console.log(final_time_array);
  $('.picker').markyourcalendar({
    availability: 
    
    	final_time_array
    ,
    // isMultiple: true,
    startDate: new Date(),
	doctorZone: '<?= $doctor_profile_data->timezone; ?>',
    onClick: function(ev, data) {
      // $('#showboomdal').click();
      //   $('.loaderhere').fadeIn('slow');
        var d = data[0].split(' ')[0];
		
		if(holidays.indexOf(d) > -1) {
			alert('Sorry! Docotr take a leave for this day. Please select another day');
			$(this).removeClass('selected');
		}
		else{
			var t = data[0].split(' ')[1] +' '+ data[0].split(' ')[2] +' '+ data[0].split(' ')[3] +' ' + data[0].split(' ')[4] +' '+ data[0].split(' ')[5];
			var doc_id = data[0].split('_')[1];        
			$.post('frontend/checkthistimeslots',{date:d,time:t,docId:doc_id},function(result){
				$('.loaderhere').fadeOut('slow');
				var obj = JSON.parse(result);
				// if(obj['status']=='not_login')
				// {
				//     $('.login_form').fadeIn('slow');
				//     return;
				// }
				// else
				// {
				if(obj['app_count'] > 0)
				{
					alert('Time slot already booked.');
					// $('.close').click();
					$(this).removeClass('selected');
				}
				else
				{
					$('#doctor_id').val(doc_id);
					$('#appointment_date').val(d);
					$('#appointment_time_slot').val(t); 
				}
				// }
			});
		}
      // data is a list of datetimes
      console.log(d,t,doc_id);
    },
    onClickNavigator: function(ev, instance) {
      var arr = 
                final_time_array_i
              instance.setAvailability(arr);
    }
  });      
 })(jQuery);
</script>

