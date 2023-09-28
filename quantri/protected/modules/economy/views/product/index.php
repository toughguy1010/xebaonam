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
            <a href="<?php echo Yii::app()->createUrl('economy/productcategory'); ?>" class="btn btn-xs btn-success" style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('product', 'product_category'); ?>
            </a>
            <?php  if (ClaUser::isSupperAdmin() || (Yii::app()->controller->site_id == 1863) ||  (Yii::app()->controller->site_id == 1922)||  (Yii::app()->controller->site_id == 1142)) { ?>
                <a href="<?php echo Yii::app()->createUrl('economy/product/importExcelCustom'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                    <i class="icon-plus"></i>
                    <?php echo Yii::t('product', 'product_create_excel'); ?>
                </a>
            <?php  }else{
                ?>
                <a href="<?php echo Yii::app()->createUrl('economy/product/importExcel'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                    <i class="icon-plus"></i>
                    <?php echo Yii::t('product', 'product_create_excel'); ?>
                </a>
                <?php
            } ?>

            <a href="<?php echo Yii::app()->createUrl('economy/product/exportcsv/');?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                    <i class="icon-plus"></i>
                    <?php echo Yii::t('product', 'product_export_excel'); ?>
                </a>
            <a href="<?php echo Yii::app()->createUrl('economy/product/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('product', 'product_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/product/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="product-grid">
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
                    'avatar' => array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function($data) {
                            if ($data->avatar_path && $data->avatar_name)
                                return '<img width="50px;" src="' . ClaUrl::getImageUrl($data->avatar_path,$data->avatar_name,['width'=>50,'height'=>50]). '" />';
                            return '';
                        }
                    ),
                    'code',
                    'color',
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
                    'product_category_id' => array(
                        'name' => 'product_category_id',
                        'value' => function($data) {
                            return Yii::app()->controller->category->getCateName($data->product_category_id);
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'state' => array(
                        'name' => 'Tình trạng',
                        'visible' =>  (Yii::app()->controller->site_id == 1187) ? true : false, //momokids.vn
                        'value' => function($data) {
                            return ($data->state) ? 'Còn hàng' : 'Hết hàng';
                        }
                    ),
                    'ishot' => array(
                        'name' => 'SP Hot',
                        'value' => function($data) {
                            return ($data->ishot) ? 'Có' : '';
                        }
                    ),
                    'isnew' => array(
                        'name' => 'SP Mới',
                        'value' => function($data) {
                            return ($data->isnew) ? 'Có' : '';
                        }
                    ),
//                    'members_only'=> array(
//                        'name' => 'For Member',
//                        'value' => function($data) {
//                            return ($data->members_only) ? 'Có' : '';
//                        }
//                    ),
                    'viewed',
                    'position',
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return ($data->created_time) ? date('d-m-Y', $data->created_time) : '';
                        }
                    ),
                    'modified_time' => array(
                        'name' => 'modified_time',
                        'visible' =>  (ClaUser::isSupperAdmin()) ? true : false,
                        'value' => function($data) {
                            return ($data->modified_time) ? date('d-m-Y H:i:s', $data->modified_time) : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_preview} {update}  {_copy}  {delete}',
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
                                    'update' => array(
                                        'label' => '',
                                        'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("/content/news/update", array("id" => $data->news_id))',
                                        'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                    ),
                                    'delete' => array(
                                        'label' => '',
                                        'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("/content/news/delete", array("id" => $data->news_id))',
                                        'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                    ),
                                    '_copy' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("economy/product/copy", array("id" => $data->id))',
                                        'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-files-o', 'title' => 'Nhân thêm sản phẩm'),
                                    ),
                                    '_copytwo' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("economy/product/copyTwo", array("id" => $data->id))',
                                        'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-files-o', 'title' => 'Copy'),
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
                            'translate' => array(
                                'header' => Yii::t('common', 'translate'),
                                'type' => 'raw',
                                'visible' => ClaSite::showTranslateButton() ? true : false,
                                'htmlOptions' => array('class' => 'button-column'),
                                'value' => function($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/product/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                            ),
                        ),
                    ));
                    ?>
        </div>
    </div>
</div>