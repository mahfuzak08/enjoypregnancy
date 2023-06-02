<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Frequently Asked Questions</h2>
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
				<div class="card">
					<div class="card-header">
                        <h4 class="card-title">FAQs for Maulaji Health Services</h4>
                    </div>
                    <div class="card-body">
						<ol class="faq-content">
							<?php foreach($faqs as $row) { ?>
								<li>
									<strong><?= $row->title; ?><br></strong>
									<?= $row->details; ?> <a href="javascript:void(0);" class="text-primary video_help" data-title="<?= $row->title; ?>" data-link="<?= $row->vlink; ?>"><i class="fas fa-video"></i> <?= $row->title; ?></a></li>
							<?php } ?>
						</ol>
                    </div>
                </div>
            </div>
            
            <!-- Blog Sidebar -->
            <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">
				<!-- Search -->
				<div class="card search-widget">
					<div class="card-body">
						<div class="input-group">
							<input type="text" onkeyup="search_faq()" id="faq_search" placeholder="Search..." class="form-control">
							<div class="input-group-append">
								<button onclick="search_faq()" class="btn btn-primary"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<!-- /Search -->
				
                <div class="card post-widget">
                    <div class="card-body">
						<h5 class="card-title">Can’t find what you were looking for? Click the button below:</h5>
                        <a href="frontend/contact" type="button" class="btn btn-rounded btn-primary">Content Us</a>
                    </div>
                </div>
                
				<div class="card category-widget">
					<div class="card-body">
						<h5 class="card-title">Looking for doctors, clinics, diagnostic labs, pharmacy?</h5><br>
						Visit <a href="https://maulaji.com/" class="text-primary">Maulaji.com</a>
					</div>
				</div>
            </div>
            <!-- /Blog Sidebar -->
            
        </div>
    </div>
</div>  
<!-- /Page Content -->