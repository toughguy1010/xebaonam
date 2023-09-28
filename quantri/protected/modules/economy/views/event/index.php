<style>
    .grid-view .button-column a {
        padding: 0 5px;
    }
</style>
<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('event', 'event_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/eventCategories'); ?>" class="btn btn-xs btn-success"
               style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('event', 'event_category'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/event/create'); ?>" class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('event', 'event_create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/event/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="product-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                //                $this->renderPartial('_search', array(
                //                    'model' => $model,
                //                ));
                ?>
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'product-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->
            <div class="clearfix" style="height: 30px;"></div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'event-grid',
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
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'name',
                    'price' => array(
                        'name' => 'price',
                        'value' => function ($data) {
                            if ($data->price)
                                return HtmlFormat::money_format($data->price);
                            return '';
                        }
                    ),

//                    'category_id' => array(
//                        'name' => 'category_id',
//                        'value' => function($data) {
//                            return Yii::app()->controller->category->getCateName($data->category_id);
//                        }
//                    ),
                    'price_market' => array(
                        'name' => 'price_market',
                        'value' => function ($data) {
                            if ($data->price_market)
                                return HtmlFormat::money_format($data->price_market);
                            return '';
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function ($data) {
                            return ($data->created_time) ? date('d-m-Y', $data->created_time) : '';
                        }
                    ),
                    'order' => array(
                        'name' => 'order',
                        'value' => function ($data) {
                            return ($data->order);
                        }
                    ),
                    'event' => array(
                        'name' => Yii::t('event', 'event'),
                        'value' => function ($data) {
                            return ($data->isprivate) ? 'SK Đóng' : 'Sk Mở';
                        }
                    ),

                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{view} {update}  {delete} ',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'viewButtonOptions' => array('class' => 'icon-eye'),
                        'viewButtonImageUrl' => false,
                        'viewButtonLabel' => '',
                        'buttons' => array(
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("economy/event/viewRegister", array("event_id" => $data->id))',
                            ),
                        ),
                    ),

                    'translate2' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/event/update', 'params' => array('id' => $data->id),'model' => $data));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>