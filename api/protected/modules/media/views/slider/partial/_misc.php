<table>
    <tbody class="active">
        <tr>
            <td>Image preload</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'imgpreload', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Preloads images used in the next slides for seamless animations.</td>
        </tr>
        <tr>
            <td>Lazy load images</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'lazyload', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Loads images only when needed to save bandwidth and server resources. Relies on the preload feature.</td>
        </tr>
        <tr>
            <td>Use relative URLs</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'relativeurls', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Use relative URLs for local images. This setting could be important when moving your WP installation.</td>
        </tr>
    </tbody>
</table>