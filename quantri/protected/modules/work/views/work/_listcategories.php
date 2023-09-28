<?php if($this->beginCache('listcategories')) { ?>
 
<?php 
$query = "SELECT b.trade_id,b.trade_name,c.group_id as parent,c.group_name,b.count_news as count_news ";
        $query.=" from lov_trades b";
        //$query .=" INNER join lov_trades b on find_in_set(b.trade_id,a.trade_id) ";
        $query .=" INNER JOIN lov_trade_groups c ON c.group_id=b.group_id";
        $query.="  group by b.trade_id ";
        $trade_group = Yii::app()->db->createCommand($query)
                ->queryAll();
$id="";
$c=0;
$icon=0;
foreach($trade_group as $key=>$trades):?>
	<?php if($trades['parent']!=$id):?>
			<?php $icon++ ;?>
			<?php if($key!='0'):?></ul></div><?php endif?>
			
				<?php if($key!='0'):?></div><?php endif?>
				<div class=" uiBlog">
					
		<?php $c++;?>
                                    <div class="bgWork">	

		<div class="titleIcon">
			 <i class="icon<?php $icon++;echo $icon;?>"></i>
                                <b><?= $trades['group_name'];?></b>
		</div>
	<ul class="boxWork">
		<?php endif;?>
		<li><a href="<?php echo $this->createUrl('/work/work/search',array('industry'=>$trades['trade_id']))?>"><?php echo $trades["trade_name"]?>&nbsp;<span>(<?php echo $trades['count_news'];?>)</span></a></li>
		<?php  $id=$trades['parent'];?>
<?php endforeach ?>
	</ul>
	
                                        </div>
	</div>
	
    

                
                	
                    
                    
                    <script>
                    	jQuery(document).ready(function($){
						 var $container = $('div.listBlog');
						$container.imagesLoaded( function(){
						  $container.masonry({
							itemSelector : '.uiBlog'
						  });
						});
						});
                    </script>


<?php $this->endCache(); } ?>

