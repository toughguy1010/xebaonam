<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/upload/ajaxupload.min.js"></script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.css"></script>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('shop', 'shop_store_create') : Yii::t('shop', 'shop_store_update'); ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-sm-12 col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>

                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" href="#basicinfo">
                                    <?php echo Yii::t('shop', 'basicinfo'); ?>
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tabdesc" class="">
                                    <?php echo Yii::t('shop', 'tabdesc'); ?>
                                </a>
                            </li>  <li class="">
                                <a data-toggle="tab" href="#tabimage" class="">
                                    <?php echo Yii::t('shop', 'tabimage'); ?>
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#tabseo">
                                    <?php echo Yii::t('shop', 'tabseo'); ?>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="basicinfo" class="tab-pane active">
                                <?php
                                $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'form' => $form, 'listdistrict' => $listdistrict, 'listprovince' => $listprovince, 'listward' => $listward));
                                ?>
                            </div>
                            <div id="tabimage" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/tabimage', array('model' => $model, 'form' => $form));
                                ?>
                            </div>
                            <div id="tabdesc" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/tabdesc', array('model' => $model, 'form' => $form));
                                ?>
                            </div>
                            <div id="tabseo" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/tabseo', array('model' => $model, 'form' => $form));
                                ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="control-group form-group buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('shop', 'shop_store_create') : Yii::t('shop', 'shop_store_update'), array('class' => 'btn btn-primary', 'id' => 'saveshop')); ?>
            </div>
            <?php
            $this->endWidget();
            ?>
        </div>
    </div>
</div>
<?php $this->renderPartial('mainscript', array('model' => $model)); ?>
<?php
$this->renderPartial('script/mainscript', array('model' => $model));
?>
<script type="text/javascript">
    //
    $(document).ready(function () {
        $('.showmap').on('click', function () {
            mapshow();
        });

    });
    jQuery(function ($) {
        jQuery('#categoryavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/shopStore/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#ShopStore_avatar').val(obj.data.avatar);
                        if (jQuery('#categoryavatar_img img').attr('src')) {
                            jQuery('#categoryavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#categoryavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#categoryavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
    });


    function removeImage(type_image) {
        var url_request = "<?php echo Yii::app()->createUrl('economy/productcategory/removeImageCat') ?>";
        jQuery.getJSON(
            url_request,
            {type: type_image},
            function (data) {
                console.log(data);
            }
        );
    }

    jQuery(document).on('change', '#ShopStore_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#ShopStore_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#ShopStore_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#ShopStore_district_id').html(res.html);
                }
                w3HideLoading();
                getWard();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

    jQuery(document).on('change', '#ShopStore_district_id', function () {
        getWard();
    });

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#ShopStore_district_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#ShopStore_district_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#ShopStore_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }
</script>