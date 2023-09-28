<div class="result">
    <ul>
        <?php foreach ($data as $dt) { ?>
            <li class="result-item">
                <a href="<?php echo $dt['url']; ?>" title="<?php echo $dt['name'];?>"><?php echo $dt['name']; ?></a>
            </li>
        <?php } ?>
    </ul>
</div>