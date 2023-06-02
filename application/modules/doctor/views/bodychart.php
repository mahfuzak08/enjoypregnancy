<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title d-flex justify-content-between">
				<span><?= $page_title; ?></span> 
				<a class="edit-link bcteditbutton" data-id="0" href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add New</a>
			</h4>
			<div class="row row-grid">
				<?php
				foreach ($template as $key => $item) {
					?>
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="profile-widget">
							<div class="doc-img">
								<a href="javascript:void(0);">
									<img class="img-fluid" alt="User Image" src="<?= base_url('common/' . $item->thumbnil) ?>">
								</a>
							</div>
							<div class="pro-content">
								<h3 class="title">
									<a href="javascript:void(0);"><?= $item->title; ?></a>
								</h3>
								<div class="row row-sm">
									<div class="col-6">
										<a href="javascript:void(0);" data-toggle="modal" data-id="<?=$item->id?>" class="btn view-btn bcteditbutton"><i class="fa fa-edit"></i> Edit</a>
									</div>
									<div class="col-6">
										<a href="prescription/Templatedelete?id=<?=$item->id?>" onclick="return confirm(\'Are you sure you want to delete this item?\');" class="btn book-btn btn-outline-danger disabled"><i class="fa fa-trash"></i> Delete</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>			
			</div>
		</div>
	</div>
</div>
<!-- / main page content in right side -->