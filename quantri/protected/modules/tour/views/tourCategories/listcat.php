<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-categories-grid').yiiGridView('update', {
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
            $.fn.yiiGridView.update('tour-categories-grid');
        }
   }); 
});

");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('tour', 'manager_category'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('tour/tourCategories/create', array('id' => ClaCategory::CATEGORY_ROOT)); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('tour', 'add_category'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('tour/tourCategories/delallcat'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="news-categories-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'tour-categories-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'summaryText' => false,
                'filter' => null,
                'enableSorting' => false,
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
                            return CHtml::textField('cat_order', $data['cat_order'], array('class' => 'updateorder', 'style' => 'width: 50px;', 'rel' => Yii::app()->createUrl('tour/tourCategories/updateorder', array('id' => $data['cat_id'],))));
                        },
                                'htmlOptions' => array('style' => 'width: 50px;'),
                            ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{_addnew} {update} {delete} ',
                                'buttons' => array(
                                    '_addnew' => array(
                                        'label' => '',
                                        'url' => 'Yii::app()->createUrl("tour/tourCategories/create", array("id" => $data["cat_id"]))',
                                        'options' => array('class' => 'icon-file-text', 'title' => Yii::t('product', 'product_create')),
                                    ),
                                    'update' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("tour/tourCategories/update", array("id" => $data["cat_id"]))',
                                        'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                    ),
                                    'delete' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("tour/tourCategories/delete", array("id" => $data["cat_id"]))',
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
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/tour/tourCategories/update', 'params' => array('id' => $data['cat_id']), 'model' => TourCategories::model()->findByPk($data['cat_id'])));
                        }
                            ),
                        ),
                    ));
                    ?>
        </div>
    </div>
</div>