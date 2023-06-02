<style>
.holiday{
	background: #b11b97; 
	border-color: #b11b97; 
	color:#FFF !important;
}
.schedule-nav .nav-tabs li a.holiday.active{
	background: #ff4877; 
	border-color: #ff4877; 
	color:#FFF;
}
</style>
<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Schedule Timings</h4>
					<div class="profile-box">
						<div class="row">
							<div class="col-md-12">
								<div class="card schedule-widget mb-0">
								
									<!-- Schedule Header -->
									<div class="schedule-header">
									
										<!-- Schedule Nav -->
										<div class="schedule-nav">
											<ul class="nav nav-tabs nav-justified">
												<li class="nav-item">
													<a class="nav-link active" data-toggle="tab" href="#slot_sunday">Sunday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#slot_monday">Monday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#slot_tuesday">Tuesday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#slot_wednesday">Wednesday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#slot_thursday">Thursday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#slot_friday">Friday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#slot_saturday">Saturday</a>
												</li>
												<li class="nav-item">
													<a class="nav-link holiday" data-toggle="tab" href="#slot_holidays">Holidays</a>
												</li>
											</ul>
										</div>
										<!-- /Schedule Nav -->
										
									</div>
									<!-- /Schedule Header -->
									
									<!-- Schedule Content -->
									<div class="tab-content schedule-cont">
									
										<!-- Sunday Slot -->
										<div id="slot_sunday" class="tab-pane fade show active">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Sunday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Sunday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Sunday Slot -->

										<!-- Monday Slot -->
										<div id="slot_monday" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Monday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Monday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Monday Slot -->

										<!-- Tuesday Slot -->
										<div id="slot_tuesday" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Tuesday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Tuesday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Tuesday Slot -->

										<!-- Wednesday Slot -->
										<div id="slot_wednesday" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Wednesday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Wednesday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Wednesday Slot -->

										<!-- Thursday Slot -->
										<div id="slot_thursday" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Thursday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Thursday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Thursday Slot -->

										<!-- Friday Slot -->
										<div id="slot_friday" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Friday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Friday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Friday Slot -->

										<!-- Saturday Slot -->
										<div id="slot_saturday" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Time Slots</span> 
												<a class="edit-link" data-toggle="modal" onclick="add_weekday('Saturday')" href="#add_time_slot"><i class="fa fa-plus-circle"></i> Add Slot</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												$isnew = true;
												foreach($schedules as $row) { 
													if($row->weekday == 'Saturday') { 
														$isnew = false; ?>
														<div class="doc-slot-list">
															<?= $row->s_time. ' - ' . $row->e_time; ?>
															<a href="javascript:void(0)" class="delete_slot" data-slot="<?= $row->id; ?>">
																<i class="fa fa-times"></i>
															</a>
														</div><?php 
													} 
												} 
												if($isnew) { ?>
													<p class="text-muted mb-0">Not Available</p><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Saturday Slot -->
										
										<!-- Holidays -->
										<div id="slot_holidays" class="tab-pane fade">
											<h4 class="card-title d-flex justify-content-between">
												<span>Date(s)</span> 
												<a class="edit-link" data-toggle="modal" href="#add_holiday"><i class="fa fa-plus-circle"></i> Add Holiday</a>
											</h4>
											<!-- Slot List -->
											<div class="doc-times">
												<?php 
												foreach($holidays as $row) { ?>
													<div class="doc-slot-list">
														<?= $row->date; ?>
														<a href="schedule/deleteHoliday2?id=<?= $row->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');">
															<i class="fa fa-times"></i>
														</a>
													</div><?php 
												} ?>
											</div>
											<!-- /Slot List -->
										</div>
										<!-- /Saturday Slot -->

									</div>
									<!-- /Schedule Content -->
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / main page content in right side -->