<?php 
$this->breadcrumbs = array(
    Yii::t('common', 'page_widget_list') => $this->createUrl('pagewidgetlist'),
    $data->widget_title => array(''),
);
Yii::app()->clientScript->registerScript('formhtml', "
             CKEDITOR.replace('config_html');
        ", CClientScript::POS_READY);
?>
<div style="padding-top: 10px;">
    <form method="POST">
        <textarea name="config_html"><?php echo $data->html ?></textarea>
        <input style="margin-top: 20px;" class="btn btn-primary" id="savewidgetconfig" type="submit" name="yt0" value="Lưu">
    </form>
</div>