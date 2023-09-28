<?php
Yii::app()->clientScript->registerScript('search', "
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
            <?php echo Yii::t('menu', 'menu_group_manager') . ' ' . $menugroup->menu_group_name; ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('/interface/menu/create', array('mgid' => $menugroup->menu_group_id)); ?>" class="btn btn-xs btn-primary" style="margin-right: 0px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('menu', 'menu_create'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            $model = new Menus();
            $model->unsetAttributes();
            $model->menu_group = $menugroup->menu_group_id;
//
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'menus-grid',
                'itemsCssClass' => 'table table-bordered table-hover',
                'dataProvider' => $model->search(),
                'filter' => null,
                'columns' => array(
                    'number' => array(
                        'header' => '',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                        'htmlOptions' => array('style' => 'width: 50px; text-align: center;')
                    ),
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
                            $linkto = Menus::getLinkToArr();
                            return $linkto[$data['menu_linkto']];
                        },
                    ),
//                    'menu_link' => array(
//                        'header' => Yii::t('menu', 'menu_link'),
//                        'name' => 'menu_link',
//                        'value' => function($data) {
//                    if ($data['menu_linkto'] == Menus::LINKTO_OUTER)
//                        return $data['menu_link'];
//                    else {
//                        $url = $data['menu_link'];
//                        if (substr($url, 0, strlen('/quantri')) == '/quantri')
//                            return substr($url, strlen('/quantri'));
//                        else
//                            return $url;
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
                        'value' => function($data) {
                    return $data['menu_order'];
                }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("interface/menu/update", array("id" => $data["menu_id"],"mgid"=>$data["menu_group"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("interface/menu/delete", array("id" => $data["menu_id"],"mgid"=>$data["menu_group"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/interface/menu/update', 'params' => array('id' => $data['menu_id'], "mgid" => $data["menu_group"]), 'model' => Menus::model()->findByPk($data['menu_id'])));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>