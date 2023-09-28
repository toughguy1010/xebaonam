
<?php echo $jsonData; ?>
<div id="show-data"></div>
<style type="text/css">
    body >* {
        display: none;
    }
    #show-data {
        display: block !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var list_dm_vn = {};
        var list_dm_quuocte = {};
        var div_lvn = $('.style_banggia').first().find('td.top_td:first-child');
        var i = 0;
        div_lvn.each(function() {
            span  = $(this).children('span');
            span.each(function() {
                list_dm_vn[i++] = {name : $(this).html(), price : $(this).parent().parent().find('td.top_td').find('.link_price').first().html()};
            });
        });
        $.ajax({
            url: '<?= Yii::app()->createUrl('/domain/domain/getPriceDMV'); ?>',
            data: {data : JSON.stringify(list_dm_vn)},
            type: 'POST',
            success: function(result){
                $('#show-data').html(result);
            }
        });
    })
</script>