<table>
    <tbody class="active">
        <tr><th colspan="3">Show navigation buttons</th></tr>
        <tr>
            <td>Show Prev &amp; Next buttons</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'navprevnext', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Disabling this option will hide the Prev and Next buttons.</td>
        </tr>
        <tr>
            <td>Show Start &amp; Stop buttons</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'navstartstop', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
                <input type="checkbox" checked="" name="navstartstop" style="display: none;"><a href="#" class="ls-checkbox on"><span></span></a>
            </td>
            <td class="desc">Disabling this option will hide the Start &amp; Stop buttons.</td>
        </tr>
        <tr>
            <td>Show slide navigation buttons</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'navbuttons', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Disabling this option will hide slide navigation buttons or thumbnails.</td>
        </tr>
        <tr><th colspan="3">Navigation buttons on hover</th></tr>
        <tr>
            <td>Show Prev &amp; Next buttons on hover</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'hoverprevnext', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Show the buttons only when someone moves the mouse cursor over the slider. This option depends on the previous setting.</td>
        </tr>
        <tr>
            <td>Slide navigation on hover</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'hoverbottomnav', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Slide navigation buttons (including thumbnails) will be shown on mouse hover only.</td>
        </tr>
        <tr><th colspan="3">Slideshow timers</th></tr>
        <tr>
            <td>Show bar timer</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'showbartimer', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Show the bar timer to indicate slideshow progression.</td>
        </tr>
        <tr>
            <td>Show circle timer</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'showcircletimer', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Use circle timer to indicate slideshow progression.</td>
        </tr>
    </tbody>
</table>