				</div>
			</div>
		</div>
		<!-- / Page Content -->
		<?php if($chatpage === false){ ?>
		<!-- Footer -->
		<footer class="footer">
			<!-- Footer Top -->
			<div class="footer-top">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-7">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<!-- Footer Widget -->
									<div class="footer-widget footer-about">
										<div class="footer-logo">
											<?php 
											if(isset($maulaji_talk) and $maulaji_talk=='yes')
			                            	{
			                            		echo '<img src="uploads/maulajitalklogo.png" class="img-fluid" alt="logo" width="250px">';
			                            	}
			                            	elseif(isset($maulaji_talk) and $maulaji_talk=='docshare')
			                            	{
			                            		echo '<img src="uploads/docshareLogo.png" class="img-fluid" alt="logo" width="250px">';
			                            	}
			                            	elseif(isset($maulaji_talk) and $maulaji_talk=='drive')
			                            	{
			                            		echo '<img src="uploads/drivelogo.png" class="img-fluid" alt="logo" width="250px">';
			                            	}
			                            	elseif(isset($maulaji_talk) and $maulaji_talk=='health')
			                            	{
			                            		echo '<img src="uploads/healthandwealthlogo.png" class="img-fluid" alt="logo" width="250px">';
			                            	}
			                            	elseif(isset($maulaji_talk) and $maulaji_talk=='learn')
			                            	{
			                            		echo '<img src="uploads/learnmedicallogo.png" class="img-fluid" alt="logo" width="250px">';
			                            	}
			                            	else
			                            	{
		                                		echo '<img src=' . $settings->logo . ' class="img-fluid" alt="logo" width="250px">';
		                            		}
											?>
											<!-- <img src="new_assets/img/logo1.png" class="img-fluid" alt="logo" width="250px"> -->
										</div>
										<div class="footer-about-content">
											<p>Maulaji Health Services. ANYTIME. ANYWHERE.Maulaji® connects you with a board-certified doctor 24/7/365 through the convenience of phone or video visits.</p>
											<div class="social-icon">										
												<ul>
													<li>	<a href="https://www.facebook.com/maulaji.telehealth" target="_blank"><i class="fab fa-facebook-f"></i> </a>
													</li>
													<li>	<a href="https://twitter.com/maulajiT" target="_blank"><i class="fab fa-twitter"></i> </a>
													</li>
													<li>	<a href="https://www.linkedin.com/in/maulaji-telehealth-1179a9202/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
													</li>
													<li>	<a href="https://www.instagram.com/maulajitelehealth/" target="_blank"><i class="fab fa-instagram"></i></a>
													</li>
													<li>	<a href="https://www.youtube.com/channel/UCWu2brD2NzoXu-dPckwJxYg" target="_blank"><i class="fab fa-youtube"></i> </a>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- /Footer Widget -->
								</div>
								<div class="col-lg-3 col-md-6">
									<!-- Footer Widget -->
									<div class="footer-widget footer-menu">
										<h2 class="footer-title">For Patients</h2>
										<ul>
											<li><a href="frontend/searchdoctors">Search for Doctors</a>
											</li>
											<li><a href="auth/login">Login</a>
											</li>
											<li><a href="auth/register">Register</a>
											</li>
											<li><a href="frontend/consult_urgent_docotrs">Book Urgent Consultation</a>
											</li>
											<li><a href="frontend/book_home_visit">Book Home Visit</a>
											</li>
										</ul>
									</div>
									<!-- /Footer Widget -->
								</div>
								<div class="col-lg-3 col-md-6">
									<!-- Footer Widget -->
									<div class="footer-widget footer-menu">
										<h2 class="footer-title">For Doctors</h2>
										<ul>
											<li><a href="frontend/searchdoctors">Appointments</a>
											</li>
											<li><a href="auth/login">Login</a>
											</li>
											<li><a href="auth/doctor_register">Register</a>
											</li>
										</ul>
									</div>
									<!-- /Footer Widget -->
								</div>
							</div>
						</div>
						<div class="col-md-5">	
							<div class="row">					
								<div class="col-lg-5 col-md-6">
									<!-- Footer Widget -->
									<div class="footer-widget footer-contact">
										<div class="footer-widget footer-menu">
											<h2 class="footer-title">Tools</h2>
											<ul>
												<li><a href="talk">Maulaji Talk</a></li>
												<li><a href="https://drive.maulaji.com/" target="_blank">Secure Drive</a></li>
												<li><a href="#" target="_blank">Secure Doc Share</a></li>
												<li><a href="#">Health & Wellness</a></li>
												<li><a href="https://learn.maulaji.com/">Learn Medical</a></li>
											</ul>
										</div>
									</div>
									<!-- /Footer Widget -->
								</div>
								<div class="col-lg-7 col-md-6">
									<!-- Footer Widget -->
									<div class="footer-widget footer-contact">
										<div class="footer-widget footer-menu">
											<h2 class="footer-title">Quick Links</h2>
											<ul>
												<li><a href="frontend/contact">Contact Us</a></li>
												<li><a href="auth/hospital_register">Register your Hospital</a>	</li>
												<li><a href="auth/pharmacy_register">Register your Pharmacy</a>	</li>
												<!-- <li><a href="mailto:contact@maulaji.com">contact@maulaji.com</a></li>										 -->
											</ul>
										</div>
									</div>
									<!-- /Footer Widget -->
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<!-- /Footer Top -->
			<!-- Footer Bottom -->
			<div class="footer-bottom">
				<div class="container-fluid">
					<!-- Copyright -->
					<div class="copyright">
						<div class="row">
							<div class="col-md-6 col-lg-6">
								<div class="copyright-text">
									<p class="mb-0">&copy; 2021 maulaji. All rights reserved.</p>
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<!-- Copyright Menu -->
								<div class="copyright-menu">
									<ul class="policy-menu">
										<li><a href="frontend/terms_conditions">Terms and Conditions</a>
										</li>
										<li><a href="frontend/privacy_policy">Privacy Policy</a>
										</li>
									</ul>
								</div>
								<!-- /Copyright Menu -->
							</div>
						</div>
					</div>
					<!-- /Copyright -->
				</div>
			</div>
			<!-- /Footer Bottom -->
		</footer>
		<!-- /Footer -->
		<?php } ?>
	</div>
	<!-- /Main Wrapper -->
	
	<audio id="notif_audio">
		<source src="new_assets/sounds/notify.ogg" type="audio/ogg">
		<source src="new_assets/sounds/notify.mp3" type="audio/mpeg">
		<source src="new_assets/sounds/notify.wav" type="audio/wav">
	</audio>

	<div id="ring_div">
		<div class="ring_text">Incoming call...</div>
		<div class="ring_btn_div">
			<button onclick="reject_call()" class="btn slash"><i class="fas fa-phone-slash"></i></button>
			<button onclick="receive_call()" class="btn"><i class="fas fa-phone"></i></button>
		</div>
		<audio id="incoming_ring"><source src="new_assets/sounds/incoming.mp3" type="audio/mp3">Your browser does not support the audio tag.</audio>
	</div>
	
	<?php $error_msg = $this->session->flashdata('error_msg'); if(! empty($error_msg)) { ?>
	<div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: absolute;top: 20%;left: calc(50% - 250px);width:500px;text-align:center;">
		<strong><?= $error_msg; ?></strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>
	<?php } ?>
	
	<?php $feedback = $this->session->flashdata('feedback'); ?>
	<?php if(! empty($feedback)) { ?>
	<div class="alert alert-<?= $feedback['status'] === false ? 'danger' : 'success'; ?> alert-dismissible fade show" style="position: absolute;top: 20%;left: calc(50% - 250px);width:500px;text-align:center;" role="alert">
		<strong><?= is_array($feedback) ? $feedback['message'] : $feedback; ?></strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>
	<?php } ?>
	<?php 
	if($chatpage === false)
		$this->load->view("partial/_popup_html"); 
	else
		$this->load->view("partial/_user_list_popup_html"); 
	?>
		
		<!-- Sticky Sidebar JS -->
        <script src="new_assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="new_assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
        <!-- Datetimepicker JS -->
        <script src="new_assets/js/moment.min.js"></script>
        <script src="new_assets/js/bootstrap-datetimepicker.min.js"></script>
        <!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- Swiper JS -->
		<script src="new_assets/plugins/swiper/js/swiper.min.js"></script>
		
		<!-- Slick JS -->
		<script src="new_assets/js/slick.js"></script>
		
		<!-- Datatables JS -->
		<script src="new_assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="new_assets/plugins/datatables/datatables.min.js"></script>
		
		<script src="new_assets/plugins/apex/apexcharts.min.js"></script>
		<?php
		if ($this->ion_auth->in_group(array('Doctor','admin'))) {
			echo '<script type="text/javascript" src="common/twilio.min.js"></script>';
		}
		?>
		<?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
		
			<script type="text/javascript" src="common/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
			<script type="text/javascript" src="common/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
			<script type="text/javascript" src="common/assets/ckeditor/ckeditor.js"></script>
			<script type="text/javascript" src="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
			<script src="common/js/advanced-form-components.js"></script>
			<script src="common/js/jquery.cookie.js"></script>
			
			<link rel="stylesheet" type="text/css" href="<?=base_url()?>common/snackbar/snackbar.css">
            <script src="<?=base_url()?>common/snackbar/snackbar.js"></script>

			<!-- Circle Progress JS -->
			<script src="new_assets/js/circle-progress.min.js"></script>
			
			<!-- Full Calander -->
			<script src="new_assets/plugins/fullcalendar/fullcalendar.min.js"></script>
			<script type="text/javascript">
				function switch_popup(){
					selectedTab = $('#patient_details .nav-link.active').attr('href');
					$('.patient_details_modal').modal('hide');
				}
				function connectCall(sender,number)
				{
					event.preventDefault();
					if (window.onCall){
						window.onCall = false;
						window.phone.disconnectAll();
						$(sender).removeClass('btn-danger');
						$(sender).html('<i class="fa fa-phone"></i>');
						return;
					}

					window.phone.connect({
						number: number
					}).on('ringing',()=>{
						console.log("Connecting To Caller"+"Info")
					});
					window.onCall = true;
					$(sender).addClass('btn-danger');
					$(sender).html('<i class="fa fa-times"></i>');
				}

				function showSendSmsModal(sender,number)
				{
					event.preventDefault();
					$('#smsModal #to_number').val(number);
					$('#smsModal').modal('show');
					switch_popup();
				}

				function sendSms()
				{
					var phone = $('#smsModal #to_number').val();
					var message = $('#smsModal #message').val();

					$('#smsModal #sendSms').attr('disabled','disabled');

					$.post('<?php echo base_url() ?>doctor/sendMessage',{
						to: phone,
						body: message
					}).done(response=>{
						response = JSON.parse(response);
						if (!response.success){
							$('#smsModal #info').addClass('bg-danger');
						}else{
							$('#smsModal #info').addClass('bg-success');
							$('#smsModal #message').val('')
						}
						$('#smsModal #info').text(response.message);
						$('#smsModal #info').show();
						$('#smsModal #sendSms').removeAttr('disabled');
					}).fail(error=>{
						$('#smsModal #message').val('')
						$('#smsModal #info').addClass('bg-danger');
						$('#smsModal #info').text(error.message);
						$('#smsModal #info').show();
						$('#smsModal #sendSms').removeAttr('disabled');
					})
				}

				function showSendEmailModal(sender,email)
				{
					event.preventDefault();
					$('#emailModal #email').val(email);
					$('#emailModal').modal('show');
					switch_popup();
				}

				function sendEmail()
				{
					var email = $('#emailModal #email').val();
					var message = $('#emailModal #body').val();

					$('#emailModal #sendEmail').attr('disabled','disabled');

					$.post('<?php echo base_url() ?>doctor/sendEmail',{
						email: email,
						body: message
					}).done(response=>{
						response = JSON.parse(response);
						if (!response.success){
							$('#emailModal #info').addClass('bg-danger');
						}else{
							$('#emailModal #info').addClass('bg-success');
							$('#emailModal #message').val('')
						}
						$('#emailModal #info').text(response.message);
						$('#emailModal #info').show();
						$('#emailModal #sendEmail').removeAttr('disabled');
					}).fail(error=>{
						$('#emailModal #message').val('')
						$('#emailModal #info').addClass('bg-danger');
						$('#emailModal #info').text(error.message);
						$('#emailModal #info').show();
						$('#emailModal #sendEmail').removeAttr('disabled');
					})
				}
				
				function registerPhone()
				{
					$.get('<?php echo base_url() ?>doctor/getToken').done(response=>{
						if ( !window.phone ){
							window.phone = new Twilio.Device(response,{ debug: true});
							console.log("Phone Ready");
							window.phone.on('connect',()=>{
								console.log("Call Connected "+" Success");
							})
							window.phone.on('disconnect',()=>{
								console.log("Call Disconnected"+"Info")
							})
						}

					}).fail(error=>{
						console.log(error);
					})
				}
				
				$(document).ready(function () {
					$('#calendar').fullCalendar({
						lang: 'en',
						events: 'appointment/getAppointmentByJason',
						header:
								{
									left: 'prev,next today',
									center: 'title',
									right: 'month,agendaWeek,agendaDay',
								},
						timeFormat: 'h(:mm) A',
						eventRender: function (event, element) {
							element.find('.fc-time').html(element.find('.fc-time').text());
							element.find('.fc-title').html(element.find('.fc-title').text());

						},
						eventClick: function (event) {
							if (event.id) {
								patient_popup_ajax(event.id);
							}
						},

						slotDuration: '00:15:00',
						businessHours: true,
						slotEventOverlap: false,
						editable: false,
						selectable: false,
						lazyFetching: true,
						minTime: "00:00:00",
						maxTime: "24:00:00",
						defaultView: 'month',
						allDayDefault: false,
						displayEventEnd: true,
						timezone: false
					});
				});
				
				function add_weekday(s){
					$("#weekday").val(s);
				}
				
				function confirm_box_open(str){
					return new Promise((resolve, reject)=>{
						$("#confirm_box .modal-body p").html(str);
						$("#confirm_box").modal('show');
						$("button").click(function(){
							if($(this).hasClass("confirm_box_ok")){$("#confirm_box").modal('hide'); resolve("yes");}
							else{$("#confirm_box").modal('hide'); resolve("no");}
						});
					});
				}
				
				$(".delete_slot").click(async function(){
					var elm = $(this);
					var ans = await confirm_box_open("Are you sure you want to delete this slot?");
					if(ans == 'yes'){
						$.ajax({
							url: "schedule/deleteTimeSlot2",
							type: "POST",
							data: {"id": $(elm).attr("data-slot")},
							success: function(res){
								if(res == 'Done')
									$(elm).closest(".doc-slot-list").remove();
								else
									alert('Error' . res);
							},
							error: function(e){
								console.log(e);
							}
						});
					}
				});
				
				$(".bcteditbutton").click(function () {
					// Get the record's ID via attribute
					var iid = $(this).data('id');
					$('#editbodycharttmp .modal-title').text('Add New Template');
					$("#img").attr("src", "//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image");
					$('#editDoctorForm').trigger("reset");
					
					if(iid>0){
						$('#editbodycharttmp .modal-title').text('Edit Template');
						$.ajax({
							url: 'prescription/editBodyTemplateByJason?id=' + iid,
							method: 'GET',
							data: '',
							dataType: 'json',
							success: function (response) {
								// Populate the form fields with the data returned from server
								$('#editDoctorForm').find('[name="id"]').val(response.template.id).end()
								$('#editDoctorForm').find('[name="title"]').val(response.template.title).end()

								if (typeof response.template.thumbnil !== 'undefined' && response.template.thumbnil != '') {
									$("#img").attr("src", 'common/'+response.template.thumbnil);
								}
							}
						});
					}
					$('#editbodycharttmp').modal('show');
					
				});
				
			</script>
		<?php } ?>
		<!-- Custom JS -->
		<script src="new_assets/js/script.js"></script>
		
		<!-- <script src="new_assets/js/socket.io.js"></script> -->
		
		<?php
		// for grapy
		$history_date = array();
		$bmi = array();
		$heart_rate = array();
		$respiratory_rate = array();
		$temperature = array();
		$blood_pressure = array();
		$vaccination = array();
		$fbc = array();
		$weight = array();
		foreach($patientMedicalHistory as $gr){
			array_push($history_date, $gr->date);
			array_push($bmi, $gr->bmi == null ? 0 : $gr->bmi);
			array_push($heart_rate, $gr->heart_rate == null ? 0 : $gr->heart_rate);
			array_push($respiratory_rate, $gr->res_rate == null ? 0 : $gr->res_rate);
			array_push($temperature, $gr->temperature == null ? 0 : $gr->temperature);
			array_push($blood_pressure, $gr->blood_pressure == null ? 0 : $gr->blood_pressure);
			array_push($vaccination, $gr->vaccine == null ? 0 : $gr->vaccine);
			array_push($fbc, $gr->fbc == null ? 0 : $gr->fbc);
			array_push($weight, $gr->weight == null ? 0 : $gr->weight);
		}
		$history_date = json_encode($history_date);
		$bmi = json_encode($bmi);
		$heart_rate = json_encode($heart_rate);
		$respiratory_rate = json_encode($respiratory_rate);
		$temperature = json_encode($temperature);
		$blood_pressure = json_encode($blood_pressure);
		$vaccination = json_encode($vaccination);
		$fbc = json_encode($fbc);
		$weight = json_encode($weight);
		?>
		<script>
		var history_date = <?= $history_date; ?>;
		var bmi = <?= $bmi; ?>;
		var heart_rate = <?= $heart_rate; ?>;
		var respiratory_rate = <?= $respiratory_rate; ?>;
		var temperature = <?= $temperature; ?>;
		var blood_pressure = <?= $blood_pressure; ?>;
		var vaccination = <?= $vaccination; ?>;
		var fbc = <?= $fbc; ?>;
		var weight = <?= $weight; ?>;
		</script>

		<script src="new_assets/js/ab.js"></script>
		
		<?php // require("chat_script.php"); ?>
		
		<script type="text/javascript">
            function googleTranslateElementInit() {
                // var userLang = navigator.language || navigator.userLanguage;
                // console.log(userLang);
              new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
            }
            function changeLanguageText() 
            {
                if ($('.goog-te-combo option:first-child').text() == "Select Language") 
                {    
                    $(".goog-logo-link").empty();
                    $('.goog-te-gadget').html($('.goog-te-gadget').children());
                    // $('.goog-te-gadget').css('display','none').children();
                    $('.goog-te-combo').css("color","");
                    // $('.goog-te-combo').prepend("<option value='' selected>Language</option>");
                    $('.goog-te-combo option:first-child').text('Languages');
                } 
                else
                {
                    setTimeout(changeLanguageText, 50);
                }
            }
            changeLanguageText();
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script type="text/javascript">
        	$(".select2").select2({
			 allowClear:true,
			 placeholder: 'Shop by categories'
			 });

        	$(".select2-brand").select2({
			 allowClear:true,
			 placeholder: 'Shop by brands'
			 });

        	$(".selectType").select2({
			 allowClear:true,
			 placeholder: 'Shop by type'
			 });

        	$(document).mouseup(function(e) 
		    {		        
		        var container1 = $(".search-div");
		        // if the target of the click isn't the container nor a descendant of the container
		        if (!container1.is(e.target) && container1.has(e.target).length === 0) 
		        {
		            $('.products-div').hide();
		        }		        
		    });
			
			function popup(url, title, width, height) {
				var left = (screen.width / 2) - (width / 2);
				var top =  (screen.height / 2) - (height / 2);
				var options = '';
				options += ',width=' + width;
				options += ',height=' + height;
				options += ',top=' + top;
				options += ',left=' + left;
				return window.open(url, title, options);
			}
			
			$('.mediaBtn').click(function (event) {
				if(!confirm($(this).data('message'))){
					return false
				}
				var url = $(this).data('ref');
				if(url){
				    popup(url, '', (screen.width*80)/100, screen.height);
				    socket.emit("send_call_notification", {participants: $("#receiver").val(), url});
				}
			});
			function stop_ring(){
				$("#ring_div").hide().attr("data-ref", "");
				let ir = document.getElementById("incoming_ring");
				ir.pause();
			}
			function reject_call(){
				stop_ring();
			}
			function receive_call(){
				let url = $("#ring_div").attr("data-ref");
				popup(url, '', (screen.width*80)/100, screen.height);
				stop_ring();
			}
			// socket.on("receive_call_notification", function(data){
			// 	var ids = data.participants.split(',');
			// 	if(ids.indexOf(user_id) == -1){
			// 		$("#ring_div").show().attr("data-ref", data.url);
			// 		let ir = document.getElementById("incoming_ring");
			// 		ir.play();
			// 	}
			// });
			
			$('#download').click(function () {
				var pdf = new jsPDF('p', 'pt', 'letter');
				pdf.addHTML($('#print_invoice_content'), function () {
					pdf.save('lab_id_<?php echo $lab->id; ?>.pdf');
				});
			});
			
			$('.view_patient').click(function () {
				let id = $(this).attr('data-id');
				console.log(id);
				patient_popup_ajax(id, '');
			});
			
			function patient_popup_ajax(id, type='calendar'){
				$('#patient_details').html('');
				$.ajax({
					url: 'patient/get_patient_details?id=' + id + '&from_where=' + type,
					method: 'GET',
					data: '',
					dataType: 'html',
					success: function(response){
						$('#patient_details').append(response);
						$(".patient_details_modal").modal('show');
					},
					error: function(error){
						console.log(265, error);
					}
				});
			}
			
			function prescription_form_ajax(id=0){
				$('#prescription_form .modal-body').html('');
				$.ajax({
					url: 'doctor/openPrescriptionForm?id=' + id,
					method: 'GET',
					data: '',
					dataType: 'html',
					success: function(response){
						$('#prescription_form .modal-body').append(response);
						$("#prescription_form").modal('show');
					},
					error: function(error){
						console.log(569, error);
					}
				});
			}
			
        </script>
		<?php if(isset($_GET['edit_dep']) && $_GET['edit_dep'] > 0) { ?>
			<script>$(".add_dependent").trigger("click");</script>
		<?php } ?>
</body>

</html>