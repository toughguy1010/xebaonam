<?php
    $array_shop_store = array();
    $shopdf = [];
    if (count($shopstore)) {
        $array_shop_store = array();
        foreach ($shopstore as $shop) {
            if(!$shopdf) {
                $shopdf = $shop;
            }
            $array_shop_store[$shop['province_name']][] = $shop;
        }
    }
?>
<div class="addres_shop">
		<div class="container">
			<div class="list_item">
				
					<div class="item_address">
						<?php foreach ($array_shop_store as $key => $shops) { ?>
						<h3> <?= $key ?></h3>
						 <?php foreach ($shops as $shop) { ?>
						 	
						<a href="<?= $shop['link'] ?>" data-img="<?= ClaHost::getImageHost() . $shop['avatar_path'] . 's400_400/' . $shop['avatar_name']; ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> <span>  <?= $shop['name'] ?></span></a>
						<?php } ?>
						<?php } ?>
					</div>
				<div class="item_address">
					<h3>Hà Nội</h3>
					<div class="img_big_shop">
						<?php $i=0;foreach ($array_shop_store as $key => $shops) { ?>
							<?php foreach ($shops as $shop) {$i++; ?>
								<div class="tab <?= ($i==1)?'active':''?>">
									<?php $shop1 = ShopStore::model()->findByPk($shop['id']); $img=$shop1->getImages();?>
									<div class="slider_main">
										<section class="big_albums  slider-for">
											<?php foreach ($img as $s) { ?>
												
												<div class="item">
													<img  data-lazy="<?= ClaHost::getImageHost() . $s['path'] . 's400_400/' . $s['name']; ?>" >
												</div>
											<?php } ?>

										</section>
										<section class="small_albums  slider-nav">
											<?php foreach ($img as $s) { ?>
												<div class="item">
													<img  data-lazy="<?= ClaHost::getImageHost() . $s['path'] . 's400_400/' . $s['name']; ?>" >
												</div>
											<?php } ?>
										</section>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
		.tab{
			display: none;
		}
		.tab.active{
			display: block;
		}
	</style>