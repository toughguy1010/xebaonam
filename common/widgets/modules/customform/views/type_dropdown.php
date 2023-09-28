<div class="form-group w3-form-group">
    <label class="col-sm-<?php echo $labelClass; ?> control-label w3-form-label<?php echo ($field['field_required']) ? ' required' : ''; ?>">
        <?php echo Yii::t('common', $field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-<?php echo 12 - $labelClass; ?> w3-form-field">
        <select name="<?php Forms::getSubmitName($field); ?>" class="form-control">
            <?php if (isset($field['field_options']['include_blank_option']) && $field['field_options']['include_blank_option']) { ?>
                <option value="">&nbsp;</option>
            <?php } ?>
            <?php foreach ($field['field_options']['options'] as $option) { ?>
                <option value="<?php echo (isset($option['value']) ? $option['value'] : ''); ?>">
                    <?php echo Yii::t('common', $option['label']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>