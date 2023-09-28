<?php
//
//$array = array('' => Yii::t('product', 'choicategory'));
//$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
//unset($option[0]);
//
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.css"></script>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        //
        CKEDITOR.replace("RealEstateProjectInfo_description", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        //
        CKEDITOR.replace("RealEstateProjectInfo_map", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        //
        CKEDITOR.replace("RealEstateProjectInfo_traffic", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        //
        CKEDITOR.replace("RealEstateProjectInfo_target", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'realestate-project-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('product', 'product_basicinfo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tabdetail">
                        <?php echo Yii::t('realestate', 'tabdetail'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tabtrafic">
                        <?php echo Yii::t('realestate', 'tabtrafic'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#tabimgvideo">
                        <?php echo Yii::t('realestate', 'tabimagevideo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#eventVideosRel">
                        <?php echo Yii::t('event', 'videos_rel'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#realestateSeo">
                        <?php echo Yii::t('realestate', 'realestateSeo'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'form' => $form, 'listdistrict' => $listdistrict, 'listprovince' => $listprovince, 'news_category' => $news_category,'realestateCategory'=>$realestateCategory));
                    ?>
                </div>
                <div id="tabdetail" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabdetail', array('model' => $model, 'form' => $form, 'news_category' => $news_category, 'real_estate_project_info' => $real_estate_project_info));
                    ?>
                </div>
                <div id="tabtrafic" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabtrafic', array('model' => $model, 'form' => $form, 'news_category' => $news_category, 'real_estate_project_info' => $real_estate_project_info));
                    ?>
                </div>
                <div id="tabimgvideo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabimagevideo', array('model' => $model, 'form' => $form, 'news_category' => $news_category, 'real_estate_project_info' => $real_estate_project_info));
                    ?>
                </div>

                <div id="eventVideosRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/video/video_rel', array(
                        'model' => $model,
                        'form' => $form,
                    ));
                    ?>
                </div>
                <div id="realestateSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabseo', array('model' => $model, 'real_estate_project_info' => $real_estate_project_info, 'form' => $form));
                    ?>
                </div>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
        </div>
        <?php
        $this->endWidget();
        ?>
    </div><!-- form -->
</div>
<?php
$this->renderPartial('script/mainscript', array('model' => $model));
?>