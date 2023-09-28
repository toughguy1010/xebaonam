<div class="groupBtn">
	<?php if(!Yii::app()->user->isGuest):?>
        <a class="btn add" href="<?php echo $this->createUrl('/work/work/myjob')?>">Tin đã đăng</a>
        
	<a class="btn" href="<?php echo $this->createUrl('/work/work/create')?>">Đăng tin tuyển dụng</a>
        <?php endif;?>   
</div>
<?php if(isset($search)):?>
	<!-- box-search-right-->
	<div class="right_form_search">
	<?php $this->renderPartial('_box_search_right',array('region'=>$region,
            'region1'=>$region1,
            'region2'=>$region2,
            'region3'=>$region3,
            'trade_group'=>$trade_group));?>
	</div>
	<?php endif; ?>
<?php if(count($work_related)):?>
<div class="block-right">
	
        <h1>Có thể bạn quan tâm</h1>
    
	<ul class="listCtqt">
	<?php foreach($work_related as $count=>$related_hot): ?>
		<li>
			<a class="load_content" href="<?php echo $this->createUrl('/work/work/view',array('id'=>$related_hot['news_id']))?>" title="<?php echo $related_hot['position'];?>">
			<b><?php echo $count+1; ?></b>
			<span><?php echo $related_hot['position'];?></span>
			</a>
		</li>
	<?php endforeach ?>
	</ul>
</div>
<?php endif?>

	

<!-- recruiter -->

