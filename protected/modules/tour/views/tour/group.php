<?php if (count($tours)) { ?>
    <div class="tour-group"> 
        <div class="category-result">
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6">
                            <span><?php echo Yii::t('tour', 'tour_result', array('{result}' => $totalitem)); ?></span>
                        </div>
                        <div class="col-xs-6 col-sm-3 pull-right">
                            <?php
                            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK1));
                            ?>
                        </div>
                        <div class="col-xs-6 col-sm-3 pull-right">
                            <?php
                            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list grid">
            <?php
            foreach ($tours as $tour) {
                ?>
                <div class="list-item">
                    <div class="list-content">
                        <div class="list-content-box">
                            <div class="list-content-img">
                                <a href="<?php echo $tour['link']; ?>">
                                    <img src="<?php echo ClaHost::getImageHost() . $tour['avatar_path'] . 's150_150/' . $tour['avatar_name'] ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class='tour-page'>
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    </div>
<?php } else { ?>
    <p class="text-info">
        <?php Yii::t('tour', 'tour_no_result'); ?>
    </p>
<?php } ?>
