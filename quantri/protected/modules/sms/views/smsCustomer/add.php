<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
?>
<div class="widget widget-box">
    <div class="widget-header"><h4>
            <?php echo Yii::app()->controller->action->id != "update" ? Yii::t('sms', 'customer_create') : Yii::t('sms', 'customer_update'); ?>
        </h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sms-customer-form',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>

                    <div class="table-responsive clearfix" style="padding: 20px 20px 0 20px; width: 100%">
                        <table id="form-input-contact" class="table table-condensed" style="float: left;width: 450px">
                            <thead>
                                <tr>
                                    <th style="width: 30%;"><?php echo $form->labelEx($model, 'name', array('class' => '')); ?></th>
                                    <th style="width: 30%;"><?php echo $form->labelEx($model, 'phone', array('class' => '')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= $dn; $i++) { ?>
                                    <tr>
                                        <td><input value="<?php echo $sms_customer[$i]['name'] ?>" onfocus="javascript:addhtml(this)" class="field_<?php echo $i ?>" name="SmsCustomer[<?php echo $i; ?>][name]" id="SmsCustomer_name" type="text" maxlength="255" /></td>
                                        <td><input value="<?php echo $sms_customer[$i]['phone'] ?>" onfocus="javascript:addhtml(this)" class="field_<?php echo $i ?>" name="SmsCustomer[<?php echo $i; ?>][phone]" id="SmsCustomer_phone" type="text" maxlength="20" onkeypress="return isNumber(event)"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div style="float: right">
                            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sms', 'customer_create') : Yii::t('sms', 'customer_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
                        </div>
                        <?php echo $form->error($model, 'empty_name_phone'); ?>
                    </div>

                    <!--                    <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                            <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                                            </div>
                                        </div>
                                        <div class="control-group form-group">
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                                            <div class="controls col-sm-10">
                    <?php echo $form->textField($model, 'phone', array('class' => 'span10 col-sm-12')); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                                            </div>
                                        </div>-->
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'group_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            echo $form->dropDownList($model, 'group_id', $option_group, array('class' => 'span10 col-sm-12'));
                            ?>
                            <?php echo $form->error($model, 'group_id'); ?>
                        </div>
                    </div>

                    <div class="control-group form-group buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sms', 'customer_create') : Yii::t('sms', 'customer_update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
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

    var count_tag = $('#form-input-contact tbody').children('tr').length;

    function addhtml(thistag) {
        count_tag++;
        var class_tag = $(thistag).attr('class');
        var count_arr = class_tag.split('_');
        var count_row = count_arr[1];
        $('.field_' + count_row).attr('onfocus', '');
        var after_tag = count_tag - 1;
        $('.field_' + after_tag).attr('onfocus', '');
        var html = "<tr>";
        html += "<td><input onfocus='javascript:addhtml(this)' class='field_" + count_tag + "' name='SmsCustomer[" + count_tag + "][name]' id='SmsCustomer_name' type='text' maxlength='255' onkeypress='return isNumber(event)'></td>";
        html += "<td><input onfocus='javascript:addhtml(this)' class='field_" + count_tag + "' name='SmsCustomer[" + count_tag + "][phone]' id='SmsCustomer_phone' type='text' maxlength='20' onkeypress='return isNumber(event)'></td>";
        html += "</tr>";
        $('#form-input-contact tbody').append(html);
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>