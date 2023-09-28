<table>
    <tbody class="active">
        <tr><th colspan="3">Slideshow behavior</th></tr>
        <tr>
            <td>Start slideshow</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'autostart', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Slideshow will automatically start after pages have loaded.</td>
        </tr>
        <tr>
            <td>Start in viewport</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'startinviewport', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">The slider will start only if it enters into the viewport.</td>
        </tr>
        <tr>
            <td>Pause on hover</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'pauseonhover', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Slideshow will temporally pause when someone moves the mouse cursor over the slider.</td>
        </tr>
        <tr><th colspan="3">Starting slide options</th></tr>
        <tr>
            <td>Start with slide</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'firstlayer'); ?>
            </td>
            <td class="desc">The slider will start with the specified slide. You can use the value "random".</td>
        </tr>
        <tr>
            <td>Animate starting slide</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'animatefirstlayer', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Disabling this option will result a static starting slide for the fisrt time on page load.</td>
        </tr>
        <tr><th colspan="3">Slideshow navigation</th></tr>
        <tr>
            <td>Keyboard navigation</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'keybnav', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">You can navigate through slides with the left and right arrow keys.</td>
        </tr>
        <tr>
            <td>Touch navigation</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'touchnav', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>
            </td>
            <td class="desc">Gesture-based navigation when swiping on touch-enabled devices.</td>
        </tr>
        <tr><th colspan="3">Looping</th></tr>
        <tr>
            <td>Loops</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'loops'); ?>
            </td>
            <td class="desc">Number of loops if automatically start slideshow is enabled (0 means infinite!)</td>
        </tr>
        <tr>
            <td>Force the number of loops</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'forceloopnum', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>                
            </td>
            <td class="desc">The slider will always stop at the given number of loops, even if someone restarts slideshow.</td>
        </tr>
        <tr><th colspan="3">Other settings</th></tr>
        <tr>
            <td>Two way slideshow</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'twowayslideshow', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label>   
            </td>
            <td class="desc">Slideshow can go backwards if someone switches to a previous slide.</td>
        </tr>
        <tr>
            <td>Shuffle mode</td>
            <td>
                <label>
                    <?php echo $form->checkBox($SliderSetting, 'randomslideshow', array('class' => 'ace ace-switch ace-switch-6')); ?>
                    <span class="lbl"></span>
                </label> 
            </td>
            <td class="desc">Slideshow will proceed in random order. This feature does not work with looping.</td>
        </tr>
    </tbody>
</table>