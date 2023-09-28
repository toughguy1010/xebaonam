<div class="newsdetail">
    <h3 class="newstitle"><?php echo $post['title']; ?></h3>
    <p class="newstime"><?php echo date('d/m/Y H:i', $post['created_time']) ?></p>
    <p class="newssordes">
        <?php echo $post['sortdesc']; ?>
    </p>
    <div class="newsdes">
        <?php
        echo $post['description'];
        ?>
    </div>
</div>
