<?php if(count($recruiter)):?>

    	<h1>Nhà tuyển dụng uy tín</h1>
      
       <a class="more" style="float:right" href="<?php echo Yii::app()->createUrl('/company/company/listcategory')?>">Xem thêm</a>
     <br/>
       <ul class="uytin">
            <?php foreach($recruiter as $dt):?>
                   		<li>
                       		<a href="<?php echo Yii::app()->createUrl('/company/company/detail',array('id'=>$dt['company_id']))?>">
                       	  		<img <?php echo $dt["company_name"];?>" src="<?php echo $dt["company_logo"];?>" alt="" width="111" height="75"/>
                          	</a>
                      	</li>
                      	<?php endforeach;?>
                        <div class="clear"></div>
                        
                    </ul>
      
      
<?php endif;?>