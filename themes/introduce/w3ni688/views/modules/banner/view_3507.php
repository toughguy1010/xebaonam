<?php
     $themUrl = Yii::app()->theme->baseUrl;
?>
<?php if (count($banners)) {?>
	<div class="slider_main ">

		<section class="big_album  slider-for">
			<?php foreach ($banners as $banner) {?>
				<div class="item">
					<a href="<?php echo $banner['banner_link'] ?>"><img src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>" /></a>
				</div>
			<?php } ?>
		</section>
		<section class="small_album  slider-nav">
			<?php foreach ($banners as $banner) {?>
				<div class="item">
					<h2><?php echo $banner['banner_name'] ?></h2>
				</div>
			<?php } ?>

		</section>
	</div>
	<?php } ?>