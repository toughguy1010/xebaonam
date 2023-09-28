<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

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
                    // 'avatar' => array(
                    //     'header' => '',
                    //     'type' => 'raw',
                    //     'value' => function($data) {
                    //         if ($data->avatar_path && $data->avatar_name)
                    //             return '<img width="50px;" src="' . ClaUrl::getImageUrl($data->avatar_path,$data->avatar_name,['width'=>50,'height'=>50]). '" />';
                    //         return '';
                    //     }
                    // ),
                    'created_at' => array(
                        'name' => 'created_at',
                        'value' => function($data) {
                            return ($data->created_at) ? date('d-m-Y H:i', $data->created_at) : '';
                        }
                    ),
                    'LastName' => array(
                        'header' => 'Khách hàng',
                        'name' => 'LastName',
                        'value' => function($data) {
                            return $data->FirstName.' '.$data->LastName;
                        }
                    ),
                    'domainName',
                    'tld',
                    'Email',
                    'Price' => array(
                        'name' => 'Price',
                        'value' => function($data) {
                            if ($data->Price)
                                return HtmlFormat::money_format($data->Price);
                            return '';
                        }
                    ),
                    array(
                        'header' => '+ 10% VAT',
                        'value' => function($data) {
                            if ($data->Price)
                                return HtmlFormat::money_format($data->Price + $data->Price/10);
                            return '';
                        }
                    ),
                    'isRegister' => array(
                        'name' => 'isRegister',
                        'type' => 'raw',
                        'value' => function($data) {
                            $html = '';
                            if($data->isRegister) {
                                $html= '<a href="'.Yii::app()->createUrl("/domain/zcom/addTime", array("id" => $data->id)).'" title="Click gia hạn" >Đã đăng ký</a>';
                            } else {
                                $html= '<a href="'.Yii::app()->createUrl("/domain/zcom/view", array("id" => $data->id)).'" title="Click đăng ký" >Chưa đăng ký</a>';
                            }
                            return $html;
                        }
                    ),
                    'date_exp' => array(
                        'name' => 'date_exp',
                        'value' => function($data) {
                            return ($data->date_exp) ? date('d-m-Y H:i', $data->date_exp) : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_preview} {update} {delete}',
                        'buttons' => array(
                            '_preview' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'type' => 'raw',
                                'url' => 'Yii::app()->createUrl("/domain/zcom/view", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-search', 'title' => 'Preview', 'target' => '_blank'),
                            ),
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                // 'url' => 'Yii::app()->createUrl("/content/news/update", array("id" => $data->news_id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                // 'url' => 'Yii::app()->createUrl("/content/news/delete", array("id" => $data->news_id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
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
            )); ?>
        </div>
    </div>
</div>