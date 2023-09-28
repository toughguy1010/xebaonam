<div class="form-group w3-form-group">
    <label class="col-sm-2 control-label w3-form-label<?php echo ($field['field_required'])?' required':'';?>">
        <?php echo Yii::t('common',$field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-10 w3-form-field">
        <?php echo CHtml::textField(Forms::getSubmitName($field), '', array('class' => "form-control w3-form-input input-text")); ?>
         <?php echo $form->error($model, $field['field_key']); ?>
    </div>
</div>