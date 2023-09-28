<?php
if (isset($data) && count($data)) {
    ?>

    <?php if ($first && $show_widget_title) { ?>
        <div class="panel panel-default menu-horizontal">
            <div class="panel-heading">
                <h3><?php echo $widget_title; ?></h3>
            </div>
            <div class="panel-body">
            <?php } ?>
            <?php if ($first) { ?>
                <div class="row menu-footer">
                <?php } ?>
                <?php
                $i = 0;
                foreach ($data as $menu_id => $menu) {
                    $i++;
                    $m_link = $menu['menu_link'];
                    ?>
                    <?php
                    if ($level == 0) {
                        if ($i > $cols)
                            break;
                        ?>
                    <div class="<?php echo $colItemClass; ?> menu-col" style="width:<?php echo 100/$cols ?>%;">
                            <ul class="list-group">    
                            <?php } ?>
                            <li class="list-group-item <?php if ($level == 0) echo 'menu-origin'; ?> <?php echo ($menu['items']) ? 'has-item' : ''; ?> <?php echo ($menu['active']) ? 'active' : '' ?>" >
                                <a href="<?php echo $m_link; ?>" <?php echo $menu['target']; ?> title="<?php echo $menu['menu_title']; ?>"><?php echo $menu['menu_title']; ?></a>
                                <?php if ($menu['items']) { ?>
                                    <ul class="list-group">   
                                    <?php } ?>
                                    <?php
                                    $this->render($this->view, array(
                                        'data' => $menu['items'],
                                        'first' => false,
                                        'level' => $level + 1,
                                        'rows' => $this->rows,
                                        'cols' => $this->cols,
                                        'colItemClass' => $colItemClass,
                                    ));
                                    ?>
                                    <?php if ($menu['items']) { ?>
                                    </ul>
                                <?php } ?>
                            </li>
                            <?php if ($level == 0) { ?>
                            </ul>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if ($first) { ?>
            </div>
        <?php } ?>
        <?php if ($first && $show_widget_title) { ?>
        </div>
    </div>
<?php } ?>