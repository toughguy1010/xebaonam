<div class="form-group w3-form-group">
    <label class="col-sm-<?php echo $labelClass; ?> control-label w3-form-label<?php echo ($field['field_required']) ? ' required' : ''; ?>">
        <?php echo Yii::t('common', $field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-<?php echo 12 - $labelClass; ?> w3-form-field">
        <?php foreach ($field['field_options']['options'] as $option) { ?>
            <?php echo CHtml::radioButton(Forms::getSubmitName($field), $option['checked'],array(
                'value' => (isset($option['value']) ? $option['value'] : ''),
                )); ?>
            <label><?php echo Yii::t('common', $option['label']); ?></label>
        <?php } ?>
        <?php if (isset($field['field_options']['include_other_option']) && $field['field_options']['include_other_option']) { ?>
            <?php echo CHtml::radioButton(Forms::getSubmitName($field), false, array(
                'value' => '-1',
                'name' => Forms::getSubmitName($field),
                )); ?>
            <label><?php echo Yii::t('common', 'other'); ?></label>
            <?php echo CHtml::textField($field['cid'] . 'other'); ?>
        <?php } ?>

    </div>
</div>