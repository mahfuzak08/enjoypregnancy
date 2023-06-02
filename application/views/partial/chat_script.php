<?php 
$chat = $this->settings_model->get_api_info('chat');
$giphy = $this->settings_model->get_api_info('giphy');
?>
<!--chat script-->
<script type="text/javascript">
socket = io.connect( '<?= $chat->key1; ?>' ); // live server
// socket = io.connect( 'http://localhost:7681' ); // localhost
var user_id = <?= $user_id; ?>;

var pingpong;
/**
 * When disconnect event occured
 **/
socket.on('disconnect', function() {
    pingpong = setInterval(function(){
    	if (! socket.connected) {
			socket.open();
            console.log('Socket connected successfully 2');
    	}
	}, 200);
});

/**
 * When connect event occured
 **/
socket.on('connect', function() {
	console.log('Socket connected successfully 1');
	socket.emit('join_me', { user_id });
	clearInterval(pingpong);
});
/**
 * When reconnect event occured
 **/
socket.on('reconnect', (attemptNumber) => {
    clearInterval(pingpong);
});

socket.on('update_conversation', (data) => {
	if($("#convid_"+data.id).is(":visible")){
		if(data.type !== undefined && data.type == 'delete'){
			$("#convid_"+data.id).remove();
		}
		else{
			var ele = $("#convid_"+data.id);
			$(ele).attr("data-fid", data.participants_ids);
			$(ele).attr("data-title", data.title);
			$(ele).find(".user-name").text(data.title);
			$(ele).attr("data-img", data.img);
			$(ele).find(".avatar-img.rounded-circle").attr("src", data.img);
		}
	}
	else{
		let members = data.participants_ids.split(",");
		console.log(51, members, user_id);
		if(members.indexOf(user_id) > -1){
			location.reload();
		}
	}
	if( $("#conversation_id").val() == data.id ){
		if(data.type !== undefined && data.type == 'delete'){
			$("#left_side_list .convlist:first").trigger('click');
		}
		else{
			$("#activeconvimg").attr("src", $("#convid_"+data.id).attr("data-img"));
			$("#activeconvname").text($("#convid_"+data.id).attr("data-title"));
			$("#receiver").val($("#convid_"+data.id).attr("data-fid"));
		}
	}
});

$("#msgs-div").animate({ scrollTop: $('#msgs-div').prop("scrollHeight")}, 1000);

function send_msg(blob = false, encoding = false){
	if(encoding == 'wav'){
		$("#msg_type").val('voice');
		$("#message").val('Voice Message');
	}
	var formdata = new FormData($("#send_msg_form")[0]);
	if(encoding == 'wav'){
		let fn = "voice."+encoding;
		var msg_audio_file = new File([blob], fn, {type: blob.type});
		formdata.append('msg_audio_file', msg_audio_file);
	}
	
	$.ajax({
		type: "POST",
		url: "<?= base_url('chat/chat_submit');?>",
		data: formdata,
		dataType: "json",
		cache : false,
		processData: false,
		contentType: false,
		success: function(data){
			if(data.success == true){
				reset_send();
				socket.emit('send_message', data.msg[0]);
				// draw_msg(data.msg[0]);
				$("#msgs-div").animate({ scrollTop: $('#msgs-div').prop("scrollHeight")}, 1000);
			} else if(data.success == false){
				alert("Error! please contact with admin");
			}
		},
		error: function(xhr, status, error) {
			console.log(xhr, status, error);
			alert(error);
		}
	});
}

function notification_msg(id, str){
	console.log(114, {conversation_id: id, message: str, sender_id: user_id});
	$.ajax({
		type: "POST",
		url: "chat/notification_msg",
		data: {conversation_id: id, message: str, sender_id: user_id},
		dataType: "json",
		success: function(data){
			if(data.success == true){
				reset_send();
				socket.emit('send_message', data.msg[0]);
				$("#msgs-div").animate({ scrollTop: $('#msgs-div').prop("scrollHeight")}, 1000);
			} else if(data.success == false){
				alert("Error! please contact with admin");
			}
		},
		error: function(xhr, status, error) {
			console.log(xhr, status, error);
			alert(error);
		}
	});
}

