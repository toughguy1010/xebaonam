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
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
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
                <?php if (isset(Yii::app()->siteinfo['products_360_module']) && Yii::app()->siteinfo['products_360_module'] == 1) { ?>
                    <li class="">
                        <a data-toggle="tab" href="#productPanorama">
                            <?php echo Yii::t('product', 'product_panorama'); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if (isset(Yii::app()->siteinfo['related_products_module']) && Yii::app()->siteinfo['related_products_module'] == 1) { ?>
                    <li class="">
                        <a data-toggle="tab" href="#productRel">
                            <?php echo Yii::t('product', 'product_relation'); ?>
                        </a>
                    </li>
                <?php } ?>

            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'productInfo' => $productInfo, 'shop_store' => $shop_store, 'form' => $form, 'option' => $option));
                    ?>
                </div>
                <div id="imagevideo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabimagevideo', array('model' => $model, 'productInfo' => $productInfo));
                    ?>
                </div>
                <div id="attributes" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabattributes', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => isset($attributes_cf) ? $attributes_cf : null));
                    ?>
                </div>                
                <div id="productSeo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabseo', array('model' => $model, 'productInfo' => $productInfo, 'form' => $form));
                    ?>
                </div>
                <?php if (isset(Yii::app()->siteinfo['related_products_module']) && Yii::app()->siteinfo['related_products_module'] == 1) { ?>
                    <div id="productRel" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/products', array('model' => $model));
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset(Yii::app()->siteinfo['products_360_module']) && Yii::app()->siteinfo['products_360_module'] == 1) { ?>
                    <?php if (Yii::app()->controller->action->id == "update") { ?>
                        <div id="productPanorama" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/tabpanorama', array('model' => $model, 'productInfo' => $productInfo, 'form' => $form));
                            ?>
                        </div>
                    <?php }else{ 
                        echo '<div id="productPanorama" class="tab-pane">Lưu sản phẩm trước khi tạo ảnh</div>';
                    }
                }
                ?>
            </div>
        </div>
<?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<?php
$this->renderPartial('script/mainscript', array('model' => $model));
?>