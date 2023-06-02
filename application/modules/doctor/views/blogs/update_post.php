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
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-12 row">
            <header class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        Add Blog
                    </div>
                    <div class="col-md-6 text-right">
                        Status
                        <label class="switch" style="margin-right: 15px">
                            <input type="checkbox" name="status" id="status_slider_chk" value="1" <?php if($edit['status']==1){ echo "checked"; } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </header> 
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <?php echo $this->session->flashdata('feedback'); ?>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="doctor/update_post_data" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Post Name</label>
                                <input type="text" name="post_name" placeholder="Post name" class="form-control" value="<?php echo $edit['page_name'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Author</label>
                                <input type="text" name="author" placeholder="author" class="form-control" value="<?php echo $edit['author'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" placeholder="Title" class="form-control" value="<?php echo $edit['title'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Post Image</label>
                                <input type="file" name="post_image" placeholder="" class="form-control">
                                <input type="hidden" name="old_image" value="<?php echo $edit['og_banner'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Video URL(You can add the Embed code here of any social media video)</label>
                                <textarea name="video_url" placeholder="Add the embed code here..." class="form-control"><?php echo $edit['video_url'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Post Short Description</label>
                                <textarea class="form-control" name="description" placeholder="Description" required><?php echo $edit['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Post Contents</label>
                                <input name="page_content" id="inp_htmlcode" type="hidden" value=""/>
                        		<div id="div_editor1" class="richtexteditor" style="width: 100%;margin:0 auto;"> 
                        		<?php echo $edit['page_content'] ?>
                        		</div>
                        
                        		<script>
                        			var editor1 = new RichTextEditor(document.getElementById("div_editor1"));
                        			editor1.attachEvent("change", function () {
                        				document.getElementById("inp_htmlcode").value = editor1.getHTMLCode();
                        			});
                        			document.getElementById("inp_htmlcode").value = editor1.getHTMLCode();
                        		</script>
                                <!--<textarea class="form-control ckeditor" name="page_content" id="editor1" placeholder="Post contents"><?php //echo $edit['page_content'] ?></textarea>-->
                            </div>
                            <input type="hidden" name="id" value='<?php
                            if (!empty($doctor->id)) {
                                echo $doctor->id;
                            }
                            ?>'>
                            <input type="hidden" name="status" id="status_id" value="<?php echo $edit['status'] ?>">
                            <input type="hidden" name="post_id" value="<?php echo $edit['id'] ?>">
                            <button type="submit" name="submit" class="btn btn-info"><?php if($edit['is_approved']==2 or $edit['is_approved']==0){ echo "Resubmit";}else{echo 'submit';} ?></button>
                            <a href="doctor/blogs"><button type="button" class="btn btn-primary"><?php echo "Go back to list"; ?></button></a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
