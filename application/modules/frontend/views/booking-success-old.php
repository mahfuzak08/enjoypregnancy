<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>frontend/pharmacy">Pharmacy</a></li>
						<li class="breadcrumb-item active" aria-current="page">Booking</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Booking</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content success-page-cont">
	<div class="container-fluid">
	
		<div class="row justify-content-center">
			<div class="col-lg-6">
			
				<!-- Success Card -->
				<div class="card success-card">
					<div class="card-body">
						<div class="success-cont">
							<i class="fas fa-check"></i>
							<?php if($this->session->flashdata('success_order') or isset($_GET['success_payment'])){
								if(isset($_GET['success_payment']) and $_GET['success_payment']=='true')
								{
									$data['transaction_id'] = '';
									$presc_id = $_COOKIE['presc_ids'];									
									$products_id = $_COOKIE['prod_ids'];
                                    $stripe_session_id = $this->session->userdata('stripe_sessionID');
                                    if($presc_id != '' or $products_id != '')
                                    {
                                    	require APPPATH . 'third_party/stripe/stripe-php/init.php';
                                    	\Stripe\Stripe::setApiKey('sk_test_51IG6NjCnnFzOpBJC51qnVDBJ54TruldpdZL8oUwEUcFtjeMjzNf8n8TOwzpJIe3SZ0qHkNXP2u2m3q6SebZnApY700wBSBRrZs');
										 $session = \Stripe\Checkout\Session::retrieve(
													  $stripe_session_id,
													  []
													);
										// echo "<pre>";
										// print_r($session);
										$payment_intent = $session->payment_intent;										
										$data = $_GET;
										$data['transaction_id'] = $payment_intent;
										$res = $this->frontend_model->insertOrders($data);
										$order_id = $res;

										$message = "<p><strong>Thank You!</strong></p>";
										$message .= "<p><strong> Dear ".$data['name'].",</strong></p>";
										$message .= "<p>Your Payment has been successfully received for this <b>Order ID: ".$order_id."</b>. Your medicines will be in your door step as soon as possible.</p>";
								        // echo $message;
								        // exit;
								        $this->load->library('email'); 
								        $config['mailtype'] = "html";
								        $config['newline'] = "\r\n";
								        $this->email->initialize($config);        
								        $this->email->from('no-replay@maulaji.com', 'Maulaji');
								        $this->email->to($data['email']);
								        $this->email->subject('Maulaji Order Payment Confirmation');
								        $this->email->message($message);
										$this->email->send();
									}
								}
								else
								{
									$order_id = $this->session->flashdata('success_order');
								}
							 ?>

								<h3>Order placed Successfully!</h3>
								<p>Order ID: <?php echo $order_id ?></p>

							<?php } if($this->session->flashdata('success_msg')){ ?>

								<h3>Appointment booked Successfully!</h3>
								<p><?php echo $this->session->flashdata('success_msg'); ?></p>

							<?php } ?>
							<?php $display_none_pharmacy = ""; if($this->session->flashdata('normal_app_feedback')){ 
								echo $this->session->flashdata('normal_app_feedback');
								$display_none_pharmacy = "none";
							 } ?>
							<a href="<?php echo base_url() ?>" class="btn btn-primary view-inv-btn">Home</a>
							<a href="<?php echo base_url('patient/dashboard') ?>" class="btn btn-primary view-inv-btn">Dashboard</a>
							<!--<a href="<?php echo base_url() ?>frontend/pharmacy" class="btn btn-primary view-inv-btn" style="display: <?php echo $display_none_pharmacy; ?>">Pharmacy</a>-->
						</div>
					</div>
				</div>
				<!-- /Success Card -->
				
			</div>
		</div>
		
	</div>
</div>		
<?php 
	if($this->session->flashdata('success_order'))
	{
		$this->frontend_model->deleteprescription();
	}
?>
<!-- /Page Content -->
<script type="text/javascript">
	var exdays = 30;
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = 'prod_ids' + "=;" + expires + ";path=/";
    document.cookie = 'presc_ids' + "=;" + expires + ";path=/";
</script>