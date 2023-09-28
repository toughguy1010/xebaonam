<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('service', 'create') : Yii::t('service', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'language-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textArea($model, 'description', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'description'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'QuestionCampaign[start_date]', //attribute name
                                'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->start_date > 0) ? date('d-m-Y H:i:s', (int) $model->start_date) : date('d-m-Y H:i:s'),
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
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'start_date'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'to_date', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $model, //Model object
                                'name' => 'QuestionCampaign[to_date]', //attribute name
                                'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                'value' => ((int) $model->to_date > 0) ? date('d-m-Y H:i:s', (int) $model->to_date) : date('d-m-Y H:i:s'),
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
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($model, 'to_date'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->label($model, 'guests', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            $selectedGuest = array();
                            if (!$model->isNewRecord) {
                                $guests = $model->getGuests();
                                foreach ($guests as $key => $guest)
                                    $selectedGuest[$key] = array('selected' => 'selected');
                            }

                            $this->widget('common.extensions.echosen.Chosen', array(
                                'model' => $model,
                                'attribute' => 'guests',
                                'multiple' => true,
                                'data' => QuestionGuest::getGuestArr(),
                                'value' => $model->guests,
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                    'options' => $selectedGuest,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'guests'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="questionCampaignavatar" style="display: block; margin-top: 0px;">
                                <div id="questionCampaignavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost() . $model->avatar_path . 's100_100/' . $model->avatar_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="questionCampaignavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('service', 'create') : Yii::t('service', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#questionCampaignavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/service/questionCampaign/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#QuestionCampaign_avatar').val(obj.data.avatar);
                        if (jQuery('#questionCampaignavatar_img img').attr('src')) {
                            jQuery('#questionCampaignavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#questionCampaignavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#questionCampaignavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
