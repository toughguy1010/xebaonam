<?php if (count($banners)) { ?>
<div class="slider_mobile">

	<div class="slider_m">
		<?php foreach ($banners as $banner) {?>
		<div class="item">
			<a href="<?php echo $banner['banner_link'] ?>" title="<?php echo $banner['banner_name'] ?>">
                                   <img src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>"/>
                              </a>
		</div>
		<?php }?>
	</div>
</div>
<?php }?>