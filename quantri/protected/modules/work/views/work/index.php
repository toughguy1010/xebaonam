

        <div class="contentBlog">
            <div class="mainBlog mainWork">
                <!-- search box -->
                <div class="searchBlue">
            	<?php $this->renderPartial('_box_search',array('model'=>$model,"data"=>$models,'region1'=>$region1,'region2'=>$region2,'region3'=>$region3,'trade_group'=>$trade_group,'region'=>$region));?>
                </div>
                    <!-- end search box -->
                 <!-- list categories -->
                  <h1 class="ttnn">Tìm theo ngành nghề</h1>
                 <div class="listBlog">
                   <?php  $this->renderPartial('_listcategories',array('trade'=>$trade,'trade_group'=>$trade_group));?>
                     </div>
                 <!-- end categories -->
               
              <!-- List jobs-->
              <div class="kqWork">
                  
                   <?php  $this->renderPartial('_list',array('models'=>$models,'pages'=>$pages,'count'=>$count,'region'=>$region));?>
              </div>
              <!-- end list jobs -->
                
              
               
                
            </div><!--mainBlog-->
            
            <div class="sideBarBlog">
            	<?php  $this->renderPartial("_right",array('work_related'=>$work_related))?>
            </div><!--sideBarBlog-->
            
            <div class="clear"></div>
           </div>
 <?php


 if(Yii::app()->user->hasFlash('warring'))
 {
    $string =  Yii::app()->user->getFlash('warring');    
 
?>
<?php $this->widget("bDialog", array(
 'overlay_id'=>'bfhQMessage', 
 'dialog_id'=>'bfhQMDialog', 
 'body_close'=>false, 
 'title'=>'Thông báo',
 'footer'=>true, 
 'footer_close'=>true, 
 'top'=>'145px' )); ?>

<div id = "check_company_warring" style = "display: none;" >
 <p><?= $string ?></p>
</div>
<script>
    $(document).ready(function(){
        overlayStart('bfhQMessage','check_company_warring',true,''); 
    });
    
</script>
<?php }?>