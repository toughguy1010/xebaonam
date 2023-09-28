 <!--js-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="form-group  w3-form-group">
    <label class="col-sm-<?php echo $labelClass; ?> control-label w3-form-label<?php echo ($field['field_required']) ? ' required' : ''; ?>">
        <?php echo Yii::t('common', $field['field_label']); ?>
        <?php if ($field['field_required']) { ?>
            <span class="required">*</span>
        <?php } ?>
    </label>
    <div class="col-sm-<?php echo 12 - $labelClass; ?> w3-form-field">
        <div class="input-group">
            <div class="g-recaptcha" data-sitekey="<?php echo $field['field_options']['site_key']; ?>"></div>
        </div>
    </div>
</div>