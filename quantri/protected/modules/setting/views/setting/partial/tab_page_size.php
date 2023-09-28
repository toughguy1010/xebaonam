<?php
//
$allowed_page_size = $model->allowed_page_size;
$allowed = explode(',', $allowed_page_size);
//
$ary_pagesize = SitePageSize::getPageKeyArr();
?>
<?php if (ClaUser::isSupperAdmin()) { ?>
    <div class="control-group form-group">
        <label class="col-sm-2 control-label no-padding-left">Allowed</label>
        <div class="controls col-sm-10">
            <?php
            $n = 0;
            foreach ($ary_pagesize as $key => $name) { ?>
                <input id="<?= $key ?>" type="checkbox" <?= in_array($key, $allowed) ? 'checked' : '' ?>
                       value="<?= $key ?>"
                       name="SiteSettings[allowed_page_size][<?= $n++ ?>]"/>
                <label for="<?= $key ?>"><?= $name ?></label>
                <br/>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php
$pagesizes = SitePageSize::getPageSizeSite();
foreach ($ary_pagesize as $key => $name) {
    if (in_array($key, $allowed)) {
        ?>
        <div class="control-group form-group">
            <label class="col-sm-2 control-label no-padding-left"><?= $name ?></label>
            <div class="controls col-sm-6">
                <input type="text" value="<?= isset($pagesizes[$key]) ? $pagesizes[$key] : '' ?>"
                       name="SitePageSize[<?= $key ?>]" class="span9 col-sm-12"
                       placeholder="<?= Yii::t('common', 'page_size') . ' - ' . $name ?>"/>
            </div>
        </div>
        <?php
    }
}
?>
<div class="control-group form-group buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'update') : Yii::t('common', 'update'), array('class' => 'btn btn-info')); ?>
</div>