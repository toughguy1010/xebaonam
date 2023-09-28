<?php
$this->breadcrumbs = array(
    Yii::t('common', 'page_widget_list') => array('pagewidgetlist'),
);
?>
<div class="page-content">
    <div class="widget-box">
        <div class="widget-header">
            <h4><?php echo Yii::t('common', 'page_widget_list') ?></h4>
        </div>
        <div class="widget-body">
            <div class="widget-main">
                <div id="news-grid" class="grid-view">
                    <table class="table table-bordered table-hover vertical-center">
                        <thead>
                            <tr>
                                <th id="news-grid_cnews_title">Tiêu đề</th>
                                <th id="news-grid_cnews_category_id">Nội dung</th>
                                <th class="button-column" id="news-grid_c1">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($data_modules_html) and count($data_modules_html) > 0) {
                                foreach ($data_modules_html as $item) {
                                    $json = json_decode($item['config_data']);
                                    ?>
                                    <tr class="odd">
                                        <td><?php echo $item['widget_title'] ?></td>
                                        <td><?php echo $json->html ?></td>
                                        <td class="button-column">
                                            <a class="icon-edit" title="" href="<?php echo $this->createUrl('editPagewidgetlist', array('page_widget_id' => $item['page_widget_id'])) ?>"></a>  
                                            <?php if (ClaUser::isSupperAdmin()) { ?>
                                            <a onclick="return confirm('<?php echo Yii::t('notice', 'areyousuredelete') ?>')" class="icon-trash" title="" href="<?php echo $this->createUrl('deletePagewidgetlist', array('page_widget_id' => $item['page_widget_id'])) ?>"></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            <tr class="odd">
                                <td><?php echo Yii::t('common', 'setting_footer'); ?></td>
                                <td><?php echo $footer_content ?></td>
                                <td class="button-column">
                                    <a class="icon-edit" title="" href="<?php echo Yii::app()->createUrl('interface/sitesettings/footersetting', array('pagewidgetlist' => 1)); ?>"></a>  
                                </td>
                            </tr>
                            <tr class="odd">
                                <td><?php echo Yii::t('common', 'setting_contact'); ?></td>
                                <td><?php echo $contact ?></td>
                                <td class="button-column">
                                    <a class="icon-edit" title="" href="<?php echo Yii::app()->createUrl('interface/sitesettings/contact', array('pagewidgetlist' => 1)); ?>"></a>  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>        
            </div>
        </div>
    </div>                    
</div>