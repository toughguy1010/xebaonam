<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('bds_project_config', 'bds_project_update'); ?></h4>
        <div class="widget-toolbar no-border">
            <a style="" class="btn btn-xs btn-primary" id="save_project_config" href="#" validate="<?php echo Yii::app()->createUrl('bds/bdsProjectConfig/validate'); ?>">
                <i class="icon-ok"></i>
                <?php echo Yii::t('bds_common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <?php
            $this->renderPartial('_form', array(
                'model' => $model,
                'listprovince' => $listprovince,
                'listdistrict' => $listdistrict,
                'listward' => $listward,
                'news_category'=>$news_category
            ));
            ?>
        </div>
    </div>
</div>