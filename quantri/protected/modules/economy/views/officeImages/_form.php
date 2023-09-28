<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'banners-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
        ));
        ?>


        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#basicinfo">
                        <?php echo Yii::t('product', 'product_basicinfo'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="basicinfo" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/tab_info', array('model' => $model, 'form' => $form));
                    ?>
                </div>
            </div>
        </div>

        <div class="control-group form-group buttons" style="border-bottom: none;">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('office', 'office_create') : Yii::t('office', 'office_edit'), array('class' => 'btn btn-info', 'id' => 'savebanner')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    jQuery('#OfficeImages_group_id').on('change', function () {
        var size = $(this).find('option:selected').attr('size');
        var temp = $(this).find('option:selected').attr('data-style');
        if (size) {
            var sizer = size.split('_');
            if (sizer[0])
                jQuery('#OfficeImages_width').val(sizer[0]);
            if (sizer[1])
                jQuery('#OfficeImages_height').val(sizer[1]);
        }
        if (temp) {
            var listitems = '<option value="0" > Chọn </option>';
            var obj = jQuery.parseJSON(temp);
            jQuery.each(obj, function (key, value) {
                listitems += '<option value=' + key + '>' + value + '</option>';
            });
            jQuery('#OfficeImages_style').html(listitems);
        } else {
            var listitems = '<option value=' + 0 + '>' + 'Chọn' + '</option>';
            jQuery('#OfficeImages_style').html(listitems);

        }
    });
</script>