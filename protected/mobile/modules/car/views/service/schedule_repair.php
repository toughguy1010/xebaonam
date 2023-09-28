<style type="text/css">
    .pop-ng label{
        display: block;
    }
</style>
<div class="buycar registered-news clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'schedule-repair-form',
        'action' => Yii::app()->createUrl('car/service/scheduleRepair', array('id' => $form_id)),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form'),
    ));
    ?>
    <div class="from-left">
        <div class="form-group w3-form-group pop-ng">
            <?php echo $form->label($model, 'title', array('class' => '')); ?>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'title', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'title'))); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <?php echo $form->label($model, 'user_name', array('class' => '')); ?>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'user_name', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'user_name'))); ?>
                <?php echo $form->error($model, 'user_name'); ?>
            </div>
        </div>

        <div class="form-group w3-form-group pop-ng  ">
            <?php echo $form->label($model, 'phone', array('class' => '')); ?>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'phone'))); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>
    </div>
    <div class="from-right">
        <div class="form-group w3-form-group pop-ng  ">
            <?php echo $form->label($model, 'address', array('class' => '')); ?>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'address', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'address'))); ?>
                <?php echo $form->error($model, 'address'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <?php echo $form->label($model, 'email', array('class' => '')); ?>
            <div class=" w3-form-field width-r ">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('common', 'email'))); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng  ">
            <?php echo $form->labelEx($model, 'time', array('class' => '')); ?>
            <div class="w3-form-field width-r">
                <?php
                $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'name' => 'CarForm[time]', //attribute name
                    'mode' => 'datetime', //use "time","date" or "datetime" (default)
                    'value' => ((int) $model->time > 0 ) ? date('d-m-Y H:i:s', (int) $model->time) : date('d-m-Y H:i:s'),
                    'language' => 'vi',
                    'options' => array(
                        'showSecond' => true,
                        'dateFormat' => 'dd-mm-yy',
                        'timeFormat' => 'HH:mm:ss',
                        'controlType' => 'select',
                        'stepHour' => 1,
                        'stepMinute' => 1,
                        'stepSecond' => 1,
                        //'showOn' => 'button',
                        'showSecond' => true,
                        'changeMonth' => true,
                        'changeYear' => false,
                        'tabularLevel' => null,
                    //'addSliderAccess' => true,
                    //'sliderAccessArgs' => array('touchonly' => false),
                    ), // jquery plugin options
                    'htmlOptions' => array(
                        'class' => 'form-control w3-form-input input-text',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'time'); ?>
            </div>
        </div>
    </div>
    <div class="form-group w3-form-group pop-ng ">
        <?php echo $form->label($model, 'content', array('class' => '')); ?>
        <div class=" w3-form-field  width-in ">
            <?php echo $form->textArea($model, 'content', array('class' => 'form-control w3-form-input input-text', 'placeholder' => Yii::t('car', 'content'))); ?>
            <?php echo $form->error($model, 'content'); ?>
        </div>
    </div>
    <div class="w3-form-group form-group">
        <div class=" w3-form-button clearfix">
            <div class="registered-action1">
                <button type="submit" class="btn btn-primary"><span>Gửi </span></button>
            </div>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>