<div class="row">
    <div class="col-xs-12 no-padding">
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
    </div>
</div>
<div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="myTab3">
        <li class="active">
            <a data-toggle="tab" href="#slider_layout">
                <i class="icon-arrows-alt bigger-110"></i>
                <?php echo Yii::t('media', 'slider_layout'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_slideshow">
                <i class="icon-film bigger-110"></i>
                <?php echo Yii::t('media', 'slider_slideshow'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_appearance">
                <i class="icon-paint-brush bigger-110"></i>
                <?php echo Yii::t('media', 'slider_appearance'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_navigation_area">
                <i class="icon-expand bigger-110"></i>
                <?php echo Yii::t('media', 'slider_navigation_area'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_thumnail_navigation">
                <i class="icon-th-large bigger-110"></i>
                <?php echo Yii::t('media', 'slider_thumnail_navigation'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_videos">
                <i class="icon-video-camera bigger-110"></i>
                <?php echo Yii::t('media', 'slider_videos'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_misc">
                <i class="icon-gear  bigger-110"></i>
                <?php echo Yii::t('media', 'slider_misc'); ?>
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#slider_logo">
                <i class="icon-bookmark-o bigger-110"></i>
                <?php echo Yii::t('media', 'slider_logo'); ?>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="slider_layout" class="tab-pane active">
            <?php
            $this->renderPartial('partial/_layout', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_slideshow" class="tab-pane">
            <?php
            $this->renderPartial('partial/_slideshow', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_appearance" class="tab-pane">
            <?php
            $this->renderPartial('partial/_appearance', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_navigation_area" class="tab-pane">
            <?php
            $this->renderPartial('partial/_navigation_area', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_thumnail_navigation" class="tab-pane">
            <?php
            $this->renderPartial('partial/_thumnail_navigation', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_videos" class="tab-pane">
            <?php
            $this->renderPartial('partial/_videos', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_misc" class="tab-pane">
            <?php
            $this->renderPartial('partial/_misc', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
        <div id="slider_logo" class="tab-pane">
            <?php
            $this->renderPartial('partial/_logo', array('model' => $model, 'form' => $form, 'SliderSetting' => $SliderSetting));
            ?>
        </div>
    </div>
</div>