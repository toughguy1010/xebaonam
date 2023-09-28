
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
        CKEDITOR.replace("TourHotelInfo_description", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
        CKEDITOR.replace("TourHotelInfo_policy", {
            height: 400,
            language: '<?php echo Yii::app()->language ?>'
        });
    });
</script>
<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'hotel-form',
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('tour', 'hotel_basicinfo'); ?>
                    </a>
                </li>      
                <li>
                    <a data-toggle="tab" href="#descriptioninfo">
                        <?php echo Yii::t('tour', 'hotel_descriptioninfo'); ?>
                    </a>
                </li>     
                <li>
                    <a data-toggle="tab" href="#comfortsinfo">
                        <?php echo Yii::t('tour', 'comfort'); ?>
                    </a>
                </li>     
                <li>
                    <a data-toggle="tab" href="#imagevideo">
                        <?php echo Yii::t('tour', 'hotel_images'); ?>
                    </a>
                </li> 
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tabbasicinfo', array(
                        'model' => $model,
                        'hotelInfo' => $hotelInfo,
                        'form' => $form,
                        'options_group' => $options_group,
                        'listprovince' => $listprovince,
                        'listdistrict' => $listdistrict,
                        'listward' => $listward,
                        'options_destinations' => $options_destinations
                    ));
                    ?>
                </div>
                <div id="descriptioninfo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabdescription', array('model' => $model, 'hotelInfo' => $hotelInfo, 'form' => $form));
                    ?>
                </div>
                <div id="comfortsinfo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabcomforts', array('model' => $model, 'hotelInfo' => $hotelInfo, 'form' => $form));
                    ?>
                </div>
                <div id="imagevideo" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/tabimagevideo', array('model' => $model, 'hotelInfo' => $hotelInfo, 'form' => $form));
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
<script type="text/javascript">
    jQuery(document).on('change', '#TourHotel_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#TourHotel_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#TourHotel_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#TourHotel_district_id').html(res.html);
                }
                w3HideLoading();
                getWard();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

    jQuery(document).on('change', '#TourHotel_district_id', function () {
        getWard();
    });

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#TourHotel_district_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#TourHotel_district_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#TourHotel_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }
</script>