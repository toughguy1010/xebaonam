<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#post-categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

jQuery(document).on('change','.updateorder',function(){
var url = jQuery(this).attr('rel');
var or  = jQuery(this).val();
   jQuery.ajax({
        type: 'POST',
        url: url,
        data: {or: or},
        success: function(){
            $.fn.yiiGridView.update('post-categories-grid');
        }
   }); 
});

");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('category', 'category_post'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('content/postcategory/addcat', array('pa' => isset($model->cat_parent) ? $model->cat_parent : ClaCategory::CATEGORY_ROOT)); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('category', 'category_add_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('content/postcategory/delallcat'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="post-categories-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'post-categories-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'summaryText' => false,
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
                        'htmlOptions' => array('style' => 'width: 50px; text-align: center;')
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'value' => '$data["cat_id"]',
                        'selectableRows' => 150,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'cat_name' => array(
                        'header' => Yii::t("category", "category_name"),
                        'name' => 'cat_name',
                        'type' => 'raw',
                    ),
                    'showinhome' => array(
                        'name' => 'showinhome',
                        'header' => Yii::t('category', 'showinhome'),
                        'value' => function($data) {
                    return (int) $data['showinhome'] ? Yii::t('common', 'yes') : Yii::t('common', 'no');
                },
                        'htmlOptions' => array('style' => 'width: 100px; text-align: center;'),
                    ),
                    'status' => array(
                        'name' => 'status',
                        'header' => Yii::t('common', 'status'),
                        'value' => function($data) {
                    $status = ActiveRecord::statusArray();
                    return isset($status[$data['status']]) ? $status[$data['status']] : '';
                },
                        'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
                    ),
                    'cat_order' => array(
                        'header' => Yii::t('category', 'category_order'),
                        'name' => 'cat_order',
                        'type' => 'raw',
                        'value' => function($data) {
                    return CHtml::textField('cat_order', $data['cat_order'], array('class' => 'updateorder', 'style' => 'width: 50px;', 'rel' => Yii::app()->createUrl('content/postcategory/updateorder', array('id' => $data['cat_id'],))));
                },
                        'htmlOptions' => array('style' => 'width: 50px;'),
                    ),
                    'add_child' => array(
                        'header' => Yii::t('category', 'category_add_child'),
                        'type' => 'raw',
                        'value' => function($data) {
                    return '<a class="icon-folder-open" style="font-size: 18px; position: relative;" href="' . Yii::app()->createUrl('content/postcategory/addcat', array('pa' => $data['cat_id'])) . '"><i class="icon-plus" style="font-size: 13px; position: absolute; top:-2px; left: -4px; color: #fe8100;"></i>' . '</a>';
                },
                        'htmlOptions' => array('style' => 'width: 100px; text-align: center;', 'title' => Yii::t('category', 'category_add_child')),
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_addnew} {update} {delete} ',
                        'buttons' => array(
                            '_addnew' => array(
                                'label' => '',
                                'url' => 'Yii::app()->createUrl("content/post/create", array("cat" => $data["cat_id"]))',
                                'options' => array('class' => 'icon-file-text', 'title' => Yii::t('post', 'post_create')),
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("content/postcategory/editcat", array("id" => $data["cat_id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("content/postcategory/delcat", array("id" => $data["cat_id"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/content/postcategory/editcat', 'params' => array('id' => $data['cat_id'])));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>