<?php if ($data && count($data)) { ?>
    <table width="800px">
        <tbody>
            <tr>
                <td colspan="2">
                    <table border="0" cellpadding="5" width="100%">
                        <tbody>
                            <?php foreach ($data as $field) { ?>
                                <tr>
                                    <td align="right" width="15%"><?php echo $field['field_label'] ?>:</td>
                                    <td>
                                        <?php echo $field['field_data']; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
<?php } ?>