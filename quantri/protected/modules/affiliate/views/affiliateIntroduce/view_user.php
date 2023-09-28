<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<form method="GET" id="form-search-daterange">
    <input type="hidden" name="start_date" id="start_date" />
    <input type="hidden" name="end_date" id="end_date" />
</form>
<input type="text" name="daterange" id="daterange" value="<?= str_replace('-', '/', $start_date) ?> - <?= str_replace('-', '/', $end_date) ?>" />
<script type="text/javascript">
    //
    $(function () {
        //
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            maxDate: new Date()
        });
        //
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            var start_date = picker.startDate.format('DD-MM-YYYY');
            start_date = encodeURI(start_date);
            var end_date = picker.endDate.format('DD-MM-YYYY');
            end_date = encodeURI(end_date);
            $('input#start_date').val(start_date);
            $('input#end_date').val(end_date);
            $('#form-search-daterange').submit();
        });
    });
    //
</script>
<div class="content bg-white border-b">
    <div class="row items-push text-uppercase" style="height: 90px;">
        <div class="col-xs-6 col-sm-2">
            <div class="font-w700 text-gray-darker animated fadeIn">Click</div>
            <div class="text-muted animated fadeIn">
                <small>Số lượng</small>
            </div>
            <a class="h3 font-w300 text-primary animated flipInX" href="javascript:void(0)" id="tour_ov_click">
                <span id="summary_clicks" class="summary_item"><?= $clickCount ?></span>
            </a>
        </div>
        <div class="col-xs-6 col-sm-2">
            <div class="font-w700 text-gray-darker animated fadeIn">Đơn hàng</div>
            <div class="text-muted animated fadeIn">
                <small>Thành công</small>
            </div>
            <a class="h3 font-w300 text-primary animated flipInX" href="javascript:void(0)" id="tour_ov_success_cvs">
                <span id="summary_conversion_success" class="summary_item"><?= $orderCompleteCount ?></span>
            </a>
        </div>
        <div class="col-xs-6 col-sm-2">
            <div class="font-w700 text-gray-darker animated fadeIn">Đơn hàng</div>
            <div class="text-muted animated fadeIn">
                <small>Chờ duyệt</small>
            </div>
            <a class="h3 font-w300 text-primary animated flipInX" href="javascript:void(0)" id="tour_ov_pending_cvs">
                <span id="summary_conversion_pending" class="summary_item"><?= $orderWaitingCount ?></span>
            </a>
        </div>
        <div class="col-xs-6 col-sm-2">
            <div class="font-w700 text-gray-darker animated fadeIn">Tỉ lệ chuyển đổi</div>
            <div class="text-muted animated fadeIn">
                <small>Đơn hàng / Click</small>
            </div>
            <a class="h3 font-w300 text-primary animated flipInX" href="javascript:void(0)" id="tour_ov_cvr">
                <span id="summary_conversion_rate" class="summary_item"><?= number_format($rate, 0, ',', '.') ?></span>%
            </a>
        </div>
        <div class="col-xs-6 col-sm-2">
            <div class="font-w700 text-gray-darker animated fadeIn">Hoa hồng</div>
            <div class="text-muted animated fadeIn">
                <small>Thành công</small>
            </div>
            <a class="h3 font-w300 text-primary animated flipInX" href="javascript:void(0)" id="tour_ov_success_revenue">
                <span id="summary_payout_success" class="summary_item"><?= number_format($commission[Orders::ORDER_COMPLETE], 0, ',', '.') ?></span><sup>₫</sup>
            </a>
        </div>
        <div class="col-xs-6 col-sm-2">
            <div class="font-w700 text-gray-darker animated fadeIn">Hoa hồng</div>
            <div class="text-muted animated fadeIn">
                <small>Chờ duyệt</small>
            </div>
            <a class="h3 font-w300 text-primary animated flipInX" href="javascript:void(0)" id="tour_ov_pending_revenue">
                <span id="summary_payout_pending" class="summary_item"><?= number_format($commission[Orders::ORDER_WAITFORPROCESS], 0, ',', '.') ?></span><sup>₫</sup>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Ngày', 'Click', 'Đơn hàng'],
<?php
$str = '';
foreach ($data as $day => $item) {
    if ($str != '') {
        $str .= ',';
    }
    $str .= '["' . $day . '", ' . $item['click'] . ', ' . $item['order'] . ']';
}
echo $str;
?>
        ]);

        var options = {
            title: 'Click & Order',
            titlePosition: 'none',
            hAxis: {
                title: 'Thống kê Click và Đơn hàng',
                titleTextStyle: {color: '#333'}
            },
            vAxis: {
                minValue: 0
            },
            chartArea: {
                width: '80%'
            },
            legend: {position: 'top', maxLines: 3},
            pointShape: 'circle',
            pointSize: 3
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<div id="chart_div" style="width: 100%; height: 500px;"></div>