<?php if (count($category)) { ?>
	<?php $i=0;foreach ($category as $cat) { $i++;?>
		<div class="list_car_mobile">
			<div class="title_list_car">
				<h2><span><?php echo $cat['cat_name']; ?></span></h2>
			</div>

			<?php if (isset($products[$cat['cat_id']]['products'])) { ?>
				<?php foreach ($products[$cat['cat_id']]['products'] as $product) { ?>
					<div class="item_car_mobile">
						<div class="img">
							<a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>">
								<img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's220_220/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
							</a>
						</div>
						<div class="text">
							<a href="<?php echo $product['link'] ?>"><h2>Xe máy Cub 50CC màu nâu</h2></a>
							<?php if ($product['price'] && $product['price'] > 0) { ?>
								<p class="price_news"><?php echo number_format($product['price'], 0, '', '.'); ?> VNĐ</p>
							<?php }?>
							<?php if ($product['price_text'] && $product['price_text'] > 0) { ?>
								<p class="price_old"><?php echo number_format($product['price_text'], 0, '', '.'); ?> VNĐ</p>
							<?php }?>
						</div>
					</div>
				<?php }?>
			<?php }?>
			<?php if($i<count($category)){?>
			<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK6)); ?>
			<?php } ?>
		</div>
	<?php } ?>
	<?php } ?>