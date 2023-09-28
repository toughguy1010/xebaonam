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
            $.fn.yiiGridView.update('news-categories-grid');
        }
   }); 
});

");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('car', 'manager_receipt_fee'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('car/carReceiptFee/create', array('id' => ClaCategory::CATEGORY_ROOT)); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('car', 'create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('car/carReceiptFee/delallcat'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="news-categories-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'car-categories-grid',
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
                        'value' => '$data["id"]',
                        'selectableRows' => 150,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'name' => array(
                        'header' => Yii::t("car", "name_receipt_fee"),
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    'number_plate_fee' => array(
                        'header' => Yii::t("car", "number_plate_fee"),
                        'name' => 'number_plate_fee',
                        'type' => 'raw',
                    ),
                    'registration_fee' => array(
                        'header' => Yii::t("car", "registration_fee"),
                        'name' => 'registration_fee',
                        'type' => 'raw',
                    ),
                    'inspection_fee' => array(
                        'header' => Yii::t("car", "inspection_fee"),
                        'name' => 'inspection_fee',
                        'type' => 'raw',
                    ),
                    'road_toll' => array(
                        'header' => Yii::t("car", "road_toll"),
                        'name' => 'road_toll',
                        'type' => 'raw',
                    ),
                    'insurance_fee' => array(
                        'header' => Yii::t("car", "insurance_fee"),
                        'name' => 'insurance_fee',
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_addnew} {update} {delete} ',
                        'buttons' => array(
                            '_addnew' => array(
                                'label' => '',
                                'url' => 'Yii::app()->createUrl("car/carReceiptFee/create", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-file-text', 'title' => Yii::t('product', 'product_create')),
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("car/carReceiptFee/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("car/carReceiptFee/delete", array("id" => $data["id"]))',
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
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/car/carReceiptFee/update', 'params' => array('id' => $data['id'])));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>