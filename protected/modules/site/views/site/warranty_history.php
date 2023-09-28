<div class="col-sm-12">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'method' => 'post',
        'action' => Yii::app()->CreateUrl('site/site/warrantyHistory'),
        'htmlOptions' => array('class' => 'form-horizontal'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <div class="control-group form-group">
        <!--    --><?php //echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls " style="text-align: center">
            <?php echo $form->textField($model, 'phone', array('class' => '', 'placeholder' => 'Số điện thoại')); ?>
            <?php echo $form->textField($model, 'imei', array('class' => '', 'placeholder' => 'imei')); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>
    <div class="control-group form-group buttons" style="text-align: center">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'check_warranty') : Yii::t('common', 'check_warranty'), array('class' => 'btn btn-info', 'id' => 'warraty-check')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <div class="col-xs-12 text-center">
        <?php
        if (isset($dataProvider)) {
            $count = $result;
            if ($count == 0 && $model->phone != null) {
                echo 'Số điện thoại bạn tìm kiếm chưa đúng';
            } else if ($model->phone) {
                echo 'Xin chào! Với số điện thoại <strong>', $model->phone, '</strong>. Chúng tôi tìm thấy <strong>', $count, '</strong> thông tin:';
            }
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'filter' => null,
                'enableSorting' => false,
                'columns' => array(
                    'product_name',
                    'imei',
//                    'start_date',
//                    'end_date' => array(
//                        'name' => 'end_date',
//                        'type' => 'raw',
//                        'value' => function ($data) {
//                            return date("d/m/Y", strtotime($data->end_date));
//                        },
//                    ),
                    'status' => array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $status = ProductWarrantyHistory::statusArray();
                            if ($data->status == 4) {
                                return "<b style='color: blue'>" . $status[$data->status] . '</b>';
                            } else if ($data->status == 0) {
                                return "<b style='color: red'>" . $status[$data->status] . "</b>";
                            } else if ($data->status == 3) {
                                return "<b style='color: green'>" . $status[$data->status] . "</b>";
                            } else {
                                return isset($status[$data->status]) ? $status[$data->status] : '';
                            }
                        },
                    ))
            ));
        }
        ?>
    </div>
</div>
