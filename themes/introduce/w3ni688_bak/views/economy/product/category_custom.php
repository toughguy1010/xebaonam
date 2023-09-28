<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<?php if ($category['cat_description'] != ''): ?>
    <div class="desc-category">
        <?= $category['cat_description']?>
    </div>
<?php endif ?>
<?php if (count($products)) { ?>
     <div class="row">
          <?php
          foreach ($products as $product) {
               ?>
               <div class="col-xs-3">
                    <div class="item-product">
                         <div class="box-product">
                              <div class="box-img-product">
                                   <?php if ($product['avatar_path'] && $product['avatar_name']) { ?>
                                        <a href="<?php echo $product['link'] ?>"
                                           title="<?php echo $product['name'] ?>">
                                             <img alt="<?php echo $product['name']; ?>"
                                                  src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>"
                                                  alt="<?php echo $product['name'] ?>">
                                        </a>
                                   <?php } else { ?>
                                        <a href="<?php echo $product['link']; ?>"
                                           title="<?php echo $product['name']; ?>">
                                             <img src="<?= $themUrl ?>/css/img/no_images.png"
                                                  alt="<?php echo $product['name'] ?>">
                                        </a>
                                   <?php } ?>
                              </div>
                              <div class="box-info-product">
                                   <h4><a href="<?php echo $product['link']; ?>">
                                             <?php echo $product['name']; ?>
                                        </a></h4>

                                   <?php if ($product['price'] && $product['price'] > 0 && $product['state'] != 0) { ?>
                                        <div class="box-price clearfix">
                                             <span><?php echo $product['price_text']; ?></span>
                                        </div>
                                        <!--                                --><?php //if ($product['price_market'] && $product['price_market'] > 0) { ?>
                                        <div class="price_old"
                                             style="text-decoration: line-through"><?php echo $product['price_market_text']; ?></div>
                                        <!--                                --><?php //} ?>
                                   <?php } else { ?>
                                        <div class="box-price clearfix">Liên hệ</div>
                                   <?php } ?>
                              </div>
                         </div>
                    </div>
               </div>
               <?php
          }
          ?>
     </div>
     <div class='box-product-page clearfix'>
          <?php
          $this->widget('common.extensions.LinkPager.LinkPager', array(
               'itemCount' => $totalitem,
               'pageSize' => $limit,
               'header' => '',
               'selectedPageCssClass' => 'active',
          ));
          ?>
     </div>
     <?php
}
?>