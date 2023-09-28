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
            <?php echo Yii::t('shoppingcart', 'contact_request'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/expertransContact/exportcsv/'); ?>"
               class="btn btn-xs btn-success"
               style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('common', 'contact_exportcsv'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/expertransContact/deleteall'); ?>"
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
                    'phone' => array(
                        'header' => 'Số điện thoại',
                        'name' => 'phone',
                        'value' => '$data->phone',
                    ),
                    'company' => array(
                        'header' => 'SĐT Công ty',
                        'name' => 'company',
                        'value' => '$data->company',
                    ),
                    'company_name' => array(
                        'header' => 'Tên công ty',
                        'name' => 'company_name',
                        'value' => '$data->company_name',
                    ),
                    'service' => array(
                        'header' => 'Dịch vụ',
                        'name' => 'service_name',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return ExpertransService::model()->findByPk($data->service)->name;
                        },
                    ),
                    'total_price' => array(
                        'header' => 'total_price',
                        'name' => 'status',
                        'value' => function ($data) {
                            return ($data->total_price > 0) ? ($data->total_price. ' USD') : '';
                        },
                    ),
                    'status' => array(
                        'header' => 'status',
                        'name' => 'status',
                        'value' => function ($data) {
                            return ExpertransContactFormModel::statusArrayTranslate()[$data->status];
                        },
                        'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
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
                        'htmlOptions' => array('style' => 'width: 160px; text-align: center;'),
                        'template' => ' {delete} {update} {view} ',
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