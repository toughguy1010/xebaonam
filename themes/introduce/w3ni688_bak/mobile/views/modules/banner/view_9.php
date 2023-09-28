<!-- library -->
<?php if (count($banners)) {?>
	<div class="library_base">
		<h2>Thư viện ảnh</h2>
		<div class="list">
			<?php foreach ($banners as $banner) {?>
				<div class="item">
					<a class="fancybox" href="<?php echo $banner['banner_src'] ?>" data-fancybox-group="gallery"><img src="<?php echo $banner['banner_src'] ?>" alt="" /></a>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>