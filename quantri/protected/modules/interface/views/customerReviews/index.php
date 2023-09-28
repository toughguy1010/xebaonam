<?php
/* @var $this BdsBrokerController */
/* @var $model BdsBroker */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#broker-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php
            echo Yii::t('reviews', 'reviews_manager');
            ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('interface/customerReviews/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('reviews', 'reviews_create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('interface/customerReviews/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="broker-grid">
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
                            'mGridId' => 'broker-grid', //Gridview id
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
                'id' => 'broker-grid',
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
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'avatar' => array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function($data) {
                            if ($data->avatar_path && $data->avatar_name)
                                return '<img src="' . ClaHost::getImageHost() . $data->avatar_path . 's50_50/' . $data->avatar_name . '" />';
                            return '';
                        }
                    ),
                    'customer_name',
                    'review'=>array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function($data) {
                            return $data->review;
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return ($data->created_time) ? date('d-m-Y', $data->created_time) : '';
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
                ),
            ));
            ?>
        </div>
    </div>
</div>