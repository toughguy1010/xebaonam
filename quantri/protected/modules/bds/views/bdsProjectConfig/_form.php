<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("BdsProjectConfig_config1_content", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("BdsProjectConfig_config2_content", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("BdsProjectConfig_config3_content", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("BdsProjectConfig_config4_content", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("BdsProjectConfig_config5_content", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("BdsProjectConfig_short_description", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'project-config-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('bds_project_config', 'basic_info'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#desc_info">
                        <?php echo Yii::t('bds_project_config', 'advance_info'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabconfig1">
                        Tùy chọn 1
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabconfig2">
                        Tùy chọn 2
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabconfig3">
                        Tùy chọn 3
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabconfig4">
                        Tùy chọn 4
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabconfig5">
                        Tùy chọn 5
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#consultant">
                        Chuyên viên tư vấn
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab_seo">
                        Hỗ trợ seo
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/basicinfo', array(
                        'model' => $model,
                        'form' => $form,
                        'listprovince' => $listprovince,
                        'listdistrict' => $listdistrict,
                        'listward' => $listward,
                    ));
                    ?>
                </div>
                <div id="desc_info" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/desc_info', array(
                        'model' => $model,
                        'form' => $form,
                        'listprovince' => $listprovince,
                        'listdistrict' => $listdistrict,
                        'listward' => $listward,
                        'news_category'=>$news_category
                    ));
                    ?>
                </div>
                <div id="tabconfig1" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/config1', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="tabconfig2" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/config2', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="tabconfig3" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/config3', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="tabconfig4" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/config4', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="tabconfig5" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/config5', array('model' => $model, 'form' => $form));
                    ?>
                </div>
                <div id="consultant" class="tab-pane">
                    <?php
                    $eventInfo = isset($eventInfo) ? $eventInfo : array();
                    $this->renderPartial('partial/consultant/consultant_rel', array(
                        'model' => $model,
                        'form' => $form,
                        'eventInfo' => $eventInfo
                    ));
                    ?>
                </div>
                <div id="tab_seo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_seo', array('model' => $model, 'form' => $form));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<?php
$this->renderPartial('script/mainscript', array('model' => $model));
?>