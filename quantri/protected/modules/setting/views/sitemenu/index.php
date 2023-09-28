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

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('menu', 'menu_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('/setting/sitemenu/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 0px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('menu', 'menu_create'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'menus-grid',
                'itemsCssClass' => 'table table-bordered table-hover',
                'dataProvider' => $model->search(),
                'filter' => null,
                'columns' => array(
                    'menu_title' => array(
                        'header' => Yii::t('menu', 'menu_title'),
                        'name' => 'menu_title',
                        'type' => 'raw',
                        'value' => function($data) {
                    return ($data['status'] . '' != '' . ActiveRecord::STATUS_ACTIVED) ? '<span style="color:#aaa;">' . $data['menu_title'] . '</span>' : $data['menu_title'];
                }
                    ),
                    'menu_linkto' => array(
                        'header' => Yii::t('menu', 'menu_linkto'),
                        'name' => 'menu_linkto',
                        'value' => function($data) {
                    $linkto = MenusAdmin::getLinkToArr();
                    return $linkto[$data['menu_linkto']];
                },
                    ),
//                    'menu_link' => array(
//                        'name' => 'menu_link',
//                        'value' => function($data) {
//                    if ($data['menu_linkto'] == Menus::LINKTO_OUTER)
//                        return $data['menu_link'];
//                    else {
//                        $url = $data['menu_link'];
//                        return $url;
//                    }
//                },
//                    ),
                    'status' => array(
                        'header' => Yii::t('common', 'status'),
                        'name' => 'status',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center;width:100px'),
                        'value' => function($data) {
                    return ($data['status'] . '' == '' . ActiveRecord::STATUS_ACTIVED) ? '<i class="icon-eye"></i>' : '<i class="icon-eye-slash"></i>';
                }
                    ),
                    'menu_order' => array(
                        'header' => Yii::t('common', 'order'),
                        'name' => 'menu_order',
                        'htmlOptions' => array('style' => 'text-align:center;width:80px'),
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("setting/sitemenu/update", array("id" => $data["menu_id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("setting/sitemenu/delete", array("id" => $data["menu_id"]))',
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