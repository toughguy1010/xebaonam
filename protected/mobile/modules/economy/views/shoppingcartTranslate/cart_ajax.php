<?php
$files = $shoppingCart->getFiles();
?>
<table class="table table-hover table-bordered">
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
