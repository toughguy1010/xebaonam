<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('user', 'manager_user'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('content/users/createNormalUser'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('common', 'create_new'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="pageSizealign">
                <?php
                $this->widget('common.extensions.PageSize.PageSize', array(
                    'mGridId' => 'news-grid', //Gridview id
                    'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                    'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                ));
                ?>
            </div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'news-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'filter' => null,
                'enableSorting' => false,
                'pager' => array(
                    'class' => 'LinkPager',
                    'header' => '',
                    'nextPageLabel' => '&raquo;',
                    'prevPageLabel' => '&laquo;',
                    'lastPageLabel' => Yii::t('common', 'last_page'),
                    'firstPageLabel' => Yii::t('common', 'first_page'),
                ),
                'columns' => array(
//                    'user_id' => array(
//                        'header' => '',
//                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
//                    ),
//                    //'news_id',
//                    'name' => array(
//                        'name' => 'name',
//                        'type' => 'raw',
//                    ),
//                    'phone',
//                    'address',
//                    'email',
//                    'type' => array(
//                        'name' => 'type',
//                        'value' => function($data) {
//                            $status = ActiveRecord::typeArrayUser();
//                            return isset($status[$data->type]) ? $status[$data->type] : '';
//                        }
//                    ),
//                    'status' => array(
//                        'name' => 'status',
//                        'type' => 'raw',
//                        'value' => function($data) {
//                            $status = ActiveRecord::statusArrayUser();
//                            $st = isset($status[$data->status]) ? $status[$data->status] : '';
//                            if ($data->status == ActiveRecord::STATUS_USER_WAITING)
//                                $st = '<b>' . $st . '</b>';
//                            return $st;
//                        }
//                    ),
                    'order_id' => array(
                        'header' => 'Hóa đơn',
                        'name' => 'type',
                        'type' => 'html',
                        'value' => function($data) {
                            echo '<a href="',Yii::app()->createUrl('/economy/order/update',array('id'=>$data->order_id)),'">',Yii::t('bonus', $data->order_id),'</a>';
                        }
                    ),
                    'type' => array(
                        'header' => 'Loại',
                        'name' => 'type',
                        'type' => 'html',
                        'value' => function($data) {
                            echo Yii::t('bonus', $data->type);
                        }
                    ),
                    'point',
                    'created_time' => array(
                        'header' => 'Ngày cộng',
                        'name' => 'type',
                        'type' => 'html',
                        'value' => function($data) {
                            echo date('d/m/Y - H:i:s', $data->created_time);
                        }
                    ),
                    'note' => array(
                        'header' => 'Ghi chú',
                        'name' => 'type',
                        'type' => 'html',
                        'value' => function($data) {
                            echo Yii::t('bonus', $data->note);
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>