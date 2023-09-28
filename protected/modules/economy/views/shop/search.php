<div class="col-xs-12 no-padding">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'shop-search-form',
        'htmlOptions' => array('class' => 'form-horizontal'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'address', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-6', 'placeholder' => Yii::t('common', 'address'))); ?>
            <?php echo $form->error($model, 'address'); ?>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span12 col-sm-12',)); ?>
            <?php echo $form->error($model, 'province_id'); ?>
        </div>
    </div>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span12 col-sm-12',)); ?>
            <?php echo $form->error($model, 'district_id'); ?>
        </div>
    </div> 
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => 'span12 col-sm-12',)); ?>
            <?php echo $form->error($model, 'ward_id'); ?>
        </div>
    </div> 
    <div class="form-group no-margin-left">
        <a onclick="submit_shop_search();" style="" class="btn btn-xs btn-primary" id="saveproduct" >
            <i class="icon-ok"></i>
            <?php echo Yii::t('common', 'save') ?>
        </a>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function submit_shop_search() {
        document.getElementById("shop-search-form").submit();
        return false;
    }
    
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
            data: 'did=' + jQuery('#Shop_district_id').val() + '&allownull=1',
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