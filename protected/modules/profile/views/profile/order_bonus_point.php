<div class="product-order">
    <h3 class="username-title"><?php echo Yii::t('bonus', 'order_bonus'); ?></h3>
    <div>
        <!--<div class="col-sm-6">-->
        <div class="user_info" style="height: 40px;">
            <?php $user = Users::getCurrentUser();
            ?>
            <p>
            <h4>Điếm thưởng hiện có: <span style="color:red"><?php echo $user->bonus_point ?> </span>
                <a href="<?php echo yii::app()->createUrl('profile/profile/bonusPointHistory') ?>">(Lịch sử)
                </a>
            </h4>
            </p>     <!--<h4>Điếm thưởng đang chờ:<span style="color:red"> 40 </span></h4>-->
        </div>
    </div>
    <div class="menu-profile">
        <ul>
            <li><a class=" <?php echo ($model->order_status == 6) ? 'active' : '' ?>"
                   href="<?php echo yii::app()->createUrl('profile/profile/bonusPoint', array('status' => 6)) ?>">Đơn
                    hàng được cộng điểm</a></li>
            <li><a class=" <?php echo ($model->order_status == 0 && $bonus_point_used != 1) ? 'active' : '' ?>"
                   href="<?php echo yii::app()->createUrl('profile/profile/bonusPoint', array('status' => 0)) ?>">Đơn
                    hàng đang chờ duyệt</a></li>
            <li><a class=" <?php echo ($bonus_point_used == 1) ? 'active' : '' ?>"
                   href="<?php echo yii::app()->createUrl('profile/profile/bonusPoint', array('bonus_point_used' => 1)) ?>">Đơn
                    hàng dùng điểm thưởng</a></li>
        </ul>
    </div>
    <style>
        .menu-profile ul {
            list-style-type: none
        }

        .menu-profile ul li {
            display: inline-block;
        }

        .menu-profile ul li a {
            color: #333;
            padding: 5px 10px;
            border: 1px solid #f1f1f1
        }

        .menu-profile ul li a.active {
            background: #428bca;
            color: #fff;
            font-weight: bold
        }
    </style>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'orders-grid',
        'dataProvider' => $model->searchBonusPoint($bonus_point_used),
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
            'created_time' => array(
                'name' => 'created_time',
                'value' => 'date("H:i:s - m/d/Y",$data->created_time)',
            ),
            'wait_bonus_point' => array(
                'name' => 'Điểm thưởng',
                'value' => function ($data) {
//                    if ($data->order_status == 6) {
                    return $data->wait_bonus_point;
//                    }
                }
            ),
            'bonus_point_used' => array(
                'name' => 'bonus_point_used',
                'value' => function ($data) {
//                    if ($data->order_status == 0) {
                    return $data->bonus_point_used;
//                    }
                }
            ),
            'order_status' => array(
                'name' => 'Trạng thái',
                'value' => function ($data) {
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
                'template' => '{_view}',
                'htmlOptions' => array('style' => 'width: 50px; text-align: center;'),
                'buttons' => array(
                    '_view' => array(
                        'label' => Yii::t('common', 'detail'),
                        'url' => 'Yii::app()->createUrl("economy/shoppingcart/order", array("id" => $data["order_id"],"key"=>$data["key"]))',
                        'options' => array('class' => 'icon-file-text', 'title' => Yii::t('news', 'news_create')),
                    ),
                ),
            ),
        ),
    ));
    ?>
</div>
