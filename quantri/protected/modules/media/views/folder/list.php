<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
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
            <?php echo Yii::t('file', 'folder_manager') . ' ' . $folder->folder_name; ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('media/file/create', array('fid' => $folder->folder_id)); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('file', 'file_create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('media/file/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="folder-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            $model = new Files();
            $model->unsetAttributes();
            $model->folder_id = $folder->folder_id;
            //
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'folder-grid',
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
                        'value' => function($data) {
                            return Files::GetStringSizeFormat($data->size);
                        }
                    ),
                    'extension',
                    'download' => array(
                        'header' => 'Download',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width: 40px; text-align:center;'),
                        'value' => function($data) {
                    if ($data->id) {
                        $api = new ClaAPI();
                        $respon = $api->createUrl(array(
                            'basepath' => 'media/media/downloadfile',
                            'params' => json_encode(array('id' => $data->id)),
                            'absolute' => 'true',
                        ));
                        if ($respon) {
                            return '<a href="' . $respon['url'] . '"><i class="icon-download" style="font-size: 19px;"></i></a>';
                        }
                    }
                }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'type' => 'raw',
                        'value' => function($data) {
                            return date('m-d-Y', $data->created_time);
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
                ),
            ));
            ?>
        </div>
    </div>
</div>