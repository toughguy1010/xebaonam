<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::t('common', 'update') . ' sitemap.xml'; ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sitemap-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                    ));
                    ?>
                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left"><?= Yii::t('site', 'update_sitemap') ?></label>
                        <div class="controls col-sm-4">
                            <div class="row" style="margin: 10px 0px;">
                                <?php echo CHtml::fileField('sitemap', $sitemap); ?>
                            </div>
                        </div>
                        <div class="controls control-label col-sm-2">
                            <?php if (file_exists($sitemap)) { ?>
                                <a href="<?= 'http://' . Yii::app()->siteinfo['domain_default'] . '/tesst/changeRoute?basepath=/sitemap.xml'; ?>"
                                   class="icon-search" target="_blank"> <?= Yii::t('site', 'view_sitemap') ?></a>
                            <?php } else {
                                echo Yii::t('site', 'website_not_sitemap');
                            } ?>
                        </div>
                        <div class="controls control-label col-sm-2">
                            <?php if (file_exists($sitemap)) { ?>
                                <a href="<?= Yii::app()->createUrl('site/updateSitemap', ['download' => true]) ?>"
                                   class="icon-download"> <?= Yii::t('site', 'download') ?></a>
                            <?php } ?>
                        </div>
                        <div class="controls control-label col-sm-2">
                            <a href="<?= Yii::app()->createUrl('site/createsitemap') ?>"
                               class="icon-plus auto-create"> Tạo tự động</a>
                        </div>
                    </div>

                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.auto-create').click(function () {
        if (confirm("Tạo tự động sẽ mất đi sitemap cũ. Bạn vẫn muốn tiếp tục?")) {
            return true;
        }
        return false;
    })
</script>
