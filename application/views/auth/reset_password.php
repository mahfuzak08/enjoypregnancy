
<style type="text/css">
	#infoMessage p{
		margin-bottom: 0px;
	}
</style>
<div class="section-category content account-page">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-10 offset-md-1">
				
				<!-- Login Tab Content -->
				<div class="account-content">
					<div class="row align-items-center justify-content-center">
						<div class="col-md-7 col-lg-7 login-left">
							<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">	
						</div>
						<div class="col-md-12 col-lg-5 login-right">
							<div class="login-header">
								<h3><?php echo lang('reset_password_heading'); ?></h3>
							</div>

							<?php if(isset($message)){ ?>
								<div id="infoMessage" class="alert alert-danger"><?php echo $message; ?></div>
							<?php } ?>
							<?php 
							if($this->session->flashdata('email_verified_msg')==true)
							{
								echo $this->session->flashdata('email_verified_msg');
							}
							?>
							<?php echo form_open('auth/reset_password/' . $code); ?>
								<div class="reg_error_msg" style="display:none;"></div>
								<div class="form-group form-focus">
									<input type="password" class="form-control floating password-input" name="new" id="new" pattern="^.{5}.*$" aria-autocomplete="list" required>
									<label class="focus-label"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label>
									<i class="fa fa-eye show-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey;"></i>
									<i class="fa fa-eye-slash hide-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey; display:none"></i>
								</div>
								<div class="form-group form-focus">
									<input type="password" class="form-control floating password-input" name="new_confirm" id="new_confirm" pattern="^.{5}.*$" aria-autocomplete="list" required>
									<label class="focus-label"><?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?></label>
									<i class="fa fa-eye show-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey;"></i>
									<i class="fa fa-eye-slash hide-password" style="position: absolute; top: 18px; right: 10px; cursor: pointer; color: grey; display:none"></i>
								</div>
								<?php echo form_input($user_id); ?>
								<?php echo form_hidden($csrf); ?>
								<button class="btn btn-primary btn-block btn-lg login-btn loginbtn" type="submit"><?= lang('reset_password_submit_btn'); ?></button>
							</form>
						</div>
					</div>
				</div>
				<!-- /Login Tab Content -->
					
			</div>
		</div>

	</div>
</div>
<script>
 $('.show-password').click(function(){
    $(this).fadeOut('slow');
    $('.hide-password').fadeIn('slow');
    $('.password-input').prop('type', 'text');
});

$('.hide-password').click(function(){
    $(this).fadeOut('slow');
    $('.show-password').fadeIn('slow');
    $('.password-input').prop('type', 'password');
});
</script>