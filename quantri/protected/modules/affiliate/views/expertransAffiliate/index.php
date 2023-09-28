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
                            'mGridId' => 'orders-grid', //Gridview id
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
                        'value' => function ($data) {
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
                        'value' => function ($data) {
                            return '<a href="' . Yii::app()->createUrl('affiliate/expertransAffiliate/affLink', array('user_id' => $data->user_id)) . '">' . AffiliateLink::countLink($data->user_id) . '</a>';
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
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("affiliate/expertransAffiliate/updateUser", array("id"=>$data->user_id))',
                            ),
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("affiliate/expertransAffiliate/viewUser", array("id"=>$data->user_id))',
                            ),
                            'view' => array(
                                'url' => 'Yii::app()->createUrl("affiliate/expertransAffiliate/viewUser", array("id"=>$data->user_id))',
                            ),
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/content/users/updateNormal', 'params' => array('id' => $data->user_id)));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>