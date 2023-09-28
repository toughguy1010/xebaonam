<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<div class="list_product_category">
	<h2><a class="title-need-bold" href="<?php echo Yii::app()->createUrl('/economy/product/hotproduct'); ?>"> <?php echo $widget_title?> </a> 
		<a href="<?php echo Yii::app()->createUrl('/economy/product/hotproduct'); ?>" class="more_title">Xem tất cả 
			<span><i class="fa fa-angle-right" aria-hidden="true"></i><i class="fa fa-angle-right" aria-hidden="true"></i></span>
		</a>
	</h2>
	<div class="slider_product owl-carousel owl-theme">
		<?php foreach ($products as $product) {  ?>
			<div class="item">
				<div class="img">
				<!-- <div class="status_stock">
					<?php if ($product['state'] == 1) { ?>
					    <a href="<?php echo $product['link']; ?>" title="còn hàng"
					       class="order-product order-promotion">  </a>
					<?php } else { ?>
					    <a href="javascript:void(0)" class="order-product order-promotion"> Hết
					        hàng </a>
					<?php } ?>					
				</div> -->
				<a href="<?php echo $product['link'] ?>">
					<img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>"> 
				</a>
			</div>
			<div class="content">
				<h3><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
					<span><?= HtmlFormat::sub_string(strip_tags($product['name']), 50)?></span>
				</a></h3>
				<?php if($product['price_market']>0){?>
					<p class="price_all"><?php echo number_format($product['price_market'], 0, '', '.'); ?> VNĐ</p>
				<?php }?>
				<p class="price_new"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
				<div class="link_product">
					<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
					<a href="/cach-tinh-tra-gop-pde,11188?price=<?= $product['price'];?>">Mua trả góp</a>
				</div>
				<div class="box-km-detail clearfix">
					<?php if (isset($product['product_sortdesc']) && $product['product_sortdesc'] != "") { ?>
						<div class="cont boder">
							<div class="title-km-detail">
								<span class="gift-icon"></span>
								<h2>Quà tặng</h2>
							</div>
						<?php } else{?>
						<div class="cont">
							<?php } ?>
							<ul>
								<?php
								$subject = $product['product_sortdesc'];
								$khuyenmai = explode("\n", $subject);
								foreach ($khuyenmai as $each) {
									if (trim(strip_tags($each)) == null) {
										continue;
									}
									echo '<li>', $each, '</li>';
								}
								?>
							</ul>
						</div>
					<!-- </div>                                         -->
				</div>
			</div>
		</div>
	<?php } ?>
</div>
</div>
