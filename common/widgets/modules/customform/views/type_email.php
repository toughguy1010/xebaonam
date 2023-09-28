<div class="form-group w3-form-group">
    <label class="col-sm-<?php echo $labelClass; ?> control-label w3-form-label<?php echo ($field['field_required']) ? ' required' : ''; ?>">
        <?php echo Yii::t('common', $field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-<?php echo 12 - $labelClass; ?> w3-form-field">
        <?php echo CHtml::emailField(Forms::getSubmitName($field), '', array('class' => "form-control w3-form-input input-email")); ?>
        <?php echo $form->error($model, $field['field_key']); ?>
    </div>
</div>