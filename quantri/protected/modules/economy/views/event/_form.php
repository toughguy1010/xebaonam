<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>

<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'event-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('event', 'event_basicinfo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#event_description">
                        <?php echo Yii::t('event', 'label_description'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#eventSeo">
                        <?php echo Yii::t('event', 'event_seo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#eventNewsRel">
                        <?php echo Yii::t('event', 'news_rel'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#eventVideosRel">
                        <?php echo Yii::t('event', 'videos_rel'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#eventFilesRel">
                        <?php echo Yii::t('event', 'files_rel'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tab_basic_info', array(
                        'model' => $model,
                        'form' => $form,
                        'category' => $category,
                        'locations' => $locations,
                    ));
                    ?>
                </div>
                <div id="event_description" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_description', array(
                        'model' => $model,
                        'form' => $form,
                        'eventInfo' => $eventInfo
                    ));
                    ?>
                </div>
                <div id="eventSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_seo', array(
                        'model' => $model,
                        'form' => $form,
                        'eventInfo' => $eventInfo
                    ));
                    ?>
                </div>
                <div id="eventNewsRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/news/news_rel', array(
                        'model' => $model,
                        'form' => $form,
                        'eventInfo' => $eventInfo
                    ));
                    ?>
                </div>
                <div id="eventVideosRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/video/video_rel', array(
                        'model' => $model,
                        'form' => $form,
                        'eventInfo' => $eventInfo
                    ));
                    ?>
                </div>
                <div id="eventFilesRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/file/file_rel', array(
                        'model' => $model,
                        'form' => $form,
                        'eventInfo' => $eventInfo
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>