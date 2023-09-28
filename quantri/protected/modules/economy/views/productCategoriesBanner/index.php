<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
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

$('.search-active-form form').submit(function(){
	$('#banner-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

");


?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            Banner danh mục
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/productCategoriesBanner/create', array('id' => ClaCategory::CATEGORY_ROOT)); ?>"
               class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                Thêm banner
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/productCategoriesBanner/delall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="news-categories-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-main">
        <div class="search-active-form" style="position: relative; margin-top: 10px;">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
            <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
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
        <div class="widget-body">
            <div class="widget-main">

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'banner-grid',
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
                        'avatar' => array(
                            'name' => 'avatar',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $ava = '<img src="' . ClaHost::getImageHost() . $data['image_path'] . 's100_100/' . $data['image_name'] . '" />';
                                return $ava;
                            }
                        ),
                        'name' => array(
                            'header' => 'name',
                            'name' => 'name',
                            'type' => 'raw',
                        ),
                        'category_id' => array(
                            'name' => 'category_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return ProductCategories::model()->findByPk($data['category_id'])->cat_name;
                            }
                        ),
                        'position' => array(
                            'name' => 'position',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $arr = ProductCategoriesBanner::arrPosition();
                                $result = '';
                                if ($data['position'] == ProductCategoriesBanner::POS_MODULE) {
                                    $result = '<b>' . $arr[$data['position']] . '</b>';
                                } else if ($data['position'] == ProductCategoriesBanner::POS_MENU) {
                                    $result = '<b style="color: red">' . $arr[$data['position']] . '</b>';
                                } else {
                                    $result = $arr[$data['position']];
                                }
                                return $result;
                            }
                        ),
                        'order',
                        'status' => array(
                            'name' => 'status',
                            'header' => Yii::t('common', 'status'),
                            'value' => function ($data) {
                                $status = ActiveRecord::statusArray();
                                return isset($status[$data['status']]) ? $status[$data['status']] : '';
                            },
                            'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => ' {update} {delete} ',
                            'buttons' => array(
                                'update' => array(
                                    'label' => '',
                                    'imageUrl' => false,
                                    'url' => 'Yii::app()->createUrl("economy/productCategoriesBanner/update", array("id" => $data["id"]))',
                                    'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                ),
                                'delete' => array(
                                    'label' => '',
                                    'imageUrl' => false,
                                    'url' => 'Yii::app()->createUrl("economy/productCategoriesBanner/delete", array("id" => $data["id"]))',
                                    'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                ),
                            ),
                            'htmlOptions' => array(
                                'style' => 'width: 150px;',
                                'class' => 'button-column',
                            ),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>