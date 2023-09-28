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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChartOsPerClick);
    google.charts.setOnLoadCallback(drawChartOsPerOrder);
    //
    google.charts.setOnLoadCallback(drawChartCampaignSourcePerClick);
    google.charts.setOnLoadCallback(drawChartCampaignSourcePerOrder);
    //
    google.charts.setOnLoadCallback(drawChartAffTypePerClick);
    google.charts.setOnLoadCallback(drawChartAffTypePerOrder);
    //
    google.charts.setOnLoadCallback(drawChartCampaignNamePerClick);
    google.charts.setOnLoadCallback(drawChartCampaignNamePerOrder);

    function drawChartOsPerClick() {
        var data = google.visualization.arrayToDataTable([
            ['Hệ điều hành', 'Click'],
                <?php foreach ($dataClickOs as $osName => $osClick) { ?>
                ['<?= $osName ?>', <?= $osClick ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Hệ điều hành / Click'
        };
        var chart = new google.visualization.PieChart(document.getElementById('osperclick'));
        chart.draw(data, options);
    }
    
    function drawChartOsPerOrder() {
        var data = google.visualization.arrayToDataTable([
            ['Hệ điều hành', 'Đơn hàng'],
                <?php foreach ($dataOrderOs as $osName => $osOrder) { ?>
                ['<?= $osName ?>', <?= $osOrder ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Hệ điều hành / Đơn hàng'
        };
        var chart = new google.visualization.PieChart(document.getElementById('osperorder'));
        chart.draw(data, options);
    }
    
    function drawChartCampaignSourcePerClick() {
        var data = google.visualization.arrayToDataTable([
            ['Nguồn chiến dịch', 'Click'],
                <?php foreach ($dataClickCampaignSource as $name => $click) { ?>
                ['<?= $name ?>', <?= $click ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Nguồn chiến dịch / Click'
        };
        var chart = new google.visualization.PieChart(document.getElementById('campaignSourcePerClick'));
        chart.draw(data, options);
    }
    
    function drawChartCampaignSourcePerOrder() {
        var data = google.visualization.arrayToDataTable([
            ['Nguồn chiến dịch', 'Đơn hàng'],
                <?php foreach ($dataOrderCampaignSource as $name => $order) { ?>
                ['<?= $name ?>', <?= $order ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Nguồn chiến dịch / Đơn hàng'
        };
        var chart = new google.visualization.PieChart(document.getElementById('campaignSourcePerOrder'));
        chart.draw(data, options);
    }
    
    function drawChartAffTypePerClick() {
        var data = google.visualization.arrayToDataTable([
            ['Cách tiếp thị', 'Click'],
                <?php foreach ($dataClickAffType as $name => $click) { ?>
                ['<?= $name ?>', <?= $click ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Cách tiếp thị / Click'
        };
        var chart = new google.visualization.PieChart(document.getElementById('affTypePerClick'));
        chart.draw(data, options);
    }
    
    function drawChartAffTypePerOrder() {
        var data = google.visualization.arrayToDataTable([
            ['Cách tiếp thị', 'Đơn hàng'],
                <?php foreach ($dataOrderAffType as $name => $order) { ?>
                ['<?= $name ?>', <?= $order ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Cách tiếp thị / Đơn hàng'
        };
        var chart = new google.visualization.PieChart(document.getElementById('affTypePerOrder'));
        chart.draw(data, options);
    }
    
    function drawChartCampaignNamePerClick() {
        var data = google.visualization.arrayToDataTable([
            ['Chiến dịch', 'Click'],
                <?php foreach ($dataClickCampaignName as $name => $click) { ?>
                ['<?= $name ?>', <?= $click ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Chiến dịch / Click'
        };
        var chart = new google.visualization.PieChart(document.getElementById('campaignNamePerClick'));
        chart.draw(data, options);
    }
    
    function drawChartCampaignNamePerOrder() {
        var data = google.visualization.arrayToDataTable([
            ['Chiến dịch', 'Đơn hàng'],
                <?php foreach ($dataOrderCampaignName as $name => $order) { ?>
                ['<?= $name ?>', <?= $order ?>],
                <?php } ?>
        ]);
        var options = {
            title: 'Chiến dịch / Đơn hàng'
        };
        var chart = new google.visualization.PieChart(document.getElementById('campaignNamePerOrder'));
        chart.draw(data, options);
    }
</script>
<div class="col-xs-12">
    <div class="col-xs-12">
        <h3>Hệ điều hành</h3>
    </div>
    <div class="col-xs-6">
        <div id="osperclick" style="width: 100%; height: 300px;"></div>
    </div>
    <div class="col-xs-6">
        <div id="osperorder" style="width: 100%; height: 300px;"></div>
    </div>
</div>
<div class="col-xs-12">
    <div class="col-xs-12">
        <h3>Nguồn chiến dịch</h3>
    </div>
    <div class="col-xs-6">
        <div id="campaignSourcePerClick" style="width: 100%; height: 300px;"></div>
    </div>
    <div class="col-xs-6">
        <div id="campaignSourcePerOrder" style="width: 100%; height: 300px;"></div>
    </div>
</div>
<div class="col-xs-12">
    <div class="col-xs-12">
        <h3>Cách tiếp thị</h3>
    </div>
    <div class="col-xs-6">
        <div id="affTypePerClick" style="width: 100%; height: 300px;"></div>
    </div>
    <div class="col-xs-6">
        <div id="affTypePerOrder" style="width: 100%; height: 300px;"></div>
    </div>
</div>
<div class="col-xs-12">
    <div class="col-xs-12">
        <h3>Tên chiến dịch</h3>
    </div>
    <div class="col-xs-6">
        <div id="campaignNamePerClick" style="width: 100%; height: 300px;"></div>
    </div>
    <div class="col-xs-6">
        <div id="campaignNamePerOrder" style="width: 100%; height: 300px;"></div>
    </div>
</div>