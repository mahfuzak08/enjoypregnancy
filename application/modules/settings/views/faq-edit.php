<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Frequently Asked Questions
				<div class="col-md-4 clearfix no-print pull-right">
                    <a href="settings/faq"> 
                        <div class="btn-group pull-right">
                            <button id="" class="btn btn-xs">Back</button>
                        </div>
                    </a> 
                </div>
            </header>
            <div class="panel-body">
                <form action="settings/faq_update" method="post" enctype="multipart/form-data">
					<div class="form-group col-md-12"> 
						<label>Title</label> 
						<input type="text" class="form-control" name="title" value="">
					</div>
					<div class="form-group col-md-12"> 
						<label>Details</label> 
						<textarea class="form-control ckeditor" id="editor1" name="details" value="" rows="50" cols="20"></textarea>
					</div>
					<div class="form-group col-md-6"> 
						<label>Attachment</label> 
						<input type="file" class="form-control" name="vlink" accept="video/mp4,video/x-m4v,video/*" value="">
					</div>
					<div class="form-group col-md-6"> 
						<label>Position</label> 
						<input type="text" class="form-control" name="position" value="">
					</div>
					<div class="form-group col-md-12"> 
						<button type="submit" name="faq-submit" class="btn green"> <?php echo lang('submit'); ?></button>
					</div>


		</form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<script src="common/js/codearistos.min.js"></script>