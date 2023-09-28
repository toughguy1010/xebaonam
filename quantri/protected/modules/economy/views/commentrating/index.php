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
            <?php echo Yii::t('comment', 'commentrating_manger'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="pageSizealign">
                <?php
                $this->widget('common.extensions.PageSize.PageSize', array(
                    'mGridId' => 'comment-grid', //Gridview id
                    'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                    'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                ));
                ?>
            </div>
            <p style="color: blue">Lưu ý: Vì liên quan đến điểm đánh giá chung của sản phẩm. Nên đánh giá có trạng thái
                "hiển thị" sẽ không thể xóa. (*)</p>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'comment-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'rowCssClassExpression' => '($data->is_view == 1) ? "" : "warning"',
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
                    //'news_id',
                    'email',
                    'rating' => array(
                        'name' => 'Điểm',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $scoreAry = ProductRating::scoreAry();
                            if (isset($data->rating) && $data->rating > 0 && $data->rating <= 5) {
                                return $data->rating .' - ('. $scoreAry[$data->rating].')';
//                                return $scoreAry[$scoreAry];
                            }
                        }
                    ),
                    'comment' => array(
                        'name' => 'comment',
//                        'type' => 'raw',
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return date('d/m/Y - h:s:t', $data->created_time);
                        },
                    ),
                    'status' => array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $status = ActiveRecord::statusArray();
                            $st = isset($status[$data->status]) ? $status[$data->status] : '';
                            if ($data->status == ActiveRecord::STATUS_ACTIVED)
                                $st = $st;
                            return $st;
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => ' {update} {delete}',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'buttons' => array(
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'visible' => '($data->status == ActiveRecord::STATUS_DEACTIVED) ? true : false',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                    ),
//                    'translate' => array(
//                        'header' => Yii::t('common', 'translate'),
//                        'type' => 'raw',
//                        'visible' => ClaSite::showTranslateButton() ? true : false,
//                        'htmlOptions' => array('class' => 'button-column'),
//                        'value' => function ($data) {
//                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/content/commentrating/update', 'params' => array('id' => $data->user_id)));
//                        }
//                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>