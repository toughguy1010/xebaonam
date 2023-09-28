<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#videos-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('video', 'video_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('media/video/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('video', 'video_create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('media/video/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="videos-grid">
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
                            'mGridId' => 'videos-grid', //Gridview id
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
                'id' => 'videos-grid',
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
                    'avatar' => array(
                        'name' => 'avatar',
                        'type' => 'raw',
                        'value' => function ($data) {
                            if ($data->avatar_path && $data->avatar_name)
                                return '<img src="' . ClaHost::getImageHost() . $data->avatar_path . 's100_100/' . $data->avatar_name . '" style="max-width: 100px;" />';
                            return '';
                        },
                        'htmlOptions' => array('style' => 'width:110px;'),
                    ),
                    'video_title',
                    'cat_id' => array(
                        'name' => Yii::t('common', 'cat_name'),
                        'value' => function ($data) {
                            return Yii::app()->controller->category->getCateName($data->cat_id);
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            return Constant::statusArray()[$data->status];
                        },
                        'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
                    ),
                    'ishot' => array(
                        'name' => 'ishot',
                        'value' => function ($data) {
                            return ($data->video_prominent) ? 'Hot' : '';
                        },
                        'htmlOptions' => array('style' => 'width: 50px; text-align: center;'),
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
                    // 'translate' => array(
                    //     'header' => Yii::t('common', 'translate'),
                    //     'type' => 'raw',
                    //     'visible' => ClaSite::showTranslateButton() ? true : false,
                    //     'htmlOptions' => array('class' => 'button-column'),
                    //     'value' => function ($data) {
                    //         $this->widget('application.widgets.translate.translate', array('baseUrl' => '/media/video/update', 'params' => array('id' => $data->video_id)));
                    //     }
                    // ),
                ),
            ));
            ?>

        </div>
    </div>
</div>