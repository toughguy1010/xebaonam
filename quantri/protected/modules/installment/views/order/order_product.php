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
            <?php echo Yii::t('shoppingcart', 'order_product_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/order/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="orders-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <!-- <div class="search-active-form" style="position: relative; margin-top: 10px;">
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
            </div> --><!-- search-form -->

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'orders-grid',
                'dataProvider' => $model->searchHotProduct(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'filter' => null,
                'enableSorting' => false,
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'product_name' => array(
                        'header' => Yii::t('shoppingcart', 'product_name'),
                        'type' => 'html',
                        'value' =>  function($data) {
                        return '<a href="'.Yii::app()->createUrl('../economy/product/detail',
                            array(
                                'alias' =>$data->alias,
                                'id'    =>$data->product_id,
                            )).'">'.$data->product_name.'</a>';}
                    ),
                    'total_product_qty' => array(
                        'header' => Yii::t('shoppingcart','total_product_qty'),
                        'value' => function($data) {
                                return $data->total_product_qty;
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>