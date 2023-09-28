<div class="form-group w3-form-group">
    <label class="col-sm-2 control-label w3-form-label<?php echo ($field['field_required'])?' required':'';?>">
        <?php echo Yii::t('common',$field['label']); ?>
         <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-10  w3-form-field">
        <?php foreach ($field['field_options']['options'] as $option) { ?>
            <?php echo CHtml::checkBox($field['cid'], $option['checked'], array('value' => (isset($option['value']) ? $option['value'] : ''), 'class' => "checkinput")); ?>
            <label><?php echo Yii::t('common',$option['label']); ?></label>
        <?php } ?>
        <?php if (isset($field['field_options']['include_other_option']) && $field['field_options']['include_other_option']) { ?>
            <?php echo CHtml::checkBox($field['cid'], false, array('value' => '-1', 'class' => "checkinput")); ?>
            <label>Other <?php echo CHtml::textField($field['cid'] . 'other'); ?></label>
        <?php } ?>
    </div>
</div>