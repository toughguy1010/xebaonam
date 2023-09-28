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
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('_search_product', array(
                    'model' => $model,
                ));
                ?>
                <div class="pageSizebox" style="position: relative; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'product-grid', //Gridview id
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
                'id' => 'product-grid',
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
                    'avatar' => array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function($data) {
                            if ($data->avatar_path && $data->avatar_name)
                                return '<img src="' . ClaHost::getImageHost() . $data->avatar_path . 's50_50/' . $data->avatar_name . '" />';
                            return '';
                        }
                    ),
                    'code',
                    'slogan',
                    'name',
                    'price' => array(
                        'name' => 'price',
                        'value' => function($data) {
                            if ($data->price)
                                return HtmlFormat::money_format($data->price);
                            return '';
                        }
                    ),
                    'price_market' => array(
                        'name' => 'price_market',
                        'value' => function($data) {
                            if ($data->price_market)
                                return HtmlFormat::money_format($data->price_market);
                            return '';
                        }
                    ),

                    'status' => array(
                        'name' => 'status',
                        'value' => function($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'viewed',
                    'position',
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_preview} {_copy} ',
                        'buttons' => array(
                            '_preview' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'type' => 'raw',
                                'url' => function($data) {
                                    $api = new ClaAPI();
                                    $respon = $api->createUrl(array(
                                        'basepath' => '/economy/product/detail',
                                        'params' => json_encode(array('id' => $data->id, 'alias' => $data->alias)),
                                        'absolute' => 'true',
                                    ));
                                    if ($respon) {
                                        return $respon['url'];
                                    }
                                },
                                        'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-search', 'title' => 'Preview', 'target' => '_blank'),
                                    ),
                                    '_copy' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("affiliate/affiliateLink/create", array("id" => $data->id))',
                                        'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-files-o', 'title' => 'Tạo link'),
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width: 130px;',
                                    'class' => 'button-column',
                                ),
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