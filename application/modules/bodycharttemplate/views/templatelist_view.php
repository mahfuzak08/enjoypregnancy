<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success'); } ?>
        <section class="panel">
            <header class="panel-heading"> Body Chart Template
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

                    <?php
                    foreach ($template as $key => $item) {
                        ?>
                        <div href="javascript:;" data-img="<?= base_url('common/' . $item->image) ?>"
                           class="col-md-3 thumbnails  img-thumbnail  text-center  " style="margin: 5px;">
                            <img src="<?= base_url('common/' . $item->thumbnil) ?>" height="200"
                                 class="img ">
                            <h5> <?= $item->title; ?></h5>        <a type="button" class="btn btn-info btn-xs btn_width editbutton" title="Edit" data-toggle="modal" data-id="<?=$item->id?>"><i class="fa fa-edit"> </i>    </a>
                            <a class="btn btn-info btn-xs btn_width delete_button" title="delete" href="prescription/Templatedelete?id=<?=$item->id?>" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>  </a>

                        </div>

                    <?php } ?>




                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->






<!-- Add Accountant Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  Add New Body Template</h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="prescription/addNewBodyTemplate" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>
                        <!--Haseen Code-->

                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
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
                <h4 class="modal-title"> Edit Template</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editDoctorForm" class="clearfix" action="prescription/addTemplate" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group last col-md-6">
                        <label class="control-label">Image Upload</label>
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="img_url"/>
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                </div>
                            </div>

                        </div>

                    </div>

                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->


<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Body Template <?php echo lang('info'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editDoctorForm" class="clearfix" action="doctor/addNew" method="post" enctype="multipart/form-data">

                    <div class="form-group last col-md-6">
                        <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img1" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <div class="nameClass"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('department'); ?></label>
                        <div class="departmentClass"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo 'Speciality'; ?></label>
                        <div class="profileClass"></div>
                    </div>


                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".editbutton", function () {
            // Get the record's ID via attribute
            var iid = $(this).data('id');

            $("#img").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
            $('#editDoctorForm').trigger("reset");
            $.ajax({
                url: 'prescription/editBodyTemplateByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editDoctorForm').find('[name="id"]').val(response.template.id).end()
                $('#editDoctorForm').find('[name="title"]').val(response.template.title).end()

                if (typeof response.template.thumbnil !== 'undefined' && response.template.thumbnil != '') {
                    $("#img").attr("src", 'common/'+response.template.thumbnil);
                }


                $('#myModal2').modal('show');

            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".inffo", function () {
            // Get the record's ID via attribute
            var iid = $(this).attr('data-id');

            $("#img1").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
            $('.nameClass').html("").end()
            $('.emailClass').html("").end()
            $('.addressClass').html("").end()
            $('.phoneClass').html("").end()
            $('.departmentClass').html("").end()
            $('.profileClass').html("").end()
            $.ajax({
                url: 'doctor/editDoctorByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                // Populate the form fields with the data returned from server
                $('#editDoctorForm').find('[name="id"]').val(response.doctor.id).end()
                $('.nameClass').append(response.doctor.name).end()
                $('.emailClass').append(response.doctor.email).end()
                $('.addressClass').append(response.doctor.address).end()
                $('.phoneClass').append(response.doctor.phone).end()
                $('.departmentClass').append(response.doctor.department).end()
                $('.profileClass').append(response.doctor.profile).end()

                if (typeof response.doctor.img_url !== 'undefined' && response.doctor.img_url != '') {
                    $("#img1").attr("src", response.doctor.img_url);
                }

                $('#infoModal').modal('show');

            });
        });
    });
</script>









<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });

    function adduseridtomodal(id,email)
    {
        $('#d_id').val(id);
        $('#d_email').val(email);
    }
    function countryval(val)
    {
        $.post('frontend/getcities2',{country_id:val},function(result){
            // console.log(result);
            $('#city').html(result);
        });
    }
    function editcountryval(val)
    {
        $.post('frontend/getcities2',{country_id:val},function(result){
            // console.log(result);
            $('#city2').html(result);
        });
    }

</script>

