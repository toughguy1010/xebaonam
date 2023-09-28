<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'course-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('course', 'course_basicinfo'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#course_description">
                        <?php echo Yii::t('common', 'label_description'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#course_advanture">
                        <?php echo Yii::t('common', 'advanture'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#schedule">
                        <?php echo Yii::t('course', 'schedule'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tabimage">
                        <?php echo Yii::t('common', 'Image'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#courseNewsRel">
                        <?php echo Yii::t('event', 'news_rel'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#courseVideosRel">
                        <?php echo Yii::t('event', 'videos_rel'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#courseSeo">
                        <?php echo Yii::t('course', 'course_seo'); ?>
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
                    ));
                    ?>
                </div>
                <div id="course_description" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_description', array(
                        'model' => $model,
                        'form' => $form,
                        'courseInfo' => $courseInfo
                    ));
                    ?>
                </div>

<!--                <div id="course_advanture" class="tab-pane">-->
<!--                    --><?php
//                    $this->renderPartial('partial/tab_advanture', array(
//                        'model' => $model,
//                        'form' => $form,
//                        'courseInfo' => $courseInfo
//                    ));
//                    ?>
<!--                </div>-->
                <div id="tabimage" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabimage', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="schedule" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/schedule/schedule_rel', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
                <div id="courseNewsRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/news/news_rel', array(
                        'model' => $model,
                        'form' => $form,
//                        'newsModel' => $newsModel,
                    ));
                    ?>
                </div>
                <div id="courseVideosRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/video/video_rel', array(
                        'model' => $model,
                        'form' => $form,
//                        'videosModel' => $videosModel,
                    ));
                    ?>
                </div>
                <div id="courseSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_seo', array(
                        'model' => $model,
                        'form' => $form,
                        'courseInfo' => $courseInfo
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<?php
$this->renderPartial('script/mainscript');
?>