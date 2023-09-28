<?php

foreach ($cateinhome as $cat) {
     ?>
	<!-- video hot -->
	<div class="video_hot fadeInUp wow">

		<div class="">
			<div class="title_n"><h2><?php echo $cat['cat_name']; ?></h2></div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<?php if (isset($data[$cat['cat_id']]['videos'])) { ?>
					 	<?php foreach ($data[$cat['cat_id']]['videos'] as $video) { ?>
							<div class="video_hot_big">
								<iframe width="100%" height="300" src="<?= $video['video_embed']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						<?php break;} ?>
					<?php } ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="video_hot_small">
						<?php $i=0;if (isset($data[$cat['cat_id']]['videos'])) { ?>
							<?php foreach ($data[$cat['cat_id']]['videos'] as $video) {$i++; if($i>=2) { ?>
								<div class="item">
									 <iframe width="100%" height="150" src="<?= $video['video_embed']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							<?php } ?>
						<?php } } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
