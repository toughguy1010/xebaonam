<?php $this->beginContent('//layouts/main_ladding'); ?>
<?php $themUrl = Yii::app()->theme->baseUrl;$vs = '1.0.1';?>



<?php echo $content;?>

<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<?php $this->endContent(); ?>	