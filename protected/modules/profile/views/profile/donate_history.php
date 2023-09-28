<div class="product-order">
    <h3 class="username-title"><?php echo Yii::t('bonus', 'donate_history'); ?></h3>
    <div>
        <!--<div class="col-sm-6">-->
        <div class="user_info">
            <?php $user = Users::getCurrentUser();
            ?>
            <h4> Số tiền đóng ghóp: <span style="color:red"><?php echo number_format($user->donate) ?></span></h4>
            <!--<h4>Điếm thưởng đang chờ:<span style="color:red"> 40 </span></h4>-->
        </div>
        <!--</div>-->
        <!--<div class="col-sm-6">-->
        <!--</div>-->
    </div>
    <style>
        .menu-profile ul{list-style-type: none}
        .menu-profile ul li{display: inline-block;}
        .menu-profile ul li a{color:#333;padding: 5px 10px;border: 1px solid #f1f1f1}
        .menu-profile ul li a.active{background: #428bca;color: #fff;font-weight: bold}
    </style>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'orders-grid',
        'dataProvider' => $model->search(true),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'htmlOptions' => array('style' => 'padding-top:0px;'),
        'filter' => null,
        'enableSorting' => false,
        'columns' => array(
            'order_id' => array(
                'header' => '# Mã đơn hàng',
                'name' => 'order_id',
                'value' => '"#".$data->order_id',
            ),
            'point' => array(
                'name' => 'point',
                'value' => function($data) {
                    return $data->point;
                }
            ),
            'created_time' => array(
                'name' => 'created_time',
                'value' => 'date("H:i:s - m/d/Y",$data->created_time)',
            ),
            'note' => array(
                'name' => 'note',
                'type' => 'raw',
                'value' => function($data) {
                   return Yii::t('bonus', $data->note);
                }
            ),
        ),
    ));
    ?>
</div>