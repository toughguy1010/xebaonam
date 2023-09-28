<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('bds_project', 'project_create') : Yii::t('bds_project', 'project_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'project-form',
                        'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'logo', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'logo', array('class' => 'span12 col-sm-12')); ?>
                            <div id="BdsProjectlogo" style="display: block; margin-top: 0px;">
                                <div id="BdsProjectlogo_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->logo) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->logo_path && $model->logo_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $model->logo_path, 's100_100/', $model->logo_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="BdsProjectlogo_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_logo'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'logo'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                            <div id="BdsProjectavatar" style="display: block; margin-top: 0px;">
                                <div id="BdsProjectavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                                    <?php if ($model->avatar_path && $model->avatar_name) { ?>
                                        <img src="<?php echo ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>" style="width: 100%;" />
                                    <?php } ?>
                                </div>
                                <div id="BdsProjectavatar_form" style="display: inline-block;">
                                    <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'avatar'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'address', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'address'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('bds_project', 'project_create') : Yii::t('bds_project', 'project_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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
        jQuery('#BdsProjectavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/bds/bdsProject/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#BdsProject_avatar').val(obj.data.avatar);
                        if (jQuery('#BdsProjectavatar_img img').attr('src')) {
                            jQuery('#BdsProjectavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#BdsProjectavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#BdsProjectavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });
</script>
