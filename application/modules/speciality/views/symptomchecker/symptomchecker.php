<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo 'List of Symptoms' ?>
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_new'); ?>
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
                                <th> <?php echo 'No.'; ?></th>
                                <th> <?php echo 'Symptoms'; ?></th>
                                <th> <?php echo 'Type'; ?></th>
                                <th class="no-print"> <?php echo lang('options') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($symptoms as $value) { ?>
                                <tr class="">
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $value->symptoms; ?></td>
                                    <td><?php echo str_replace(',',' & ',$value->type); ?></td>
                                    <td class="no-print">
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $value->id; ?>"><i class="fa fa-edit"></i> </button>   
                                        <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="speciality/deletesymptom?id=<?php echo $value->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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




<!-- Add Department Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo 'Add Symptom'; ?></h4>
            </div> 
            <div class="modal-body">
                <form role="form" action="speciality/addNewSymptom" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Symptom'; ?> <?php echo lang('name') ?></label>
                                <input type="text" class="form-control" name="symptoms" id="exampleInputEmail1" value='' placeholder="" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Type'; ?></label>
                                <select name="type" class="form-control" required="required">
                                    <option value=""> Select Type </option>
                                    <option value="Adult"> Adult </option>
                                    <option value="Child"> Child </option>
                                    <option value="Adult,Child"> Adult & Child </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" value=''>
                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Department Modal-->

<!-- Edit Department Modal-->
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo 'Edit Symptom'; ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="departmentEditForm" class="clearfix" action="speciality/addNewSymptom" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Symptom'; ?> <?php echo lang('name') ?></label>
                                <input type="text" class="form-control" name="symptoms" id="exampleInputEmail1" value='' placeholder="" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Type'; ?></label>
                                <select name="type" class="form-control" required="required">
                                    <option value=""> Select Type </option>
                                    <option value="Adult"> Adult </option>
                                    <option value="Child"> Child </option>
                                    <option value="Adult,Child"> Adult & Child </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" value='' id="symptoms_id">
                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $(".editbutton").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $.ajax({
            url: 'speciality/editSymptomByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            // Populate the form fields with the data returned from server 
            $('#departmentEditForm').find('[name="id"]').val(response.symptom_data.id).end()
            $('#departmentEditForm').find('[name="symptoms"]').val(response.symptom_data.symptoms).end()
            $('#departmentEditForm').find('[name="type"]').val(response.symptom_data.type).end()
            // CKEDITOR.instances['editor'].setData(response.speciality.description)
            $('#myModal2').modal('show');
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
            buttons: [],

            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: 10,
            "order": [[0, "asc"]],

            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
