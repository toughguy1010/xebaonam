<table class="table table-hover">
    <tbody>
        <?php if ($shop['phone']) { ?>
            <tr>
                <td><?php echo Yii::t('common', 'phone') ?></td>
                <td><?php echo $shop['phone'] ?></td>
            </tr>
            <?php
        }
        if ($shop['email']) {
            ?>
            <tr>
                <td><?php echo Yii::t('common', 'email') ?></td>
                <td><?php echo $shop['email'] ?></td>
            </tr>
            <?php
        }
        if ($shop['yahoo']) {
            ?>
            <tr>
                <td><?php echo Yii::t('common', 'yahoo') ?></td>
                <td><?php echo $shop['yahoo'] ?></td>
            </tr>
            <?php
        }
        if ($shop['skype']) {
            ?>
            <tr>
                <td><?php echo Yii::t('common', 'skype') ?></td>
                <td><?php echo $shop['skype'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>