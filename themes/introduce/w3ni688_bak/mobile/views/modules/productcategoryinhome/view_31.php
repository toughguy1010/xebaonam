<?php if (count($cateinhome)) { ?>
	<?php $i=0;foreach ($cateinhome as $cat) {$i++; ?>
		<?php if (count($data[$cat['cat_id']]['products'])) { ?>
		<div class="list_car_mobile">
			<div class="title_list_car">
				<h2><a href="<?php echo $cat['link']; ?>"><span><?php echo $cat['cat_name']; ?></span></a></h2>
			</div>

			<?php if ($data[$cat['cat_id']]['products']) { ?>
				<?php foreach ($data[$cat['cat_id']]['products'] as $product) { ?>
					<div class="item_car_mobile">
						<div class="img">
							<a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>">
								<img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
							</a>
						</div>
						<div class="text">
							  <a href="<?php echo $product['link'] ?>"><h2><?php echo $product['name']; ?></h2></a>
							<?php if ($product['price'] && $product['price'] > 0) { ?>
								<p class="price_news"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
							<?php }?>
							<?php if ($product['price_market'] && $product['price_market'] > 0) { ?>
								<p class="price_old"><?php echo number_format($product['price_market'], 0, '', '.'); ?> VNĐ</p>
							<?php }?>
							<div class="link_product">
								<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
								 <a href="/cach-tinh-tra-gop-pde,11188?price=<?= $product['price'];?>">Mua trả góp</a>
							</div>
						</div>
					</div>
				<?php }?>
			<?php }?>
			<?php if($i==1){?>
				<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK6)); ?>
			<?php } ?>
		</div>
		<?php } ?>
	<?php } ?>
	<?php } ?>