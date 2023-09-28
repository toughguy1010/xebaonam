<div class="form-group  w3-form-group">
    <label class="col-sm-<?php echo $labelClass; ?> control-label w3-form-label<?php echo ($field['field_required']) ? ' required' : ''; ?>">
        <?php echo Yii::t('common', $field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-<?php echo 12 - $labelClass; ?> w3-form-field">
        <div class="input-group">
            <?php echo CHtml::textField(Forms::getSubmitName($field), '', array('class' => "form-control w3-form-input input-text")); ?>
            <span class="input-group-addon" style="padding: 0px 5px; min-width: 110px;">
                <?php
                $this->widget('CCaptcha', array(
                    'buttonLabel' => '<i class="ico ico-refrest"></i>',
                    'imageOptions' => array(
                        'height' => '34px',
                    ),
                ));
                ?>
            </span>
        </div>
        <?php echo $form->error($model, $field['field_key']); ?>
    </div>
</div>