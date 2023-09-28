<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        //
//        CKEDITOR.replace("Shop_contact", {
//            height: 400,
//            language: '<?php // echo Yii::app()->language ?>'
//        });
    });
</script>
<div class="widget widget-box">
    <div class="widget-header">
        <h4><?php echo Yii::app()->controller->action->id != "update" ? Yii::t('shop', 'create') : Yii::t('shop', 'update'); ?></h4>
        <div class="widget-toolbar no-border">
            <a onclick="submit_shop_form();" style="" class="btn btn-xs btn-primary" id="saveproduct" >
                <i class="icon-ok"></i>
                <?php echo Yii::t('common', 'save') ?>
            </a>
        </div>
    </div>

    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <?php
                if (Yii::app()->controller->action->id == "update" && $model->status == 2) {
                    echo '<span style="display: block;margin: 10px 0 20px 20px;font-style: italic;color: red;">Gian hàng của bạn đang chờ được duyệt</span>';
                } else if (Yii::app()->controller->action->id == "update" && $model->status == 0) {
                    echo '<span style="display: block;margin: 10px 0 20px 20px;font-style: italic;color: red;">Gian hàng của bạn không được duyệt</span>';
                }
                if ((Yii::app()->controller->action->id == "create") || (Yii::app()->controller->action->id == "update" && $model->status != 0)) {
                    ?>
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
                                <li>
                                    <a data-toggle="tab" href="#tabimage">
                                        <?php echo Yii::t('shop', 'tabimage'); ?>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="basicinfo" class="tab-pane active">
                                    <?php
                                    $this->renderPartial('partial/tabbasicinfo', array('model' => $model, 'form' => $form, 'listprovince' => $listprovince, 'listdistrict' => $listdistrict, 'listward' => $listward, 'categories' => $categories));
                                    ?>
                                </div>
                                <div id="tabimage" class="tab-pane">
                                    <?php
                                    $this->renderPartial('partial/tabimage', array('model' => $model, 'form' => $form, 'listprovince' => $listprovince, 'listdistrict' => $listdistrict, 'listward' => $listward, 'categories' => $categories));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div><!-- form -->
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    function submit_shop_form() {
        document.getElementById("shop-form").submit();
        return false;
    }
</script>
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