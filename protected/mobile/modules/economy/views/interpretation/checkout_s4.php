<?php foreach ($langs as $key => $lang) {
    if ($ary_lang[$lang['from_lang']]) {
        continue;
    }
    $ary_lang[$lang['from_lang']] = ClaLanguage::getCountryName($lang['from_lang']);
} ?>
<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'six_step') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'step234') ?></p>
                </div>
            </div>
            <form action="" method="POST">
                <div class="col-lg-12 right-header-order-sale-2_2">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="list-payment standart-checkbox">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php
                                        echo CHtml::dropDownList('select_lang_from', null, array('' => Yii::t('translate', 'select_lang_from')) + $ary_lang, array('class' => 'selService', 'id' => 'select_lang_from'));
                                        ?>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table style="text-align: center;padding: 15px;margin-top: 15px"
                                           class="table table-bordered table-hover vertical-center">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center"><?= Yii::t('translate', 'select') ?></th>
                                            <th style="text-align: center"><?= Yii::t('translate', 'from_lang') ?></th>
                                            <th style="text-align: center"><?= Yii::t('translate', 'to_lang') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($langs as $key => $lang) { ?>
                                            <tr data-langid="<?= $lang['from_lang'] ?>">
                                                <td>
                                                    <input value="<?= $lang['id'] ?>" name="lang_ids[]" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </td>
                                                <td><? echo ClaLanguage::getCountryName($lang['from_lang']) ?></td>
                                                <td><? echo ClaLanguage::getCountryName($lang['to_lang']) ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="w3-form-group">
                                            <div class="width-option w3-form-field">
                                                <select class="form-control" name="options" id="">
                                                    <option value=""><?= Yii::t('translate', 'select_interpretation_pair') ?></option>
                                                    <option value="1">Escort Negotiation</option>
                                                    <option value="2">Consecutive Inter</option>
                                                    <option value="3">Simultaneous Inter</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="w3-form-group">
                                            <div class="width-option w3-form-field">
                                                <select class="form-control" name="day" id="">
                                                    <?php for ($i = 0.5; $i < 30; $i += 0.5) {
                                                        echo '<option value="' . $i . '">' . $i . ' ' . Yii::t('translate', 'day') . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="center" style="margin-top: 30px">
                        <button type="submit"
                                class="submit-form-1 close-modal-translate"><?= Yii::t('common', 'next') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#select_lang_from').on('change', function () {
            $('.list-payment tbody tr').css({display: "table-row"})
            var val = $(this).val();
            if (val) {
                $('.list-payment tbody tr').each(function () {
                    if ($(this).data('langid') !== val) {
                        $(this).css({display: "none"})
                    }
                })
            }
        })
    })
</script>
