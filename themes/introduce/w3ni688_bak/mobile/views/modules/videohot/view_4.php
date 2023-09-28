<?php
if (count($videos)) {
?>
<div class="content-menu-video clearfix">
    <div class="row">
    <?php foreach ($videos as $video) { ?>
        <div class="col-sm-8">
            <div class="video-mv">
                    <iframe width="800" height="413" frameborder="0" src="<?php echo $video['video_embed']; ?>?autohide=1" allowfullscreen="1" allowtransparency="true">
                    </iframe>
            </div>
        </div>
        <?php } ?>
        <div class="col-sm-4">
            <div class="content-mv">
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2)); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>