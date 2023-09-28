<?php
/* @var $this AffiliateLinkController */
/* @var $model AffiliateLink */

$this->breadcrumbs = array(
    'Affiliate Links' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List AffiliateLink', 'url' => array('index')),
    array('label' => 'Manage AffiliateLink', 'url' => array('admin')),
);
?>

<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::app()->controller->action->id != "update" ? Yii::t('shop', 'create') : Yii::t('shop', 'update'); ?></h4>
        <div class="widget-toolbar no-border">
            <a onclick="submit_shop_form();" style="" class="btn btn-xs btn-primary" id="saveproduct" >
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>

    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php $this->renderPartial('_form', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

