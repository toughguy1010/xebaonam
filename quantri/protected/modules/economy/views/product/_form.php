<?php
//
$array = array('' => Yii::t('product', 'choicategory'));
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
//unset($option[0]);
//
$arrayManufacturer = array('' => Yii::t('manufacturer', 'choicategory'));
$optionManufacturer = $manufacturerCategory->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arrayManufacturer);
//
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js?ver=' . VERSION); ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <!--chosen-->
    <link rel="stylesheet"
          href="<?php echo Yii::app()->request->baseUrl; ?>/js/selectize/dist/css/selectize.css"></link>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/selectize/dist/js/standalone/selectize.js"></script>
    <!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.js"></script>-->
    <!--<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.css"></script>-->
    <script type="text/javascript">
        var ta = true;
        jQuery(document).ready(function () {
            $("#addCate").colorbox({width: "80%", overlayClose: false});
            //
            CKEDITOR.replace("ProductInfo_product_desc", {
                height: 400,
                language: '<?php echo Yii::app()->language ?>'
            });
            $('#select-beast').selectize({
                create: false,
                sortField: 'text'
            });
        });
        jQuery(function ($) {
        });

    </script>

<?php
$this->renderPartial('script/stylenew');
?>
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
                        <a data-toggle="tab" href="#productextrainfo">
                            <?php echo Yii::t('product', 'product_extrainfo'); ?>
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#imagevideo">
                            <?php echo Yii::t('product', 'product_imagevideo'); ?>
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#video">
                            <?php echo Yii::t('product', 'product_video'); ?>
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" href="#attributes" id="pro-att-t">
                            <?php echo Yii::t('product', 'product_attribute'); ?>
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
                            <a data-toggle="tab" href="#imagevideodetail">
                                <?php echo Yii::t('product', 'product_imagevideoextra'); ?>
                            </a>
                        </li>
                        <?php
                        $siteinfo = Yii::app()->siteinfo;
                        if ($siteinfo['site_skin'] == 'w3ni700') {
                            ?>
                            <li class="">
                                <a data-toggle="tab" href="#productRel">
                                    <?php echo Yii::t('product', 'product_rell'); ?>
                                </a>

                            </li>
                        <?php } else { ?>
                            <li class="">
                                <a data-toggle="tab" href="#productRel">
                                    <?php echo Yii::t('product', 'product_relation'); ?>
                                </a>

                            </li>
                        <?php } ?>

                        <li class="">
                            <a data-toggle="tab" href="#product_vtRel">
                                <?php echo Yii::t('product', 'Sản phẩm cùng loại'); ?>
                            </a>

                        </li>
                        <?php
                        $siteinfo = Yii::app()->siteinfo;
                        if ($siteinfo['site_skin'] == 'w3ni700') {
                            ?>
                            <li class="">
                                <a data-toggle="tab" href="#product_inkRel">
                                    <?php echo Yii::t('product', 'product_ink'); ?>
                                </a>

                            </li>
                        <?php } ?>
                        <li class="">
                            <a data-toggle="tab" href="#productNewsRel">
                                <?php echo Yii::t('product', 'news_rel'); ?>
                            </a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#use_manual">
                                <?php echo Yii::t('product', 'news_rel_manual'); ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="">
                        <a data-toggle="tab" href="#productSeo">
                            <?php echo Yii::t('product', 'product_seo'); ?>
                        </a>
                    </li>
                    <?php if (isset(Yii::app()->siteinfo['product_highlights']) && Yii::app()->siteinfo['product_highlights'] == 1) { ?>
                        <li class="">
                            <a data-toggle="tab" href="#producthightlights">
                                <?php echo Yii::t('product', 'product_hightlights'); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div id="basicinfo" class="tab-pane active">
                        <?php
                        $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'productInfo' => $productInfo, 'shop_store' => $shop_store, 'form' => $form, 'option' => $option, 'optionManufacturer' => $optionManufacturer));
                        ?>
                    </div>
                    <div id="productextrainfo" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/product_extrainfo', array('model' => $model, 'productInfo' => $productInfo, 'shop_store' => $shop_store, 'form' => $form, 'option' => $option));
                        ?>
                    </div>
                    <div id="imagevideo" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/tabimagevideo', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => isset($attributes_cf) ? $attributes_cf : null));
                        ?>
                    </div>
                    <div id="video" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/video/video_rel', array('model' => $model, 'productInfo' => $productInfo));
                        ?>
                    </div>

                    <div id="attributes" class="tab-pane ">
                        <?php
                        $this->renderPartial('partial/tabattributes', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => isset($attributes_cf) ? $attributes_cf : null, 'attributes_changeprice' => isset($attributes_changeprice) ? $attributes_changeprice : null));
                        ?>
                    </div>
                    <div id="productSeo" class="tab-pane">
                        <?php
                        $this->renderPartial('partial/tabseo', array('model' => $model, 'productInfo' => $productInfo, 'form' => $form));
                        ?>
                    </div>
                    <?php if (isset(Yii::app()->siteinfo['product_highlights']) && Yii::app()->siteinfo['product_highlights'] == 1) { ?>
                        <div id="producthightlights" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/tablhighlights', array('model' => $model, 'productInfo' => $productInfo, 'form' => $form));
                            ?>
                        </div>
                    <?php } ?>
                    <?php if (isset(Yii::app()->siteinfo['related_products_module']) && Yii::app()->siteinfo['related_products_module'] == 1) { ?>
                        <div id="imagevideodetail" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/tabimagevideoextra', array('model' => $model, 'productInfo' => $productInfo));
                            ?>
                        </div>

                        <div id="productRel" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/products', array('model' => $model));
                            ?>
                        </div>

                        <div id="product_vtRel" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/products_vt', array('model' => $model));
                            ?>
                        </div>

                        <?php
                        $siteinfo = Yii::app()->siteinfo;
                        if ($siteinfo['site_skin'] == 'w3ni700') {
                            ?>
                            <div id="product_inkRel" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/products_ink', array('model' => $model));
                                ?>
                            </div>
                        <?php } ?>
                        <div id="productNewsRel" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/news_rel', array('model' => $model));
                            ?>
                        </div>
                        <div id="use_manual" class="tab-pane">
                            <?php
                            $this->renderPartial('partial/news_rel_manual', array('model' => $model));
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
                            <?php
                        } else {
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
$this->renderPartial('script/mainscriptnew', array('model' => $model));
?>