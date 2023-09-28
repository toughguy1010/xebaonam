<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#folder-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('file', 'folder_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('media/folder/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('file', 'folder_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('media/folder/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="folder-grid">
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
                            'mGridId' => 'folder-grid', //Gridview id
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
                'id' => 'folder-grid',
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
                        'htmlOptions' => array('width' => 10,),
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 10,),
                    ),
                    'folder_name' => array(
                        'name' => 'folder_name',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<a href="' . Yii::app()->createUrl('media/folder/list', array('fid' => $data->folder_id)) . '">' . $data->folder_name . '</a>';
                        }
                    ),
                    'folder_description',
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_addfile} {update} {delete} ',
                        'buttons' => array(
                            '_addfile' => array(
                                'label' => '',
                                'url' => 'Yii::app()->createUrl("media/file/create", array("fo" => $data["folder_id"]))',
                                'options' => array('class' => 'icon-file-text', 'title' => Yii::t('file', 'file_create')),
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("media/folder/update", array("id" => $data["folder_id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("media/folder/delete", array("id" => $data["folder_id"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),

                    ),
                    // 'translate' => array(
                    //     'header' => Yii::t('common', 'translate'),
                    //     'type' => 'raw',
                    //     'visible' => ClaSite::showTranslateButton() ? true : false,
                    //     'htmlOptions' => array('class' => 'button-column'),
                    //     'value' => function ($data) {
                    //         $this->widget('application.widgets.translate.translate', array('baseUrl' => '/media/folder/update', 'params' => array('id' => $data->folder_id), 'model' => $data));
                    //     }
                    // ),
                ),
            ));
            ?>
        </div>
    </div>
</div>