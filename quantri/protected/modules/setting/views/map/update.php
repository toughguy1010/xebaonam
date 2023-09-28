<div class="widget widget-box">
    <div class="widget-header"><h4><?php echo Yii::t('map', 'map_update'); ?></h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="wmap">
                <div id="map-canvas" style="width: 100%; height: 550px; background-color: #F1F1F1;"></div>
                <input type="text" class="pac-input" id="pac-input" placeholder="<?php echo Yii::t('map', 'search-help'); ?>" />
            </div>
            <?php $this->renderPartial('mainscript', array('model' => $model, 'map_api_key' => $map_api_key)); ?>
        </div>
    </div>
</div>