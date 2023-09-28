<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#banner-groups-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('banner', 'banner_group_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('banner/bannergroup/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('banner', 'banner_group_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('banner/bannergroup/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="banner-groups-grid">
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
                            'mGridId' => 'banner-groups-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->

            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'banner-groups-grid',
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
                        'htmlOptions' => array('style' => 'width: 50px; text-align: center;'),
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'banner_group_name' => array(
                        'name' => 'banner_group_name',
                        'type' => 'raw',
                        'value' => function($data) {
                    return '<a href="' . Yii::app()->createUrl('/banner/bannergroup/list', array('bgid' => $data->banner_group_id)) . '">' . $data->banner_group_name . '</a>';
                }
                    ),
                    'banner_group_description',
                    'add_child' => array(
                        'header' => Yii::t('banner', 'banner_group_add_child'),
                        'type' => 'raw',
                        'value' => function($data) {
                    return '<a class="icon-th" style="font-size: 18px; position: relative;" href="' . Yii::app()->createUrl('banner/banner/create', array('bgid' => $data['banner_group_id'])) . '"><i class="icon-plus" style="font-size: 13px; position: absolute; top:-2px; left: -4px; color: #fe8100;"></i>' . '</a>';
                },
                        'htmlOptions' => array('style' => 'width: 100px; text-align: center;', 'title' => Yii::t('category', 'category_add_child')),
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
//                    'translate' => array(
//                        'header' => Yii::t('common', 'translate'),
//                        'type' => 'raw',
//                        'visible' => ClaSite::isMultiLanguage() ? true : false,
//                        'htmlOptions' => array('class' => 'button-column'),
//                        'value' => function($data) {
//                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/banner/bannergroup/update', 'params' => array('id' => $data->banner_group_id)));
//                }
//                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>