<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12 col-lg-6">
				
					<!-- Change Password Form -->
					<form action="patient/change_password" method="post">
						<div class="form-group">
							<label>Old Password</label>
							<input type="password" name="old" class="form-control">
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input type="password" name="new" class="form-control">
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" name="new_confirm" class="form-control">
						</div>
						<div class="submit-section">
							<button type="submit" name="change_password" class="btn btn-primary submit-btn">Save Changes</button>
						</div>
					</form>
					<!-- /Change Password Form -->
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / main page content in right side -->