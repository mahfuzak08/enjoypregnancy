<div class="row">
	<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-dashboard-top">
		<div class="card">
			<div class="card-body text-center">
				<div class="mb-3">
					<img src="new_assets/img/specialities/pt-dashboard-01.png" alt="" width="55">
				</div>
				<h5>Heart Rate</h5>
				<h6><?= $respiratory_rate; ?> <sub>bpm</sub></h6>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-dashboard-top">
		<div class="card">
			<div class="card-body text-center">
				<div class="mb-3">
					<img src="new_assets/img/specialities/pt-dashboard-02.png" alt="" width="55">
				</div>
				<h5>Body Temperature</h5>
				<h6><?= $temperature; ?> <sub>C</sub></h6>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-dashboard-top">
		<div class="card">
			<div class="card-body text-center">
				<div class="mb-3">
					<img src="new_assets/img/specialities/pt-dashboard-03.png" alt="" width="55">
				</div>
				<h5>Glucose Level</h5>
				<h6><?= $glucose_level; ?></h6>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-dashboard-top">
		<div class="card">
			<div class="card-body text-center">
				<div class="mb-3">
					<img src="new_assets/img/specialities/pt-dashboard-04.png" alt="" width="55">
				</div>
				<h5>Blood Pressure</h5>
				<h6><?= $blood_pressure; ?> <sub>mg/dl</sub></h6>
			</div>
		</div>
	</div>
</div>

<div class="row patient-graph-col">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Graph Status</h4>
			</div>
			<div class="card-body pt-2 pb-2 mt-1 mb-1">
				<div class="row">
					<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-graph-box">
						<a href="#" class="graph-box" data-toggle="modal" data-target="#graph1">
							<div>
								<h4>BMI Status</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-01.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 6d</span>
							</div>
						</a>
					</div>
					<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-graph-box">
							<a href="#" class="graph-box pink-graph" data-toggle="modal" data-target="#graph2">
								<div>
									<h4>Heart Rate Status</h4>
								</div>
								<div class="graph-img">
									<img src="new_assets/img/shapes/graph-02.png" alt="">
								</div>
								<div class="graph-status-result mt-3">
									<span class="graph-update-date">Last Update 2d</span>
								</div>
							</a>
					</div>
					<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-graph-box">
						<a href="#" class="graph-box sky-blue-graph" data-toggle="modal" data-target="#graph3">
							<div>
								<h4>FBC Status</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-03.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 5d</span>
							</div>
						</a>
					</div>
					<div class="col-12 col-md-6 col-lg-4 col-xl-3 patient-graph-box">
						<a href="#" class="graph-box orange-graph" data-toggle="modal" data-target="#graph4">
							<div>
								<h4>Weight Status</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-04.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 3d</span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>