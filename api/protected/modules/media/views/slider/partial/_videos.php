<table>
    <tbody class="active">
        <tr>
            <td>Automatically play videos</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'autoplayvideos', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Videos will be automatically started on the active slide.</td>
        </tr>
        <tr>
            <td>Pause slideshow</td>
            <td>
                <?php echo $form->dropDownList($SliderSetting, 'autopauseslideshow', $SliderSetting->getPauseSlideshowArr()); ?>
            </td>
            <td class="desc">The slideshow can temporally be paused while videos are playing. You can choose to permanently stop the pause until manual restarting.</td>
        </tr>
        <tr>
            <td>Youtube preview</td>
            <td>
                <?php echo $form->dropDownList($SliderSetting, 'youtubepreview', $SliderSetting->getYoutubePreviewArr()); ?>
            </td>
            <td class="desc">The preview image quaility for YouTube videos. Please note, some videos do not have HD previews, and you may need to choose a lower quaility.</td>
        </tr>
    </tbody>
</table>