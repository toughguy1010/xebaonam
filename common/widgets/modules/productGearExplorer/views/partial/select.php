<?php if (count($attribute['options'])) { ?>
    <tr>
        <td class="attr-table-title">
            <a href="<?php echo $attribute['unset_link']; ?>" class="list-group-item-heading">
                <?php echo $attribute['att']['name'] ?>
            </a>
        </td>
        <td>
            <ul class="list-inline">
                <?php
                foreach ($attribute['options'] as $att) {
                    ?>
                    <li class="attr-item">
                        <a id="fi_<?php echo $key; ?>_<?php echo $att['index_key']; ?>" class="op-ft <?php if ($att['checked']) { ?>active<?php } ?>" href="<?php echo $att['checked'] ? 'javascript:void(0)' : $att['link']; ?>"><?php echo $att['name']; ?></a>
                        <?php if ($att['checked']) { ?>
                            <a class="op-ft-del" href="<?php echo $att['link']; ?>" rel="nofollow">x</a>
                            <?php
                            break;
                        }
                        ?>
                    </li>
                <?php } ?>
            </ul>
        </td>
    </tr>
<?php } ?>