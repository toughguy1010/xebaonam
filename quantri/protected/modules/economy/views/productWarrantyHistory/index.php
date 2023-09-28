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
            <?php echo Yii::t('product', 'product_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/productWarrantyHistory/create'); ?>"
               class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('product', 'product_create_warranty_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/productwarranty/deleteall'); ?>"
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
                <!--                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">-->
                <!--                    <div class="pageSizealign">-->
                <!--                        --><?php
                //                        $this->widget('common.extensions.PageSize.PageSize', array(
                //                            'mGridId' => 'product-grid', //Gridview id
                //                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                //                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                //                        ));
                //                        ?>
                <!--                    </div>-->
                <!--                </div>-->
            </div><!-- search-form -->
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
                    'email',
                    'status' => array(
                        'name' => 'status',
                        'type' => 'html',
                        'value' => function ($data) {
                            $status = ProductWarrantyHistory::statusArray();
                            if ($data->status == 4) {
                                return "<b style='color: blue'>" . $status[$data->status] . '</b>';
                            } else if ($data->status == 0) {
                                return "<b style='color: red'>" . $status[$data->status] . "</b>";
                            } else if ($data->status == 3) {
                                return "<b style='color: green'>" . $status[$data->status] . "</b>";
                            } else {
                                return isset($status[$data->status]) ? $status[$data->status] : '';
                            }
                        }
                    ),

//                    'num' => array(
//                        'name' => 'num',
//                        'value' => function ($data) {
//                            return $data->num;
//                        }
//                    ),
//                    'product_name',
                    'receipt_date' => array(
                        'name' => 'receipt_date',
                        'value' => function ($data) {
                            return ($data->receipt_date) ? date('d-m-Y', strtotime($data->receipt_date)) : '';
                        }
                    ),
                    'expected_date' => array(
                        'name' => 'expected_date',
                        'value' => function ($data) {
                            return ($data->expected_date) ? date('d-m-Y', strtotime($data->expected_date)) : '';
                        }
                    ),
                    'returns_date' => array(
                        'name' => 'returns_date',
                        'value' => function ($data) {
                            return ($data->returns_date) ? date('d-m-Y', strtotime($data->returns_date)) : '';
                        }
                    ),
//                    'end_date' => array(
//                        'name' => 'end_date',
//                        'value' => function ($data) {
//                            return ($data->end_date) ? date("d/m/Y", strtotime($data->end_date)) : '';
//                        }
//                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => ' {update} {delete} {repairing} {repairedSendmail} {complete}',
                        'buttons' => array(
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("economy/product/copy", array("id" => $data->id))',
//                                'options' => array('class' => 'icon-files-o', 'title' => 'Copy'),
//                                'visible' => (($data->status == 0) ? true : false),
                                'visible' => '(ClaSite::getAdminSession()) ? true : false',
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("economy/productWarranty/updateWarranty", array("id" => $data->id))',
//                                'options' => array('class' => 'icon-files-o', 'title' => 'Copy'),
                                'visible' => true,
                            ),
                            'repairing' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("economy/productWarrantyHistory/statusReparing", array("id" => $data->id))',
                                'options' => array('class' => 'icon-gavel', 'title' => 'Chuyển trạng thái sang đang sửa'),
                                'visible' => true,
                            ),
                            'repairedSendmail' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("economy/productWarrantyHistory/statusRepaied", array("id" => $data->id))',
                                'options' => array('class' => 'icon-envelope', 'title' => 'Chuyển trạng thái sửa xong và gửi mail cho khách hàng'),
                                'visible' => '$data->status != ProductWarrantyHistory::STATUS_REPAIR_COMPLETE && $data->status != ProductWarrantyHistory::STATUS_COMPLETE && $data->status != 0',
                            ),
                            'complete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("economy/productWarrantyHistory/statusComplete", array("id" => $data->id))',
                                'options' => array('class' => 'icon-check', 'title' => 'Hoàn thành bảo hành'),
                                'visible' => '$data->status == ProductWarrantyHistory::STATUS_REPAIR_COMPLETE && $data->status != ProductWarrantyHistory::STATUS_COMPLETE',
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