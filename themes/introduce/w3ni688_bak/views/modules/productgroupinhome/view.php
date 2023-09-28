
<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<?php
foreach ($data as $cat) {

	
	?>
	<div class="list_product_category">
		<div class="title_product_pc">
			<h2><a class="title-need-bold" href=" <?= $cat['link']; ?>"> <?= $cat['name']; ?></a></h2>

		</div>


		<?php if(count( $cat['products'])){?>
			<div class="slider_product owl-carousel owl-theme">
				<?php foreach ($cat['products'] as $product) { ?>
					<div class="item">
						<div class="img">
							<a href="<?= $product['link'] ?>">
								<img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
							</a>
						</div>
						<div class="content">
							<h3><a href="<?= $product['link'] ?>"><span><?= HtmlFormat::sub_string(strip_tags($product['name']), 50)?></span> 
							</a></h3>
							<?php if($product['price_market'] && $product['price_market']>0){ ?>
								<p class="price_all"> <?= number_format($product['price_market'], 0, '', '.') . 'VNĐ' ?></p>
							<?php }?>
							<?php if($product['price'] && $product['price']>0){?>
								<p class="price_new"><?= number_format($product['price'], 0, '', '.') . 'VNĐ' ?></p>
							<?php }?>
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
								</div>
							</div>
						</div>
					<?php }?>
				</div>
			<?php }?>
		</div>

	<?php }?>