function draw_new_conversation(params)
{
	console.log(132, params);
	let title = params.conv_type == 'single' ? params.username : params.title;
	let img = params.conv_type == 'single' ? params.fimg : params.img;
	let fid = params.conv_type == 'single' ? params.participants_ids.replace(params.created_by, '').replace(',', '') : params.participants_ids;
	let html = '<a href="javascript:void(0);" onclick="start_conv('+ params.conversation_id +')" class="convlist offline media '+ params.active +'" id="convid_'+ params.conversation_id +'" data-conversation_type="'+ params.conv_type +'" data-created_by="'+ params.created_by +'" data-fid="'+ fid +'" data-title="'+ title +'" data-img="'+ img +'">';
				html += '<div class="media-img-wrap">';
					html+= '<div class="avatar online_offline avatar-online">';
						html += '<img src="'+ img +'" onerror="this.src=\'uploads/default.jpg\'" alt="'+ title +' Image" class="avatar-img rounded-circle">';
					html += '</div>';
				html += '</div>';
				html += '<div class="media-body">';
					html += '<div>';
						html += '<div class="user-name">'+ title +'</div>';
						html += '<div class="user-last-chat">'+ (params.msg_body).split("@FILE@")[0] +'</div>';
					html += '</div>';
					html += '<div>';
						html += '<div class="last-chat-time block">Now</div>';
							html += '<div class="badge unread_count badge-success badge-pill">1</div>';
						html += '</div>';
					html += '</div>';
		html += '</a>';
	$("#left_side_list").prepend(html);
}

