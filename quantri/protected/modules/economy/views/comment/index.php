<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#comment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('comment', 'listcomment'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/comment/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="orders-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/comment/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('common', 'add'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="pageSizealign">
                <?php
//                $this->widget('common.extensions.PageSize.PageSize', array(
//                    'mGridId' => 'comment-grid', //Gridview id
//                    'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
//                    'mDefPageSize' => Yii::app()->params['defaultPageSize'],
//                ));
                ?>
            </div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'comment-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'rowCssClassExpression' => '($data->viewed == 1) ? "" : "warning"',
                'filter' => null,
                'enableSorting' => true,
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
                    'number' => array(
                        'header' => '#',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                    ),
                    //'news_id',
                    'name',
//                    'rating',
                    'object_id' => array(
                        'name' => Yii::t('comment', 'object_id'),
                        'type' => 'raw',
                        'value' => function($data) {
                            if ($data->type == Comment::COMMENT_PRODUCT) {
                                $object = Product::model()->findByPk($data->object_id);
                                return '<a target="_blank" href="' . Yii::app()->createUrl('../economy/product/detail', array('id' => $object['id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->name) . '</a>';
                            } else if ($data->type == Comment::COMMENT_NEWS) {
                                $object = News::model()->findByPk($data->object_id);
                                return '<a target="_blank" href="' . Yii::app()->createUrl('../news/news/detail', array('id' => $object['news_id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->news_title) . '</a>';
                            } else if ($data->type == Comment::COMMENT_QUESTION) {
                                $object = QuestionAnswer::model()->findByPk($data->object_id);
                                return '<a target="_blank" href="' . Yii::app()->createUrl('../economy/question/detail', array('id' => $object['question_id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->question_content) . '</a>';
                            } else if ($data->type == Comment::COMMENT_CATEGORY_NEWS) {
                                $object = NewsCategories::model()->findByPk($data->object_id);
                                return '<a target="_blank" href="' . Yii::app()->createUrl('../news/news/category', array('id' => $object['cat_id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->cat_name) . '</a>';
                            }
//                            return $data->object_id;
//                          
                        },
                            ),
//                    'type' => array(
//                        'name' => 'type',
//                        'type' => 'raw',
//                        'value' => function($data) {
//                            return $data->object_id;
//                            return ActiveRecord::typeCommentArray()[$data->type];
//                            return ActiveRecord::typeCommentArray()[$data->type];
//                        },
//                    ),
                            'content' => array(
                                'name' => 'content',
                                'type' => 'raw',
                                'value' => function($data) {
                                    return HtmlFormat::subCharacter($data->content);
                                }
                            ),
                    'email_phone',

                    'created_time' => array(
                                'name' => 'created_time',
                                'type' => 'raw',
                                'value' => function($data) {
                                    return date('d/m/Y-h:s:t', $data->created_time);
                                },
                            ),
//                            'status' => array(
//                                'name' => 'status',
//                                'type' => 'raw',
//                                'value' => function($data) {
//                                    $status = ActiveRecord::statusArray();
//                                    $st = isset($status[$data->status]) ? $status[$data->status] : '';
//                                    if ($data->status == ActiveRecord::STATUS_ACTIVED)
//                                        $st = $st;
//                                    return $st;
//                                }
//                            ),
                            'viewed' => array(
                                'name' => 'viewed',
                                'type' => 'html',
                                'value' => function($data) {
                                    return (($data->viewed == 1) ? 'Đã trả lời' : 'Chưa trả lời') . (($data->status == ActiveRecord::STATUS_ACTIVED) ? '-(Hiện)' : '-(Ẩn)');
                                }
                            ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update} {delete}',
                                'viewButtonLabel' => '',
                                'viewButtonOptions' => array('class' => 'icon-eye'),
                                'viewButtonImageUrl' => false,
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