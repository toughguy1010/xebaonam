<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('site', 'storage_manager'); ?>
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('_search_storage', array(
                    'model' => $model,
                ));
                ?>
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'news-grid', //Gridview id
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
                'id' => 'news-grid',
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
                    ),
                    'storage' => array(
                        'name' => 'storage',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<strong>'.ClaStorage::format_size($data->storage).'</strong>';
                        }
                    ),
                    'storage_limit' => array(
                        'name' => 'storage_limit',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return ClaStorage::format_size($data->storage_limit*1024*1024);
                        }
                    ),
                    'percent' => array(
                        'name' => 'Mức độ sử dụng',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $discount = round($data->storage / ($data->storage_limit*1024*1024),4)*100 .'%';
                            $color = 'lightgreen';
                            if ($discount >= 100) {
                                $color = '#AF4E96';
                            }
                            if ($discount < 100 && $discount>=80) {
                                $color = '#DA5430';
                            }
                            if ($discount < 80 && $discount>=40) {
                                $color = '#2a91d8';
                            }
                            if ($discount < 40) {
                                $color = '#59a84b';
                            }
                            return "<strong style='color: ".$color."'>".$discount."</strong>";
                        }
                    ),
                    'domain' => array(
                        'name' => 'Tên miền',
                        'type' => 'raw',
                        'value' => function ($data) {
                            $domain = SiteSettings::model()->findByPk($data->site_id)->domain_default;
                            return $domain;
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_preview}',
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                        'buttons' => array(
                            '_preview' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'type' => 'raw',
                                'url' => function ($data) {
                                    $respon = Yii::app()->createUrl('/site/detailStorage',['id' => $data->site_id]);
                                    return $respon;
                                },
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-search', 'title' => 'Preview'),
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>