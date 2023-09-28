<div class="order-sale-page float-full pad-70-0">
    <div class="container">
        <div class="order-sale_s2 float-full">
            <div class="title-1 center">
                <h2><span><?= Yii::t('translate', 'six_step') ?></span></h2>
                <div class="desc">
                    <p><?= Yii::t('translate', 'six_step_note') ?></p>
                </div>
            </div>
            <div class="content-order-sale-s2 float-full">
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
                                        <!--                <a href="#"><i class="fa fa-close"></i></a>-->
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bottom-order-sale">
                    <div class="button-1">
                        <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/order') ?>">
                            <?= Yii::t('translate', 'upload_file') ?>
                        </a>
                    </div>
                    <div class="button-2">
                        <a href="<?= Yii::app()->createUrl('economy/shoppingcartTranslate/selectLang') ?>"><?= Yii::t('translate', 'next_step') ?></a>
                    </div>
                </div>
                <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK7)); ?>
            </div>

        </div>
    </div>
</div>

	