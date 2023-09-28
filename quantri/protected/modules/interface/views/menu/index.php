<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#menus-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2><?php echo Yii::t('menu', 'menu_manager') ?></h2>

<?php echo CHtml::link(Yii::t('common', 'common_search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'menus-grid',
    'itemsCssClass' => 'table table-bordered table-hover',
    'dataProvider' => $model->search(),
    'filter' => null,
    'columns' => array(
        'menu_id',
        'menu_title',
        'parent_id',
        'menu_linkto' => array(
            'name' => 'menu_linkto',
            'value' => function($data) {
        $linkto = Menus::getLinkToArr();
        return $linkto[$data->menu_linkto];
    },
        ),
        'menu_link' => array(
            'name' => 'menu_link',
            'value' => function($data) {
        if ($data->menu_linkto == Menus::LINKTO_OUTER)
            return $data->menu_link;
        else {
            return Yii::app()->createUrl($data->menu_basepath, json_decode($data->menu_pathparams, true));
        }
    },
        ),
        'status' => array(
            'name' => 'status',
            'type' => 'raw',
            'value' => function($data) {
        return ($data->status == ActiveRecord::STATUS_ACTIVED) ? '<i class="icon-eye"></i>' : '<i class="icon-eye-slash"></i>';
    }
        ),
        'menu_order',
        'menu_group' => array(
            'name' => 'menu_group',
            'value' => function($data) {
        $menu_group = Menus::getMenuGroupArr();
        return isset($menu_group[$data->menu_group]) ? $menu_group[$data->menu_group] : '';
    },
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
        $this->widget('application.widgets.translate.translate', array('baseUrl' => '/interface/menu/update', 'params' => array('id' => $data->menu_id)));
    }
        ),
    ),
));
?>
