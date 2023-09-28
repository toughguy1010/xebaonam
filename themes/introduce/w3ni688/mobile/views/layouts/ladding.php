<?php $this->beginContent('//layouts/main'); ?>
<?php $themUrl = Yii::app()->theme->baseUrl;$vs = '1.1.9';?>
<link href='<?php echo $themUrl ?>/css/plugin.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>
<link href='<?php echo $themUrl ?>/css/one.css?v=<?= $vs ?>' rel='stylesheet' type='text/css'/>

<?php echo $content;?>
<script src="<?php echo $themUrl ?>/js/wow.min.js"></script>    
<script type="text/javascript">
	new WOW().init();
</script> 
<?php $this->endContent(); ?>	