<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo 'List of Specialities' ?>
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
                                <th> <?php echo 'Speciality'; ?></th>
                                <th> <?php echo 'Image'; ?></th>
                                <th> <?php echo 'Icon'; ?></th>
                                <th class="no-print"> <?php echo lang('options') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($specialities as $speciality) { ?>
                                <tr class="">
                                    <td><?php echo $speciality->speciality; ?></td>
                                    <td><img src="<?php echo $speciality->image; ?>" class="img-thumbnail" style="border-radius: 100%; height: 80px; width: 80px;"></td>
                                    <td><img src="<?php echo $speciality->icon; ?>" class="img-thumbnail" style="border-radius: 100%; height: 80px; width: 80px;"></td>
                                    <td class="no-print">
                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $speciality->id; ?>"><i class="fa fa-edit"></i> </button>   
                                        <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="speciality/delete?id=<?php echo $speciality->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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
                <h4 class="modal-title"> <?php echo 'Add Speciality'; ?></h4>
            </div> 
            <div class="modal-body">
                <form role="form" action="speciality/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Speciality'; ?> <?php echo lang('name') ?></label>
                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Image'; ?></label>
                                <input type="file" class="form-control" name="image" id="" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo 'Icon'; ?> </label>
                                <input type="file" class="form-control" name="icon" id="" required>
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
                <h4 class="modal-title">   <?php echo lang('edit_department') ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="departmentEditForm" class="clearfix" action="speciality/addNew" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo 'speciality' ?> <?php echo lang('name') ?></label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo 'Icon'; ?> </label>
                            <input type="file" class="form-control" name="icon">
                            <input type="hidden" name="old_icon" id="old_icon">
                            <img src="" class="img-thumbnail" id="old_icon_preview">
                        </div>
                        
                    </div>

                    <!-- <div class="col-md-6">

                    </div> -->

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo 'Image'; ?></label>
                            <input type="file" class="form-control" name="image" id="">
                            <input type="hidden" name="old_image" id="old_image">
                            <img src="" class="img-thumbnail" id="old_image_preview">
                        </div>
                    </div>
                </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value=''>

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
            url: 'speciality/editSpecialityByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            // Populate the form fields with the data returned from server
            $('#departmentEditForm').find('[name="id"]').val(response.speciality.id).end()
            $('#departmentEditForm').find('[name="name"]').val(response.speciality.speciality).end()
            $('#departmentEditForm').find('[name="old_image"]').val(response.speciality.image).end()
            $('#departmentEditForm').find('[name="old_icon"]').val(response.speciality.icon).end()
            $('#old_image_preview').attr('src', response.speciality.image).end()
            $('#old_icon_preview').attr('src', response.speciality.icon).end()
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
            buttons: [
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
