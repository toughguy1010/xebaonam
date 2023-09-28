<div class="wmap">
    <div id="map-canvas" style="width: 100%; height: 550px; background-color: #F1F1F1;"></div>
    <input type="text" class="pac-input" id="pac-input" placeholder="<?php echo Yii::t('map', 'search-help'); ?>" />
</div>
<?php $this->renderPartial('mainscript', array('model' => $model, 'map_api_key' => $map_api_key)); ?>