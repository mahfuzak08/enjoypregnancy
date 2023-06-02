<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Frequently Asked Questions
				<div class="col-md-4 clearfix no-print pull-right">
                    <a href="settings/faq_update"> 
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> Add New
                            </button>
                        </div>
                    </a> 
                </div>
            </header>

            <div class="panel-body">
                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Attachment</th>
                                <th>Position</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
							foreach($faqs as $row){?>
								<tr>
									<td><?= $row->id; ?></td>
									<td><?= $row->title; ?></td>
									<td><?= $row->details; ?></td>
									<td><a href="<?= $row->vlink; ?>" target="_blank"><?= explode("/", $row->vlink)[2]; ?></a></td>
									<td><?= $row->position; ?></td>
									<td>
										<a class="btn btn-danger btn-xs" style="color: #fff;" href="settings/faq?id=<?= $row->id; ?>" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> Delete</a>
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
