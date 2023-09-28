<?php
$allServices = isset($allServices) ? $allServices : SeServices::getServices();
$_providerServices = isset($providerServices) ? $providerServices : SeProviderServices::getProviderServices(array('provider_id' => $model->id));
$providerServices = array();
foreach ($_providerServices as $ps) {
    $providerServices[$ps['service_id']] = $ps;
}
$timeOptions = ClaService::getWorkTimeDuration(array('none' => false));
//
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'provider-services-form',
    'action' => Yii::app()->createUrl('service/provider/addservice', array('provider_id' => $model->id)),
    'htmlOptions' => array(
        'class' => 'form-horizontal', 'enctype' => 'multipart/form-data',
    ),
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
        ));
?>
<div class="header-services-staff">
    <div class="row">
        <label class="col-sm-6">
            <input class="checkAll" type="checkbox" style="margin-left: 5px;"> <?php echo Yii::t('service', 'allservice'); ?>
        </label>
        <label class="col-sm-2"><?php echo strtoupper(Yii::t('product', 'price')); ?></label>
        <label class="col-sm-2"><?php echo strtoupper(Yii::t('service', 'duration')); ?></label>
        <label class="col-sm-2"><?php echo strtoupper(Yii::t('service', 'capacity')); ?></label>
    </div>
</div>
<?php
foreach ($allServices as $service) {
    $info = array();
    $checked = false;
    if (isset($providerServices[$service['id']])) {
        $checked = true;
        $info = $providerServices[$service['id']];
    }
    ?>
    <div class="item-services-staff row">
        <div class="name-services col-sm-6">
            <div class="checkbox">
                <label>
                    <input class="ace" type="checkbox" <?php if ($checked) { ?>checked="checked"<?php } ?> name="<?php echo "Service[{$service['id']}][select]"; ?>" value="1">
                    <span class="lbl"> <?php echo $service['name']; ?></span>
                </label>
            </div>
        </div>
        <div class="price-services col-sm-2">
            <?php
            echo CHtml::numberField("Service[{$service['id']}][price]", isset($info['price']) ? $info['price'] : $service['price'], array('class' => 'form-control show-input'));
            ?>
        </div>
        <div class="price-services col-sm-2">
            <?php 
            $duration = isset($info['duration']) ? $info['duration'] : $service['duration'];
            $_timeOptions = ClaService::insertWorkTimeDuration($timeOptions, array('time'=>$duration));
            echo CHtml::dropDownList("Service[{$service['id']}][duration]", isset($info['duration']) ? $info['duration'] : $service['duration'], $_timeOptions, array('class' => 'form-control')); 
            ?>
        </div>
        <div class="capacity-services duration-services col-sm-2">
            <?php
            echo CHtml::numberField("Service[{$service['id']}][capacity]", isset($info['capacity']) ? $info['capacity'] : 1, array('class' => 'form-control show-input'));
            ?>
        </div>
    </div>
<?php } ?>
<span class="boder-bottom-form"></span>
<div class="form-group right width-100">
    <?php echo CHtml::submitButton(Yii::t('common', 'save'), array('style' => 'margin-right:15px;', 'class' => 'btn btn-sm btn-primary pull-right', 'id' => 'saveBusinessHours')); ?>
</div>
<script type="text/javascript">
    jQuery(function () {
        setTimeout(function(){
            jQuery('.item-services-staff input[type=checkbox]').trigger('change');
        },100);
        jQuery(document).on('change', '.checkAll', function () {
            if (jQuery(this).is(':checked')) {
                jQuery('.item-services-staff input[type=checkbox]').prop('checked', true);
            } else {
                jQuery('.item-services-staff input[type=checkbox]').prop('checked', false);
            }
            jQuery('.item-services-staff input[type=checkbox]').trigger('change');
        });
        jQuery(document).on('change', '.name-services .checkbox input[type=checkbox]', function () {
            if (jQuery(this).is(':checked')) {
                jQuery(this).closest('.item-services-staff').find(':input').removeAttr('disabled');
            } else {
                jQuery(this).closest('.item-services-staff').find(':input:not(:checkbox)').attr('disabled',true);
            }
        });
        jQuery('#provider-services-form').on('submit', function () {
            var _this = jQuery(this);
            var url = _this.attr('action');
            if (url) {
                jQuery.ajax({
                    url: url,
                    data: _this.serialize(),
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        w3ShowLoading(jQuery('#saveGeneral'), 'right', 20, 0);
                    },
                    success: function (res) {
                        if (res.code) {
                            if (res.message) {
                                var dialog = bootbox.dialog({
                                    size: 450,
                                    message: res.message

                                });
                                setTimeout(function () {
                                    dialog.modal('hide');
                                }, 2000);
                            }
                        }
                        w3HideLoading();
                    },
                    error: function () {
                        w3HideLoading();
                    }
                });
            }
            return false;
        });
    });
</script>
<?php $this->endWidget(); ?>