<div class="box-animation-box">
    <div class="animation-sp-sp ">
        <div class="box-title-animation-sp-sp clearfix">
            <div class="title-animation-sp-sp">Giá cả</div>
            <div class="view-list-animation-sp-sp">
                <div class="box-input-animation">
                    <span><input type="text" name="fi_pmin" id="min_price" value="<?php echo Yii::app()->request->getParam('fi_pmin',"");?>" class="animation-last"/>đ</span>
                    <span><input type="text" name="fi_pmax" id="max_price" value="<?php echo Yii::app()->request->getParam('fi_pmax',"");?>" class="animation-child" />đ</span>
                </div>
            </div><!--end-view-list-animation-sp-sp-->

        </div><!--end-box-title-animation-sp-sp-->
        <div class="animation-box-sp-sp">
            <div id="slider-range"></div>
        </div>
    </div>
</div><!--end-box-animation-box-->
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui',  ClientScript::POS_END);?>
<script>  
    var time_out_filter;
    $(function () {
        var maxv = 50000000;
        var pmin = <?php echo (int)Yii::app()->request->getParam('fi_pmin',0);?>;
        var pmax = <?php echo (int)Yii::app()->request->getParam('fi_pmax',50000000);?>;                
        pmax= (pmax>maxv)?maxv:pmax;        
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: maxv,
            values: [pmin, pmax],
            slide: function (event, ui) {
                $("#min_price").val(ui.values[ 0 ]);
                $("#max_price").val(ui.values[ 1 ]);
                    time_out_filter = setTimeout(function(){
                        runLinkPrice();                        
                    },2000 );
                ;
            }
        });
        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val($("#slider-range").slider("values", 1));
    });
    
    function runLinkPrice(pmin,pmax){
        var url = location.href;
        var paramsUrl = parseParams(url.split('?')[1] || '');
        paramsUrl = paramsUrl || {};
        if(jQuery('#min_price').val() == 0 && jQuery('#max_price').val() == 50000000){
            delete paramsUrl.fi_pmin;
            delete paramsUrl.fi_pmax;
        }else{
            paramsUrl['fi_pmin']=jQuery('#min_price').val();            
            paramsUrl['fi_pmax']=jQuery('#max_price').val();            
        }
        if (jQuery.param(paramsUrl)) {
            location.href=url.split('?')[0] + '?' + jQuery.param(paramsUrl);
        } else {
            location.href=url.split('?')[0];
        }
    }
    
    function parseParams(query) {
        var re = /([^&=]+)=?([^&]*)/g;
        var decode = function(str) {
            return decodeURIComponent(str.replace(/\+/g, ' '));
        };
        var params = {}, e;
        if (query) {
            if (query.substr(0, 1) == '?') {
                query = query.substr(1);
            }
            while (e = re.exec(query)) {
                var k = decode(e[1]);
                var v = decode(e[2]);
                if (params[k] !== undefined) {
                    if (!$.isArray(params[k])) {
                        params[k] = [params[k]];
                    }
                    params[k].push(v);
                } else {
                    params[k] = v;
                }
            }
        }
        return params;
    }
</script>