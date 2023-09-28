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
        <?php echo $form->labelEx($model, 'birthday', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php
            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                'model' => $model,
                'attribute' => 'birthday',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'tabularLevel' => null,
                    'yearRange' => "-80:+0",
                ),
                'language' => '',
                'htmlOptions' => array(
                    //'style' => 'color: #333',
                    'autocomplete' => 'on',
                    'placeholder' => $model->getAttributeLabel('birthday'),
                    'tabindex' => 9,
                    'value' => $model->birthday ? $model->birthday : '',
                    'class' => 'span9 form-control',
                ),
            ));
            ?>
            <?php echo $form->error($model, 'birthday'); ?>
        </div>
    </div>

    <div class="control-group form-group">
        <?php echo $form->labelEx($model, 'sex', array('class' => 'control-label col-sm-2')); ?>
        <div class="controls col-sm-10">
            <?php
            echo $form->dropDownList($model, 'sex', ClaUser::getListSexArr(), array('class' => 'span9 form-control',));
            ?>
            <?php echo $form->error($model, 'sex'); ?>
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
        jQuery(document).on('change', '#Users_province_id', function() {
            jQuery.ajax({
                url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
                data: 'pid=' + jQuery('#Users_province_id').val(),
                dataType: 'JSON',
                beforeSend: function() {
                    w3ShowLoading(jQuery('#Users_province_id'), 'right', 20, 0);
                },
                success: function(res) {
                    if (res.code == 200) {
                        jQuery('#Users_district_id').html(res.html);
                    }
                    w3HideLoading();
                },
                error: function() {
                    w3HideLoading();
                }
            });
        });
    </script>
</div>