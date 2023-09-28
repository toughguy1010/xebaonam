<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s1 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'three_step') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'three_step_note') ?></p>
                </div>
            </div>
            <div class="content-order-sale-s1 float-full">
                <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/upload/ajaxupload.min.js"></script>
                <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
                <p>
                    Bạn có thể nhập hoặc kéo thả tệp văn bản vào đây
                </p>
                <form class="" id="uploadfile">
                    <div class="fallback">
                        <input name="file" type="file" multiple/>
                    </div>
                </form>
                <div class="bottom-order-sale">
                    <div class="button-2">
                        <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/checkfile') ?>">
                            Bước tiếp theo
                        </a>
                    </div>
                </div>
            </div>

            <div class="content-order-sale-s2 float-full">
                <div id="shopcart">
                    <?php
                    $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                    $files = $shoppingCart->getFiles();
                    ?>
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th class="col-1"><?= Yii::t('translate', 'file_name') ?></th>
                            <th class="col-2"><?= Yii::t('translate', 'file_type') ?></th>
                            <th class="col-3"><?= Yii::t('translate', 'word_num') ?></th>
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
                                    <td class="file-name">
                                        <?= $value['extension'] ?>
                                    </td>
                                    <td class="count-char"><?= $value['w_qty'] ?>  </td>
                                    <td class="delete-file">
                                        <a onclick="return confirm('<?php echo Yii::t('translate', 'delete_words_from_cart_confirm'); ?>')"
                                           href="<?php echo $this->createUrl('/economy/shoppingcartTranslate/delete', array('key' => $key)); ?>">
                                            <i
                                                    class="fa fa-close"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="hightlight-text file-name">
                                    <?= Yii::t('translate', 'total_file') . ': ' . $shoppingCart->countFiles(); ?>
                                </td>
                                <td class="hightlight-text count-char">
                                    <?= Yii::t('translate', 'total_word') . ': ' . $shoppingCart->countTotalWords(); ?>
                                </td>
                                <td class="hightlight-text delete-file">
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bottom-order-sale-s1 float-full">
                <div class="desc">
                    <p>Hiện tại chúng tôi hỗ trợ hầu hết các loại file: word, excel, pdf, rtf, ppt, doc, docx, image...
                        và không giới hạn dung lượng, nếu bạn gặp bất cứ vấn đề nào về việc up load file vui lòng liên
                        hệ hotline: <a href="#">092 605 1999</a> chúng tôi sẽ trợ giúp bạn trong thời gian sớm nhất</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {
        jQuery('#uploadfile').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("economy/shoppingcartTranslate/uploadfile"); ?>',
            name: 'file',
            dataType: "json",
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = JSON.parse(result);
                if (obj.code == '200') {
                    jQuery("#shopcart").html(obj.cart);
                }
            }
        });
    });
</script>