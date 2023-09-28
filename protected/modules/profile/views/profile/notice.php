<div id="userdetail">
    <h3 class="username-title"><?php echo Yii::t('common', 'profile'); ?></h3>
    <table>

        <?php
        if (count($notice)) {
            foreach ($notice as $item) { ?>
                <tr class="<?= ($item['viewed']) ? 'readed' : '' ?>">
                    <td><a href="<?= $item['link'] ?>"><?= $item['title'] ?></a></td>
                    <td><?= date('d/m/y', $item['created_time']) ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>