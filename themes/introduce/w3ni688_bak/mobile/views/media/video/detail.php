<div class="content-menu-video clearfix">
    <div class="row">
        <div class="col-sm-8">
            <div class="video-mv">
                <iframe width="100%" height="100%" frameborder="0" allowtransparency="true" allowfullscreen="1" src="<?php echo $video['video_embed'] . '?autohide=1&autoplay=1'; ?>" id="videlplayer" class="lfloat">
                </iframe>
                <!--                                    <img src="css/img/video1.jpg" alt="#" title="#">-->
            </div>
        </div>
        <div class="col-sm-4">
            <div class="content-mv">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2)); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_SHOPPING_CART)); ?>
