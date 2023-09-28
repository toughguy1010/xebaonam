<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("BdsRealEstateInfo_description", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("BdsRealEstateInfo_history_build", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'real-estate-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('bds_common', 'basic_info'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabdescription">
                        <?php echo Yii::t('bds_common', 'description_info'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tabrelation">
                        <?php echo Yii::t('bds_common', 'relation_info'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tab_basic_info', array('model' => $model, 'form' => $form, 'real_estate_map' => $real_estate_map));
                    ?>
                </div>
                <div id="tabdescription" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_description', array('model' => $model, 'form' => $form, 'real_estateInfo' => $real_estateInfo));
                    ?>
                </div>
                <div id="tabrelation" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tab_relation_info', array('model' => $model, 'form' => $form));
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