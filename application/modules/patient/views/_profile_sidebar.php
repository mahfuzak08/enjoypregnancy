<!-- Profile Sidebar -->
<?php $select_menu = $this->uri->segment(2, 0); ?>
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
	<div class="profile-sidebar">
		<div class="widget-profile pro-widget-content">
			<div class="profile-info-widget">
				<a href="#" class="booking-doc-img">
					<img src="<?= $patient_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
				</a>
				<div class="profile-det-info">
					<h3><?= $patient_data->name; ?></h3>
					<div class="patient-details">
						<h5><i class="fas fa-birthday-cake"></i> <?= $patient_data->birthdate; ?>, <?= floor(abs(strtotime(date("Y-m-d")) - strtotime($patient_data->birthdate)) / (365*60*60*24)); ?> years</h5>
						<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $patient_data->address; ?></h5>
					</div>
				</div>
			</div>
		</div>
		<div class="dashboard-widget">
			<nav class="dashboard-menu">
				<ul>
					<li class="<?= $select_menu == 'dashboard' ? 'active': ''; ?>">
						<a href="patient/dashboard">
							<i class="fas fa-columns"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li class="<?= $select_menu == 'favourites' ? 'active': ''; ?>">
						<a href="patient/favourites">
							<i class="fas fa-bookmark"></i>
							<span>Favourites</span>
						</a>
					</li> 
					<li class="<?= $select_menu == 'dependent' ? 'active': ''; ?>">
						<a href="patient/dependent">
							<i class="fas fa-users"></i>
							<span>Dependent</span>
						</a>
					</li> 
					<li class="<?= $select_menu == 'chat' ? 'active': ''; ?>">
						<a href="chat/open/all">
							<i class="fas fa-comments"></i>
							<span>Message</span>
							<small class="unread-msg">23</small>
						</a>
					</li>
					<li class="<?= $select_menu == 'accounts' ? 'active': ''; ?>">
						<a href="patient/accounts">
							<i class="fas fa-file-invoice-dollar"></i>
							<span>Accounts</span>
						</a>
					</li>
					<li class="<?= $select_menu == 'medical_records' ? 'active': ''; ?>">
						<a href="patient/medical_records">
							<i class="fas fa-clipboard"></i>
							<span>Add Medical Records</span>
						</a>
					</li>
					<li class="<?= $select_menu == 'medical_details' ? 'active': ''; ?>">
						<a href="patient/medical_details">
							<i class="fas fa-file-medical-alt"></i>
							<span>Medical Details</span>
						</a>
					</li>
					<li class="<?= $select_menu == 'profile' ? 'active': ''; ?>">
						<a href="patient/profile">
							<i class="fas fa-user-cog"></i>
							<span>Profile Settings</span>
						</a>
					</li>
					<li class="<?= $select_menu == 'change_password' ? 'active': ''; ?>">
						<a href="patient/change_password">
							<i class="fas fa-lock"></i>
							<span>Change Password</span>
						</a>
					</li>
					<li>
						<a href="auth/logout">
							<i class="fas fa-sign-out-alt"></i>
							<span>Logout</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>

	</div>
</div>
<!-- / Profile Sidebar -->