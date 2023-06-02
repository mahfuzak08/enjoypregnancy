<div class="row">
	<div class="col-md-12">
		<div class="card dash-card">
			<div class="card-body">
				<div class="row">
					<div class="col-4">
						<div class="dash-widget dct-border-rht">
							<div class="circle-bar circle-bar1">
								<div class="circle-graph1" data-percent="<?= $total_patient; ?>">
									<img src="<?= base_url("new_assets/img/icon-01.png"); ?>" class="img-fluid" alt="patient">
								</div>
							</div>
							<div class="dash-widget-info">
								<h6>Total Patient</h6>
								<h3><?= $total_patient; ?></h3>
								<p class="text-muted">Till Today</p>
							</div>
						</div>
					</div>
					
					<div class="col-4">
						<div class="dash-widget dct-border-rht">
							<div class="circle-bar circle-bar2">
								<div class="circle-graph2" data-percent="<?= $today_patient; ?>">
									<img src="<?= base_url("new_assets/img/icon-02.png"); ?>" class="img-fluid" alt="Patient">
								</div>
							</div>
							<div class="dash-widget-info">
								<h6>Today Patient</h6>
								<h3><?= $today_patient; ?></h3>
								<p class="text-muted"><?= date("d, M Y"); ?></p>
							</div>
						</div>
					</div>
					
					<div class="col-4">
						<div class="dash-widget">
							<div class="circle-bar circle-bar3">
								<div class="circle-graph3" data-percent="<?= count($appointments); ?>">
									<img src="<?= base_url("new_assets/img/icon-03.png"); ?>" class="img-fluid" alt="Patient">
								</div>
							</div>
							<div class="dash-widget-info">
								<h6>Appoinments</h6>
								<h3><?= count($appointments); ?></h3>
								<p class="text-muted"><?= date("d, M Y"); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>