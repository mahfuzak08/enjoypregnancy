<link rel="stylesheet" href="<?php echo base_url();?>assets/richtexteditor/rte_theme_default.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/richtexteditor/rte.js"></script>
<script type="text/javascript" src='<?php echo base_url();?>assets/richtexteditor/plugins/all_plugins.js'></script>
<!--<link href="<?php echo base_url();?>assets/editor.css" type="text/css" rel="stylesheet"/>-->
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 55px;
  height: 28px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
    width: 18px;
    left: 7px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.round-img
{
	border-radius: 100%;
	width: 180px;
	height: 180px;
	margin-bottom: 0px !important;
	display: inline;
}	
.bootstrap-tagsinput
{
	width: 100%;
}
.bootstrap-tagsinput input
{
	width: 130px;
}
</style>
<!--sidebar end-->
<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">Add Blog</h4>
			<?php //print_r($edit); ?>
			<div class="row form-row">
				<div class="col-md-12 text-right">
					Status
					<label class="switch" style="margin-right: 15px">
						<input type="checkbox" name="status" id="status_slider_chk" value="1" <?= (empty($edit) || @$edit['status']==1) ? "checked" : ""; ?>>
						<span class="slider round"></span>
					</label>
				</div>
				<div class="col-md-12">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<?php echo $this->session->flashdata('feedback'); ?>
					</div>
					<div class="col-md-3"></div>
				</div>
				<form role="form" action="doctor/<?= empty($edit) ? 'save_new_post' : 'update_post_data'; ?>" method="post" enctype="multipart/form-data">
					<div class="col-md-12">
						<div class="form-group">
							<label>Post Name</label>
							<input type="text" name="post_name" placeholder="Post name" class="form-control" value="<?= @$edit['page_name']; ?>" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Author</label>
							<input type="text" name="author" placeholder="author" class="form-control" value="<?= empty($edit) ? $doctor_data->name : @$edit['author']; ?>" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Blog Category</label>
							<input type="text" name="blog_category" placeholder="Select Category" list="bcat" value="<?= $edit['bct']; ?>" class="form-control" required>
							<datalist id="bcat">
								<?php foreach($blogs_category as $bc) { ?>
								<option><?= $bc->title; ?>
								<?php } ?>
							</datalist>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Title</label>
							<input type="text" name="title" placeholder="Title" class="form-control" value="<?= @$edit['title']; ?>" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Post Image</label>
							<input type="file" name="post_image" placeholder="" class="form-control" <?= empty($edit) ? 'required' : ''; ?>>
							<?php if(! empty($edit)) {?>
								<input type="hidden" name="old_image" value="<?= @$edit['og_banner'] ?>">
							<?php } ?>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Video URL(You can add the Embed (iframe) code here of any social media video)</label>
							<textarea name="video_url" class="form-control" placeholder="Add the embed code here..."><?= @$edit['video_url']; ?></textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Post Tag List (Like as Children, Family, etc)</label>
							<input type="text" name="tag_lists" placeholder="Type tag name separate by (,) comma." class="form-control" value="<?= @$edit['tag_lists']; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Post Short Description</label>
							<textarea class="form-control" name="description" placeholder="Description" required><?= @$edit['description']; ?></textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Post Contents</label>
							<input name="page_content" id="inp_htmlcode" type="hidden" />
							<div id="div_editor1" class="richtexteditor" style="width: 100%;margin:0 auto;"><?= @$edit['page_content']; ?></div>
							<script>
								var editor1 = new RichTextEditor(document.getElementById("div_editor1"));
								editor1.attachEvent("change", function () {
									document.getElementById("inp_htmlcode").value = editor1.getHTMLCode();
								});
								document.getElementById("inp_htmlcode").value = editor1.getHTMLCode();
							</script>
						</div>
					</div>
					<div class="submit-section submit-btn-bottom">
						<input type="hidden" name="id" value='<?php if (!empty($doctor_data->id)) { echo $doctor_data->id; } ?>'>
						<input type="hidden" name="status" id="status_id" value="<?= @$edit['status']; ?>">
						<input type="hidden" name="post_id" id="post_id" value="<?= @$edit['id']; ?>">
						<button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
						<a href="doctor/blogs" class="btn btn-light">Back</a>
					</div>
				</form>
            </div>
        </div>
        <!-- page end-->
    </div>
</div>
<!-- / main page content in right side -->