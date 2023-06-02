<!-- main page content in right side -->
				<div class="card-body">
					<?php echo validation_errors(); ?>
					<form role="form" action="prescription/addNewPrescription" class="clearfix" method="post" enctype="multipart/form-data">
						<div class="row form-row">
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
									<input type="date" class="form-control" name="date" value="<?= date('Y-m-d'); ?>" min="<?= date('Y-m-d'); ?>">
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
									<select class="form-control m-bot15" id="patientchoose" name="patient" value=''>
										<?php foreach($patients as $patient) { ?>
										<option value="<?= $patient->id; ?>"><?= $patient->name; ?> - (<?= lang('id'); ?> : <?= $patient->id; ?>)</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1"> <?php echo lang('doctor'); ?></label>
									<input type="text" class="form-control" id="doctorchoose1" name="doctor" value="<?= $doctor_data->name; ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row form-row">
							<div class="col-12">
								<div class="form-group">
									<label class="control-label"><?php echo lang('history'); ?></label>
									<textarea class="form-control ckeditor" id="editor1" name="symptom" value="" rows="5"></textarea>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label class="control-label"><?php echo lang('note'); ?></label>
									<textarea class="form-control ckeditor" id="editor3" name="note" value="" rows="5"></textarea>
								</div>
							</div>
						</div>
							
							<div class="form-group col-md-12 medicine_block">
								<div class="col-md-3"></div>
								<div class="text-center col-md-9">
									<p>
										<a href="https://bnf.nice.org.uk/" target="_blank"><b>https://bnf.nice.org.uk</b></a> &nbsp;|&nbsp; <a href="https://bnfc.nice.org.uk/" target="_blank"><b>https://bnfc.nice.org.uk</b></a>
									</p>
								</div>
								<div class="col-md-4">
									<label class="control-label"> <?php echo lang('medicine'); ?></label><br>
									<br>
									<button type="button" class="btn btn-info" onclick="addmoremedicines()">Add more medicines <i class="fa fa-plus"></i></button>
								</div>
								<div class="col-md-8">
									<?php if (empty($prescription->medicine)) { ?>
										<select class="form-control m-bot15 medicinee"  id="my_select1_disabled" name="category" value=''>

										</select>
									<?php } else { ?>
										<select name="category"  class="form-control m-bot15 medicinee"  multiple="multiple" id="my_select1_disabled" >
											<?php
											if (!empty($prescription->medicine)) {

												// $category_name = $payment->category_name;
												$prescription_medicine = explode('###', $prescription->medicine);
												foreach ($prescription_medicine as $key => $value) {
													$prescription_medicine_extended = explode('***', $value);
													$medicine = $this->medicine_model->getMedicineById($prescription_medicine_extended[0]);
													?>
													<option value="<?php echo $medicine->id . '*' . $medicine->name; ?>"  <?php echo 'data-dosage="' . $prescription_medicine_extended[1] . '"' . 'data-frequency="' . $prescription_medicine_extended[2] . '"data-days="' . $prescription_medicine_extended[3] . '"data-instruction="' . $prescription_medicine_extended[4] . '"'; ?> selected="selected">
														<?php echo $medicine->name; ?>
													</option>                

													<?php
												}
											}
											?>
										</select>
									<?php } ?>
									
								</div>
							</div>

							<div class="form-group col-md-12 panel-body medicine_block">
								<label class="control-label col-md-2"><?php echo lang('medicine'); ?></label>
								<div class="col-md-10 medicine pull-right">

								</div>

							</div>



							<div class="form-group col-md-12">
								<label class="control-label"><?php echo lang('advice'); ?></label>
								<textarea class="form-control ckeditor" id="editor3" name="advice" value="" rows="30" cols="20"><?php
									if (!empty($setval)) {
										echo set_value('advice');
									}
									if (!empty($prescription->advice)) {
										echo $prescription->advice;
									}
									?>
								</textarea>
							</div>



							<input type="hidden" name="admin" value='admin'>

							<input type="hidden" name="id" value='<?php
							if (!empty($prescription->id)) {
								echo $prescription->id;
							}
							?>'>

							<div class="form-group">
								<button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
							</div>
					</form>					
				</div>
<!-- / main page content in right side -->