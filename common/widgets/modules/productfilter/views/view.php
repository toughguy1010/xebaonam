<div class="filter-left-contain">            
    <div style="overflow:hidden;" class="box-title-colleft-sp-sp">
        <span><b>Tìm kiếm kim cương</b><a class="icon-box20" href="<?php echo Yii::app()->createUrl('economy/product/categorySearch',array('id'=>$category->cat_id,'alias'=>$category->alias))?>"><i></i>Reset</a></span>
    </div>    
    <?php        
    if (count($attributes)) {
        foreach ($attributes as $key => $attribute) {
            if (is_int($key)) {
                if($key == 10003){
                ?> 
                    <div class="att-filter-shape box-shape-sp-sp">
                        <div class="att-title title-shape-sp-sp"><?php echo $attribute['att']['name'] ?></div>
                        <div class="att-list-box-shape shape-sp-sp clearfix">
                            <ul class="att-filter-ops-shape">
                                <?php
                                $ind=0;                               
                                foreach ($attribute['options'] as $att) {
                                    $ind++;
                                    ?>
                                    <li class="<?php if ($ind % 5 == 0) { ?>last<?php }?> <?php if ($att['checked']) { ?>active<?php } ?>">
                                        <a class="op-ft op-ft-shape kimcuong-<?php echo $ind;?> <?php if ($att['checked']) { ?>active<?php } ?>" href="<?php echo $att['link']; ?>" rel="nofollow" title="<?php echo $att['name'];?>"><i></i></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <?php $this->render('items/view_item_price',array());?>
                <?php                 
                }else{?>
                    <div class="att-filter">
                        <div class="att-title title-more-box-box"><?php echo $attribute['att']['name'] ?></div>
                        <div class="att-list-box clearfix">
                            <ul class="att-filter-ops">
                                <?php
                                $ind=0;                               
                                foreach ($attribute['options'] as $att) {
                                    $ind++;
                                    ?>
                                    <li class="<?php if ($ind % 4 == 0) { ?>last<?php }?> <?php if ($att['checked']) { ?>active<?php } ?>">
                                        <a class="op-ft <?php if ($att['checked']) { ?>active<?php } ?>" href="<?php echo $att['link']; ?>" rel="nofollow"><?php echo $att['name'];?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } 
            }
        }
        ?>
    <?php } ?>

</div>      
