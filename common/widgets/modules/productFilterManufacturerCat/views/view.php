<?php
$manuIds = explode(',', $manu_id);
?>
<div class="categories-menu">
    <h2>
        Hãng xe <span class="fa fa-minus"></span>
    </h2>
    <div class="group-check-box">
        <?php foreach ($manufacturers as $manufacturer) { ?>
            <div class="checkbox checkbox-manufacturer">
                <input type="checkbox" <?= in_array($manufacturer['cat_id'], $manuIds) ? 'checked' : '' ?> class="ais-checkbox" value="<?= $manufacturer['cat_id'] ?>">
                <label><span class="text-clip" title="radio"><?= $manufacturer['cat_name'] ?></span></label>
            </div>
        <?php } ?>
    </div>
</div>

<?php
$manuModelIds = explode(',', $manu_model_id);
?>
<?php if (isset($manu_models) && $manu_models) { ?>
    <div class="categories-menu">
        <h2>
            Model <span class="fa fa-minus"></span>
        </h2>
        <div class="group-check-box">
            <?php foreach ($manu_models as $manumodel) { ?>
                <div class="checkbox checkbox-manufacturer-model">
                    <input type="checkbox" <?= in_array($manumodel['cat_id'], $manuModelIds) ? 'checked' : '' ?> class="ais-checkbox" value="<?= $manumodel['cat_id'] ?>">
                    <label><span class="text-clip" title="radio"><?= $manumodel['cat_name'] ?></span></label>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php
$manuTypeIds = explode(',', $manu_type_id);
?>
<?php if (isset($manu_types) && $manu_types) { ?>
    <div class="categories-menu">
        <h2>
            Model Type <span class="fa fa-minus"></span>
        </h2>
        <div class="group-check-box">
            <?php foreach ($manu_types as $manutype) { ?>
                <div class="checkbox checkbox-manufacturer-type">
                    <input type="checkbox" <?= in_array($manutype['cat_id'], $manuTypeIds) ? 'checked' : '' ?> class="ais-checkbox" value="<?= $manutype['cat_id'] ?>">
                    <label><span class="text-clip" title="radio"><?= $manutype['cat_name'] ?></span></label>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
                param,
                params_arr = [],
                queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
    }
    function insertParam(key, value)
    {
        key = encodeURI(key);
        value = encodeURI(value);
        var kvp = document.location.search.substr(1).split('&');
        var i = kvp.length;
        var x;
        while (i--) {
            x = kvp[i].split('=');
            if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }
        if (i < 0) {
            kvp[kvp.length] = [key, value].join('=');
        }
        document.location.search = kvp.join('&');
    }
    $(document).ready(function () {
        $('.checkbox-manufacturer').click(function () {
            var manuId = [];
            $('.checkbox-manufacturer').each(function () {
                if ($(this).children('input').is(':checked')) {
                    manuId.push($(this).children('input').val());
                }
            });
            if (manuId.length >= 1) {
                insertParam('manu_id', manuId.join());
            } else {
                var url = location.href;
                url = removeParam('manu_id', url);
                location.href = url;
            }
        });
        $('.checkbox-manufacturer-model').click(function () {
            var manuId = [];
            $('.checkbox-manufacturer-model').each(function () {
                if ($(this).children('input').is(':checked')) {
                    manuId.push($(this).children('input').val());
                }
            });
            if (manuId.length >= 1) {
                insertParam('manu_model_id', manuId.join());
            } else {
                var url = location.href;
                url = removeParam('manu_model_id', url);
                location.href = url;
            }
        });
        $('.checkbox-manufacturer-type').click(function () {
            var manuId = [];
            $('.checkbox-manufacturer-type').each(function () {
                if ($(this).children('input').is(':checked')) {
                    manuId.push($(this).children('input').val());
                }
            });
            if (manuId.length >= 1) {
                insertParam('manu_type_id', manuId.join());
            } else {
                var url = location.href;
                url = removeParam('manu_type_id', url);
                location.href = url;
            }
        });
    });
</script>