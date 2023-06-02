
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>blogs">Blogs List</a></li>
									<li class="breadcrumb-item active" aria-current="page">Blog Details</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Blog Details</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">
				
					<div class="row">
						<div class="col-lg-8 col-md-12">
							<div class="blog-view">
								<div class="blog blog-single-post">
									<div class="blog-image text-center">
									    <a href="javascript:void(0);"><img alt="" src="assets/images/post_img/<?php echo $post_details->og_banner ?>" class="img-fluid"></a>
									</div>
									<h3 class="blog-title"><?php echo $post_details->title ?></h3>
									<div class="blog-info clearfix">
										<div class="post-left">
										    <?php 
										        $this->db->select('img_url');
                                                $this->db->where('id', $post_details->doc_id);
                                                $doc_img = $this->db->get('doctor')->row();
										    ?>
											<ul>
												<li>
													<div class="post-author">
														<a href="javascript:void(0)"><img src="<?php echo $doc_img->img_url; ?>" onerror="this.src='new_assets/img/doctors/doctor-thumb-01.jpg';" style="height: 28px;"> <span><?php echo $post_details->author ?></span></a>
													</div>
												</li>
												<li><i class="far fa-calendar"></i><?php echo date('d M, Y',strtotime($post_details->dateandtime)); ?></li>
											</ul>
										</div>
									</div>
									<div class="blog-content" style="overflow:hidden;">
										<?php if(str_replace(' ','',$post_details->video_url) != ""){ ?>
											<?php echo $post_details->video_url; ?>
										<?php } ?>
										<?php echo $post_details->page_content ?>
									</div>
								</div>
								
								<div class="card blog-share clearfix">
									<div class="card-header">
										<h4 class="card-title">Share the post</h4>
									</div>
									<div class="card-body">
										<ul class="social-share">
											<li><a href="#" title="Facebook"><i class="fab fa-facebook"></i></a></li>
											<li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
											<li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
											<li><a href="#" title="Google Plus"><i class="fab fa-google-plus"></i></a></li>
											<li><a href="#" title="Youtube"><i class="fab fa-youtube"></i></a></li>
										</ul>
									</div>
								</div>
								<!--<div class="card author-widget clearfix">-->
								<!--<div class="card-header">-->
								<!--	<h4 class="card-title">About Author</h4>-->
								<!--	</div>-->
								<!--<div class="card-body">-->
								<!--	<div class="about-author">-->
								<!--		<div class="about-author-img">-->
								<!--			<div class="author-img-wrap">-->
								<!--				<a href="doctor-profile.html"><img class="img-fluid rounded-circle" alt="" src="assets/img/doctors/doctor-thumb-02.jpg"></a>-->
								<!--			</div>-->
								<!--		</div>-->
								<!--		<div class="author-details">-->
								<!--			<a href="doctor-profile.html" class="blog-author-name">Dr. Darren Elder</a>-->
								<!--			<p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
								<!--</div>-->

							</div>
						</div>
					
						<!-- Blog Sidebar -->
						<div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

							<!-- Latest Posts -->
							<div class="card post-widget">
								<div class="card-header">
									<h4 class="card-title">Latest Posts</h4>
								</div>
								<div class="card-body">
									<ul class="latest-posts">
									    <?php foreach($recent_posts as $key => $value){ 
									    if($post_details->id != $value->id){
									    ?>
										<li>
											<div class="post-thumb">
												<a href="blog-details/<?php echo $value->page_url ?>">
													<img class="img-fluid" src="assets/images/post_img/<?php echo $value->og_banner ?>" alt="">
												</a>
											</div>
											<div class="post-info">
												<h4>
													<a href="blog-details/<?php echo $value->page_url ?>"><?php echo $value->title ?></a>
												</h4>
												<p><?php echo date('d M, Y',strtotime($value->dateandtime)) ?></p>
											</div>
										</li>
									<?php } } ?>
									</ul>
								</div>
							</div>
							<!-- /Latest Posts -->
							<!-- Categories -->
							<div class="card category-widget">
								<div class="card-header">
									<h4 class="card-title">Blog Categories</h4>
								</div>
								<div class="card-body">
									<ul class="categories">
										<?php foreach($blogs_category as $row) { ?>
											<li><a href="blogs?cat=<?= $row->id; ?>"><?= $row->title; ?> <span>(<?= $row->category_id ? $row->category_id : 0; ?>)</span></a></li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<!-- /Categories -->

							<!-- Tags -->
							<div class="card tags-widget">
								<div class="card-header">
									<h4 class="card-title">Tags</h4>
								</div>
								<div class="card-body">
									<ul class="tags">
										<?php foreach($tag_lists as $row) { ?>
											<li><a href="blogs?tag=<?= $row; ?>" class="tag"><?= $row; ?></a></li>
										<?php } ?>
									</ul>
								</div>
							</div>
							<!-- /Tags -->
							
						</div>
						<!-- /Blog Sidebar -->
						
                </div>
				</div>

			</div>		
			<!-- /Page Content -->
   