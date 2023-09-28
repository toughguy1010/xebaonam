<div id="breadcrumbs" class="breadcrumbs">
    <?php
    $cdata = count($data);
    if ($data && $cdata) {
        ?>
        <ul class="breadcrumb">
            <?php
            $i = 0;
            foreach ($data as $name => $url) {
                $i++;
                ?>
                <?php if ($i != $cdata) { ?>
                    <li>
                        <?php if ($i == 1) { ?>
                            <i class="icon-home home-icon"></i>
                        <?php } ?>
                        <a href="<?php echo $url ?>"><?php echo $name; ?></a>
                    </li>
                <?php } else { ?>
                    <li class="active"><?php echo $name; ?></li>
                    <?php } ?>
                <?php } ?>
        </ul>
    <?php } ?>
</div>