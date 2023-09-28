<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#file-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('file', 'file_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('media/folder'); ?>" class="btn btn-xs btn-success"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('file', 'folder_manager'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('media/file/create'); ?>" class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('file', 'file_create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('media/file/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="file-grid">
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
                            'mGridId' => 'file-grid', //Gridview id
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
                'id' => 'file-grid',
                'itemsCssClass' => 'table table-bordered table-hover',
                'dataProvider' => $model->search(),
                'filter' => null,
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
                    'display_name',
                    'size' => array(
                        'name' => 'size',
                        'value' => function ($data) {
                            return Files::GetStringSizeFormat($data->size);
                        }
                    ),
                    'extension',
                    'created_time' => array(
                        'name' => 'created_time',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return date('m-d-Y', $data->created_time);
                        }
                    ),
                    'linkDownload' => array(
                        'header' => 'Link Download',
                        'value' => function($data) {
                            if ($data->id) {
                                $api = new ClaAPI();
                                $respon = $api->createUrl(array(
                                    'basepath' => 'media/media/downloadfile',
                                    'params' => json_encode(array('id' => $data->id, ClaSite::LANGUAGE_KEY => Yii::app()->language)),
                                    'absolute' => 'true',
                                ));
                                if ($respon) {
                                    return $respon['url'];
                                }
                            }
                        }
                    ),
                    'download' => array(
                        'header' => 'Download',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width: 40px; text-align:center;'),
                        'value' => function ($data) {
                            if ($data->id) {
                                $api = new ClaAPI();
                                $respon = $api->createUrl(array(
                                    'basepath' => 'media/media/downloadfile',
                                    'params' => json_encode(array('id' => $data->id, ClaSite::LANGUAGE_KEY => Yii::app()->language)),
                                    'absolute' => 'true',
                                ));
                                if ($respon) {
                                    return '<a href="' . $respon['url'] . '"><i class="icon-download" style="font-size: 19px;"></i></a>';
                                }
                            }
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {delete} ',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'updateButtonUrl' => 'Yii::app()->createUrl("media/file/update", array("id" => $data->id))',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'deleteButtonUrl' => 'Yii::app()->createUrl("media/file/delete",array("id"=>$data->id))',
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/media/file/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>