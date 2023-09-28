<?php
/* @var $this CategorypageController */
/* @var $model CategoryPage */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#category-page-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('categorypage', 'categorypage_manager') ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('content/categorypage/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('categorypage', 'categorypage_add'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('content/categorypage/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="category-page-grid">
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
                            'mGridId' => 'category-page-grid', //Gridview id
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
                'id' => 'category-page-grid',
                'dataProvider' => $model->search(),
                'filter' => null,
                'itemsCssClass' => 'table table-bordered table-hover',
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
                        'htmlOptions' => array('width' => 15, 'style' => 'text-align: center;'),
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'title',
                    'content' => array(
                        'name' => 'content',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<a href="' . Yii::app()->createUrl('/content/categorypage/update/', array('id' => $data->id)) . '">' . Yii::t('common', 'detail') . '</a>';
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
                                'htmlOptions' => array('class' => 'button-column', 'style' => "width: 150px;"),
                                'buttons' => array(
                                    'view' => array(
                                        'label' => '',
                                        'url' => function($data) {
                                            $api = new ClaAPI();
                                            $respon = $api->createUrl(array(
                                                'basepath' => '/page/category/detail',
                                                'params' => json_encode(array('id' => $data->id, 'alias' => $data->alias)),
                                                'absolute' => 'true',
                                            ));
                                            if ($respon) {
                                                return $respon['url'];
                                            }
                                        },
                                                'imageUrl' => false,
                                                'options' => array('class' => 'icon-search', "target" => "_blank"),
                                            )
                                        )
                                    ),
                                    'translate' => array(
                                        'header' => Yii::t('common', 'translate'),
                                        'type' => 'raw',
                                        'visible' => ClaSite::showTranslateButton() ? true : false,
                                        'htmlOptions' => array('class' => 'button-column'),
                                        'value' => function($data) {
                                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/content/categorypage/update', 'params' => array('id' => $data->id), 'model' => $data));
                                }
                                    ),
                                ),
                            ));
                            ?>
        </div>
    </div>
</div>