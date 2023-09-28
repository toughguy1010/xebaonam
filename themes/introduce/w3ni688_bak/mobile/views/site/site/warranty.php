<div class="row">
    <div class="col-xs-12 text-center">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-form',
            'method' => 'user-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php // echo $form->labelEx($model, 'shipping_phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls ">
                <?php echo $form->textField($model, 'shipping_phone', array('class' => 'form-control w3-form-input input-text', 'placeholder' => 'Nhập số điện thoại. VD:0915xxxxxx','style'=>'width:350px;margin:auto;')); ?>
                <?php echo $form->error($model, 'shipping_phone'); ?>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'check_warranty') : Yii::t('common', 'check_warranty'), array('class' => 'btn btn-info', 'id' => 'warraty-check')); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
    <div class="col-xs-12 text-center">
        <?php
        $count = $result;
        if ($count == 0 && $model->shipping_phone != null) {
            echo 'Số điện thoại bạn tìm kiếm chưa đúng';
        } else if ($model->shipping_phone) {
            echo 'Xin chào! Với số điện thoại <strong>', $model->shipping_phone, '</strong>. Chúng tôi tìm thấy <strong>', $count, '</strong> kết quả:';
            $this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' => $dataProvider,
                'itemsCssClass' => 'table table-warranty table-bordered table-hover vertical-center',
                'filter' => null,
                'enableSorting' => false,
                'columns' => array(
                    'order_id' => array(
                        'header' => 'Đơn hàng',
                        'name' => 'order_id',
                        'value' => '$data->order_id',
                    ),
                    'customer' => array(
                        'header' => Yii::t('shoppingcart', 'customer'),
                        'value' => '$data->billing_name',
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                    ),
                    'order_status' => array(
                        'name' => 'order_status',
                        'value' => function($data) {
                            $status = Orders::getStatusArr();
                            return isset($status[$data->order_status]) ? $status[$data->order_status] : '';
                        }
                    ),
                    'order_total' => array(
                        'name' => 'order_total',
                        'type' => 'raw',
                        'value' => '$data->getTotalPriceText()',
                    ),
                    array(
                        'header' => 'Chi tiết đơn hàng',
                        'type' => 'html',
                        'value' => function($data) {
                            return '<a target="_blank" href="' . Yii::app()->createUrl('economy/shoppingcart/order', array('id' => $data->order_id, 'key' => $data->key)) . '">' . 'Chi tiết' . '</a>';
                        }
                            ),
                        ),
                    ));
                    ?>
                <?php } ?>
    </div>
</div>
<style>
    .table-warranty-index {
        text-align: center;
    }
</style>
