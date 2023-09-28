<div class="business-hour">
    <?php if ($show_widget_title) { ?>
        <h2><?= $widget_title ?></h2>
    <?php } ?>
    <ul>
        <?php foreach ($hours as $index => $h) { ?>
            <li>
                <p><?php echo ClaDateTime::getDayTextFromIndex($index); ?> :
                    <span>
                        <?php
                        if ($h['start_time'] == 0 && $h['end_time'] == 0) {
                            echo 'Closed';
                        } else {
                            echo gmdate('h:i A', $h['start_time']), ' - ', gmdate('h:i A', $h['end_time']);
                        }
                        ?>
                    </span>
                </p>
            </li>
        <?php } ?>
    </ul>
</div>