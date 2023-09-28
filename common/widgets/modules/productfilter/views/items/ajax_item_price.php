<div class="box-animation-box">
    <div class="animation-sp-sp ">
        <div class="box-title-animation-sp-sp clearfix">
            <div class="title-animation-sp-sp">Giá cả</div>
            <div class="view-list-animation-sp-sp">
                <div class="box-input-animation">
                    <span><input type="text" name="fi_pmin" id="min_price" value="<?php echo Yii::app()->request->getParam('fi_pmin', ""); ?>" class="animation-last"/>đ</span>
                    <span><input type="text" name="fi_pmax" id="max_price" value="<?php echo Yii::app()->request->getParam('fi_pmax', ""); ?>" class="animation-child" />đ</span>
                    <input type="hidden" name="active_ftop_price" id="active_ftop_price" class="fi_pmin fi_pmax" value="0"/>
                </div>
            </div><!--end-view-list-animation-sp-sp-->

        </div><!--end-box-title-animation-sp-sp-->
        <div class="animation-box-sp-sp">
            <div id="slider-range"></div>
        </div>
    </div>
</div><!--end-box-animation-box-->
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui', ClientScript::POS_END); ?>
<script>
    $(function() {
        var maxv = <?php echo $maxv; ?>;
        var pmin = <?php echo floatval(Yii::app()->request->getParam('fi_pmin', 0)); ?>;
        var pmax = <?php echo floatval(Yii::app()->request->getParam('fi_pmax', $maxv)); ?>;
        pmax = (pmax > maxv) ? maxv : pmax;
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: maxv,
            values: [pmin, pmax],
            slide: function(event, ui) {
                $("#min_price").val(economy.FormatNumber(ui.values[ 0 ]));
                $("#max_price").val(economy.FormatNumber(ui.values[ 1 ]));
                $("#active_ftop_price").val(1);
                clearTimeout(time_out_filter);
                time_out_filter = setTimeout(function() {
                    runFilter();
                }, 2000);
                ;
            }
        });
        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val(economy.FormatNumber($("#slider-range").slider("values", 1)));
    });
</script>