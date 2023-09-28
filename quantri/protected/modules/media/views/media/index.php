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
            <?php echo Yii::t('contact', 'site_contact_form'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
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
                    'image_src' => array(
                        'header' => 'Image',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align: center;'),
                        'value' => function($data) {
                    return $this->renderPartial('partial/image_view', array('model' => $data), true);
                }
                    ),
                    'name',
                    'email',
                    'phone',
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return ($data->created_time) ? date('d-m-Y', $data->created_time) : '';
                        }
                    ),
                    'note',
                    'status' => array(
                        'name' => 'status',
                        'header' => Yii::t('common', 'status'),
                        'value' => function($data) {
                            $status = ActiveRecord::statusPrintImageArray();
                            return isset($status[$data['status']]) ? $status[$data['status']] : '';
                        },
                        'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
                    ),
                    'payment_method' => array(
                        'name' => 'payment_method',
                        'header' => Yii::t('shoppingcart', 'payment_method'),
                        'value' => function($data) {
                            $status = ActiveRecord::statusPaymentMethod();
                            return isset($status[$data['payment_method']]) ? $status[$data['payment_method']] : '';
                        },
                        'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
                    ),
                    'payment_status' => array(
                        'name' => 'payment_status',
                        'header' => Yii::t('shoppingcart', 'payment_status'),
                        'value' => function($data) {
                            $status = ActiveRecord::statusPayment();
                            return isset($status[$data['payment_status']]) ? $status[$data['payment_status']] : '';
                        },
                        'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
                    ),
                    'transport_method' => array(
                        'name' => 'transport_method',
                        'header' => Yii::t('shoppingcart', 'transport_method'),
                        'value' => function($data) {
                            $status = ActiveRecord::transportMethod();
                            return isset($status[$data['transport_method']]) ? $status[$data['transport_method']] : '';
                        },
                        'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
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
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/banner/banner/update', 'params' => array('id' => $data->banner_id)));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>