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
                        'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <?php echo $form->labelEx($model, 'group_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <?php
                            echo $form->dropDownList($model, 'group_id', $option_group, array('class' => 'span10 col-sm-12'));
                            ?>
                            <?php echo $form->error($model, 'group_id'); ?>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <?php echo CHtml::label(Yii::t('sms', 'choose_file'), '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                        <div class="controls col-sm-10">
                            <div class="row" style="margin: 10px 0px;">
                                <?php echo CHtml::fileField('ExcelFile'); ?>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($importinfo['ImportList']) && count($importinfo['ImportList'])) { ?>
                        <table style="margin: 20px;">
                            <?php foreach ($field_list as $key => $text) { ?>
                                <tr style="height: 65px;">
                                    <td style="width: 150px;"><?php echo $text ?></td>
                                    <td>
                                        <select id="postfield_<?php echo $key; ?>" name="postfield[<?php echo $key; ?>]">
                                            <?php foreach ($importinfo['ImportList'] as $k => $value) { ?>
                                                <option value="<?php echo $k ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <input type="hidden" value="<?php echo $importinfo['excelfile'] ?>" name="excelfile" />
                    <?php } ?>
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
    $(document).ready(function () {
        $('#btnAddCate').click(function () {
            var group_id = $('#SmsCustomer_group_id').val();
            if (group_id == 0) {
                alert('Bạn phải chọn nhóm liên hệ');
                return false;
            }
<?php if (isset($importinfo['ImportList']) && count($importinfo['ImportList'])) { ?>
                var field_phone = $('#postfield_phone').val();
                var field_name = $('#postfield_name').val();
                if (field_phone == field_name) {
                    alert('Cột số di động và cột tên khách hàng phải khác nhau')
                    return false;
                }
<?php } else { ?>
        if( document.getElementById("ExcelFile").files.length == 0 ){
            alert('Bạn phải chọn file');
            return false;
        }
<?php } ?>
            return true;
        });
    });
</script>
