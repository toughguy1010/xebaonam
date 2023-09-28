<div class="tabbable">
    <ul class="nav nav-tabs" id="myTabSlides">
        <li class="active">
            <a data-toggle="tab" href="#slide1">
                <?php echo Yii::t('media', 'Slide'); ?><span class="slide_number">1</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="slide1" class="tab-pane active">
            <?php
            $this->renderPartial('partial/_slide_settings', array('model' => $model, 'SliderSetting' => $SliderSetting, 'form' => $form));
            ?>
        </div>
    </div>
</div>