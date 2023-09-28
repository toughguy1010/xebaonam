<div class="new-tour">
    <div class="title-tour clearfix">
        <div class="title-new-tour">
            <?php if ($show_widget_title) { ?>
                <h2>
                    <a href="javascript:void(0)" title="<?php echo $widget_title ?>"><?php echo $widget_title ?></a>
                </h2>
            <?php } ?>
<!--            <div class="icon-view-menu">Chọn</div>
            <div class="tab-title-new">
                <ul>
                    <li class=""><a href="#" title="#">DỊCH VỤ VÉ</a></li>
                    <li class=""><a href="#" title="#">VẬN CHUYỂN</a></li>
                    <li class=""><a href="#" title="#">DỊCH VỤ KHÁC</a></li>
                    <li class=""><a href="#" title="#">DỊCH VỤ KHÁC</a></li>
                </ul>
            </div>-->
        </div>
    </div>
    <?php if (count($tours)) { ?>
        <div class="content-tour">
            <div class="row">
                <?php foreach ($tours as $tour) { ?>
                    <div class="col-sm-3 box-product-tour">
                        <div class="product-tour">
                            <div class="img-tour">
                                <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>">
                                    <img src="<?php echo ClaHost::getImageHost(), $tour['avatar_path'], 's250_0/', $tour['avatar_name'] ?>" alt="<?php echo $tour['name'] ?>">
                                </a>
                            </div>
                            <div class="title-tour-in">
                                <h3>
                                    <a href="<?php echo $tour['link'] ?>" title="<?php echo $tour['name'] ?>"><?php echo $tour['name'] ?></a>
                                </h3>
                                <div class="checkbox-product">
                                    <a href="<?php echo $tour['link'] ?>" title="chi tiết" class="a-btn-2">
                                        <span class="a-btn-2-text"><?php echo Yii::t('common', 'detail') ?></span> 
                                    </a> 
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>