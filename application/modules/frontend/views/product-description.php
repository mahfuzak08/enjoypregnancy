<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Product Description</li>
					</ol>
				</nav>
				<h2 class="breadcrumb-title">Product Description</h2>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container">

		<div class="row">

			<div class="col-md-7 col-lg-9 col-xl-9">
				<!-- Doctor Widget -->
				<div class="card">
					<div class="card-body product-description">
						<div class="doctor-widget">
							<div class="doc-info-left">
								<div class="doctor-img1">
										<img src="assets/images/image/<?php echo $product_history->image ?>.jpg" class="img-fluid" alt="User Image" onerror="this.src = '<?php echo base_url(); ?>assets/images/default_image.jpg';">
								</div>
								<div class="doc-info-cont">
									<h4 class="doc-name mb-2"><?php echo $product_history->name ?></h4>
									<p><b>Category:</b> <?php echo $product_history->subcategory ?></p>
									<p><b>Product Type:</b> <?php echo $product_history->product_type ?></p>
									<?php if($product_history->prescription_required=="yes"){ ?>
									<div class="card">
        								<div class="card-body">
        									<div class="booking-doc-info">
        										<a href="doctor-profile.html" class="booking-doc-img">
        											<img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
        										</a>
        										<div class="booking-info">
        											<h4><a href="#">Prescription Required</a></h4>  
        											<p>You need to upload the doctor prescription to book this product.</p>      											
        										</div>
        									</div>
        								</div>
        							</div>
        							<?php } ?>
        							<p><b>Description:</b> <?php echo $product_history->description ?></p>
								</div>
							</div>
							
						</div>
						
					</div>
				</div>
				<!-- /Doctor Widget -->

			</div>

			<div class="col-md-5 col-lg-3 col-xl-3 theiaStickySidebar">
				
				<!-- Right Details -->
				<div class="card search-filter">
					<div class="card-body">
						<div class="clini-infos mt-0">
							<h2><?php echo $product_history->price ?></h2>
						</div>
						<span class="badge badge-primary">In stock</span>
						<div class="custom-increment pt-4">
                            <div class="input-group1">
                                <span class="input-group-btn float-left">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                      <span><i class="fas fa-minus"></i></span>
                                    </button>
                                </span>
                                <input type="text" id="quantity" name="quantity" class=" input-number" value="10">
                                <span class="input-group-btn float-right">
                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                        <span><i class="fas fa-plus"></i></span>
                                    </button>
                                </span>
                        	</div>
            			</div>
						<div class="clinic-details mt-4">
							<div class="clinic-booking">
								<a class="apt-btn addcart_cart_btn<?php echo $product_history->id ?>" href="javascript:void(0)" onclick="addtocart(<?php echo $product_history->id ?>)">Add To Cart</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card search-filter">
					<div class="card-body">
						<div class="card flex-fill mt-0 mb-0">
							<ul class="list-group list-group-flush benifits-col">
								<li class="list-group-item d-flex align-items-center">
									<div>
										<i class="fas fa-shipping-fast"></i>
									</div>
									<div>
										Free Shipping<br><span class="text-sm">For orders from Rs.300</span>
									</div>
								</li>
								<li class="list-group-item d-flex align-items-center">
									<div>
										<i class="far fa-question-circle"></i>
									</div>
									<div>
										Support 24/7<br><span class="text-sm">Call us anytime</span>
									</div>
								</li>
								<li class="list-group-item d-flex align-items-center">
									<div>
										<i class="fas fa-hands"></i>
									</div>
									<div>
										100% Safety<br><span class="text-sm">Only secure payments</span>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Right Details -->
				
			</div>

		</div>

		

	</div>
</div>		
<!-- /Page Content -->