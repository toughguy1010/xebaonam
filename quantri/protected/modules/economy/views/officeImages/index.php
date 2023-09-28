<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#banners-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            Quản lý ảnh văn phòng
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/officeImages/create'); ?>" class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('officener', 'office_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/officeImages/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="banners-grid">
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
                    'bannergroup' => $bannergroup,
                ));
                ?>
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'banners-grid', //Gridview id
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
                'id' => 'banners-grid',
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
                    'image' => array(
                        'header' => Yii::t('menu', 'image'),
                        'name' => 'image',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<img src="' . $data->src . '" style="max-width: 200px;" width="200">';
                        }
                    ),
                    'from_area', 'to_area',
                    'name' => array(
                        'header' => Yii::t('menu', 'name'),
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return ($data['actived'] . '' != '' . ActiveRecord::STATUS_ACTIVED) ? '<span style="color:#aaa;">' . $data['name'] . '</span>' : $data['name'];
                        }
                    ),
                    'actived' => array(
                        'name' => 'actived',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center;'),
                        'value' => function ($data) {
                            return ($data->actived == ActiveRecord::STATUS_ACTIVED) ? '<i class="icon-eye"></i>' : '<i class="icon-eye-slash"></i>';
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
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/officeImages/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>