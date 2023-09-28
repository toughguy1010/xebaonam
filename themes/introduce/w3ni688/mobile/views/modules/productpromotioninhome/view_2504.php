<?php
if (count($promotionInHome) > 0) { ?>
     <ul class="menu-repairs menu-promotion clearfix">
          <li class=""><a href="#" title="#"><i class="icon-repairs repairs-home"></i><span>tổng hợp</span></a>
          </li>
          <?php
          $j = 0;
          $x=false;
          foreach ($promotionInHome as $promotion) {
               ++$j;
               ?>
               <li class="<?php echo ($x) ? 'active' : ''; ?>"><a
                         href="<?php echo Yii::app()->createUrl('/economy/product/promotion', array('id' => $promotion['promotion_id'], 'alias' => $promotion['alias'])) ?>"
                         title="<?php echo $promotion['name']; ?>">
                         <i class="icon-repairs repairs-home-<?php echo $j; ?>"></i>
                         <span><?php echo $promotion['name']; ?></span>
                    </a>
               </li>
               <?php
          } ?>
     </ul>
     <?php
}

