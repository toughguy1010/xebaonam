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
					 	<?php foreach ($data[$cat['cat_id']]['videos'] as $video) {
					 	    $src1 = ClaHost::getImageHost(). $video['avatar_path']. 's600_600/'. $video['avatar_name'];
					 	    ?>
							<div class="video_hot_big">
                                <?php Yii::app()->controller->renderPartial('//layouts/img_youtube', array('height' => '310','src'=> $src1, 'link_vd' =>$video['video_embed'], 'title' => $video['video_title'])); ?>
							</div>
						<?php break;} ?>
					<?php } ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="video_hot_small">
						<?php $i=0;if (isset($data[$cat['cat_id']]['videos'])) { ?>
							<?php foreach ($data[$cat['cat_id']]['videos'] as $video) {$i++; if($i>=2) {
                                $src2 = ClaHost::getImageHost(). $video['avatar_path']. 's300_300/'. $video['avatar_name'];
							    ?>
								<div class="item">
                                    <?php Yii::app()->controller->renderPartial('//layouts/img_youtube', array('height' => '150','src'=> $src2, 'link_vd' =>$video['video_embed'], 'title' => $video['video_title'])); ?>
								</div>
							<?php } ?>
						<?php } } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php Yii::app()->controller->renderPartial('//layouts/shops_store_footer')?>