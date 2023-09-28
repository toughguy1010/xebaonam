<?php $this->beginContent('//layouts/main'); ?>
<style>#main { background:#fff;}</style>
<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<?php echo $content; ?>
<?php
//$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
?>
<?php $this->endContent(); ?>