<div class="widget widget-box">
    <div class="widget-header"><span class="title"><?php echo Yii::t('album','album_update'); ?></span></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php $this->renderPartial('_form', array('model'=>$model, 'images'=>$images, 'option_category' => $option_category)); ?>
        </div>
    </div>
</div>