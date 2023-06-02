<!--sidebar end-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css"/>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <?php if($this->session->flashdata('blog_success_msg')){
                echo "<br><div class='alert alert-success'>".$this->session->flashdata('blog_success_msg')."</div>";
        } ?>
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                Blogs List
                <div class="col-md-4 clearfix pull-right">
                    <a href="doctor/add_new_blog">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_new'); ?> 
                            </button>
                        </div>
                    </a>  
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
                                <th>Status</th>
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
                                    <td> <?php if($val->is_approved==1){ echo "Approved "; }elseif($val->is_approved==2){echo "Rejected ";}else{ echo "In Progress "; } if($val->status==1){echo "<span class='badge badge-info'>Active</span>";}else{ echo "<span class='badge badge-danger'>Inactive</span>"; } ?> </td> 
                                    <td>
                                        <a href="blog-details/<?php echo $val->page_url ?>" target="_blank">
                                            <button type="button" class="btn btn-primary btn-xs btn_width"><i class="fa fa-eye"></i> <?php echo 'view'; ?></button>
                                        </a>
                                        <?php if($val->is_approved !=1){ ?>
                                        <a href="doctor/edit_post/<?php echo $val->id ?>">
                                            <button type="button" class="btn btn-info btn-xs btn_width"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>
                                        </a>
                                        <?php } ?>
                                        <a href="doctor/delete_post/<?php echo $val->id ?>" onclick="return confirm('Are you sure to delete this post?')">
                                            <button type="button" class="btn btn-danger btn-xs btn_width"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></button>
                                        </a>
                                        <a href="doctor/copypost/<?php echo $val->id ?>" onclick="return confirm('Are you sure to copy this post?')">
                                            <button type="button" class="btn btn-primary btn-xs btn_width"><i class="fa fa-copy"></i> <?php echo 'Copy'; ?></button>
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
