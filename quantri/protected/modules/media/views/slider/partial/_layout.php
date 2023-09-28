<table>
    <tbody class="active">
        <tr><th colspan="3">Slider dimensions</th></tr>
        <tr>
            <td>Slider width</td>
            <td>
                <?php echo $form->textField($SliderSetting, 'width'); ?>
            </td>
            <td class="desc">The width of the slider in pixels. Accepts percents, but is only recommended for full-width layout.</td>
        </tr>
        <tr>
            <td>Slider height</td>
            <td>
                <?php echo $form->textField($SliderSetting, 'height'); ?>
            </td>
            <td class="desc">The height of the slider in pixels.</td>
        </tr>
        <tr><th colspan="3">Responsive mode</th></tr>
        <tr>
            <td>Responsive</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'responsive', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Responsive mode provides optimal viewing experience across a wide range of devices (from desktop to mobile) by adapting and scaling your sliders for the viewing environment.</td>
        </tr>
        <tr>
            <td>Max-width</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'maxwidth'); ?>
            </td>
            <td class="desc">The maximum width your slider can take in pixels when responsive mode is enabled.</td>
        </tr>
        <tr><th colspan="3">Full-width slider settings</th></tr>
        <tr>
            <td>Full-width</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'fullwith', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Enable this option to force the slider to become full-width, even if your theme does not support such layout.</td>
        </tr>
        <tr>
            <td>Responsive under</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'responsiveunder'); ?>
            </td>
            <td class="desc">Turns on responsive mode in a full-width slider under the specified value in pixels. Can only be used with full-width mode.</td>
        </tr>
        <tr>
            <td>Layers container</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'sublayercontainer'); ?>
            </td>
            <td class="desc">Creates an invisible inner container with the given dimension in pixels to hold and center your layers.</td>
        </tr>
        <tr><th colspan="3">Other settings</th></tr>
        <tr>
            <td>Hide on mobile</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'hideonmobile', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Hides the slider on mobile devices.</td>
        </tr>
        <tr>
            <td>Hide under</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'hideunder'); ?>
            </td>
            <td class="desc">Hides the slider under the given value of browser width in pixels.</td>
        </tr>
        <tr>
            <td>Hide over</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'hideover'); ?>
            </td>
            <td class="desc">Hides the slider over the given value of browser width in pixel.</td>
        </tr>
    </tbody>
</table>