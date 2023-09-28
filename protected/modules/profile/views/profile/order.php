<div class="product-order">
    <h3 class="username-title"><?php echo Yii::t('shoppingcart', 'order_2'); ?></h3>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'orders-grid',
        'dataProvider' => $model->search(),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'htmlOptions' => array('style' => 'padding-top:0px;'),
        'filter' => null,
        'columns' => array(
            'order_id' => array(
                'header' => '#',
                'name' => 'order_id',
                'value' => '"#".$data->order_id',
            ),
            'created_time' => array(
                'name' => 'created_time',
                'value' => 'date("H:i:s, m-d-Y",$data->created_time)',
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
                'class' => 'CButtonColumn',
                'template' => '{delete} {_view}',
                'htmlOptions' => array('style' => 'width: 160px; text-align: center;'),
                'buttons' => array(
                    '_view' => array(
                        'label' => Yii::t('common', 'detail'),
                        'url' => 'Yii::app()->createUrl("economy/shoppingcart/order", array("id" => $data["order_id"],"key"=>$data["key"]))',
                        'options' => array('class' => 'icon-file-text', 'title' => Yii::t('news', 'news_create')),
                    ),
                    'delete' => array(
                        'label' => Yii::t('shoppingcart', 'order_destroy') . ' | ',
                        'imageUrl' => null,
                        'url' => 'Yii::app()->createUrl("profile/profile/cancelorder", array("oid" => $data["order_id"],"key"=>$data["key"]))',
                        'visible' => '($data["order_status"]==Orders::ORDER_WAITFORPROCESS)?true:false',
                    ),
                ),
                'deleteConfirmation' => Yii::t('shoppingcart', 'order_destroy_ask'),
            ),
        ),
    ));
    ?>
</div>