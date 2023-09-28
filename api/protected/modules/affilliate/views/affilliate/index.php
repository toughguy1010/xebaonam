<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#affilliate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('affilliate', 'affilliate_list'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <!-- <a href="<?php echo Yii::app()->createUrl('economy/affilliate/exportExcelv2/'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('affilliate', 'affilliate_export_excel'); ?>
            </a> -->
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
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'affilliate-grid', //Gridview id
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
                'id' => 'affilliate-grid',
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
                    'object_id',
                    'created_time' => array(
                        'name' => 'created_at',
                        'value' => function ($model) {
                            return $model->show('created_at');
                        }
                    ),
                    'total' => array(
                        'name' => 'total',
                        'value' => function ($model) {
                            return $model->show('total');
                        }
                    ),
                    'percent' => array(
                        'name' => 'percent',
                        'value' => function ($model) {
                            return $model->show('percent');
                        }
                    ),
                    'value' => array(
                        'name' => 'value',
                        'value' => function ($model) {
                            return $model->show('value');
                        }
                    ),
                    'fn'
                ),
            ));
            ?>
        </div>
    </div>
</div>