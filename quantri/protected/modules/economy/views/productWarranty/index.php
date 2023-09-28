<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#product-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('warranty', 'warranty_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/productWarranty/create'); ?>"
               class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('product', 'product_create_warranty_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/productWarranty/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="product-grid">
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
            </div>
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
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
                    'product_name',
                    'imei',
                    'phone',
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            $status = ProductWarranty::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'num' => array(
                        'name' => 'num',
                        'value' => function ($data) {
                            return $data->num;
                        }
                    ),
                    'start_date' => array(
                        'name' => 'start_date',
                        'value' => function ($data) {
                            return ($data->start_date) ? date('d/m/Y', strtotime($data->start_date)) : '';
                        }
                    ),
                    'end_date' => array(
                        'name' => 'end_date',
                        'value' => function ($data) {
                            return ($data->end_date) ? date("d/m/Y", strtotime($data->end_date)) : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => ' {update} {delete}',
                        'buttons' => array(
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("economy/product/copy", array("id" => $data->id))',
//                                'options' => array('class' => 'icon-files-o', 'title' => 'Copy'),
//                                'visible' => (($data->status == 0) ? true : false),
//                                'visible' => false ,
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("economy/product/copy", array("id" => $data->id))',
//                                'options' => array('class' => 'icon-files-o', 'title' => 'Copy'),
//                                'visible' => true ,
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
//                        'viewButtonLabel' => '',
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
//                    'translate' => array(
//                        'header' => Yii::t('common', 'translate'),
//                        'type' => 'raw',
//                        'visible' => ClaSite::showTranslateButton() ? true : false,
//                        'htmlOptions' => array('class' => 'button-column'),
//                        'value' => function ($data) {
//                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/product/update', 'params' => array('id' => $data->id), 'model' => $data));
//                        }
//                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>