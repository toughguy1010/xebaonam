<style type="text/css">
    .buycar .form-control{
        margin-bottom: 15px;
    }
</style>
<div class="clearfix" style="padding: 0px;">
    <div class="col-xs-3">
        <div class="buycar">
            <div class="form-group w3-form-group pop-ng  ">
                <span class="width-td">Mẫu xe</span>
                <div class=" w3-form-field width-r">
                    <select id="CarId" name="car_id" onchange="getVersion()" class="form-control width-r">
                        <option>--Tất cả--</option>
                        <?php
                        if (count($cars)) {
                            foreach ($cars as $car) {
                                ?>
                                <option <?php echo ($car['id'] == $cid) ? 'selected' : '' ?> value="<?php echo $car['id'] ?>"><?php echo $car['name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <script type="text/javascript">
                    function getVersion() {
                        var car_id = $("#CarId").val();
                        var url = '<?php echo $this->createUrl('getVersion') ?>';
                        $.ajax({
                            url: url,
                            data: {car_id: car_id},
                            type: 'get',
                            dataType: 'json',
                            success: function (data) {
                                if (data.code == 200) {
                                    $("#car_versions").html(data.html);
                                }
                            }
                        });
                    }
                </script>
            </div>
            <div class="form-group w3-form-group pop-ng  ">
                <span class="width-td">Phiên bản</span>
                <div class=" w3-form-field width-r">
                    <select id="car_versions" class="form-control width-r">
                        <option>--Tất cả--</option>
                        <?php
                        if (count($versions)) {
                            foreach ($versions as $version) {
                                ?>
                                <option <?php echo ($version['id'] == $vid) ? 'selected' : '' ?> value="<?php echo $version['id'] ?>"><?php echo $version['name'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group w3-form-group pop-ng ">
                <span class=" width-td">Lãi suất </span> 
                <div class=" w3-form-field width-r ">
                    <input type="number" max="99" min="1" id="Interest" class="form-control" style="width:100%">
                </div>
            </div>
            <div class="form-group w3-form-group pop-ng  ">
                <span class="width-td">Trả trước</span>
                <div class=" w3-form-field width-r">
                    <select id="first_price" class="form-control width-r">
                        <option>Số tiền trả trước-</option>
                        <?php
                        $arr_percent = range(10, 80, 10);
                        foreach ($arr_percent as $percent) {
                            ?>
                            <option value="<?php echo $percent ?>"><?php echo $percent ?> %</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group w3-form-group pop-ng  ">
                <span class="width-td">Thời hạn vay</span>
                <div class=" w3-form-field width-r">
                    <select id="Month" class="form-control width-r">
                        <option>Thời hạn vay</option>
                        <?php
                        $arr_time = range(6, 60, 6);
                        foreach ($arr_time as $time) {
                            ?>
                            <option value="<?php echo $time ?>"><?php echo $time ?> tháng</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="w3-form-group form-group">
                <div class=" w3-form-button clearfix">
                    <div class="registered-action1 col-xs-6">
                        <button type="button" class="btn btn-primary"><span>Tính </span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-9" id="result"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.registered-action1 button').click(function () {
            var car_id = $("#CarId").val();
            var version_id = $('#car_versions').val();
            var interest = $('#Interest').val();
            var first_price = $('#first_price').val();
            var month = $('#Month').val();
            var url = '<?php echo $this->createUrl('cal'); ?>';
            $.ajax({
                url: url,
                data: {car_id: car_id, version_id: version_id, interest: interest, first_price: first_price, month: month},
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    if (data.code == 200) {
                        $('#result').html(data.html)
                    }
                }
            });
        });
    });
</script>

