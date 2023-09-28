<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('user', 'manager_user'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('content/users/createNormalUser'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('common', 'create_new'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="pageSizealign">
                <?php
                $this->widget('common.extensions.PageSize.PageSize', array(
                    'mGridId' => 'news-grid', //Gridview id
                    'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                    'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                ));
                ?>
            </div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'news-grid',
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
                    ),
                    'name' => array(
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    'phone',
                    'address',
                    'email',
                    'status' => array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => function($data) {
                            $status = ActiveRecord::statusArrayUser();
                            $st = isset($status[$data->status]) ? $status[$data->status] : '';
                            if ($data->status == ActiveRecord::STATUS_USER_WAITING)
                                $st = '<b>' . $st . '</b>';
                            return $st;
                        }
                    ),
                    'total_link' => array(
                        'header' => 'Số link đã tạo',
                        'type' => 'raw',
                        'value' => function($data) {
                            return AffiliateLink::countLink($data->user_id);
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {view}',
                        'viewButtonOptions' => array('class' => 'icon-eye'),
                        'viewButtonImageUrl' => false,
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("affiliate/affiliate/updateUser", array("id"=>$data->user_id))',
                            ),
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("affiliate/affiliate/viewUser", array("id"=>$data->user_id))',
                            ),
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/content/users/updateNormal', 'params' => array('id' => $data->user_id)));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>