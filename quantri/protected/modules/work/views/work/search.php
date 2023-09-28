<div class="contentBlog">
    <div class="mainBlog mainWork">
        <!-- _BOX_SEARCH -->
        <div class="searchBlue">
            
            <?php $this->renderPartial('_box_search',array('model'=>$model,"data"=>$obj_recruitment,'region1'=>$region1,'region2'=>$region2,'region3'=>$region3,'trade_group'=>$trade_group,'region'=>$region));?>
        </div>
        <!-- END _BOX_SEARCH -->  



        <!-- BOX LIST ITEM -->
        <div class="kqWork">
            <?php echo $this->renderPartial('_list', array('models' => $obj_recruitment, 'pages' => $pages, 'count' => $count,'searchbyuser'=>$searchbyuser)); ?>
        </div><!--END LIST_ITEM-->
    </div><!-- end left content -->


    <!-- CONTENT RIGHT -->
    <div class="sideBarBlog">      	
        <?php echo $this->renderPartial("_right", array('work_related' => $work_related)) ?>
    </div><!--right-content-->
    <div style="clear:both"></div>
</div>