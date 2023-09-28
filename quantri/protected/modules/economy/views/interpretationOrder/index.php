<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#orders-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('shoppingcart', 'order_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/interpretationOrder/exportcsv/'); ?>" class="btn btn-xs btn-success"
               style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('common', 'contact_exportcsv'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/interpretationOrder/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="orders-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'orders-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'orders-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'filter' => null,
                'enableSorting' => false,
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'id' => array(
                        'header' => '#',
                        'name' => 'id',
                        'value' => '"#".$data->id',
                    ),
                    'name' => array(
                        'header' => 'Tên',
                        'name' => 'id',
                        'value' => '$data->name',
                    ),
                    'tell' => array(
                        'header' => 'Số điện thoại',
                        'name' => 'id',
                        'value' => '$data->tell',
                    ),
                    'total_price' => array(
                        'header' => 'Đơn giá',
                        'name' => 'id',
                        'value' => '$data->total_price',
                    ),
                    'currency' => array(
                        'header' => 'Đơn vị tiền tệ',
                        'name' => 'id',
                        'value' => '$data->currency',
                    ),

                    'payment_method' => array(
                        'header' => 'Phương thức thanh toán',
                        'name' => 'id',
                        'value' => function ($data) {
                            return TranslateOrder::getPaymentMethod()[$data->payment_method];
                        }
                    ),
                    'status' => array(
                        'header' => 'Trạng thái',
                        'name' => 'id',
                        'value' => function ($data) {
                            return Orders::getStatusArr()[$data->status];
                        }
                    ),
                    'payment_status' => array(
                        'header' => 'Tình trạng thanh toán',
                        'name' => 'id',
                        'value' => function ($data) {
                            return TranslateOrder::getPaymentStatus()[$data->payment_status];
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                    ),
                    'affiliate_id' => array(
                        'header' => 'Người giới thiệu',
                        'name' => 'id',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $user = Users::model()->findByPk($data->affiliate_user);
                            return '<a target="_blank" href="' . Yii::app()->createUrl('affiliate/expertransAffiliate/viewUser', array('id' => $user->user_id)) . '">' . $user->name . '</a>';
                        }
                    ),
                    'aff_percent' => array(
                        'name' => 'aff_percent',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return $data->affiliate_id ? $data->aff_percent : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {delete} ',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>