<?php
$settings = $this->frontend_model->getSettings();
$title = explode(' ', $settings->title);
?>
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
												<li><a href="frontend/faq">FAQ</a></li>
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
		</div>
		<!-- /Main Wrapper -->
		
		<div class="modal fade bd-example-modal-lg show" id="help_video_box">
	      	<div class="modal-dialog modal-lg">
	        	<div class="modal-content">
	              	<div class="modal-header">
	                	<h4 class="modal-title" id="help_video_box_label">How to Register</h4>
	                	<button class="close" type="button" onclick="pauseVid()" title=""><span aria-hidden="true">×</span></button>
	              	</div>
	              	<div class="modal-body" id="video_player_div"></div>
	        	</div>
	      	</div>
	    </div>
		<?php $error_msg = $this->session->flashdata('error_msg'); if(! empty($error_msg)) { ?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: absolute;top: 20%;left: calc(50% - 250px);width:500px;text-align:center;">
			<strong><?= $error_msg; ?></strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<?php } ?>
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		 <div class="modal-dialog modal-md modal-dialog-centered" role="document">   
		     <div class="modal-content">
		        <div class="modal-header">
		            <h5 class="modal-title">Lab Test Details</h5>
		            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        </div>
		        <div class="modal-body labtestdetails_div">            
		           
		        </div>
		        <div class="modal-footer">
		            <button class="btn btn-info" data-dismiss="modal" aria-label="Close" type="button">Close</button>
		            <button class="btn btn-primary" type="button"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
		        </div>   
		     </div>
		    
		</div>
		</div>
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
		
		<!-- Custom JS -->
		<script src="new_assets/js/script.js"></script>
		<script src="new_assets/js/ab.js"></script>

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
			
			
        </script>
</body>

</html>