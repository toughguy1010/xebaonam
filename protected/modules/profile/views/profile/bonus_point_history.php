<div class="product-order">
    <h3 class="username-title"><?php echo Yii::t('bonus', 'order_bonus'); ?></h3>
    <div>
        <!--<div class="col-sm-6">-->
        <div class="user_info" style="min-height: 40px">
            <?php $user = Users::getCurrentUser();
            ?>
            <h4>Điếm thưởng hiện có: <span style="color:red"><?php echo $user->bonus_point ?></span></h4>
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
        'dataProvider' => $model->search(),
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
            'type' => array(
                'name' => 'Loại điểm',
                'value' => function($data) {
//                    if ($data->type == 0) {
                    return Yii::t('bonus', $data->type);
//                    }
                }
            ),
            'point' => array(
                'name' => 'Điểm',
                'value' => function($data) {
//                    if ($data->point == 0) {
                    return $data->point;
//                    }
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