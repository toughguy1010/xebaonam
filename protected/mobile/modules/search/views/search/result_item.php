<div class="result">
    <ul>
        <?php foreach ($data as $dt) { ?>
            <li class="result-item">
                <a href="<?php echo $dt['url']; ?>" title="<?php echo $dt['content'];?>"><?php echo $dt['content']; ?></a>
            </li>
        <?php } ?>
    </ul>
</div>