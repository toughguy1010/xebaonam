<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<?php
foreach ($cateinhome as $cat) {

	if (!isset($data[$cat['cat_id']]['products']) || !count($data[$cat['cat_id']]['products']))
		continue;
	?>
	<div class="list_product_category">
		<div class="title_product_pc">
			<h2> <a href=" <?= $category['link']; ?>"> <?= $cat['cat_name']; ?></a></h2>
			<div class="list_category_pc">
				<ul>
					<?php
						$claCategory = new ClaCategory(array('create' => true, 'type' => 'product'));
						$claCategory->application = false;
						$cat_child = $claCategory->getSubCategory($cat['cat_id']);
						if(count($cat_child)){?>
							<?php $i=0;foreach($cat_child as $cat2){$i++;if($i<=5){?>
								<li><a href="<?= $cat2['link']; ?>"><?= $cat2['cat_name']; ?></a></li>
							<?php } }?>

							<?php
						}

					?>
					<li>
						<a href="<?= $cat['link']; ?>" class="more_title">
							Xem tất cả
							<span><i class="fa fa-angle-right" aria-hidden="true"></i><i class="fa fa-angle-right" aria-hidden="true"></i></span>
						</a>
					</li>
				</ul>
			</div>
		</div>


		<div class="slider_product owl-carousel owl-theme">
			<?php foreach ($data[$cat['cat_id']]['products'] as $product) {
			    $src = ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'];
			    ?>
				<div class="item">
					<div class="img">
						<a href="<?= $product['link'] ?>">
                            <?php Yii::app()->controller->renderPartial('//layouts/img_lazy', array('src'=> $src,'class' => '', 'title' => $product['name'])); ?>
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
							<a href="<?=Yii::app()->createUrl('installment/installment/index',['id' => $product['id']])?>">Mua trả góp</a>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
	</div>

	<?php }?>