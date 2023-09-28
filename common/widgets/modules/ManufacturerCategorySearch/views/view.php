<div class="layout-left-page-in layout-left-page-in1 layout-search-page-in">
    <?php if ($show_widget_title) { ?>
        <div class="title-llpi">
            <h3>
                <?= $widget_title ?>
            </h3>
        </div>
    <?php } ?>
    <div class="content-llpi content-search-pi">
        <select id="manufacturer_category_root" class="search-page-in search-page-in21">
            <option value="-1">---Chọn thương hiệu---</option>
            <?php foreach ($dataManufacturer as $item) { ?>
                <option value="<?= $item['cat_id'] ?>"><?= $item['cat_name'] ?></option>
            <?php } ?>
        </select>
        <select id="manufacturer_category_lv2" class="search-page-in search-page-in22" style="display: none">
        </select>
        <select id="manufacturer_category_lv3" class="search-page-in search-page-in22" style="display: none">
        </select>
        <div class="button-search-page-in">
            <button type="button" id="btn-submit-manufacturer">
                tìm kiếm
            </button>
        </div>
        <input type="hidden" id="url_submit" value=""/>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#btn-submit-manufacturer').click(function () {
            var url = $('#url_submit').val();
            if (url) {
                location.href = url;
            }
        });

        $('#manufacturer_category_root').change(function () {
            var cat_parent = $(this).val();
            $.getJSON(
                '<?= Yii::app()->createUrl('/economy/manufacturer/getChildrenCategory') ?>',
                {cat_parent: cat_parent},
                function (data) {
                    var result = data.categories;
                    if (Object.keys(result).length > 0) {
                        var html = '<option value="-2">---Chọn mã máy---</option>';
                        for (i in result) {
                            html += '<option value=' + result[i]['cat_id'] + '>' + result[i]['cat_name'] + '</option>';
                        }
                        $('#manufacturer_category_lv2').html(html);
                        $('#manufacturer_category_lv2').css('display', 'block');
                    } else {
                        $('#manufacturer_category_lv2').css('display', 'none');
                    }
                    $('#url_submit').val(data.url);
                }
            );
        });
        $('#manufacturer_category_lv2').change(function () {
            var cat_parent2 = $(this).val();
            $.getJSON(
                '<?= Yii::app()->createUrl('/economy/manufacturer/getChildrenCategory') ?>',
                {cat_parent: cat_parent2},
                function (data) {
                    var result = data.categories;
                    if (Object.keys(result).length > 0) {
                        var html = '<option value="-3">---Chọn mã máy---</option>';
                        for (i in result) {
                            html += '<option value=' + result[i]['cat_id'] + '>' + result[i]['cat_name'] + '</option>';
                        }
                        $('#manufacturer_category_lv3').html(html);
                        $('#manufacturer_category_lv3').show();
                    } else {
                        $('#manufacturer_category_lv3').hide();
                    }
                    $('#url_submit').val(data.url);
                }
            );
        });
        $('#manufacturer_category_lv3').change(function () {
            var cat_parent3 = $(this).val();
            $.getJSON(
                '<?= Yii::app()->createUrl('/economy/manufacturer/getChildrenCategory') ?>',
                {cat_parent: cat_parent3},
                function (data) {
                    $('#url_submit').val(data.url);
                }
            );
        });
    });

</script>