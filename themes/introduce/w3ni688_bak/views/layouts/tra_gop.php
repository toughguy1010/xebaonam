<?php $this->beginContent('//layouts/main'); ?>
<div class="installment">
	<div class="container">
		<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
		<?php
		echo $content;
		?>
	</div>
</div>
<?php $this->endContent(); ?>