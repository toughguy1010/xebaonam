<h2>Ẩn hiện HEADER</h2>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$pages = SiteSettings::getPageKeyArr();
$pages = array(1 => [SiteSettings::HF_SHOWALL_KEY . '' => Yii::t('common', 'all')]) + $pages;
//
$checkallheader = ($model->isNewRecord && !$model->header_rules || $model->header_showall) ? true : false;
if (!$checkallheader) {
    $rules = explode(',', $model->header_rules);
}
//
foreach ($pages as $key => $options) {
    $label_page = '';
    if ($key == 'normal') {
        $label_page = 'Trang thông thường';
    } else if ($key == 'categorypage') {
        $label_page = 'Trang nội dung';
    } else if ($key == 'productcategory') {
        $label_page = 'Trang danh mục sản phẩm';
    } else if ($key == 'newscategory') {
        $label_page = 'Trang danh mục tin tức';
    } else if ($key == 'productgroup') {
        $label_page = 'Trang nội dung';
    }
    ?>
    <div class="box">
        <label><b><?= $label_page ?></b></label> <br/>
        <?php
        foreach ($options as $key1 => $label) {
            $checked = false;
            if (!$checkallheader) {
                if (in_array(SiteSettings::getRealPageKey($key1), $rules)) {
                    $checked = true;
                }
            }
            ?>
            <label class="labelcheckpage">
                <input <?= ($checkallheader || $checked) ? 'checked="checked"' : '' ?> type="checkbox"
                                                                                       value="<?php echo $key1; ?>"
                                                                                       class="checkheader"
                                                                                       name="checkheader[]"> <?php echo $label; ?>
            </label>
            <?php
        }
        ?> 
    </div>
    <?php
}
?>

<hr>

<h2>Ẩn hiện FOOTER</h2>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
$checkallfooter = ($model->isNewRecord && !$model->footer_rules || $model->footer_showall) ? true : false;
if (!$checkallfooter) {
    $rules = explode(',', $model->footer_rules);
}
//
foreach ($pages as $key => $options) {
    $label_page = '';
    if ($key == 'normal') {
        $label_page = 'Trang thông thường';
    } else if ($key == 'categorypage') {
        $label_page = 'Trang nội dung';
    } else if ($key == 'productcategory') {
        $label_page = 'Trang danh mục sản phẩm';
    } else if ($key == 'newscategory') {
        $label_page = 'Trang danh mục tin tức';
    }
    ?>
    <div class="box">
        <label><b><?= $label_page ?></b></label> <br/>
        <?php
        foreach ($options as $key1 => $label) {
            $checked = false;
            if (!$checkallfooter) {
                if (in_array(SiteSettings::getRealPageKey($key1), $rules)) {
                    $checked = true;
                }
            }
            ?>
            <label class="labelcheckpage">
                <input <?= ($checkallfooter || $checked) ? 'checked="checked"' : '' ?> type="checkbox"
                                                                                       value="<?php echo $key1; ?>"
                                                                                       class="checkfooter"
                                                                                       name="checkfooter[]"> <?php echo $label; ?>
            </label>
            <?php
        }
        ?> 
    </div>
    <?php
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '.checkheader', function (e) {
            e.preventDefault();
            var thi = $(this);
            var checked = thi.prop("checked");
            var value = thi.val();
            //
            if (checked) {
                if (value == 'all')
                    jQuery('.checkheader').prop('checked', true);
            } else {
                if (value == 'all')
                    jQuery('.checkheader').prop('checked', false);
                //
                jQuery('.checkheader[value=all]').prop('checked', false);
            }
        });
        //
        $(document).on('change', '.checkfooter', function (e) {
            e.preventDefault();
            var thi = $(this);
            var checked = thi.prop("checked");
            var value = thi.val();
            //
            if (checked) {
                if (value == 'all')
                    jQuery('.checkfooter').prop('checked', true);
            } else {
                if (value == 'all')
                    jQuery('.checkfooter').prop('checked', false);
                //
                jQuery('.checkfooter[value=all]').prop('checked', false);
            }
        });
    });
</script>