<!-- main page content in right side -->
<style>
a.lock-btn:hover {
    background-color: #28a745 !important;
    color: #fff !important;
}
</style>
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body pt-0">
			<div class="text-right">		
				<a href="#" class="add-new-btn" data-toggle="modal" data-target="#add_medical_records_modal">Add Medical Records</a>
			</div>
			<div class="card card-table mb-0">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-center mb-0">
							<thead>
								<tr>
									<th>ID</th>
									<th>Date</th>
									<th>Title</th>
									<th>Patient Name</th>
									<!--<th>Symptoms</th>-->
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($patient_materials as $row) { ?>
								<tr>
									<td><?= $row->id; ?></td>
									<td><?= date("d-m-Y", $row->date); ?></td>
									<td><a href="<?= $row->url; ?>" target="_blank"><?= $row->title != '' ? $row->title : 'No Title'; ?></a><br><?= $row->symptoms; ?></td>
									<td><?= $row->patient_name; ?></td>
									<!--<td><?= $row->symptoms; ?></td>-->
									<td>
										<?php
										$ext = pathinfo($row->url, PATHINFO_EXTENSION);
										$extensionImg = array("jpeg", "jpg", "png", "gif", "pdf" );
										$extensionVideo = array(  "mp4", "wav", "ogg", "avi","webm");
										?>
										<?php if(in_array($ext,$extensionImg)){ ?>
										<!--<a href="<?php echo $row->url; ?>" download target="_blank"><img style="height:60px; width:100px;" src="<?php echo $row->url; ?>" alt="image-1" /></a>-->
										<a href="<?php echo $row->url; ?>" target="_blank"><img style="height:60px; width:100px;" src="<?php echo $row->url; ?>" alt="image-1" /></a>
										<?php } ?>
										<?php if(in_array($ext,$extensionVideo)){ ?>
											<a class="example-image-link" href="<?=base_url($row->url)?>" target="_blank">
												<video width="100px" height="60px">
													<source src="<?=base_url($row->url) ?>" type="video/webm">
													<source src="<?=base_url($row->url) ?>" type="video/mp4">
													Sorry, your browser doesn't support embedded videos.
												</video>
											</a>
										<?php } ?>									
									</td>
									<td>
										<a href="<?php echo $row->url; ?>" target="_blank" class="btn btn-sm bg-info-light">
											<i class="fas fa-eye"></i> View
										</a>
										<a href="patient/medical_records?type=<?= $row->privacy == 'Public' ? 'Private' : 'Public'; ?>&privacy=<?= $row->id; ?>" class="btn btn-sm bg-<?= $row->privacy == 'Public' ? 'primary' : 'success'; ?>-light lock-btn">
											<i class="fa fa-<?= $row->privacy == 'Public' ? 'unlock' : 'lock'; ?>"></i> <?= $row->privacy; ?>
										</a>
										<a href="patient/medical_records?delete=<?= $row->id; ?>" class="btn btn-sm bg-danger-light">
											<i class="fas fa-trash-alt"></i> Delete
										</a>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- / main page content in right side -->