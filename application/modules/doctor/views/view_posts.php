<!--sidebar end-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.timepicker.css"/>
<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="card">
		<div class="card-header">
			<?php if($this->session->flashdata('blog_success_msg')){
                echo "<br><div class='alert alert-success'>".$this->session->flashdata('blog_success_msg')."</div>";
			} ?>
			<div class="row">
				<div class="col-sm-6">
					<h3 class="card-title">Blogs List</h3>
				</div>
				<div class="col-sm-6">
					<div class="text-right">
						<a href="doctor/add_new_blog" class="btn btn-primary btn-sm">Add Blog</a>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body ">
			<div class="card card-table mb-0">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-center mb-0">
							<thead>
								<tr>
									<th> # </th>
									<th>Post Name</th>
									<th>Author</th>
									<th>Created Date</th>
									<th>Status</th>
									<th></th>
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
												<button type="button" class="btn btn-primary btn-xs btn_width"><i class="fa fa-eye"></i> </button>
											</a>
											<?php if($val->is_approved !=1){ ?>
											<a href="doctor/edit_post/<?php echo $val->id ?>">
												<button type="button" class="btn btn-info btn-xs btn_width"><i class="fa fa-edit"></i> </button>
											</a>
											<?php } ?>
											<a href="doctor/delete_post/<?php echo $val->id ?>" onclick="return confirm('Are you sure to delete this post?')">
												<button type="button" class="btn btn-danger btn-xs btn_width"><i class="fa fa-trash"></i> </button>
											</a>
											<a href="doctor/copypost/<?php echo $val->id ?>" onclick="return confirm('Are you sure to copy this post?')">
												<button type="button" class="btn btn-primary btn-xs btn_width"><i class="fa fa-copy"></i> </button>
											</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>					

<script src="common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function () {
    $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
