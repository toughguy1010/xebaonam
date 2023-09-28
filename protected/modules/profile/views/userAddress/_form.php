<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-model-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'form-horizontal',
    ),
));
?>
<div class="profileif">
    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'name', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>


    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'phone', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'phone', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>

    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'address', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'address', array('class' => 'span9 form-control')); ?>
            <?php echo $form->error($model, 'address'); ?>
        </div>
    </div>

    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'province_id', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php
            echo $form->dropDownList($model, 'province_id', $listprivince, array('class' => 'span9 form-control',));
            ?>
            <?php echo $form->error($model, 'province_id'); ?>
        </div>
    </div>

    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'district_id', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php
            echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span9 form-control',));
            ?>
            <?php echo $form->error($model, 'district_id'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'save'), array('class' => 'btn btn-info')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <script type="text/javascript">
        jQuery(document).on('change', '#UsersAddress_province_id', function () {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                data: 'pid=' + jQuery('#UsersAddress_province_id').val(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#UsersAddress_province_id'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('#UsersAddress_district_id').html(res.html);
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        });
    </script>
</div>