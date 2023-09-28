<?php $this->beginContent('//layouts/main'); ?>
<?php echo $content; ?>
<?php
$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
?>
<?php $this->endContent(); ?>