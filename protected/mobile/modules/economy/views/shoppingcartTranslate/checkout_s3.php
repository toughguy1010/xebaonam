<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'six_step') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'six_step_note') ?></p>
                </div>
            </div>
            <form action="<?php echo Yii::app()->createUrl('economy/shoppingcartTranslate/selectLanguage') ?>">
                <div class="content-order-sale-s2_2 float-full">
                    <div class="header-order-sale_s2_2">
                        <div class="row">
                            <div class="col-lg-6 left-header-order-sale-2_2">
                                <?php
                                $ct = TranslateLanguage::getAllLanguageTranslateFrom();
                                echo CHtml::dropDownList('lang_from', '', array('' => Yii::t('translate', 'select_lang_from')) + TranslateLanguage::getAllLanguageTranslateFrom(), array(
                                    'onchange' => 'getLangTo(this)',
                                    'class' => 'wide',
                                    'id' => 'selectlang',
                                ));
                                ?>
                            </div>
                            <div class="col-lg-6 right-header-order-sale-2_2">
                                <div>
                                    <a class="btn-translate-to" data-toggle="modal"
                                       href='#modal-translate-to'><?= Yii::t('translate', 'select_language') ?>
                                        <span class="translate-to"></span></a>
                                    <div class="modal fade" id="modal-translate-to">
                                        <div class="container">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="title-2">
                                                            <h2><?= Yii::t('translate', 'select_language') ?></h2>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="cover-content-translate-to">

                                                        </div>
                                                        <div class="center">
                                                            <button type="submit"
                                                                    class="submit-form-1 close-modal-translate"><?= Yii::t('translate', 'chose') ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $('.close-modal-translate').on('click', function () {
                                            $('#modal-translate-to').modal('toggle');
                                        })
                                    })
                                    function getLangTo(ev) {
                                        var select_val = jQuery(ev).find('option:selected').val();
                                        var url = '<?php echo Yii::app()->createUrl('economy/shoppingcartTranslate/langTo')?>';
                                        $.ajax({
                                            url: url,
                                            dataType: "json",
                                            data: {langFrom: select_val},
                                            success: function (result) {
//                                            var obj = jQuery.parseJSON(result);
                                                if (result.code == '200') {
                                                    jQuery(".cover-content-translate-to").html(result.html);
                                                }
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
            </form>

            <div class="content-order-sale-s2 float-full">
                <div id="shopcart">
                    <?php
                    $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                    $langs = $shoppingCart->getLangs();
                    $files = $shoppingCart->getFiles();
                    ?>
                </div>
            </div>
            <table style="margin-top: 40px" class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th class="col-1"><?= Yii::t('translate', 'file_name') ?></th>
                    <th class="col-2"><?= Yii::t('translate', 'file_type') ?></th>
                    <th class="col-3"><?= Yii::t('translate', 'words') ?></th>
                    <th class="col-3"><?= Yii::t('translate', 'delete') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($files) { ?>
                    <?php foreach ($files as $key => $value) { ?>
                        <tr>
                            <td class="file-name">
                                <h4><?= $value['display_name'] ?></h4>
                            </td>
                            <td class="count-char"><?= $value['extension']; ?>  </td>
                            <td class="count-char"><?= $value['w_qty']; ?>  </td>
                            <td class="delete-file">
                                <a onclick="return confirm('<?php echo Yii::t('translate', 'delete_words_from_cart_confirm'); ?>')"
                                   href="<?php echo $this->createUrl('/economy/shoppingcartTranslate/delete', array('key' => $key)); ?>">
                                    <i
                                            class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                <?php } ?>
                </tbody>
            </table>
            <div class="total">
                <div class="left">
                    <p><?= Yii::t('translate', 'translate_from') . ': ' . ClaLanguage::getCountryName($shoppingCart->getFromLang()) ?></p>
                    <p><?= Yii::t('translate', 'number_of_language') . ': ' . count($langs) ?>:
                        <?php
                        foreach ($langs as $key => $lang) {
                            echo ClaLanguage::getCountryName($lang['to_lang']) . ', ';
                        }
                        ?>
                    </p>
                </div>
                <div class="right">
                    <p>
                        <?= Yii::t('shoppingcart', 'total') ?>:
                        <span style="color: red">
                            <?= ($shoppingCart->getTotalPrice()) ? ($shoppingCart->getTotalPrice() . ' ' . $shoppingCart->getCurrency()) : Yii::t('common', 'contact') ?>
                        </span>
                    </p>
                </div>
            </div>
            <div class="note">
                    <textarea name="" id="" cols="30" rows="10"
                              placeholder="<?= Yii::t('translate', 'request_note') ?>"
                              class="input-1 plh-italic"></textarea>
            </div>
            <div class="bottom-order-sale">
                <div class="button-1">
                    <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/checkfile') ?>">
                        <button><?= Yii::t('translate', 'back') ?></button>
                    </a>
                </div>
                <div class="button-2">
                    <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectOption') ?>">
                        <?= Yii::t('translate', 'next_step') ?>
                    </a>
                </div>
            </div>
            <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK7)); ?>
        </div>
    </div>
</div>
<style>
    #modal-translate-to .cover-content-translate-to ul li {
        width: 50%;
        float: left;
        margin-bottom: 25px;
    }
</style>