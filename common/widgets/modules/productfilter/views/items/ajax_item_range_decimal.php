<?php 
    $nmin = 'fi_amin_'.$attribute['att']['id']; 
    $nmax = 'fi_amax_'.$attribute['att']['id']; 
    $vmax = 2000;
    
?>
<div class="box-animation-box">
    <div class="animation-sp-sp ">
        <div class="box-title-animation-sp-sp clearfix">
            <div class="title-animation-sp-sp"><?php echo $attribute['att']['name'];?></div>
            <div class="view-list-animation-sp-sp">
                <div class="box-input-animation">
                    <span><input type="text" name="<?php echo $nmin;?>" id="<?php echo $nmin;?>" class="op-ft-range" value="<?php echo Yii::app()->request->getParam($nmin,"");?>" class="animation-last"/></span>
                    <span><input type="text" name="<?php echo $nmax;?>" id="<?php echo $nmax;?>" class="op-ft-range" value="<?php echo Yii::app()->request->getParam($nmax,"");?>" class="animation-child" /></span>
                    <input type="hidden" name="<?php echo 'active_ftop_range_'.$attribute['att']['id'];?>" id="<?php echo 'active_ftop_range_'.$attribute['att']['id'];?>" class="<?php echo "active_".$nmin;?> <?php echo "active_".$nmax;?>" value="0"/>
                </div>
            </div><!--end-view-list-animation-sp-sp-->

        </div><!--end-box-title-animation-sp-sp-->
        <div class="animation-box-sp-sp">
            <div id="slider-range-<?php echo $attribute['att']['id'];?>"></div>
        </div>
    </div>
</div><!--end-box-animation-box-->
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui',  ClientScript::POS_END);?>
<script>      
    $(function () {
        var attid = <?php echo $attribute['att']['id'];?>;
        var nmin = '<?php echo $nmin;?>';
        var nmax = '<?php echo $nmax;?>';
        var vmax = <?php echo $vmax;?>;
        var smin = <?php echo (is_numeric(Yii::app()->request->getParam($nmin,0)))?Yii::app()->request->getParam($nmin,0):0;?>;
        var smax = <?php echo (is_numeric(Yii::app()->request->getParam($nmax,$vmax)))?Yii::app()->request->getParam($nmax,$vmax):0;?>;                
        smax= (smax>vmax)?vmax:smax;        
        $("#slider-range-"+attid).slider({
            range: true,
            min: 0,
            max: vmax,
            values: [smin, smax],
            slide: function (event, ui) {
                $("#"+nmin).val(ui.values[ 0 ]/100);
                $("#"+nmax).val(ui.values[ 1 ]/100);
                $("#active_ftop_range_"+attid).val(1);
                    clearTimeout(time_out_filter);
                    time_out_filter = setTimeout(function(){
                        runFilter();                      
                    },2000 );
                ;
            }
        });
        $("#"+nmin).val($("#slider-range-"+attid).slider("values", 0));
        $("#"+nmax).val($("#slider-range-"+attid).slider("values", 1)/100);
    });        
    
</script>