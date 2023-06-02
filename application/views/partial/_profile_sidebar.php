<!-- Profile Sidebar -->
<?php 
$class = $this->uri->segment(1, 0);
$select_menu = $this->uri->segment(2, 0); 
?>
<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
	<div class="profile-sidebar">
		<div class="widget-profile pro-widget-content">
			<?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
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
			<?php } ?>
			<?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
			<div class="profile-info-widget">
				<a href="#" class="booking-doc-img">
					<img src="<?= $doctor_data->img_url; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image">
				</a>
				<div class="profile-det-info">
					<h3><?= $doctor_data->name; ?></h3>
					<div class="patient-details">
						<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= str_replace('"', '', str_replace(']', '', str_replace('[', '', $doctor_data->address))); ?></h5>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="dashboard-widget">
			<nav class="dashboard-menu">
				<ul>
					<?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
						<li class="lg-menu <?= $select_menu == 'dashboard' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/dashboard">
								<i class="fas fa-columns"></i>
								<span>Dashboard</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'favourites' ? 'active': ''; ?>">
							<a href="patient/favourites">
								<i class="fas fa-bookmark"></i>
								<span>Favourites</span>
							</a>
						</li> 
						<li class="lg-menu <?= $select_menu == 'dependent' ? 'active': ''; ?>">
							<a href="patient/dependent">
								<i class="fas fa-users"></i>
								<span>Dependent</span>
							</a>
						</li> 
						<?php $total = $this->chat_model->totalUnreadMessages($patient_data->ion_user_id); ?>
						<li class="lg-menu <?= $select_menu == 'open' ? 'active': ''; ?>">
							<a href="chat/open/all">
								<i class="fas fa-comments"></i>
								<span>Message</span>
								<small class="unread-msg"><?= $total > 0 ? $total : ''; ?></small>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'accounts' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/accounts">
								<i class="fas fa-file-invoice-dollar"></i>
								<span>Accounts</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'medical_records' ? 'active': ''; ?>">
							<a href="patient/medical_records">
								<i class="fas fa-clipboard"></i>
								<span>Add Medical Records</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'medical_details' ? 'active': ''; ?>">
							<a href="patient/medical_details">
								<i class="fas fa-file-medical-alt"></i>
								<span>Medical Details</span>
							</a>
						</li>
						<?php 
					} ?>
					
					<?php if ($this->ion_auth->in_group(array('Doctor')) && $doctor_data->is_approved == 1) { ?>
						<li class="lg-menu <?= $select_menu == 'dashboard' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/dashboard">
								<i class="fas fa-columns"></i>
								<span>Dashboard</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'appointments' ? 'active': ''; ?>">
							<a href="doctor/appointments">
								<i class="fas fa-calendar-check"></i>
								<span>Appointments</span>
							</a>
						</li> 
						<li class="lg-menu <?= $select_menu == 'my_patients' ? 'active': ''; ?>">
							<a href="doctor/my_patients">
								<i class="fas fa-user-injured"></i>
								<span>My Patients</span>
							</a>
						</li> 
						<?php $total = $this->chat_model->totalUnreadMessages($doctor_data->ion_user_id); ?>
						<li class="lg-menu <?= $select_menu == 'open' ? 'active': ''; ?>">
							<a href="chat/open/all">
								<i class="fas fa-comments"></i>
								<span>Message</span>
								<small class="unread-msg"><?= $total > 0 ? $total : ''; ?></small>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'schedule_timing' ? 'active': ''; ?>">
							<a href="doctor/schedule_timing">
								<i class="fas fa-hourglass-start"></i>
								<span>Schedule Timings</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'prescriptions' ? 'active': ''; ?>">
							<a href="doctor/prescriptions">
								<i class="fas fa-prescription"></i>
								<span>Prescriptions</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'bodycharttemplate' ? 'active': ''; ?>">
							<a href="doctor/bodycharttemplate">
								<i class="fa fa-male"></i>
								<span>Body Chart Template</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'accounts' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/accounts">
								<i class="fas fa-file-invoice-dollar"></i>
								<span>Accounts</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'blogs' ? 'active': ''; ?>">
							<a href="doctor/blogs">
								<i class="fas fa-file-invoice"></i>
								<span>Blogs</span>
							</a>
						</li>
						<?php 
					} ?>
						<li class="lg-menu <?= $select_menu == 'profile' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/profile">
								<i class="fas fa-user-cog"></i>
								<span>Profile Settings</span>
							</a>
						</li>
						<li class="lg-menu <?= $select_menu == 'change_password' ? 'active': ''; ?>">
							<a href="<?= $class; ?>/change_password">
								<i class="fas fa-lock"></i>
								<span>Change Password</span>
							</a>
						</li>
						<li class="lg-menu">
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