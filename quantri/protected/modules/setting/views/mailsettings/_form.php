<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'mail-settings-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>

<?php
Yii::app()->clientScript->registerScript('mailsettings', "
        jQuery(document).on('click','.addattri',function(){
            var length  = jQuery('#mailattributes').find('.attributeitem').length;
            if(length==1){
                jQuery('#mailattributes').find('.attributeitem').find('.removeattri').css({'display':'inline-block'});
            }
            var thi = jQuery(this);
            jQuery(thi).parents('.attributeitem').after('<div class=\"attributeitem controls row\"><input name=\"akey[]\" class=\"col-sm-5\" type=\"text\" placeholder=\"Key\" value=\"\"><input name=\"ades[]\" class=\"col-sm-5\" type=\"text\" placeholder=\"Description\" value=\"\"><span class=\"help-inline action\"><i class=\"addattri icon-plus\"></i><i class=\"removeattri icon-minus\"></i></span></div>');           
            return false;
        });
        
        jQuery(document).on('click', '.removeattri', function() {
            var length  = jQuery('#mailattributes').find('.attributeitem').length;
            if (length > 1) {
                var thi = jQuery(this);
                jQuery(thi).parents('.attributeitem').remove();
                if(length == 2)
                    jQuery('#mailattributes').find('.attributeitem').find('.removeattri').fadeOut('fast');
            }
            return false;
        });
        
        CKEDITOR.replace('MailSettings_mail_msg',{
            height: 300
        });
    ");
?>
<style>
    #mailattributes .controls{margin-left: 0px;}
    #mailattributes .action{line-height: 30px;padding-top: 5px;}
    /*    #mailattributes .action *{font-size: 12px;}*/
    #mailattributes .action i{margin: 10px 5px; cursor: pointer; float: left;}
    #mailattributes .attributeitem{margin-top: 8px;}
</style>

<table class="table">
    <tr>
        <td width="60%" style="border-right: 1px solid #CCC; padding-right: 0px; padding-bottom: 0px;">
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'mail_key', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php
                    $params = array('class' => 'span12 col-sm-12');
                    if (!ClaUser::isSupperAdmin()) {
                        $params['readOnly'] = true;
                    }
                    echo $form->textField($model, 'mail_key', $params);
                    ?>
                    <?php echo $form->error($model, 'mail_key'); ?>
                </div>
            </div>

            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'mail_title', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php echo $form->textField($model, 'mail_title', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'mail_title'); ?>
                </div>
            </div>

            <div class="control-group form-group no-border">
                <?php echo $form->labelEx($model, 'mail_subject', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php echo $form->textField($model, 'mail_subject', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'mail_subject'); ?>
                </div>
            </div>
            <div class="control-group form-group no-border" style="border-bottom:none;">
                <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'description'); ?>
                </div>
            </div>
        </td>
        <?php
        $attrs = $model->decodeAttribute();
        $cattr = count($attrs);
        ?>
        <td width="40%" style="padding-bottom: 0px;">
            <div id="mailattributes">
                <div class="controls">
                    <label><?php echo Yii::t('mail', 'mail_attributes'); ?></label>
                </div>
                <?php
                if ($attrs && $cattr) {

                    foreach ($attrs as $key => $att) {
                        ?>
                        <div class="attributeitem controls row">
                            <input name="akey[]" class="col-sm-5" type="text" placeholder="Key" value="<?php echo $key; ?>">
                            <input name="ades[]" class="col-sm-5" type="text" placeholder="Description" value="<?php echo $att; ?>">
                            <span class="help-inline action">
                                <i class="addattri icon-plus"></i>
                                <i class="removeattri icon-minus"></i>
                            </span>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="attributeitem controls row">
                        <input name="akey[]" class="col-sm-5" type="text" placeholder="Key" value="">
                        <input name="ades[]" class="col-sm-5" type="text" placeholder="Description" value="">
                        <span class="help-inline action">
                            <i class="addattri icon-plus"></i>
                            <i class="removeattri icon-minus" style="display: none;"></i>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'mail_msg', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-12 no-padding-left">
                    <?php echo $form->textArea($model, 'mail_msg', array('class' => 'col-sm-12', 'style' => 'min-height: 300px;')); ?>
                    <?php echo $form->error($model, 'mail_msg'); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
              <div class="control-group form-group no-border" style="border-bottom:none;">
                <?php echo $form->labelEx($model, 'for_common', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php echo $form->checkBox($model, 'for_common', array('class' => 'checkbox')); ?>
                    <?php echo $form->error($model, 'for_common'); ?>
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="control-group form-group buttons" style="border-bottom: none;">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('mail', 'mail_create') : Yii::t('mail', 'mail_update'), array('class' => 'btn btn-info')); ?>
</div>
<?php $this->endWidget(); ?>

