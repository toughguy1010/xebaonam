<?php if (count($news)) { ?>
<div class="customer_mobile">
	<div class="title_list_car">
		<h2>
			<a href="https://xebaonam.com/hinh-anh-khach-hang">
				<span>
					Hình ảnh khách hàng
				</span>
			</a>
		</h2>
	</div>
	


	<div class="list-item-customer customer-img owl-carousel">
		<?php foreach ($news as $ne) {?>
		<div class="item-customer">
			<div class="img">
				<div class="cover">
					<a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"> 
						<img alt="<?php echo $ne['news_title'] ?>" src="<?php echo ClaHost::getImageHost(), $ne['image_path'], 's400_400/', $ne['image_name'] ?>" /> 
					</a> 
				</div>
			</div>
			<div class="text">
				<a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"><h2><?php echo $ne['news_title'] ?></h2></a> 
			</div>
		</div>
		<?php } ?>
	</div>


	<div class="clear">
		
	</div>
</div>
<?php } ?>