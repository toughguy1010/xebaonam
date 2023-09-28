<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sms-settings-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>

<?php
Yii::app()->clientScript->registerScript('smssettings', "
        jQuery(document).on('click','.addattri',function(){
            var length  = jQuery('#smsattributes').find('.attributeitem').length;
            if(length==1){
                jQuery('#smsattributes').find('.attributeitem').find('.removeattri').css({'display':'inline-block'});
            }
            var thi = jQuery(this);
            jQuery(thi).parents('.attributeitem').after('<div class=\"attributeitem controls row\"><input name=\"akey[]\" class=\"col-sm-5\" type=\"text\" placeholder=\"Key\" value=\"\"><input name=\"ades[]\" class=\"col-sm-5\" type=\"text\" placeholder=\"Description\" value=\"\"><span class=\"help-inline action\"><i class=\"addattri icon-plus\"></i><i class=\"removeattri icon-minus\"></i></span></div>');           
            return false;
        });
        
        jQuery(document).on('click', '.removeattri', function() {
            var length  = jQuery('#smsattributes').find('.attributeitem').length;
            if (length > 1) {
                var thi = jQuery(this);
                jQuery(thi).parents('.attributeitem').remove();
                if(length == 2)
                    jQuery('#smsattributes').find('.attributeitem').find('.removeattri').fadeOut('fast');
            }
            return false;
        });
    ");
?>
<style>
    #smsattributes .controls{margin-left: 0px;}
    #smsattributes .action{line-height: 30px;padding-top: 5px;}
    /*    #smsattributes .action *{font-size: 12px;}*/
    #smsattributes .action i{margin: 10px 5px; cursor: pointer; float: left;}
    #smsattributes .attributeitem{margin-top: 8px;}
</style>

<table class="table">
    <tr>
        <td width="60%" style="border-right: 1px solid #CCC; padding-right: 0px; padding-bottom: 0px;">
            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'key', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php echo $form->textField($model, 'key', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'key'); ?>
                </div>
            </div>

            <div class="control-group form-group">
                <?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-9">
                    <?php echo $form->textField($model, 'title', array('class' => 'span12 col-sm-12')); ?>
                    <?php echo $form->error($model, 'title'); ?>
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
            <div id="smsattributes">
                <div class="controls">
                    <label><?php echo Yii::t('sms','attributes'); ?></label>
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
                <?php echo $form->labelEx($model, 'message', array('class' => 'col-sm-3 control-label no-padding-left')); ?>
                <div class="controls col-sm-12 no-padding-left">
                    <?php echo $form->textArea($model, 'message', array('class' => 'col-sm-12', 'style' => 'min-height: 300px;')); ?>
                    <?php echo $form->error($model, 'message'); ?>
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
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sms','sms_create') : Yii::t('sms','sms_update'), array('class' => 'btn btn-info')); ?>
</div>
<?php $this->endWidget(); ?>

