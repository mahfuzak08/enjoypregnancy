<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">            
            <header class="panel-heading">
                <?php if($this->session->userdata('is_hospital')==1){ echo "Pharmacy Registration Requests From Website "; }elseif($this->session->userdata('is_hospital')==2){ echo "Laboratory Registration Requests From Website ";}else{ echo lang('hospital_registration_requests_from_website'); } ?>
            </header>

            <style>
                .editbutton{
                    width: auto !important;
                }
                .delete_button{
                    width: auto !important;
                }
                .status{
                    background: #123412 !important;
                }
            </style>

            <div class="panel-body">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('title'); ?></th>
                                <th> <?php echo lang('email'); ?></th>
                                <th> <?php echo lang('address'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> <?php echo lang('package'); ?></th>
                                <th> <?php echo lang('status'); ?></th>
                                <th class="no-print"> <?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <style>
                            .img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
                            }
                        </style>

                        <?php
                        foreach ($requests as $request) {
                            ?>
                            <tr class="">
                                <td> <?php echo $request->name; ?></td>
                                <td><?php echo $request->email; ?></td>
                                <td class="center"><?php echo $request->address; ?></td>
                                <td><?php echo $request->phone; ?></td>
                                <td>
                                    <?php
                                    if (!empty($request->package)) {
                                        echo $this->package_model->getPackageById($request->package)->name;
                                    }
                                    ?>
                                </td>
                                <td> <?php echo $request->status; ?></td>
                                <td class="no-print">
                                    <?php
                                    $status = $this->db->get_where('request', array('id' => $request->id))->row()->status;
                                    if ($status == 'Pending') {
                                        ?>
                                        <a href="request/approve?id=<?php echo $request->id; ?>&is_hospital=<?php if($this->session->userdata('is_hospital')==1){echo 1;}elseif($this->session->userdata('is_hospital')==2){echo 2;} ?>" type="button" class="btn btn-info btn-xs status" data-toggle="modal" data-id="<?php echo $request->id; ?>"><?php echo lang('approve'); ?></a>  

                                    <?php }
                                    ?>
                                    <?php if ($status != 'Approved') { ?>
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="request/delete?id=<?php echo $request->id; ?>" onclick="return confirm('Are you sure you want to decline this request?');"><i class="fa fa-trash"></i> <?php echo lang('decline'); ?></a>
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