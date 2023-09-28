<?php $this->beginContent('//layouts/main'); ?>
<!--<style>body{ background:#fff;}</style>-->
<?php //$this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<div class="page-in page-list-store">
    <?php echo $content; ?>
</div>
<?php
//$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_QUESTION_MOBILE));
?>
<?php $this->endContent(); ?>