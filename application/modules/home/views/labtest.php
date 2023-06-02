<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo 'Lab Tests'; ?>
                <div class="col-md-4 no-print pull-right"> 
                    <a href="home/addnewlabTest">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo 'Add New Lab Test'; ?>
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
                                <th><?php echo lang('name'); ?></th>
                                <th><?php echo 'Sample Required'; ?></th>
                                <th><?php echo lang('price'); ?></th>
                                <th><?php echo 'Created Date & Time'; ?></th>
                                <th class="no-print"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($labtest as $value) { ?>
                            <tr class="">
                                <td><?php echo $value->name; ?></td>
                                <td><?php echo $value->sample_required; ?></td>
                                <td class="center"><?php echo $value->price; ?></td>
                                <td><?php echo date('d-m-Y H:i',strtotime($value->dateandtime)); ?></td>
                                <td class="no-print">
                                    <a class="btn btn-info btn-xs btn_width" href="home/editlabtest/<?php echo $value->id; ?>" title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                                    <a class="btn btn-info btn-xs btn_width delete_button" onclick="return confirm('Are you sure you want to delete this item?')" href="home/deletelabtest/<?php echo $value->id; ?>" title="Edit"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php } ?>

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






<!-- Add Pharmacist Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo 'Add New Saleman'; ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="laboratorist/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('image'); ?></label>
                        <input type="file" name="img_url">
                    </div>
                    <input type="hidden" name="is_saleman" value="1">
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right row"><?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Accountant Modal-->

<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo 'Edit Saleman'; ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editPharmacistForm" class="clearfix" action="laboratorist/addNew" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('password'); ?></label>
                        <input type="password" class="form-control" name="password" id="exampleInputEmail1" placeholder="********">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="" required="required">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('image'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="is_saleman" value="1">


                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right row"><?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
                                    $(document).ready(function () {
                                        $(".editbutton").click(function (e) {
                                            e.preventDefault(e);
                                            // Get the record's ID via attribute  
                                            var iid = $(this).attr('data-id');
                                            $('#editPharmacistForm').trigger("reset");
                                            $('#myModal2').modal('show');
                                            $.ajax({
                                                url: 'home/editPharmacistByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                            }).success(function (response) {
                                                // Populate the form fields with the data returned from server
                                                $('#editPharmacistForm').find('[name="id"]').val(response.pharmacist.id).end()
                                                $('#editPharmacistForm').find('[name="name"]').val(response.pharmacist.name).end()
                                                $('#editPharmacistForm').find('[name="password"]').val(response.pharmacist.password).end()
                                                $('#editPharmacistForm').find('[name="email"]').val(response.pharmacist.email).end()
                                                $('#editPharmacistForm').find('[name="address"]').val(response.pharmacist.address).end()
                                                $('#editPharmacistForm').find('[name="phone"]').val(response.pharmacist.phone).end()
                                            });
                                        });
                                    });
</script>
<script>
    $(document).ready(function () {
        var table = $('#editable-sample').DataTable({
            responsive: true,

            dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
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
                        columns: [1, 2, 3, 4],
                    }
                },
            ],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [[0, "desc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },

        });

        table.buttons().container()
                .appendTo('.custom_buttons');

    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

