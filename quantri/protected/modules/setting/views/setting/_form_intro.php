<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script>
    jQuery(document).ready(function () {
        $('#ck-check').on("click", function () {
            if (this.checked) {
                CKEDITOR.replace("SiteIntroduces_sortdesc", {
                    height: 400,
                    language: '<?php echo Yii::app()->language ?>'
                });
            } else {
                var a = CKEDITOR.instances['SiteIntroduces_sortdesc'];
                if (a) {
                    a.destroy(true);
                }

            }
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'site-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>

        <?php
        Yii::app()->clientScript->registerScript('sitesettings', "
             CKEDITOR.replace('SiteIntroduces_description');
    jQuery('#SiteIntroduceavatar_form').ajaxUpload({
        url : '" . Yii::app()->createUrl("/setting/setting/uploadava",array(Yii::app()->request->csrfTokenName=>Yii::app()->request->getCsrfToken())) . "',
        name: 'file',
        onSubmit: function() {
        },
        onComplete: function(result) {
            var obj = $.parseJSON(result);
            if(obj.status == '200') {
                if(obj.data.realurl){
                   jQuery('#SiteIntroduces_avatar').val(obj.data.avatar);
                        if (jQuery('#SiteIntroduceavatar_img img').attr('src')) {
                            jQuery('#SiteIntroduceavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#SiteIntroduceavatar_img').append('<img src=\"' + obj.data.realurl + '\" />');
                        }
                        jQuery('#SiteIntroduceavatar_img').css({\"margin-right\": \"10px\"});
                }
            }
        }
    });

");
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'sortdesc', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <input name="us-ck" type="checkbox" id="ck-check" value="" style="">
                <label for="ck-check" style="font-size: 12px;color: blue;pointer:cursor">Sử dụng trình soạn thảo</label>
                <?php echo $form->textArea($model, 'sortdesc', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'sortdesc'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
                <div style="clear: both;"></div>
                <div id="SiteIntroduceavatar" style="display: block; margin-top: 10px;">
                    <div id="SiteIntroduceavatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                        <?php if ($model->image_path && $model->image_name) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $model->image_path . 's100_100/' . $model->image_name; ?>" style="width: 100%;" />
                        <?php } ?>
                    </div>
                    <div id="SiteIntroduceavatar_form" style="display: inline-block;">
                        <?php echo CHtml::button(Yii::t('setting', 'btn_select_avatar'), array('class' => 'btn  btn-sm')); ?>
                    </div>
                </div>
                <?php echo $form->error($model, 'avatar'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <div class="span12">
                    <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_keywords', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_keywords'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_description', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_description'); ?>
            </div>
            <div style="clear: both;"><br/></div>
            <?php echo $form->labelEx($model, 'meta_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textArea($model, 'meta_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'meta_title'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>