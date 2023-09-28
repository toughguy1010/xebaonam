<div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td style="width: 20%;"><b><?php echo Yii::t('sms', 'text_message') ?></b></td>
                <td><?php echo $model->text_message ?></td>
            </tr>
            <tr>
                <td><b><?php echo Yii::t('sms', 'count_message') ?></b></td>
                <td><?php echo $model->count_message ?></td>
            </tr>
            <tr>
                <td><b><?php echo Yii::t('sms', 'number_person') ?></b></td>
                <td><?php echo $model->number_person ?> <i>(<?php echo $model->ary_provider ?>)</i></td>
            </tr>
            <tr>
                <td><b><?php echo Yii::t('sms', 'type') ?></b></td>
                <td><?php echo Sms::getTypeInput($model->type) ?></td>
            </tr>
            <tr>
                <td><b><?php echo Yii::t('sms', 'created_time') ?></b></td>
                <td><?php echo date('d-m-Y H:i:s', $model->created_time) ?></td>
            </tr>
            <tr>
                <td><b>Chi phí</b></td>
                <td>
                    <?php
                    $ary_price = json_decode($model->ary_price);
                    foreach ($ary_price as $key => $price) {
                        echo '<p><span>' . $key . '</span>: <span>' . number_format($price, 0, '', '.') . ' ' . Yii::t('sms', 'unit_price') . '</span></p>';
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'news-categories-grid',
        'dataProvider' => $model_detail->search(),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'summaryText' => false,
        'filter' => null,
        'enableSorting' => false,
        'columns' => array(
            'number' => array(
                'header' => '',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                'htmlOptions' => array('style' => 'width: 50px; text-align: center;')
            ),
            'phone' => array(
                'name' => 'phone',
                'type' => 'raw',
            ),
            'message' => array(
                'name' => 'message',
                'type' => 'raw',
            ),
            'created_time' => array(
                'name' => 'created_time',
                'value' => function($data) {
                    return date('d-m-Y H:i:s', $data->created_time);
                }
            ),
        ),
    ));
    ?>
</div>

