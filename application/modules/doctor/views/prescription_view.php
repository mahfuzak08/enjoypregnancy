<?php
$doctor = $this->doctor_model->getDoctorById($prescription->doctor);
$patient = $this->patient_model->getPatientById($prescription->patient);
?>
<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-body" style="background:#FFF;" id="print_invoice_content">
			<table style="width:100%;">
				<tr>
					<td style="width:69%;">
						<h2 class='doctor'><?php
							if (!empty($doctor)) {
								echo $doctor->name;
							} else {
								?>
								<?php echo $settings->title; ?>
								<h5><?php echo $settings->address; ?></h5>
								<h5><?php echo $settings->phone; ?></h5>
							<?php }
							?>
						</h2>
						<h4>
							<?php
							if (!empty($doctor)) {
								echo $doctor->profile;
							}
							?>
						</h4>
					</td>
					<td style="width:30%;"><img src="<?php echo $settings->logo; ?>" onerror="this.src='uploads/logo.png'" width="100%"></td>
				</tr>
			</table>
			<br>
			<hr>
			<table style="width:100%;">
				<tr>
					<td style="width:40%;">
						<?php echo lang('date'); ?> : <?php echo date('d-m-Y', $prescription->date); ?>
					</td>
					<td style="width:60%;">
						<?php echo lang('prescription'); ?> <?php echo lang('id'); ?> : <?php echo $prescription->id; ?>
					</td>
				</tr>
			</table>
            <hr>
			<table style="width:100%;">
				<tr>
					<td style="width:40%;">
						<?php echo lang('patient'); ?>: <?php
                            if (!empty($patient)) {
                                echo $patient->name;
                            }
                            ?>
					</td>
					<td style="width:25%;">
						<?php echo lang('patient_id'); ?>: <?php
                            if (!empty($patient)) {
                                echo $patient->id;
                            }
                            ?>
					</td>
					<td style="width:20%;">
						<?php echo lang('age'); ?>: 
                            <?php
                            if (!empty($patient)) {
                                $birthDate = strtotime($patient->birthdate);
                                $birthDate = date('m/d/Y', $birthDate);
                                $birthDate = explode("/", $birthDate);
                                $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
                                echo $age . ' Year(s)';
                            }
                            ?>
					</td>
					<td style="width:15%;">
						<?php echo lang('gender'); ?>: <?php echo $patient->sex; ?>
					</td>
				</tr>
			</table>
			<hr>
			<br><br><br>
			<table style="width:100%; min-height: 400px;">
				<tr>
					<td style="width:40%; padding: 10px; border-right: 1px solid #999;vertical-align: top;">
						<div class="panel-body">
                            <div class="pull-left">
                                <h5><strong><?php echo lang('history'); ?>: </strong> <br> <br> <?php echo $prescription->symptom; ?></h5>
                            </div>
                        </div>

                        <hr>

                        <div class="panel-body">
                            <div class="pull-left">
                                <h5><strong><?php echo lang('note'); ?>:</strong> <br> <br> <?php echo $prescription->note; ?></h5>
                            </div>
                        </div>




                        <hr>

                        <div class="panel-body">
                            <div class="pull-left">
                                <h5><strong><?php echo lang('advice'); ?>: </strong> <br> <br> <?php echo $prescription->advice; ?></h5>
                            </div>
                        </div>
					</td>
					<td style="width:60%; padding: 20px;vertical-align: top;">
						<div style="padding-left: 10px; ">
							<strong style="border-bottom: 1px solid #000;"> Rx </strong>
						</div>
						<?php
						if (!empty($prescription->medicine)) {
							?>
							<table class="table table-striped table-hover">                      
								<thead>       
								<th><?php echo lang('medicine'); ?></th>
								<th><?php echo lang('instruction'); ?></th>
								<th class="text-right"><?php echo lang('frequency'); ?></th>    
								</thead>
								<tbody>
									<?php
									$medicine = $prescription->medicine;
									$medicine = explode('###', $medicine);
									foreach ($medicine as $key => $value) {
										?>
										<tr>
											<?php $single_medicine = explode('***', $value); ?>

											<td class=""><?php echo $this->medicine_model->getMedicineById($single_medicine[0])->name . ' - ' . $single_medicine[1]; ?> </td>
											<td class=""><?php echo $single_medicine[3] . ' - ' . $single_medicine[4]; ?> </td>
											<td class="text-right"><?php echo $single_medicine[2] ?> </td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
						<?php } ?>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td style="width:60%;">
						<div class="pull-left" style="font-size: 12px;">
							<div class="row"> 
								<div class="col-md-3 text-center" style="padding: 0px;">
									<img src="<?php echo $doctor->img_url; ?>" onerror="this.src='uploads/default.jpg'" class="thumbnail" width="100%" height="150px" style="border-radius: 100%;">
								</div>
								<div class="col-md-9">
									<h3 style="color: #2f80bf; margin-top: 0px;">Dr. <?php echo $doctor->name; ?></h3>
									<p><?php echo $doctor->profile; ?></p>
									<h4><?php $hopital_name = $this->doctor_model->getDoctorHospitalById($doctor->hospital_id); echo $hopital_name['name']; ?></h4>
									<p>	<strong>Phone: </strong><?php echo $doctor->phone; ?><br>
										<strong>Email: </strong><?php echo $doctor->email; ?><br>
										<strong>Address: </strong><?php $address_i = json_decode($doctor->address); echo $address_i[0].' '.$address_i[1]; ?></p>
								</div>
							 </div>
						</div>
					</td>
					<td style="width:40%; vertical-align: top;">
						<div class="pull-right text-right">
							<h3 class='hospital' style="margin-top: 0px;"><?php echo $settings->title; ?></h3>
							<h5><?php echo $settings->address; ?></h5>
							<h5><?php echo $settings->phone; ?></h5>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-12">
			<a class="btn btn-info btn-sm invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
			<a class="btn btn-primary btn-sm detailsbutton download" id="download_prescriptions"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
			<a class="btn btn-info btn-sm" href='doctor/prescriptions'><i class="fa fa-medkit"></i> <?php echo lang('all'); ?> <?php echo lang('prescriptions'); ?> </a>
			<a class="btn btn-primary btn-sm" href="doctor/openPrescriptionForm"><i class="fa fa-plus-circle"></i> <?php echo lang('add_prescription'); ?> </a>
		</div>
		<br><br>
	</div>
</div>
<!-- / main page content in right side -->

<script src="common/js/codearistos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script>


                            $('#download_prescriptions').click(function () {
                                var pdf = new jsPDF('p', 'pt', 'letter');
                                pdf.addHTML($('#print_invoice_content'), function () {
                                    pdf.save('prescription_id_<?php echo $prescription->id; ?>.pdf');
                                });
                            });

                            // This code is collected but useful, click below to jsfiddle link.
</script>