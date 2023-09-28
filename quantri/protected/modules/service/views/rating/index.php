<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#service-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('rating', 'rating_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('service/rating/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="service-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'service-grid',
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
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'user_id' => array(
                        'name' => 'user_id',
                        'type' => 'raw',
                        'value' => function($data) {
                            $user = Users::model()->findByPk($data->user_id);
                            return isset($user->name) ? $user->name : '';
                        }
                    ),
                    'rating' => array(
                        'name' => 'rating',
                        'value' => function($data) {
                            return $data->rating;
                        }
                    ),
                    'Site' => array(
                        'name' => 'Site',
                        'value' => function($data) {
                            $site = SiteSettings::model()->findByPk($data->object_id);
                            return isset($site['site_title']) ? $site['site_title'] : '';
                        }
                    ),
                    'content' => array(
                        'name' => 'content',
                        'value' => function($data) {
                            return $data->content;
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function($data) {
                            $status = ActiveRecord::statusArray();

                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {delete} ',
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/service/rating/update", array("id" => $data->id))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/service/rating/delete", array("id" => $data->id))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/service/rating/update', 'params' => array('id' => $data->id), 'model' => $data));
                }
                    ),
                ),
            ));
            ?>     
        </div>
    </div>
</div>