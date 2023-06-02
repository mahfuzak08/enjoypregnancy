<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Bank Transection
				<!--
                <div class="col-md-4 clearfix no-print pull-right">
                    <a href="finance/addPaymentView"> 
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_payment'); ?>
                            </button>
                        </div>
                    </a> 
                </div>
				-->
            </header>

            <div class="panel-body">
                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Account No</th>
                                <th>Account Name</th>
                                <th>Bamk Name</th>
                                <th>Branch Name</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
							foreach($result as $row){?>
								<tr>
									<td><?= date('d-m-y', strtotime($row->createdat)); ?></td>
									<td><?= $row->doctor_name; ?></td>
									<td><?= $row->account_no; ?></td>
									<td><?= $row->account_name; ?></td>
									<td><?= $row->bank_name; ?></td>
									<td><?= $row->branch_name; ?></td>
									<td><?= number_format(-$row->amount, 2, '.', ','); ?></td>
									<td><?= $row->note; ?></td>
									<td><?= $row->status == 1 ? '<span class="bg-success" style="border-radius:25px; padding:0 5px;">Completed<span>' : '<span class="bg-danger" style="border-radius:25px; padding:0 5px;">Pending</span>'; ?></td>
									<td>
										<a class="btn btn-info btn-xs invoicebutton" style="color: #fff;" href="finance/invoice?id=<?= $row->id; ?>"><i class="fa fa-file-invoice"></i>Invoice</a>
										<?php if($row->status==0){ ?>
										<a class="btn btn-info btn-xs editbutton" style="color: #fff;" href="payment/add_update_bank_trans?tid=<?= $row->id; ?>&bid=<?= $row->bid; ?>&amt=<?= $row->amount; ?>" onclick="return confirm(\'Are you sure you want to process this request?\');"><i class="fa fa-file-invoice"></i>Process</a>
										<?php } ?>
									</td>
								</tr>
							<?php 
							}
							?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->



<script src="common/js/codearistos.min.js"></script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });</script>



<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            dom: "<'row'<'col-md-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                    }
                },
            ],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: 100
        });
        table.buttons().container().appendTo('.custom_buttons');     
    });
</script>
