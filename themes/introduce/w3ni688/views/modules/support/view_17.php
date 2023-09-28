<ul>
    
</ul>

<div class="youtube-fp">
    <?php
    if ($data && count($data)) {
        ?>
        <?php
        $i = 0;
        foreach ($data as $support) {
            if ($support['type'] == 'fb' || $support['type'] == 'youtube' || $support['type'] == 'instagram' || $support['type'] == 'twitter'){
                $i++;
                if ($i > $limit) {
                    break;
                }
                Yii::app()->controller->renderPartial('//modules/support/type_' . $support['type'], array('data' => $support));
            }
        }
        ?>
    <?php } ?>
</div>