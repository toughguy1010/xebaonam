<style type="text/css">
/*    .buycar .form-control{
        margin-bottom: 15px;
    }*/
</style>
<div class="buycar col-xs-3">
    <form class="form-horizontal popup w3f-form" role="form">
        <div class="form-group w3-form-group pop-ng">
            <span class="width-td">Mẫu xe</span>
            <div class=" w3-form-field width-r">
                <select class="form-control width-r" id="CarId" name="car_id" onchange="getVersion()">
                    <option value="">--Tất cả--</option>
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
        <div class="form-group w3-form-group pop-ng">
            <span class="width-td">Dòng xe</span>
            <div class=" w3-form-field width-r">
                <select id="car_versions" class="form-control width-r">
                    <option value="">--Tất cả--</option>
                    <?php
                    if (count($versions)) {
                        foreach ($versions as $version) {
                            ?>
                            <option value="<?php echo $version['id'] ?>"><?php echo $version['name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group w3-form-group pop-ng">
            <span class="width-td">Khu vực</span>
            <div class=" w3-form-field width-r">
                <select id="car_regionals" class="form-control width-r">
                    <option value="">--Tất cả--</option>
                    <?php foreach ($regionals as $regional) { ?>
                        <option value="<?php echo $regional['id'] ?>"><?php echo $regional['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="w3-form-group">
            <div class=" w3-form-button">
                <div class="registered-action1">
                    <button type="button" class="btn btn-primary"><span>Tính phí </span></button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="col-xs-9" id="result"></div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.registered-action1 button').click(function () {
            var car_id = $("#CarId").val();
            var version_id = $('#car_versions').val();
            var regional_id = $('#car_regionals').val();
            var url = '<?php echo $this->createUrl('estimate'); ?>';
            $.ajax({
                url: url,
                data: {car_id: car_id, version_id: version_id, regional_id: regional_id},
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    if (data.code == 200) {
                        $("#result").html(data.html);
                    }
                }
            });
        });
    });
</script>
<div class="clearfix"></div>
