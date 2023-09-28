<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('common', 'create') : Yii::t('common', 'update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'ward_id', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'ward_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'type', LibWards::typeWard(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'type'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'province_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'district_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'create') : Yii::t('common', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).on('change', '#LibWards_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#LibWards_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#LibWards_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#LibWards_district_id').html(res.html);
                }
                w3HideLoading();
                getWard();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

    jQuery(document).on('change', '#LibWards_district_id', function () {
        getWard();
    });

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#LibWards_district_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#LibWards_district_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#LibWards_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }
</script>