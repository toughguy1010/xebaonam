<?php
//
$array = array('' => Yii::t('tour', 'choicategory'));
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
//unset($option[0]);
//
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.css"></script>
<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        $("#addCate").colorbox({width: "80%", overlayClose: false});
        //
        CKEDITOR.replace("TourInfo_price_include", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("TourInfo_schedule", {
            height: 300,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("TourInfo_policy", {
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
            'id' => 'tour-form',
            'htmlOptions' => array('class' => 'form-horizontal',  'enctype' => 'multipart/form-data',
                'role' => 'form'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('tour', 'tour_basicinfo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tabdescription">
                        <?php echo Yii::t('tour', 'tour_description'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tabplan">
                        <?php echo Yii::t('tour', 'tour_plan'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tabhotelslist">
                        <?php echo Yii::t('tour', 'tour_hotels_list'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#imagevideo">
                        <?php echo Yii::t('tour', 'tour_imagevideo'); ?>
                    </a>
                </li>            
                <li class="">
                    <a data-toggle="tab" href="#tourSeo">
                        <?php echo Yii::t('tour', 'tour_seo'); ?>
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#productNewsRel">
                        <?php echo Yii::t('product', 'news_rel'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array(
                        'model' => $model,
                        'tourInfo' => $tourInfo,
                        'form' => $form,
                        'option' => $option,
                        'options_partners' => $options_partners,
                        'options_destinations' => $options_destinations
                    ));
                    ?>
                </div>
                <div id="tabdescription" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabdescription', array('model' => $model, 'tourInfo' => $tourInfo, 'form' => $form));
                    ?>
                </div>
                <div id="tabplan" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabplan', array('model' => $model, 'tourInfo' => $tourInfo, 'form' => $form));
                    ?>
                </div>
                <div id="tabhotelslist" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabhotelslist', array('model' => $model, 'tourInfo' => $tourInfo, 'form' => $form));
                    ?>
                </div>
                <div id="imagevideo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabimagevideo', array('model' => $model, 'tourInfo' => $tourInfo));
                    ?>
                </div>              
                <div id="tourSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabseo', array('model' => $model, 'tourInfo' => $tourInfo, 'form' => $form));
                    ?>
                </div>
                <div id="productNewsRel" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/news_rel', array('model' => $model));
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