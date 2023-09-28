<div class="form-group w3-form-group">
    <label class="col-sm-<?php echo $labelClass; ?> control-label w3-form-label<?php echo ($field['field_required']) ? ' required' : ''; ?>">
        <?php echo Yii::t('common', $field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-<?php echo 12 - $labelClass; ?> w3-form-field">
        <?php
        $this->widget('application.widgets.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'mode' => 'date',
            'name' => Forms::getSubmitName($field),
            'options' => array(
                'buttonImageOnly' => true,
                'dateFormat' => $field['field_options']['dateformat'],
                'changeMonth' => true,
                'changeYear' => true,
                'tabularLevel' => null,
                'yearRange' => '1970:' . (date('Y') + 20),
            ),
            'language' => '',
            'htmlOptions' => array(
                //'style' => 'color: #333',
                'autocomplete' => 'on',
                'class' => 'form-control input-text  format_date ',
            ),
        ));
        ?>
    </div>
</div>