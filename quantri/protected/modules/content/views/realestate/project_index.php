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
            <?php echo Yii::t('realestate', 'list_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('content/realestate/projectCreate'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('realestate', 'realestate_project_create'); ?>
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
            </div>
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
                    'number' => array(
                        'header' => '',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                    ),
                    'name' => array(
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    'real_estate_cat_id' => array(
                        'name' => 'real_estate_cat_id',
                        'value' => function($data) {
                            return Yii::app()->controller->category->getCateName($data->real_estate_cat_id);
                        }
                    ),
                    'ishot' => array(
                        'header' => 'Dự án nổi bật',
                        'value' => function($data) {
                            return ($data->ishot)?'Nổi bật':'';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return date('d-m-Y H:i:s', $data->created_time);
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
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
                        'buttons' => array
                            (
                            'update' => array
                                (
                                'url' => 'Yii::app()->createUrl("content/realestate/projectUpdate", array("id"=>$data->id))',
                            ),
                            'delete' => array
                                (
                                'url' => 'Yii::app()->createUrl("content/realestate/projectDelete", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>