function draw_msg(data)
{
	let sender_id = $("#sender_id").val();
	let sent_receive = data.sender_id == sender_id ? 'sent' : 'received';
	let body = (data.msg_body).split('@FILE@');
	
	// YouTube embed view
	if(body[0].indexOf("https://www.youtube.com/") === 0){
		let new_url = body[0].replace("watch?v=", "embed/");
		body[0] = '<iframe width="560" height="315" src="'+ new_url +'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	}
	
	let html = '<li class="media '+ sent_receive +'">';
		if(data.sender_id != sender_id) {
		html += 	'<div class="avatar">'+
						'<img src="'+ data.sender_img +'" onerror="this.src=\'uploads/default.jpg\'" alt="'+ data.sender_name +' Image" class="avatar-img rounded-circle">'+
					'</div>';
		}
		html +=		'<div class="media-body">'+
						'<div class="msg-box">'+
							'<div>'+
								'<p>'+ body[0] +'</p>';
								if(body[1] !== undefined) { 
									html += draw_msg_attch(data, body[1]);
								}
		html += 				'<ul class="chat-msg-info">'+
									'<li>'+
										'<div class="chat-time">'+
											'<span>'+ data.created_at +'</span>'+
										'</div>'+
									'</li>'+
								'</ul>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</li>';
	$("#msgs-div-ul").append(html);
	setTimeout(function(){$("#convid_"+ data.conversation_id +" .unread_count").text("");}, 1000);
}
function draw_msg_attch(msg, str){
	var attch = JSON.parse(str);
	var html = '<div class="chat-msg-attachments">';
	if(msg.msg_type == 'voice'){
		html += '<audio controls><source src="'+ attch[0] +'" type="audio/wav">Your browser does not support the audio tag.</audio>';
	}
	else{
		$.each(attch, function(ak, af) {
			var an = af.substring(25);	
			html += '<div class="chat-attachment">'+
						'<img src="'+ af +'" onerror="this.src=\'new_assets/img/other.png\'" alt="Attachment">'+
						'<div class="chat-attach-caption">'+ an +'</div>'+
						'<a href="'+ af +'" target="_blank" class="chat-attach-download">'+
							'<i class="fas fa-eye"></i>'+
						'</a>'+
					'</div>';
		});
	}
	html += '</div>';
	return html;
}
function start_conv(id)
{
	$("#msgs-div-ul").html("");
	$(".convlist").removeClass("active");
	$("#convid_"+id).addClass("active");
	$(".chat-cont-right .online_offline").removeClass (function (index, className) {
		return (className.match (/(^|\s)avatar-\S+/g) || []).join(' ');
	});
	let convtype = $("#convid_"+id).attr("data-conversation_type");
	if($("#convid_"+id).attr("data-conversation_type") == "single"){
		let online_offline = $("#convid_"+id).hasClass("online") ? "avatar-online" : "avatar-away";
		$(".chat-cont-right .online_offline").addClass(online_offline).addClass('avatar-'+$("#convid_"+id).attr("data-fid") );
	}
	else
		$(".chat-cont-right .online_offline").addClass("avatar-online");
	$("#activeconvimg").attr("src", $("#convid_"+id).attr("data-img"));
	$("#activeconvname").text($("#convid_"+id).attr("data-title"));
	$("#receiver").val($("#convid_"+id).attr("data-fid"));
	$("#conversation_id").val(id);
	$(".chat-header .media").attr("onclick", "show_room_details("+id+")");
	$("#call_btn").attr("data-ref", "meeting/liveChatApp?type="+ convtype +"&m=2&roomId="+ id);
	$.ajax({
		type: "POST",
		url: "<?= base_url('chat/openajax');?>",
		data: {id},
		dataType: "json",
		cache : false,
		success: function(data){
			$("#message").val('').focus();
			if(data.success == true){
				$.each(data.messages, function(k, v){
					draw_msg(v);
				});
				$("#msgs-div").animate({ scrollTop: $('#msgs-div').prop("scrollHeight")}, 1000);
			} else if(data.success == false){
				alert("Error! please contact with admin");
			}
		},
		error: function(xhr, status, error) {
			alert(error);
		}
	});
}

socket.on('online_notification', function(data){
	$(".online_offline.single").removeClass("avatar-online").addClass("avatar-away");
	$(".convlist").removeClass("online").addClass("offline");
	$.each(data.online_user_list, function(k, v){
		$(".avatar-"+v.uid).removeClass("avatar-away").addClass("avatar-online");
		$(".avatar-"+v.uid).closest(".convlist").removeClass("offline").addClass("online");
	});
});

socket.on( 'new_message', function( data ) {
	console.log(171, "message received from socket server", data);
	// received a msg, so play a sound
	if(data.sender_id != user_id)
		$('#notif_audio')[0].play();
	
	// total msg notification
	if($(".unread-msg").is(":visible")){
		let old_total = Number($(".unread-msg").text());
		if(typeof old_total === 'number');{
			$(".unread-msg").html("");
			$(".unread-msg").html(Number(old_total)+Number(1));
		}
	}
	
	// per conversation msg notification
	// when conversation is not opened
	if($("#convid_"+ data.conversation_id).is(":visible")){
		let per_msg_total = Number($("#convid_"+ data.conversation_id +" .unread_count").text()) + 1;
		$("#convid_"+ data.conversation_id +" .unread_count").text(! isNaN(per_msg_total) ? per_msg_total : "");
		let body = (data.msg_body).split('@FILE@');
		$("#convid_"+ data.conversation_id + " .user-last-chat").text(body[0]);
		$("#convid_"+ data.conversation_id + " .last-chat-time").text('Just now');
		let clone_li = $("#convid_"+ data.conversation_id);
		$("#convid_"+ data.conversation_id).remove();
		$("#left_side_list").prepend(clone_li);
	}
	else if(! $("#convid_"+ data.conversation_id).is(":visible") && (data.read_status.indexOf(user_id) > -1 || data.sender_id == user_id)){
		draw_new_conversation(data);
		// if(data.sender_id == user_id)
			// $("#convid_"+ data.conversation_id).trigger("click");
	}
	
	// when conversation is opened
	if(data.conversation_id == $("#conversation_id").val()){
		draw_msg(data);
		$("#msgs-div").animate({ scrollTop: $('#msgs-div').prop("scrollHeight")}, 1000);
	}
	
});

var select_user = [user_id];
function open_room_popup(){
	select_user = [user_id];
	$(".per_li").removeClass("active");
}
function select(eleid, id){
	if(select_user.indexOf(id) == -1){
		select_user.push(id)
		$(eleid + " .liid_"+id).addClass("active");
	}
	else{
		select_user.splice(select_user.indexOf(id), 1);
		$(eleid + " .liid_"+id).removeClass("active");
	}
}

function create_room(){
	var room_name = $("#room_name").val();
	if(select_user.length >= 2){
		if(room_name == "" && select_user.length > 2){
			alert("Please give a room name");
		}
		else{
			$.ajax({
				type: "POST",
				url: "<?= base_url('chat/create_room');?>",
				data: {select_user, room_name},
				dataType: "json",
				cache : false,
				success: function(data){
					if(data.success == true){
						if(select_user.length == 2){
							if($("#convid_"+ data.conversation.id).is(":visible"))
								start_conv(data.conversation.id);
							else{
								notification_msg(data.conversation.id, "Welcome to this group");
							}
						}
						else if(select_user.length > 2){
							notification_msg(data.conversation.id, "Welcome to this group");
						}
						$("#new_user_list_popup").modal("hide");
					} else if(data.success == false){
						alert(data.msg);
					}
				},
				error: function(xhr, status, error) {
					alert(error);
				}
			});
		}
	}else{
		alert("Please select atlist one user for start conversation");
	}
}

function show_room_details(id){
	let ele = $("#room_details_popup");
	$(ele).find(".reset").html('');
	$(ele).find(".conv_title").val('');
	$(ele).find(".old_room_name").val('');
	$(ele).find(".conv_img").attr('src', '');
	$(ele).find(".title_edit").hide();
	$(ele).find(".btn").hide();
	$(ele).modal("show");
	let type = $("#convid_"+id).attr("data-conversation_type");
	$.ajax({
		url: "chat/getOneConversation",
		data: {id, user_id, type},
		dataType: "JSON",
		success: function(rep){
			console.log(rep.conversation);
			if(rep.conversation.conv_type == 'single'){
				$(ele).find(".conv_img").attr("src", rep.conversation.fimg);
				$(ele).find(".conv_title").val(rep.conversation.username);
				$(ele).find(".old_room_name").val(rep.conversation.username);
			}else{
				$(ele).find(".conv_img").attr("src", rep.conversation.img);
				$(ele).find(".conv_title").val(rep.conversation.title);
				$(ele).find(".old_room_name").val(rep.conversation.title);
				$(ele).find(".title_edit").show();
				$(ele).find(".btn-info").show();
				$(ele).find(".btn-primary").attr("onclick", "update_group("+ id +")");
				if(rep.conversation.created_by == user_id)
					$(ele).find(".btn-danger").show();
				else
					$(ele).find(".btn-warning").show();
			}
			$(ele).find(".conv_member").text(rep.participants.length);
			$(ele).find(".conv_type").text(rep.conversation.conv_type + ' conversation');
			
			rep.participants.forEach(function(v, k){
				let html = '<a class="per_li liid_'+ v.id +'" href="javascript:void(0);">';
					html += 	'<div style="float: left; border-bottom:1px solid #DDD; padding: 5px;width:100%;">';
					html += 		'<div class="avatar online_offline avatar-'+ v.id +' avatar-away" style="float: left;margin-right: 20px;">';
					html +=				'<img src="'+ v.img +'" onerror="this.src=\'uploads/default.jpg\'" alt="'+ v.username +' Image" class="avatar-img rounded-circle">';
					html +=			'</div>';
					html +=			'<p class="docname">'+ v.username +'<i class="fas fa-check-circle"></i></p>';
					html += 	'</div>';
					html +=	'</a>';
				$(ele).find(".member-lists .chat-scroll").append(html);
			});
		},
		error: function(e){
			alert(e);
		}
	});
}

function title_edit(){
	$("#room_details_popup .conv_title").attr("disabled", false).focus();
	$("#room_details_popup .btn-primary").show();
}
function update_group(id=0){
	let title = $("#room_details_popup .conv_title").val();
	let old_room_name = $("#room_details_popup .old_room_name").val();
	if(id==0) alert("Your browser are not ready, please reload again");
	else if(title != ""){
		let data = { id, title, old_room_name, select_user }
		$.ajax({
			url: "chat/update_room",
			data: data,
			dataType: "JSON",
			type: "POST",
			success: function(rep){
				console.log(rep);
				if(rep.success){
					socket.emit("update_conversation", rep.conversation);
					$("#room_details_popup .conv_title").attr("disabled", true);
					$("#room_details_popup .btn-primary").hide();
					
					$("#room_details_popup .member-lists").show();
					$("#room_details_popup #more_doctor_list").hide();
					$("#room_details_popup .btn-info").text("Add Member");
					select_user = [user_id];
				}
				$("#room_details_popup .msgbox").text(rep.msg).fadeIn('slow', function () {
					$(this).delay(5000).fadeOut('slow');
				});
			},
			error: function(e){
				alert(e);
			}
		});
	}
	else{
		alert("Group name is required");
	}
}

function leave_delete_group(type){
	let data = {
		id: $("#conversation_id").val(),
		receiver: $("#receiver").val(),
		type: type
	}
	$.ajax({
		url: "chat/leave_delete_group",
		data: data,
		dataType: "JSON",
		type: "POST",
		success: function(rep){
			console.log(rep);
			if(rep.success){
				if(rep.conversation == null) rep.conversation = {id: data.id, participants_ids: data.receiver, type: data.type};
				socket.emit("update_conversation", rep.conversation);
				if(data.type == 'leave'){
					$("#convid_"+data.id).remove();
					$("#left_side_list .convlist:first").trigger('click');
				}
				$("#room_details_popup").modal('toggle');
			}
		},
		error: function(e){
			alert(e);
		}
	});
}

function add_more_member(){
	if($("#more_doctor_list").is(":visible")){
		$("#room_details_popup .member-lists").show();
		$("#room_details_popup #more_doctor_list").hide();
		$("#room_details_popup .btn-primary").hide();
		$("#room_details_popup .btn-info").text("Add Member");
		select_user = [user_id];
	}
	else{
		$("#room_details_popup .member-lists").hide();
		$("#room_details_popup #more_doctor_list").show();
		$("#room_details_popup .btn-primary").show();
		$("#room_details_popup .btn-info").text("Hide List");
		let members = $("#receiver").val().split(",");
		select_user = members;
		$.get("chat/get_users", function(data, status){
			data = JSON.parse(data);
			$("#more_doctor_list .chat-scroll").html("");
			if(status == 'success'){
				(data.doctors).forEach(function(v, k){
					if(members.indexOf(v.ion_user_id) > -1) return;
					let html = '<a class="per_li liid_'+ v.ion_user_id +'" href="javascript:void(0);" onclick="select(\'#more_doctor_list\', '+ v.ion_user_id +')">';
						html += 	'<div style="float: left; border-bottom:1px solid #DDD; padding: 5px;width:100%;">';
						html += 		'<div class="avatar online_offline avatar-'+ v.ion_user_id +' avatar-away" style="float: left;margin-right: 20px;">';
						html +=				'<img src="'+ v.img_url +'" onerror="this.src=\'uploads/default.jpg\'" alt="'+ v.name +' Image" class="avatar-img rounded-circle">';
						html +=			'</div>';
						html +=			'<p class="docname">'+ v.name +'<i class="fas fa-check-circle"></i></p>';
						html += 	'</div>';
						html +=	'</a>';
					$("#more_doctor_list .chat-scroll").append(html);
				});
			}
		});
	}
}

function search_li(str, id){
	str = str.toLowerCase();
	
	$.each($(id + " a"), function(k, v){
		if($(v).text().toLowerCase().indexOf(str) > -1)
			$(v).show();
		else
			$(v).hide();
	});
}

function toggole_more_chat_option(){
	$(".options-div").slideToggle('slow');
}

function display_preview(){
	if($("#msg_files")[0].files.length > 4){
		$("#send_msg_form")[0].reset();
		alert("You can select maximum 4 files at a time");
	}
	else if($("#msg_files")[0].files.length > 0){
		$.each($("#msg_files")[0].files, function(k, file){
			var ext = file.name.split('.').pop().toLowerCase();
			var imgtype = ["jpeg", "jpg", "png", "gif"];
			var videotype = ["avi", "3gp", "mp4", "mov", "mkv", "m4v", "flv"];
			var img = document.createElement('img');
			img.style.height = "80px";
			img.style.display = "inline-block";
			img.style.margin = "10px";
			if(imgtype.indexOf(ext) > -1)
				img.src = window.URL.createObjectURL(file);
			else if(ext == "pdf")
				img.src = "new_assets/img/pdf.png";
			else if(ext == "doc" || ext == 'docx')
				img.src = "new_assets/img/doc.png";
			else if(ext == "zip" || ext == "rar")
				img.src = "new_assets/img/zip.png";
			else if(videotype.indexOf(ext) > -1)
				img.src = "new_assets/img/video.png";
			else
				img.src = "new_assets/img/other.png";
			$(".file-preview").append(img);
		});	
		$(".file-preview").show('slow');
		$("#message").val('Attachment').focus();
		$("#msg_type").val('attachment');
	}
}
function reset_send(){
	$("#send_msg_form")[0].reset();
	$('.file-preview img').remove(); 
	$('.file-preview').hide();
	$('.giphy-file-preview figure').remove(); 
	$('.giphy').hide();
	$('#recordProgress').hide();
	$('#recordProgressBar').attr("data-widht", 0).css("width", 0).text("");
	$('.options-div').hide();
	$("#message").focus();
}

function active_tab1(){
	setTimeout(function(){
		$('#group_smile').addClass('active').show();
	}, 500);
}
var offset = 0;
var giphy_str = "ryan+gosling";

function search_giphy(){
	giphy_str = $(".giphy #search").val();
	$(".giphy-file-preview").html("");
	show_giphy(giphy_str, offset);
}

function show_giphy(s=giphy_str, page=0){
	var giphy_xhr = $.get("https://api.giphy.com/v1/gifs/search?q="+ s +"&api_key=<?= $giphy->key1; ?>&limit=5&offset="+page);
	giphy_xhr.done(function(data) { 
		data.data.forEach(function(v, k){
			let fig = document.createElement("figure");
			let img = document.createElement("img");
			let fc = document.createElement("figcaption");
			img.src = v.images.downsized.url;
			img.alt = v.title;
			img.style.maxWidth = "250px";
			fc.textContent = v.title;
			fig.appendChild(img);
			fig.appendChild(fc);
			fig.setAttribute("onclick", "send_giphy('"+ v.images.downsized.url +"', '"+ v.title +"')");
			$(".giphy-file-preview").append(fig);
			$("#search").val("");
			$(".giphy").show();
		});
	});
}

function send_giphy(url, title){
	$("#message").val(title +"<br><img src='"+ url +"' class='giphy-img'>");
	$("#msg_type").val('giphy');
	offset = 0;
	giphy_str = "ryan+gosling";
	send_msg();
}

$('.giphy').scroll((event) => {
	event.stopImmediatePropagation();
	// when scroll reaches to bottom.
	if($(".giphy").scrollTop() + $(".giphy").innerHeight() >= $(".giphy")[0].scrollHeight) {
		$(".giphy").css("overflow-y", "hidden");
		offset++;
		show_giphy(giphy_str, offset);
		setTimeout(function(){
			$(".giphy").css("overflow-y", "auto");
		}, 3000);
	}
});

</script>