<style>
.docname{
	padding: 10px 0px 0 0;
}
.docname .fas{
	display: none;
	position: relative;
	right: 10px;
	float: right;
}
a.active .docname .fas{
	display: block;
}
#basic-addon2:hover{
	cursor: pointer;
	background: #0de0fe;
	color: #FFF;
}
.conv_type{
	text-transform: capitalize;
}
#room_details_popup .input-group{
	margin-bottom: 10px;
}
#room_details_popup .title_edit{
	background: #CCC;
    padding: 12px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
}
</style>

<div class="modal fade show" id="new_user_list_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create Group</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body" style="max-height: calc(100vh - 100px); overflow-y: auto;">
				<div id="new_doctor_list">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Enter Group Name" id="room_name" name="room_name" aria-describedby="basic-addon2">
						<div class="input-group-append">
							<span class="input-group-text" onclick="create_room()" id="basic-addon2">Go</span>
						</div>
					</div>
					<br>
					<input type="text" onkeyup="search_li(this.value, '#doctor_popup_list')" class="form-control" placeholder="Search">
					<div class="chat-users-list">
						<div class="chat-scroll" id="doctor_popup_list">
						<?php foreach($doctors as $rowd) { if($rowd->ion_user_id == $sender_id) continue; ?>
							<a class="per_li liid_<?= $rowd->ion_user_id; ?>" href="javascript:void(0);" onclick="select('#new_user_list_popup', '<?= $rowd->ion_user_id; ?>')">
								<div style="float: left; border-bottom:1px solid #DDD; padding: 5px;width:100%;">
									<div class="avatar online_offline avatar-<?= $rowd->ion_user_id; ?> avatar-away" style="float: left;margin-right: 20px;">
										<img src="<?= $rowd->img_url; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $rowd->name; ?> Image" class="avatar-img rounded-circle">
									</div>
									<p class="docname"><?= $rowd->name; ?><i class="fas fa-check-circle"></i></p>
								</div>
							</a>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade show" id="room_details_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" aria-modal="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Conversation Details</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close" data-original-title="" title=""><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body" style="max-height: calc(100vh - 100px); overflow-y: auto;">
				<div class="col-12">
					<div class="card widget-profile pat-widget-profile">
						<div class="card-body">
							<div class="pro-widget-content">
								<div class="profile-info-widget">
									<a href="javascript:void(0);" class="booking-doc-img">
										<img src="" class="conv_img" onerror="this.src='uploads/default.jpg'" alt="User Image">
									</a>
									<div class="profile-det-info">
										<div class="input-group">
											<input type="text" disabled=true class="form-control conv_title" placeholder="Enter Group Name" style="text-align: center;" name="room_name">
											<div class="input-group-append title_edit">
												<i class="fa fa-edit" onclick="title_edit()"></i>
											</div>
										</div>
										<div class="patient-details">
											<h5 class="reset conv_type"></h5>
											<h5 class="mb-0"><span class="reset conv_member"></span> members in this conversation.</h5>
											<h5 class="mb-0 msgbox" style="display: none;"></h5>
										</div>
									</div>
									<hr>
									<input type="hidden" class="old_room_name">
									<button class="btn btn-info" onclick="add_more_member()">Add Member</button>
									<button class="btn btn-danger" onclick="leave_delete_group('delete')">Delete Group</button>
									<button class="btn btn-warning" onclick="leave_delete_group('leave')">Leave Group</button>
									<button class="btn btn-primary" onclick="update_group()">Update</button>
								</div>
							</div>
							<div class="chat-users-list member-lists">
								<div class="chat-scroll reset"></div>
							</div>
							<div id="more_doctor_list" style="display:none;">
								<input type="text" onkeyup="search_li(this.value, '#more_doctor_popup_list')" class="form-control" placeholder="Search">
								<div class="chat-users-list">
									<div class="chat-scroll" id="more_doctor_popup_list"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>