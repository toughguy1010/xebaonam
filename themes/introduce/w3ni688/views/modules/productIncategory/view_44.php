<?php
$themUrl = Yii::app()->theme->baseUrl;
?>

<div class="list_product_category">
	<h2><a href=" <?= $category['link']; ?>"> <?= $category['cat_name']; ?></a></h2>
	<div class="slider_product owl-carousel owl-theme">
		<?php foreach($products as $key=>$product){ ?>
			<div class="item">
				<div class="img">
					<a href="<?= $product['link'] ?>">
						<img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's400_400/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
					</a>
				</div>
				<div class="content">
					<h3><a href="<?= $product['link'] ?>"><?= HtmlFormat::sub_string(strip_tags($product['name']), 25)?> <img src="<?= $themUrl;?>/css/home/images/qua.png"></a></h3>
					<?php if($product['price_market']){?>
						<p class="price_all"> <?= number_format($product['price_market'], 0, '', '.') . 'VNĐ' ?></p>
					<?php }?>
					<?php if($product['price_market']){?>
						<p class="price_new"><?= number_format($product['price'], 0, '', '.') . 'VNĐ' ?></p>
					<?php }?>
					<div class="link_product">
						<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua ngay</a>
						<a href="<?php echo Yii::app()->createUrl('/economy/shoppingcart/add', array('pid' => $product['id'])); ?>">Mua trả góp</a>
					</div>
				</div>
			</div>
		<?php }?>
	</div>
</div>