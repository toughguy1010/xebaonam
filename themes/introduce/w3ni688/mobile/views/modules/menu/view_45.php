<?php if ($show_widget_title) { ?>

    <h5><?php echo $widget_title ?>:</h5>

<?php } ?>
<?php
if (isset($data) && count($data)) {
    ?>
    <ul class="clearfix">
        <?php
        foreach ($data as $menu_id => $menu) {
            $m_link = $menu['menu_link'];
            ?>
            <li><a title="<?php echo $menu['menu_title']; ?>" href="<?php echo $m_link; ?>"><?php echo $menu['menu_title']; ?></a></li>
            <?php
        }
        ?>
    </ul>
    <?php
}
?>
