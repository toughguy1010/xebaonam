<?php
	$themUrl = Yii::app()->theme->baseUrl;
	?>
<div class="list_product_category">
	<h2><a href="<?php echo Yii::app()->createUrl('/economy/product/index'); ?>"><?php echo $widget_title?></a> 
		<a href="<?php echo Yii::app()->createUrl('/economy/product/index'); ?>" class="more_title">Xem tất cả 
			<span><i class="fa fa-angle-right" aria-hidden="true"></i><i class="fa fa-angle-right" aria-hidden="true"></i></span>
		</a>
	</h2>
	<div class="slider_product owl-carousel owl-theme">
		<?php foreach ($products as $product) { ?>
		<div class="item">
			<div class="img">
					<a href="<?php echo $product['link'] ?>">
						<img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>"> 
					</a>
			</div>
			<div class="content">
				<h3><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
					<?= HtmlFormat::sub_string(strip_tags($product['name']), 25)?>
					</h3>
				<?php if($product['price_text']>0){?>
					<p class="price_all"><?php echo number_format($product['price_text'], 0, '', '.'); ?> VNĐ</p>
				<?php }?>
				<p class="price_new"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
				<div class="link_product">
					<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
					<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua trả góp</a>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</div>