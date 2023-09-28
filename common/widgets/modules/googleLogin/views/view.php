<?php
$authUrl = $client->createAuthUrl();
?>
<div class="gg_login">
    <?php
    if (isset($authUrl)) {
        echo "<a class='login' href='" . $authUrl . "'>Facebook Login!</a>";
    }
    ?>
</div>