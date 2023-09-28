<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#menu-groups-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('menu', 'menu_group_manager') ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('interface/menugroup/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('menu', 'menu_group_create') ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('interface/menugroup/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="menu-groups-grid">
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
                            'mGridId' => 'menu-groups-grid', //Gridview id
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
                'id' => 'menu-groups-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover',
                'pager' => array(
                    'class' => 'LinkPager',
                    'header' => '',
                    'nextPageLabel' => '&raquo;',
                    'prevPageLabel' => '&laquo;',
                    'lastPageLabel' => Yii::t('common', 'last_page'),
                    'firstPageLabel' => Yii::t('common', 'first_page'),
                ),
                'filter' => null,
                'columns' => array(
                    'number' => array(
                        'header' => '',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                        'htmlOptions' => array('width' => 15, 'style' => 'text-align: center;'),
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'menu_group_name' => array(
                        'name' => 'menu_group_name',
                        'type' => 'raw',
                        'value' => function($data) {
                    return '<a href="' . Yii::app()->createUrl('/interface/menugroup/list', array('mgid' => $data->menu_group_id)) . '">' . $data->menu_group_name . '</a>';
                }
                    ),
                    'menu_group_description',
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}{delete}',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'buttons' => array(
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("interface/menugroup/delete",array("id"=>$data->menu_group_id))',
                                'visible' => '($data->menu_group_type==MenuGroups::MENU_GROUP_TYPE_SYSTEM)?false:true',
                            ),
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::isMultiLanguage() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/interface/menugroup/update', 'params' => array('id' => $data->menu_group_id)));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>