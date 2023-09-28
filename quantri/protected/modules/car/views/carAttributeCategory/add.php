<div class="widget widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('car', 'create') : Yii::t('car', 'update'); ?>
        </h4>
    </div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'car-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'group_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->dropDownList($model, 'group_id', CarAttributeGroup::optionGroup(), array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'group_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php echo $form->textField($model, 'order', array('class' => 'span10 col-sm-12')); ?>
                            <?php echo $form->error($model, 'order'); ?>
                        </div>
                    </div>

                    <div class="well well-lg clearfix">
                        <h4 class="blue">Các giá trị</h4>
                        <?php
                        $values = CarAttributeCategory::getAllOptions($model->id);
                        ?>
                        <div class="wrap_options_value">
                            <?php
                            if (isset($values) && count($values)) {
                                foreach ($values as $value) {
                                    ?>
                                    <div class="options">
                                        <div class="col-xs-6">
                                            <label style="display: block">Giá trị: </label>
                                            <input class="form-control" type="text" name="CarAttributeOptionExist[<?= $value['id'] ?>][name]" value="<?= $value['name'] ?>" />
                                        </div>
                                        <div class="col-xs-1">
                                            <label style="display: block">Sắp xếp: </label>
                                            <input class="form-control" type="text" name="CarAttributeOptionExist[<?= $value['id'] ?>][order]" value="<?= $value['order'] ?>" />
                                        </div>
                                        <div style="clear: both; margin-bottom: 10px"></div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="options">
                                    <div class="col-xs-6">
                                        <label style="display: block">Giá trị: </label>
                                        <input class="form-control" type="text" name="CarAttributeOption[1][name]" value="" />
                                    </div>
                                    <div class="col-xs-1">
                                        <label style="display: block">Sắp xếp: </label>
                                        <input class="form-control" type="text" name="CarAttributeOption[1][order]" value="" />
                                    </div>
                                    <div style="clear: both; margin-bottom: 10px"></div>
                                </div>
                            <?php } ?>
                        </div>
                        <div style="clear: both"></div>
                        <div class="col-xs-12">
                            <button type="button" class="btn btn-success add_option_color" onclick="addhtmloption()"><?php echo Yii::t('car', 'create') ?></button>
                        </div>
                    </div>


                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('car', 'create') : Yii::t('car', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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
    var count = $('.wrap_options_value .options').length;
    function addhtmloption() {
        count++;
        var html = '';
        html += '<div class="options">';
        html += '<div class="col-xs-6">';
        html += '<label style="display: block">Giá trị: </label>';
        html += '<input class="form-control" type="text" name="CarAttributeOption[' + count + '][name]" value="" />';
        html += '</div>';
        html += '<div class="col-xs-1">';
        html += '<label style="display: block">Sắp xếp: </label>';
        html += '<input class="form-control" type="text" name="CarAttributeOption[' + count + '][order]" value="" />';
        html += '</div>';
        html += '<div style="clear: both; margin-bottom: 10px"></div>';
        html += '</div>';
        $('.wrap_options_value').append(html);
    }
</script>
