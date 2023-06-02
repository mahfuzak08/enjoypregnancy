<?php
// for last recorde
$lbmi = 0;
$lhr = 0;
$lrr = 0;
$ltm = 0;
$lbp = 0;
$lvc = 0;
$lfbc = 0;
$lwt = 0;
foreach($patientMedicalHistory as $gr){
	$lbmi = $gr->bmi != null && $lbmi == 0 ? $gr->bmi : $lbmi;
	$lhr = $gr->heart_rate != null && $lhr == 0 ? $gr->heart_rate : $lhr;
	$lrr = $gr->res_rate != null && $lrr == 0 ? $gr->res_rate : $lrr;
	$ltm = $gr->temperature != null && $ltm == 0 ? $gr->temperature : $ltm;
	$lbp = $gr->blood_pressure != null && $lbp == 0 ? $gr->blood_pressure : $lbp;
	$lvc = $gr->vaccine != null && $lvc == 0 ? $gr->vaccine : $lvc;
	$lfbc = $gr->fbc != null && $lfbc == 0 ? $gr->fbc : $lfbc;
	$lwt = $gr->weight != null && $lwt == 0 ? $gr->weight : $lwt;
}
?>

<div class="doctor-slider slider">
	<div class="profile-widget" style="margin-bottom: 0px;">
		<div class="doc-img">
			<a href="javascript:void(0);">
				<img class="img-fluid" alt="User Image" src="new_assets/img/specialities/pt-dashboard-01.png">
			</a>
		</div>
		<div class="pro-content text-center">
			<h3 class="title">Heart Rate</h3>
			<h6><?= $lhr; ?> <sub>bpm</sub></h6>
		</div>
	</div>
	<div class="profile-widget" style="margin-bottom: 0px;">
		<div class="doc-img">
			<a href="javascript:void(0);">
				<img class="img-fluid" alt="User Image" src="new_assets/img/specialities/specialities-01.png">
			</a>
		</div>
		<div class="pro-content text-center">
			<h3 class="title">Respiratory Rate</h3>
			<h6><?= $lrr; ?> <sub>bpm</sub></h6>
		</div>
	</div>
	<div class="profile-widget" style="margin-bottom: 0px;">
		<div class="doc-img">
			<a href="javascript:void(0);">
				<img class="img-fluid" alt="User Image" src="new_assets/img/specialities/pt-dashboard-02.png">
			</a>
		</div>
		<div class="pro-content text-center">
			<h3 class="title">Body Temperature</h3>
			<h6><?= $ltm; ?> <sub>C</sub></h6>
		</div>
	</div>
	<div class="profile-widget" style="margin-bottom: 0px;">
		<div class="doc-img">
			<a href="javascript:void(0);">
				<img class="img-fluid" alt="User Image" src="new_assets/img/specialities/pt-dashboard-03.png">
			</a>
		</div>
		<div class="pro-content text-center">
			<h3 class="title">Glucose Level</h3>
			<h6><?= $lfbc; ?></h6>
		</div>
	</div>
	<div class="profile-widget" style="margin-bottom: 0px;">
		<div class="doc-img">
			<a href="javascript:void(0);">
				<img class="img-fluid" alt="User Image" src="new_assets/img/specialities/pt-dashboard-04.png">
			</a>
		</div>
		<div class="pro-content text-center">
			<h3 class="title">Blood Pressure</h3>
			<h6><?= $lbp; ?> <sub>mg/dl</sub></h6>
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
				<div class="doctor-slider slider">
					<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box pink-graph" data-toggle="modal" data-target="#graph2">
							<div>
								<h4>Heart Rate</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-01.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 2d</span>
							</div>
						</a>
					</div>
					<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box sky-blue-graph" data-toggle="modal" data-target="#graph5">
							<div>
								<h4>Respiratory Rate</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-02.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 2d</span>
							</div>
						</a>
					</div>
					<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box" data-toggle="modal" data-target="#graph6">
							<div>
								<h4>Temperature</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-03.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 2d</span>
							</div>
						</a>
					</div>
					<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box orange-graph" data-toggle="modal" data-target="#graph3">
							<div>
								<h4>Glucose Level</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-04.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 5d</span>
							</div>
						</a>
					</div>
					<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box pink-graph" data-toggle="modal" data-target="#graph7">
							<div>
								<h4>Blood Pressure</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-01.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 5d</span>
							</div>
						</a>
					</div>
					<!--<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box sky-blue-graph" data-toggle="modal" data-target="#graph8">
							<div>
								<h4>Vaccination</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-02.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 5d</span>
							</div>
						</a>
					</div>-->
					<div class="profile-widget" style="margin-bottom: 0px;">
						<a href="#" class="graph-box" data-toggle="modal" data-target="#graph1">
							<div>
								<h4>BMI Status</h4>
							</div>
							<div class="graph-img">
								<img src="new_assets/img/shapes/graph-03.png" alt="">
							</div>
							<div class="graph-status-result mt-3">
								<span class="graph-update-date">Last Update 6d</span>
							</div>
						</a>
					</div>
					<div class="profile-widget" style="margin-bottom: 0px;">
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