<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('user', 'user_admin_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate/create'); ?>" class="btn btn-xs btn-primary">
                <i class="icon-plus"></i>
                <?php echo Yii::t('user', 'user_add'); ?>
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
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'users-grid', //Gridview id
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
                'id' => 'users-grid',
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
                    'user_id',
                    'user_name',
                    'email',
                    'sex' => array(
                        'name' => 'sex',
                        'value' => function($data) {
                            $listS = ClaUser::getListSexArr();
                            return isset($listS[$data->sex]) ? $listS[$data->sex] : '';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function ($data) {
                            if ($data->created_time) {
                                return date('d-m-Y', $data->created_time);
                            }
                            return '';
                        }
                    ),
                    'site_id' => array(
                        'header' => 'Site',
                        'type' => 'raw',
                        'visible' => (ClaUser::isSupperAdmin()) ? true : false,
                        'value' => function ($data) {
                            $site = ClaSite::getSiteInfo($data->site_id);
                            if ($site) {
                                return '<a href="' . Yii::app()->createUrl('/manager/site/update', array('id' => $data->site_id)) . '">' . $site['domain_default'] . '<a>';
                            }
                        },
                            ),
                    'is_root' => array(
                        'header' => 'Is Root',
                        'type' => 'raw',
                        'visible' => (ClaUser::isSupperAdmin()) ? true : false,
                        'value' => function ($data) {
                            return $data->is_root;
                        },
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
                                        'url' => 'Yii::app()->createUrl("/UsersAffilliate/UsersAffilliate/update", array("id" => $data->user_id))',
                                        'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                        'visible' => '$data->canUpdate();',
                                    ),
                                    'delete' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("/UsersAffilliate/UsersAffilliate/delete", array("id" => $data->user_id))',
                                        'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                        'visible' => '$data->canUpdate();',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    ?>
        </div>
    </div>
</div>