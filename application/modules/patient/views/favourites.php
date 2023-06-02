<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<div class="row row-grid">
		<?php foreach($favourites as $row) { ?>
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="profile-widget">
					<div class="doc-img">
						<a href="frontend/doctor_profile/<?= $row->id; ?>">
							<img class="img-fluid" alt="User Image" src="<?= $row->img_url; ?>">
						</a>
						<a href="frontend/add_favourites/<?php echo $row->id ?>?dash=favo" class="fav-btn">
							<i class="far fa-bookmark"></i>
						</a>
					</div>
					<div class="pro-content">
						<h3 class="title">
							<a href="frontend/doctor_profile/<?= $row->id; ?>"><?= $row->name; ?></a> 
							<i class="fas fa-check-circle verified"></i>
						</h3>
						<p class="speciality"><?= $row->profile; ?></p>
						<div class="rating">
							<?php $has_any = false; foreach($rating as $doctor_rat) { ?>
								<?php if($doctor_rat->product_id == $row->id) { $has_any = true; ?>
									<?php for($i=1; $i<=5; $i++) { ?>
										<?php if($doctor_rat->avg_rating > ($i-1) && $doctor_rat->avg_rating < $i){ ?>
											<i class="fas fa-star-half-alt filled"></i>
										<?php } elseif($doctor_rat->avg_rating >= $i){ ?>
											<i class="fas fa-star filled"></i>
										<?php } else { ?>
											<i class="fas fa-star"></i>
										<?php } ?>
									<?php } ?>
									<span class="d-inline-block average-rating">(<?= $doctor_rat->total; ?>)</span>
								<?php } ?>
							<?php } ?>
							<?php if($has_any === false) { ?>
								<?php for($i=1; $i<=5; $i++) { ?>
									<i class="fas fa-star"></i>
								<?php } ?>
								<span class="d-inline-block average-rating">(0)</span>
							<?php } ?>
						</div>
						<ul class="available-info">
							<li>
								<i class="fas fa-map-marker-alt"></i> <?= str_replace('"', '', str_replace(']', '', str_replace('[', '', $row->address))); ?>
							</li>
							<!--<li>
								<i class="far fa-clock"></i> Available on Fri, 22 Mar
							</li>
							<li>
								<i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
							</li>-->
						</ul>
						<div class="row row-sm">
							<div class="col-6">
								<a href="frontend/doctor_profile/<?= $row->id; ?>" class="btn view-btn">View Profile</a>
							</div>
							<div class="col-6">
								<a href="frontend/book_appointment/<?= $row->id; ?>" class="btn book-btn">Book Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<!-- / main page content in right side -->