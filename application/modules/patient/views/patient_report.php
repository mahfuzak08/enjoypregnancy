<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="invoice-content" id="print_invoice_content">
		<div class="row invoice-list">
			<div class="col-md-12 text-center corporate-id">
				<h3><?php echo $settings->title ?></h3>
				<h4><?php echo $settings->address ?></h4>
				<h4>Tel: <?php echo $settings->phone ?></h4>
				<img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="65">
				<h4 style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
					<?php echo 'Diagnostic Form'; ?>
					<hr style="width: 200px; border-bottom: 1px solid #000; margin-top: 5px; margin-bottom: 5px;">
				</h4>
			</div>
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table table-center mb-0">
						<tr>
							<th style="border-top: 1px solid #dee2e6;"><?php echo lang('patient').' '.lang('name'); ?></th>
							<td><?= $patient_data->name; ?></td>
						</tr>
						<tr>
							<th><?php echo lang('patient_id'); ?></th>									
							<td><?= $patient_data->id; ?></td>									
						</tr>
						<tr>
							<th><?php echo lang('address'); ?></th>
							<td><?= $patient_data->address; ?></td>
						</tr>
						<tr>
							<th><?php echo lang('phone'); ?></th>
							<td><?= $patient_data->phone; ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table table-center mb-0">
						<tr>
							<th style="border-top: 1px solid #dee2e6;"><?php echo lang('Diagnostic').' '.lang('id'); ?></th>
							<td><?= @$lab->id;; ?></td>
						</tr>
						<tr>
							<th><?php echo lang('date'); ?></th>									
							<td><?= date('d-m-Y', @$lab->date); ?></td>									
						</tr>
						<tr>
							<th><?php echo lang('doctor'); ?></th>
							<td><?php
									if (!empty($lab->doctor)) {
										$doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
										if (!empty($doctor_details)) {
											echo $doctor_details->name. '<br>';
										}
									}
									?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12 panel-body">
			<br><br><br>
			<?php
			if (!empty($lab->report)) {
				echo $lab->report;
			}
			?>
		</div>		
	</div>
	<div class="row">
		<div class="col-xl-3">
			<a href="#" onclick="history.back(); return false;" class="btn btn-flat btn-block btn-primary">Back</a>
		</div>
		<div class="col-xl-1"><br></div>
		<div class="col-xl-3">
			<a href="javascript:false;" class="btn btn-flat btn-block btn-success download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?></a>
		</div>
		<div class="col-xl-1"><br></div>
		<div class="col-xl-3">
			<a href="javascript:window.print();" class="btn btn-flat btn-block btn-info"><i class="fas fa-print"></i> Print</a>
		</div>
	</div>
</div>
<!-- / main page content in right side -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>