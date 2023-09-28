<?php $this->beginContent('//layouts/main') ?>

<?php 
	$route=$this->createUrl('/work/work/search');
	$js="var ROUTE='".$route."'";
	Yii::app()->clientScript->registerScript('route',$js,0);
?>
<?php echo $content; ?>
<?php $this->endContent() ?>
 <?php
 /*
 if(Yii::app()->user->hasFlash('warring'))
 {
    $string =  Yii::app()->user->getFlash('warring');
    echo "<script language='javascript'>
        alert('".$string."');
        
         </script>";
 }*/
?>