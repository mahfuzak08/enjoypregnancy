<script src="new_assets/plugins/emojiarea/jquery.emojiarea.js"></script>
<link rel="stylesheet" href="new_assets/plugins/emojiarea/reset.css">
<link rel="stylesheet" href="new_assets/plugins/emojiarea/style.css">
<style>
.giphy{
	position: absolute;
    background: #FFF;
    width: 300px;
    height: 300px;
    overflow-y: auto;
    bottom: 45px;
    left: 6%;
    border-radius: 4px;
    padding: 10px;
	display: none;
}
.giphy #btnSearch{
	position: absolute;
    top: 45px;
    right: 20px;
    border-radius: 50%;
    background: #0de0fe;
	cursor: pointer;
    padding: 3px 7px;
    border: none;
}
.giphy-file-preview{
	margin-top: 10px;
}
</style>
<div class="col-xl-12">
	<div class="chat-window">
		<?php //print_r($conversation_lists); ?>
		<!-- Chat Left -->
		<div class="chat-cont-left">
			<div class="chat-header">
				<!--<span>Chats</span>-->
				<a href="<?= $this->ion_auth->in_group(array('Doctor')) ? 'doctor' : 'patient'; ?>/dashboard" class="btn btn-sm btn-flat btn-light">
					<i class="fa fa-chevron-left"></i> Back
				</a>
				<?php if(! $this->ion_auth->in_group(array('Patient'))) { ?>
				<i class="material-icons" data-toggle="modal" data-target="#new_user_list_popup" onclick="open_room_popup()" title="Search other doctor" style="cursor:pointer;">control_point</i>
				<?php } ?>
			</div>
			<div class="chat-search">
				<div class="input-group">
					<div class="input-group-prepend">
						<i class="fas fa-search"></i>
					</div>
					<input type="text" onkeyup="search_li(this.value, '#left_side_list')" class="form-control" placeholder="Search">
				</div>
			</div>
			<div class="chat-users-list">
				<div class="chat-scroll" id="left_side_list">
					<?php foreach($conversation_lists as $row){?>
					<?php 
					$active = $row->id == $conversation->id ? ' read-chat active' : '';
					if($row->conv_type == 'single') {
						$title = $row->username;
						$img = $row->fimg;
						$fids = explode(",", $row->participants_ids);
						$receiver_id = $fids[0] == $sender_id ? $fids[1] : $fids[0];
					} else {
						$title = $row->title;
						$img = $row->img;
						$receiver_id = $row->participants_ids;
					}?>
					<a href="javascript:void(0);" onclick="start_conv(<?= $row->id; ?>)" class="convlist offline media <?= $active; ?>" id="convid_<?= $row->id; ?>" data-conversation_type="<?= $row->conv_type; ?>" data-created_by="<?= $row->created_by; ?>" data-fid="<?= $receiver_id; ?>" data-title="<?= $title; ?>" data-img="<?= $img; ?>">
						<div class="media-img-wrap">
							<div class="avatar online_offline <?= $row->conv_type == 'single' ? 'single avatar-'.$receiver_id.' avatar-away' : 'group avatar-online'; ?>">
								<img src="<?= $img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $title; ?> Image" class="avatar-img rounded-circle">
							</div>
						</div>
						<div class="media-body">
							<div>
								<div class="user-name"><?= $title; ?></div>
								<div class="user-last-chat"><?= strip_tags($row->msg_body == null ? "No message" : explode("@FILE@", $row->msg_body)[0]); ?></div>
							</div>
							<div>
								<div class="last-chat-time block"><?= $row->msg_time == null ? $this->common->time_ago($row->created_at) : $this->common->time_ago($row->msg_time) ?></div>
								<div class="badge unread_count badge-success badge-pill"><?= $row->total_unread > 0 ? $row->total_unread : ""; ?></div>
							</div>
						</div>
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- /Chat Left -->
	
		<!-- Chat Right -->
		<div class="chat-cont-right">
			<div class="chat-header">
				<?php if($conversation->conv_type == 'single'){
					$tt = $conversation->username;
					$ti = $conversation->fimg;
					$fids = explode(",", $conversation->participants_ids);
					$receiver_id = $fids[0] == $sender_id ? $fids[1] : $fids[0];
				} else {
					$tt = $conversation->title;
					$ti = $conversation->img;
					$receiver_id = $conversation->participants_ids;
				} 
				$convtype = $conversation->conv_type;
				?>
				<a id="back_user_list" href="javascript:void(0)" class="back-user-list">
					<i class="material-icons">chevron_left</i>
				</a>
				<div class="media" onclick="show_room_details(<?= $conversation->id; ?>)">
					<div class="media-img-wrap">
						<div class="avatar online_offline avatar-<?= $receiver_id; ?> avatar-away">
							<img id="activeconvimg" src="<?= $ti; ?>" onerror="this.src='uploads/default.jpg'" alt="User Image" class="avatar-img rounded-circle">
						</div>
					</div>
					<div class="media-body">
						<div class="user-name" id="activeconvname"><?= $tt; ?></div>
						<div class="user-status">online</div>
					</div>
				</div>
				<div class="chat-options">
					<a href="javascript:void(0)" id="call_btn" data-message="Are you sure you want to start a live video meeting?" data-ref="<?php echo base_url('meeting/liveChatApp?type='. $convtype .'&m=2&roomId='.$conversation->id); ?>" title="<?= lang('live'); ?>" class="btn btn-sm btn-flat btn-light mediaBtn">
						<i class="fa fa-headphones" style="margin-right: 5px;"></i>Join
					</a>
					<!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#voice_call">
						<i class="material-icons">local_phone</i>
					</a>
					<a href="javascript:void(0)">
						<i class="material-icons">more_vert</i>
					</a>
					-->
				</div>
			</div>
			<div class="chat-body">
				<div class="chat-scroll" id="msgs-div">
					<ul class="list-unstyled" id="msgs-div-ul">
						<?php foreach($messages as $msg){ 
							$body = explode("@FILE@", $msg->msg_body); 
							if(strpos($body[0], "https://www.youtube.com/") === 0){
								$new_url = str_replace("watch?v=", "embed/", $body[0]);
								$body[0] = '<iframe width="560" height="315" src="'. $new_url .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
							}
							?>
							<li class="media <?= $msg->sender_id == $sender_id ? 'sent' : 'received'; ?>">
								<?php if($msg->sender_id != $sender_id) { ?>
								<div class="avatar">
									<img src="<?= $msg->sender_img; ?>" onerror="this.src='uploads/default.jpg'" alt="<?= $msg->sender_name; ?> Image" class="avatar-img rounded-circle">
								</div>
								<?php } ?>
								<div class="media-body">
									<div class="msg-box">
										<div>
											<p><?= $body[0]; ?></p>
											<?php if(! empty($body[1])) { 
													$attch = json_decode($body[1]); ?>
													<div class="chat-msg-attachments">
														<?php if($msg->msg_type == 'voice') { ?>
															<audio controls><source src="<?= $attch[0]; ?>" type="audio/wav">Your browser does not support the audio tag.</audio>
														<?php } else { ?>
															<?php foreach($attch as $af){ $an = substr($af, (strpos($af, "_", 10)+1)); ?>
																<div class="chat-attachment">
																	<img src="<?= $af; ?>" onerror="this.src='new_assets/img/other.png'" alt="Attachment">
																	<div class="chat-attach-caption"><?= $an; ?></div>
																	<a href="<?= $af; ?>" target="_blank" class="chat-attach-download">
																		<i class="fas fa-eye"></i>
																	</a>
																</div>
															<?php }  ?>
														<?php }  ?>
													</div>
											<?php } ?>
											<ul class="chat-msg-info">
												<li>
													<div class="chat-time">
														<span><?= $msg->created_at; ?></span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="chat-footer">
				<form action="" method="POST" id="send_msg_form" onsubmit="send_msg(); return false;">
					<div class="input-group" data-emojiarea data-type="unicode" data-global-picker="false">
						<div class="input-group-prepend">
							<div class="btn-group">
								<button type="button" onclick="toggole_more_chat_option()" class="btn btn-primary send-more"><i class="material-icons">more_vert</i></button>
								<div class="options-div">
									<div class="btn options giphy-open" onclick="show_giphy()" title="Giphy"><span style="position: relative;left: -5px;">😜</span></div>
									<div class="btn options emoji-button" onclick="active_tab1()" title="Emoji"><i class="far fa-smile"></i></div>
									<div class="btn options btn-file" title="Attachment">
										<i class="fa fa-paperclip"></i>
										<input type="file" id="msg_files" name="msg_files[]" multiple="multiple" onchange="display_preview()">
									</div>
									<div class="btn options" title="Voice Message"><i id="recordButton" class="fa fa-microphone"></i></div>
									<div class="btn options red" title="Stop Recording"><i id="stopButton" class="fa fa-microphone"></i></div>
								</div>
							</div>
						</div>
						<div class="giphy">
							<button class="close" type="button" onclick="reset_send()" title="Remove" style="margin-right: 10px;"><span aria-hidden="true">×</span></button>
							<input id="search" class="form-control" type="search" />
							<div id="btnSearch" onclick="search_giphy()"><i class="fa fa-search"></i></div>
							<div class="giphy-file-preview"></div>
						</div>
						<div class="file-preview">
							<button class="close" type="button" onclick="reset_send()" title="Remove" style="margin-right: 10px;"><span aria-hidden="true">×</span></button>
						</div>
						<div class="progress" id="recordProgress">
							<div class="progress-bar progress-bar-striped" id="recordProgressBar" role="progressbar" data-widht=0 style="width: 0%">0</div>
						</div>
						<input id="message" name="message" class="input-msg-send form-control" placeholder="Type something" autocomplete="off">
						<div class="input-group-append">
							<input type="hidden" name="conversation_id" id="conversation_id" value="<?= $conversation->id; ?>">
							<input type="hidden" name="sender_id" id="sender_id" value="<?= $sender_id; ?>">
							<input type="hidden" name="receiver" id="receiver" value="<?= $receiver_id; ?>">
							<input type="hidden" name="msg_type" id="msg_type" value="text">
							<button type="button" class="btn msg-send-btn" onclick="send_msg()"><i class="fab fa-telegram-plane"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- /Chat Right -->
		
	</div>
</div>
<script src="new_assets/plugins/recorder/WebAudioRecorder.min.js"></script>
<script src="new_assets/plugins/recorder/app.js"></script>
