<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#themes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
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
            $.fn.yiiGridView.update('themes-grid');
        }
   }); 
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('theme', 'theme_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('setting/themesetting/category'); ?>" class="btn btn-xs btn-success" style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('category', 'category_manager'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('setting/themesetting/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('theme', 'theme_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('setting/themesetting/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="themes-grid">
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
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'themes-grid', //Gridview id
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
                'id' => 'themes-grid',
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
                    'theme_picture' => array(
                        'header' => '',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'width:200px;'),
                        'value' => function($data) {
                    return ($data->avatar_path && $data->avatar_name) ? '<img src="' . ClaHost::getImageHost() . $data->avatar_path . 's200_200/' . $data->avatar_name . '"/>' : '';
                }
                    ),
                    'theme_id',
                    'theme_name',
                    'theme_type' => array(
                        'name' => 'theme_type',
                        'value' => function($data) {
                            $themeTypes = ClaSite::getSiteTypes();
                            return isset($themeTypes[$data->theme_type]) ? $themeTypes[$data->theme_type] : '';
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function($data) {
                            $status = Themes::getThemeStatus();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return date('d-m-Y H:i', $data->created_time);
                        }
                    ),
                    'order' => array(
                        'name' => 'order',
                        'type' => 'raw',
                        'value' => function($data) {
                            return CHtml::textField('order', $data['order'], array('class' => 'updateorder', 'style' => 'width: 50px;', 'rel' => Yii::app()->createUrl('/setting/themesetting/updatethemeorder', array('id' => $data['theme_id'],))));
                        },
                                'htmlOptions' => array('style' => 'width: 50px;'),
                            ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{_preview} {_previewadmin} {_copy} {update} {delete} ',
                                'buttons' => array(
                                    '_preview' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => '$data->previewlink',
                                        'options' => array('class' => 'icon-search', 'title' => 'Preview', 'target' => '_blank'),
                                    ),
                                    '_previewadmin' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => '$data->previewlink."/".ClaSite::getAdminEntry()',
                                        'options' => array('class' => 'icon-wrench', 'title' => 'Admin', 'target' => '_blank'),
                                    ),
                                    '_copy' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("setting/themesetting/copy", array("id" => $data["theme_id"]))',
                                        'options' => array('class' => 'icon-files-o', 'title' => 'Copy'),
                                    ),
                                    'update' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("setting/themesetting/update", array("id" => $data["theme_id"]))',
                                        'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                    ),
                                    'delete' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("setting/themesetting/delete", array("id" => $data["theme_id"]))',
                                        'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width: 250px;',
                                    'class' => 'button-column',
                                ),
                            ),
                        ),
                    ));
                    ?>
        </div>
    </div>
</div>