<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Blogs</h2>
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
				<?php foreach($blogs as $key => $value){ ?>
					<!-- Blog Post -->
					<div class="blog">
						<div class="blog-image">
							<a href="blog-details/<?php echo $value->page_url ?>"><img class="img-fluid" src="assets/images/post_img/<?php echo $value->og_banner ?>" alt="Post Image"></a>
						</div>
						<h3 class="blog-title"><a href="blog-details/<?php echo $value->page_url ?>"><?php echo $value->title ?></a></h3>
						<div class="blog-info clearfix">
							<div class="post-left">
								<ul>
									<li>
										<div class="post-author">
											<a href="frontend/doctor_profile/<?= $value->doc_id; ?>"><img src="<?= $value->doctor_img; ?>" alt="Post Author"> <span><?php echo $value->author ?></span></a>
										</div>
									</li>
									<li><i class="far fa-clock"></i><?= date('d M Y', strtotime($value->dateandtime)); ?></li>
									<!--<li><i class="far fa-comments"></i>12 Comments</li>-->
									<li><i class="fa fa-tags"></i><?= $value->blog_category_title; ?></li>
								</ul>
							</div>
						</div>
						<div class="blog-content">
							<p><?php echo $value->description ?></p>
							<a href="blog-details/<?php echo $value->page_url ?>" class="read-more">Read More</a>
						</div>
					</div>
					<!-- /Blog Post --><?php 
				} ?>
            </div>
            
            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">
				<!-- Search -->
				<div class="card search-widget">
					<div class="card-body">
						<form class="search-form">
							<div class="input-group">
								<input type="text" placeholder="Search..." class="form-control">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /Search -->
				
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