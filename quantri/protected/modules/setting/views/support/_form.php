<div class="support">
    <div class="list-support">
        <?php
        if ($data && is_array($data)) {
            foreach ($data as $dt) {
                $this->renderPartial('form/item', array('data' => $dt));
            }
        }
        ?>
    </div>
    <a href="#" class="btn btn-sm btn-info support-add"><i class="icon-plus"></i><?php echo Yii::t('support', 'add'); ?></a>
    <br>
    <br>
    <a href="<?php echo Yii::app()->request->getRequestUri() ?>" class="btn btn-primary support-save" id="saveData">
        <i class="icon-check"></i>
        <?php echo Yii::t('common', 'update'); ?>
    </a>
</div>
<?php
$this->renderPartial('script');
?>