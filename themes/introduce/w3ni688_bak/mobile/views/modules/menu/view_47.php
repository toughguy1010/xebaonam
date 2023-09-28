<?php if (isset($data) && count($data)) { ?>
    <div class="box-right chinh-sach clearfix">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <table class="tblcs">
            <tbody>
                <?php foreach ($data as $menu_id => $menu) { ?>
                    <tr class="tablecs">
                        <td class="tdimage">
                            <a href="<?php echo $menu['menu_link']; ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $menu['icon_path'] . $menu['icon_name'] ?>" />
                            </a>
                        </td>
                        <td class="tdtext">
                            <a href="<?php echo $menu['menu_link']; ?>">
                                <span class="titlespan"><?php echo $menu['menu_title'] ?></span>
                                <span class="contentspan"><?php echo $menu['description'] ?></span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>