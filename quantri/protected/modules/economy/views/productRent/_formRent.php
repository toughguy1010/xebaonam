<?php
$array = array('' => Yii::t('product', 'product_create_warranty_new'));
//$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<link rel="stylesheet"
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui/jquery-ui.min.css"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js"></script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-rent-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <!--            <ul class="nav nav-tabs" id="myTab">-->
            <!--                <li class="active">-->
            <!--                    <a data-toggle="tab" href="#basicinfo">-->
            <!--                        --><?php //echo Yii::t('product', 'product_basicinfo'); ?>
            <!--                    </a>-->
            <!--                </li>-->
            <!--            </ul>-->
            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partialRent/tabbasicinfo', array('model' => $model, 'form' => $form, 'option_product' => $option_product));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<script type="text/javascript">
    var config = {
        '.chosen-product': {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $('#ProductToRent_product_id').on('change', function (e) {
        // triggers when whole value changed
        $('#ProductToRent_display_name').val($("form .chosen-single span").text());
    });


</script>

