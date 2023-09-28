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
                    'username' => array(
                        'header' => Yii::t('shoppingcart', 'customer'),
                        'value' => '$data->username',
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            $status = Orders::getStatusArr();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'total' => array(
                        'name' => 'total',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return number_format($data->total, 0, '', '.').'đ';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => 'date("d-m-Y, H:i:s",$data->created_time)',
                    ),
                    'Sửa lại báo giá' => array(
                        'header' => Yii::t('common', 'Sửa lại báo giá'),
                        'type' => 'html',
                        'visible' => (Yii::app()->controller->site_id == 1899) ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            return ($data->order_status == Orders::ORDER_WAITFORPROCESS) ? '<a class="icon-edit" href="' . Yii::app()->createUrl('/installment/order/edit', array('id' => $data->id)) . '></a>' : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}',
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