<div class="widget widget-box no-border">
    <div class="widget-header"><h4>
            <?php echo Yii::t('course', 'add_schedule') . " '" . $model->name . "'"; ?>
        </h4></div>
    <div class="widget-body" style="border: none;">
        <div class="widget-main">
            <div class="row" style="overflow: hidden;">
                <div class="col-xs-12">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'schedule-groups-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>

                    <div class="form-group no-margin-left">
                        <?php echo $form->labelEx($courseSchedule, 'course_open', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <div class="input-group input-group-sm">
                                <?php
                                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                    'model' => $courseSchedule, //Model object
                                    'name' => 'CourseSchedule[course_open]', //attribute name
                                    'mode' => 'date',
                                    'value' => ((int)$courseSchedule->course_open > 0) ? date('d-m-Y', (int)$courseSchedule->course_open) : '',
                                    'language' => Yii::app()->language,
                                    'options' => array(
                                        'showSecond' => true,
                                        'dateFormat' => 'dd-mm-yy',
                                        'timeFormat' => 'HH:mm:ss',
                                        'controlType' => 'select',
                                        //'showOn' => 'button',
                                        'tabularLevel' => null,
                                        'addSliderAccess' => true,
                                        'sliderAccessArgs' => array('touchonly' => false),
                                    ), // jquery plugin options
                                    'htmlOptions' => array(
                                        'class' => 'form-control',
                                    )
                                ));
                                ?>
                                <span class="input-group-addon"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                        <?php echo $form->labelEx($courseSchedule, 'course_finish', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <div class="input-group input-group-sm">
                                <?php
                                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                    'model' => $courseSchedule, //Model object
                                    'name' => 'CourseSchedule[course_finish]', //attribute name
                                    'mode' => 'date',
                                    'value' => ((int)$courseSchedule->course_open > 0) ? date('d-m-Y', (int)$courseSchedule->course_open) : '',
                                    'language' => Yii::app()->language,
                                    'options' => array(
                                        'showSecond' => true,
                                        'dateFormat' => 'dd-mm-yy',
                                        'timeFormat' => 'HH:mm:ss',
                                        'controlType' => 'select',
                                        //'showOn' => 'button',
                                        'tabularLevel' => null,
                                        'addSliderAccess' => true,
                                        'sliderAccessArgs' => array('touchonly' => false),
                                    ), // jquery plugin options
                                    'htmlOptions' => array(
                                        'class' => 'form-control',
                                    )
                                ));
                                ?>
                                <span class="input-group-addon"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group no-margin-left">
                        <?php echo $form->labelEx($courseSchedule, 'price_me', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <?php echo $form->textField($courseSchedule, 'price', array('class' => 'numberFormat span2 col-sm-2')); ?>
                        </div>
                        <?php echo $form->labelEx($courseSchedule, 'price_member', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-4">
                            <?php echo $form->textField($courseSchedule, 'price_member', array('class' => 'numberFormat span2 col-sm-2')); ?>
                        </div>
                    </div>
                    <div class="widget-toolbar no-border">
                        <?php echo CHtml::submitButton(Yii::t('course', 'create_schedule'), array('class' => 'btn btn-xs btn-primary', 'id' => 'btnProductSave')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->renderPartial('partial/schedule/script', array('isAjax' => $isAjax)); ?>