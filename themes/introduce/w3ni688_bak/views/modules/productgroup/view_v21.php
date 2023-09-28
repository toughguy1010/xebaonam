<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<?php if (count($products)) {?>
<div class="list_product_category">
	<h2><a href="">Sản phẩm nổi bật nhất</a>
		<a href="" class="more_title">Xem tất cả 
			<span><i class="fa fa-angle-right" aria-hidden="true"></i><i class="fa fa-angle-right" aria-hidden="true"></i></span>
		</a>
	</h2>
<?php $list_product=array_chunk($products, 3);?>
<?php $i=0;foreach($list_product as $products){$i++;?>
	<div class="product_list">
		<?php foreach($products as $product){?>
			<div class="product_big">
				<div class="item">
					<div class="content">
						
						<div class="img">
							<a href="<?= $product['link'] ?>">
								 <img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
							</a>
						</div>
						<h3><a href="<?= $product['link'] ?>"><span><?= HtmlFormat::sub_string(strip_tags($product['name']), 50)?></span> </a></h3>
						<?php if($product['price_market']){?>
							<p class="price_all"> <?= number_format($product['price_market'], 0, '', '.') . 'VNĐ' ?></p>
						<?php }?>
						<?php if($product['price_market']){?>
							<p class="price_new"><?= number_format($product['price'], 0, '', '.') . 'VNĐ' ?></p>
						<?php }?>
						<div class="link_product">
							<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
						<a href="/cach-tinh-tra-gop-pde,11188?price=<?= $product['price'];?>">Mua trả góp</a>
						</div>
					</div>
				</div>
				<div class="content_text">
					 <?= $product['product_info']['product_sortdesc'] ?>
					
				</div>
			</div>
		<?php break;}?>
		<div class="product_small">
				<?php $i=0;foreach($products as $product){$i++; if($i>=2){?>
				<div class="item">
					<div class="img">
						<a href="<?= $product['link'] ?>">
									 <img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
								</a>
					</div>
					<div class="content">
						<h3><a href="<?= $product['link'] ?>"><span><?= HtmlFormat::sub_string(strip_tags($product['name']), 50)?></span> </a></h3>
						<?php if($product['price_market']){?>
								<p class="price_all"> <?= number_format($product['price_market'], 0, '', '.') . 'VNĐ' ?></p>
							<?php }?>
							<?php if($product['price_market']){?>
								<p class="price_new"><?= number_format($product['price'], 0, '', '.') . 'VNĐ' ?></p>
							<?php }?>
						<div class="link_product">
							<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
						<a href="/cach-tinh-tra-gop-pde,11188?price=<?= $product['price'];?>">Mua trả góp</a>
						</div>
					</div>
				</div>
			<?php }}?>
		</div>
	</div>
	<?php }?>
</div>
<?php }?>