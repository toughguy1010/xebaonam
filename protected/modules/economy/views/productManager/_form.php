<?php
//
$array = array('' => Yii::t('product', 'choicategory'));
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
//unset($option[0]);
//
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/main.js');
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
        CKEDITOR.replace("ProductInfo_product_desc", {
            height: 400,
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
            'id' => 'product-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
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
                    <a data-toggle="tab" href="#imagevideo">
                        <?php echo Yii::t('product', 'product_imagevideo'); ?>
                    </a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#attributes" id="pro-att-t">
                        <?php echo Yii::t('product', 'product_attribute'); ?>
                    </a>
                </li>                
                <li class="">
                    <a data-toggle="tab" href="#productSeo">
                        <?php echo Yii::t('product', 'product_seo'); ?>
                    </a>
                </li>

            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'productInfo' => $productInfo, 'form' => $form, 'option' => $option));
                    ?>
                </div>
                <div id="imagevideo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabimagevideo', array('model' => $model, 'productInfo' => $productInfo));
                    ?>
                </div>
                <div id="attributes" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabattributes', array('model' => $model, 'productInfo' => $productInfo,'attributes_cf'=>isset($attributes_cf)?$attributes_cf:null));
                    ?>
                </div>                
                <div id="productSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabseo', array('model' => $model, 'productInfo' => $productInfo, 'form' => $form));
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