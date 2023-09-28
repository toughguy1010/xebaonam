<li class="support-item <?php echo "support-" . $data['type']; ?>">
    <a href="skype:<?php echo $data['nick'] ?>?chat" rel="nofollow">
        <!--        /mediumicon/,/bigclassic/,/smallclassic/,/balloon/ -->
        <img src="http://mystatus.skype.com/smallicon/<?php echo $data['nick'] ?>" class="sp-icon"/>
        <span class="sp-title-content"><?php echo $data['title']; ?></span>
    </a>
</li>