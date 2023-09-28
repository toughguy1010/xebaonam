<h3 class="newstitle"><?php echo $model['title']; ?></h3>
<p class="newstime"><?php echo date('d/m/Y H:i', $model['publicdate']) ?></p>
<p class="newssordes">
    <?php echo $model['sortdesc']; ?>
</p>
<div class="newsdes">
    <?php
    echo $model['description'];
    ?>
</div>
