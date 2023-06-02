<!--sidebar end-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css"/>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php if($this->session->flashdata('blog_success_msg')){
                echo "<br><div class='alert alert-success'>".$this->session->flashdata('blog_success_msg')."</div>";
            } ?>
        <section class="panel">
            <header class="panel-heading">
                Requested Blog List
                <div class="col-md-4 clearfix pull-right">
                    <!--<a href="doctor/add_new_blog">-->
                    <!--    <div class="btn-group pull-right">-->
                    <!--        <button id="" class="btn green btn-xs">-->
                    <!--            <i class="fa fa-plus-circle"></i>  <?php echo lang('add_new'); ?> -->
                    <!--        </button>-->
                    <!--    </div>-->
                    <!--</a>  -->
                </div>
            </header>
            
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Post Name</th>
                                <th>Author</th>
                                <th>Created Date</th>
                                <!--<th>Status</th>-->
                                <th><?php echo lang('options'); ?></th>

                            </tr>
                        </thead>
                        <tbody> 
                            <?php $i=1; foreach($all_posts as $key => $val){ ?>
                                <tr class="">
                                    <td><?php echo $i++ ?></td> 
                                    <td> <?php echo $val->page_name ?> </td>
                                    <td> <?php echo $val->author ?> </td> 
                                    <td> <?php echo $val->dateandtime ?> </td> 
                                    <!--<td> <?php if($val->is_approved==1){ echo "Approved "; }else{ echo "In Progress "; } if($val->status==1){echo "<span class='badge badge-info'>Active</span>";}else{ echo "<span class='badge badge-danger'>Inactive</span>"; } ?> </td> -->
                                    <td>
                                        <a href="blog-details/<?php echo $val->page_url ?>" target="_blank">
                                            <button type="button" class="btn btn-primary btn-xs btn_width"><i class="fa fa-eye"></i> <?php echo 'view'; ?></button>
                                        </a>
                                        <a href="doctor/approve_post/<?php echo $val->id ?>" onclick="return confirm('Are you sure to Approve this post?')">
                                            <button type="button" class="btn btn-info btn-xs btn_width"><i class="fa fa-check"></i> <?php echo 'Approve'; ?></button>
                                        </a>
                                        <a href="doctor/reject_post/<?php echo $val->id ?>" onclick="return confirm('Are you sure to reject this post?')">
                                            <button type="button" class="btn btn-danger btn-xs btn_width"><i class="fa fa-times"></i> <?php echo 'Reject'; ?></button>
                                        </a>
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

<!-- Edit Time Slot Modal-->

<script src="common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function () {
    $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
