<?php
//
$allowed = $model->allowed_seo;
$allowed = json_decode($allowed, true);
//
$array_seos = SiteSeo::arrayKeysSeo();
?>
<?php if (ClaUser::isSupperAdmin()) { ?>
    <div class="control-group form-group">
        <label class="col-sm-2 control-label no-padding-left">Allowed</label>
        <div class="controls col-sm-10">
            <?php foreach ($array_seos as $key => $name) { ?>
                <input type="checkbox" <?= in_array($key, $allowed) ? 'checked' : '' ?> value="<?= $key ?>" name="SiteSettings[allowed_seo][<?= $key ?>]" /> <?= $name ?>
                <br />
            <?php } ?>
        </div>
    </div>
<?php } ?>

<h2><?= Yii::t('common', 'homepage') ?></h2>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'meta_keywords', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'meta_keywords', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'meta_keywords'); ?>
        </span>
    </div>
</div>
<div class="control-group form-group">
    <?php echo $form->labelEx($model, 'meta_description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'meta_description', array('class' => 'span9 col-sm-12')); ?>
        <span class="help-inline">
            <?php echo $form->error($model, 'meta_description'); ?>
        </span>
    </div>
</div>

<?php
$seos = SiteSeo::getSeoSite();
foreach ($array_seos as $key => $name) {
    if (in_array($key, $allowed)) {
        ?>
        <h2><?= $name ?></h2>
        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Meta Title</label>
            <div class="controls col-sm-10">
                <input type="text" value="<?= isset($seos[$key]['meta_title']) ? $seos[$key]['meta_title'] : '' ?>" name="SiteSeo[<?= $key ?>][meta_title]" class="span9 col-sm-12" />
            </div>
        </div>
        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Meta Keywords</label>
            <div class="controls col-sm-10">
                <input type="text" value="<?= isset($seos[$key]['meta_keywords']) ? $seos[$key]['meta_keywords'] : '' ?>" name="SiteSeo[<?= $key ?>][meta_keywords]" class="span9 col-sm-12" />
            </div>
        </div>
        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left">Meta Description</label>
            <div class="controls col-sm-10">
                <textarea name="SiteSeo[<?= $key ?>][meta_description]" class="span9 col-sm-12"><?= isset($seos[$key]['meta_description']) ? $seos[$key]['meta_description'] : '' ?></textarea>
            </div>
        </div>
        <?php
    }
}
?>

<div class="control-group form-group buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
</div>