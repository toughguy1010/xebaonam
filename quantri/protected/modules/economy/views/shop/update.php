<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>

<script type="text/javascript">
    var ta = true;
    jQuery(document).ready(function () {
        //
        CKEDITOR.replace("Shop_policy", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("Shop_contact", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
    jQuery(function ($) {
    });
</script>
<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::t('shop', 'update'); ?></h4>
        <div class="widget-toolbar no-border">
            <a onclick="submit_shop_form();" style="margin-right: 20px;" class="btn btn-xs btn-primary" id="savecar" href="javascript:void(0)">
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'shop-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                    ));
                    ?>
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" href="#basicinfo">
                                    <?php echo Yii::t('shop', 'shop_basicinfo'); ?>
                                </a>
                            </li>

                            <li class="">
                                <a data-toggle="tab" href="#shoppolicy">
                                    <?php echo Yii::t('shop', 'policy'); ?>
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#shopcontact">
                                    <?php echo Yii::t('shop', 'contact'); ?>
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#choosen_seo">
                                    <?php echo Yii::t('shop', 'shop_seo'); ?>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div id="basicinfo" class="tab-pane active">
                                <?php
                                $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'form' => $form, 'listprovince' => $listprovince, 'listdistrict' => $listdistrict, 'listward' => $listward, 'categories' => $categories));
                                ?>
                            </div>
                            <div id="shoppolicy" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/tabpolicy', array('model' => $model, 'form' => $form));
                                ?>
                            </div>
                            <div id="shopcontact" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/tabcontactinfo', array('model' => $model, 'form' => $form));
                                ?>
                            </div>
                            <div id="choosen_seo" class="tab-pane">
                                <?php
                                $this->renderPartial('partial/tabseo', array('model' => $model, 'form' => $form));
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div><!-- form -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var width_window = $(window).width();
        var width_left = $('#sidebar').width();
        var width_element = width_window - width_left - 20 * 2 - 15;
        $(window).scroll(function () {
            var scroll_top = $(document).scrollTop();
            if (scroll_top > 100) {
                $('.main-content .page-content .widget-header').css('position', 'fixed');
                $('.main-content .page-content .widget-header').css('top', '0px');
                $('.main-content .page-content .widget-header').css('z-index', '99');
                $('.main-content .page-content .widget-header').css('width', width_element);
            } else {
                $('.main-content .page-content .widget-header').css('position', 'static');
            }
        });
    });
</script>
<script>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }

    jQuery(function ($) {
        jQuery('#Shopavatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/shop/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Shop_avatar').val(obj.data.avatar);
                        if (jQuery('#Shopavatar_img img').attr('src')) {
                            jQuery('#Shopavatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#Shopavatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#Shopavatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });

    });

    jQuery(document).on('change', '#Shop_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#Shop_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#Shop_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Shop_district_id').html(res.html);
                }
                w3HideLoading();
                getWard();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

    jQuery(document).on('change', '#Shop_district_id', function () {
        getWard();
    });

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#Shop_district_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#Shop_district_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Shop_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }
</script>