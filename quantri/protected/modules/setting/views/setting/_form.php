<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'site-settings-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('common', 'settings'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#configseo">
                        <?php echo Yii::t('common', 'seo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#config_page">
                        <?php echo Yii::t('common', 'tab_page_size'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#config_header_footer">
                        Ẩn hiện header, footer
                    </a>
                </li>
                <li class="mail_config" style="display: none">
                    <a data-toggle="tab" href="#config_mail_send">
                        Cấu hình mail gửi đi
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/basicinfo', array('model' => $model, 'form' => $form, 'shop_store' => $shop_store));
                    ?>
                </div>
                <div id="configseo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabseo', array('model' => $model, 'form' => $form, 'model_seo' => $model_seo));
                    ?>
                </div>
                <div id="config_page" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_page_size', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="config_header_footer" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_rules_header', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="config_mail_send" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_config_mail_send', array('model' => $model, 'config_mail' => $config_mail, 'form' => $form));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        if ($('#SiteSettings_config_mail_send').is(':checked')) {
            $('.mail_config').show();
        } else {
            $('.mail_config').hide();
        }
    });
</script>