<?php if (count($albums)) { ?>
    <div class="album-hot-index hide" id="pageface">
        <div class="list_news">
            <?php foreach ($albums as $album) { ?>
                <li>
                    <a href="<?php echo $album['link']; ?>">
                        <img src="<?php echo ClaHost::getImageHost(), $album['avatar_path'], 's300_300/', $album['avatar_name']; ?>" alt="<?php echo $album['album_name'] ?>" />
                        <h3><?php echo $album['album_name'] ?></h3>
                        <label>
							<span class="log">
								<?= date('y-m-d h:i:s', $album['publicdate']) ?>
							</span>
							•  Album
						</label>
                    </a>
                </li>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<style>
    .album-hot-index {
        float: left;
        width: 100%;
    }

    .item-album {
        float: left;
        width: 50%;
        padding: 10px;
    }

    .item-album .img {
        float: left;
        width: 100%;
        height: 110px;
        overflow: hidden;
        position: relative;
    }

    .item-album .img a {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }

    .item-album .img a img {
        height: 100%;
        min-width: 100%;
        object-fit: cover;
        object-position: center;
        overflow: hidden;
    }

    .item-album h2 a {
        float: left;
        width: 100%;
        color: #333;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }
</style>