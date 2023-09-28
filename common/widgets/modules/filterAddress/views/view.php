<div class="fiter clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'shop-search-form',
        'action' => Yii::app()->createUrl('economy/shop/filterAddress'),
        'htmlOptions' => array('class' => 'form-horizontal w3f-form'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
    ));
    ?>
    <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => '',)); ?>
    <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => '',)); ?>
    <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => '',)); ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function submit_shop_search() {
        document.getElementById("shop-search-form").submit();
        return false;
    }

    jQuery(document).on('change', '#Shop_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#Shop_province_id').val() + '&allownull=1&filter=1',
            dataType: 'JSON',
            beforeSend: function () {
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Shop_district_id').html(res.html);
                }
                getWard();
            },
            error: function () {
            }
        });
    });

    jQuery(document).on('change', '#Shop_district_id', function () {
        getWard();
    });

    jQuery(document).on('change', '#Shop_ward_id', function () {
        setFilterWard();
    });

    function setFilterWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/setFilterWard') ?>',
            data: 'ward_id=' + jQuery('#Shop_ward_id').val() + '&filter=1',
            dateType: 'JSON',
            beforeSend: function () {
            },
            success: function (res) {
            },
            error: function () {
            }
        });
    }

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#Shop_district_id').val() + '&allownull=1&filter=1',
            dataType: 'JSON',
            beforeSend: function () {
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Shop_ward_id').html(res.html);
                }
            },
            error: function () {
            }
        });
    }
</script>