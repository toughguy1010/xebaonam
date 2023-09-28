<div class="col-sm-12">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'method' => 'post',
        'action' => Yii::app()->CreateUrl('site/site/warranty'),
        'htmlOptions' => array('class' => 'form-horizontal'),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <div class="control-group form-group">
        <!--    --><?php //echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls " style="text-align: center">
            <?php echo $form->textField($model, 'phone', array('class' => '', 'placeholder' => 'Số điện thoại')); ?>
            <!--            --><?php //echo $form->error($model, 'phone'); ?>
            <?php echo $form->textField($model, 'imei', array('class' => '', 'placeholder' => 'Imei')); ?>
            <!--            --><?php //echo $form->error($model, 'phone'); ?>
        </div>
    </div>
    <div class="control-group form-group buttons" style="text-align: center">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'check_warranty') : Yii::t('common', 'check_warranty'), array('class' => 'btn btn-info', 'id' => 'warraty-check')); ?>
    </div>
    <?php $this->endWidget(); ?>
    <div class="text-center">
        <?php
        if (isset($dataProvider) && count($dataProvider)) {
//            echo "<pre>";
//            print_r($dataProvider);
//            echo "</pre>";
//            die();
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
                    'start_date' => array(
                        'name' => 'start_date',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return date("d/m/Y", strtotime($data->start_date));
                        },
                    ),
                    'end_date' => array(
                        'name' => 'end_date',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return date("d/m/Y", strtotime($data->end_date));
                        },
                    ),
                    'status' => array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return (strtotime($data->end_date) >= time())
                                ? '<span style="color: #00a851">Còn bảo hành</span>'
                                : '<span style="color: red">Hết bảo hành</span>';
                        },
                    ))
            ));
        }
        ?>
    </div>
<!--    <a href="--><?php //echo Yii::app()->createUrl('/site/site/warrantyHistory'); ?><!--">Kiểm tra lịch sử bảo hành</a>-->
</div>
<style>
    #warraty-check {
        float: none;
    }
    .controls input {
        border-radius: 5px;
        border: 1px solid #3339;
        padding: 3px 7px;
    }
    #warraty-check {
        background-color: #ed2024;
        border-color: #ed2024;
    }
    .left {
        width: 100%;
    }
</style>
