<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#notices-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('notice', 'notice_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('service/notice/create'); ?>" class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('notice', 'notice_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('service/notice/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="notices-grid">
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
                            'mGridId' => 'notices-grid', //Gridview id
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
                'id' => 'notices-grid',
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
                        'htmlOptions' => array('width' => 15, 'style' => 'text-align: center;'),
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'title',
                    'status' => array(
                        'name' => 'status',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center;'),
                        'value' => function ($data) {
                            return ($data->status == ActiveRecord::STATUS_ACTIVED) ? '<i class="icon-eye"></i>' : '<i class="icon-eye-slash"></i>';
                        }
                    ),
                    'showall' => array(
                        'name' => 'showall',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center;'),
                        'value' => function ($data) {
                            return ($data->showall == ActiveRecord::STATUS_ACTIVED) ? 'Tất cả thành viên' : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_show}  {delete} ',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'buttons' => array(
//                            'update' => array(
//                                'label' => '',
//                                'imageUrl' => false,
////                                'url' => 'Yii::app()->createUrl("/content/news/update", array("id" => $data->news_id))',
//                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
//                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("/content/news/delete", array("id" => $data->news_id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                            '_show' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("service/notice/show", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-eye', 'title' => 'Copy'),
                            )
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/notice/notice/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>