<table>
    <tbody class="active">
        <tr>
            <td>Skin</td>
            <td>
                <?php
                echo $form->dropDownList($SliderSetting, 'skin', $SliderSetting->getSkinArr());
                ?>
            </td>
            <td class="desc">You can change the skin of the slider. The 'noskin' skin is a border- and buttonless skin. Your custom skins will appear in the list when you create their folders as well.</td>
        </tr>
        <tr>
            <td>Background color</td>
            <td>
                <?php
                $this->widget('common.extensions.spectrum.MSpectrum', array(
                    'model' => $SliderSetting,
                    'attribute' => 'backgroundcolor',
                    'options' => array(
                        'preferredFormat' => 'rgb',
                        'showAlpha' => true,
                        'clickoutFiresChange' => true
                    ),
                    'htmlOptions' => array(
                    ),
                ));
                ?>
            </td>
            <td class="desc">Global background color of the slider. Slides with non-transparent background will cover this one. You can use all CSS methods such as HEX or RGB(A) values.</td>
        </tr>
        <tr>
            <td>Background image</td>
            <td>
                <?php echo CHtml::fileField('backgroundimage', ''); ?>
            </td>
            <td class="desc">Global background image of the slider. Slides with non-transparent backgrounds will cover it. This image will not scale in responsive mode.</td>
        </tr>

        <tr>
            <td>Initial fade duration</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'sliderfadeinduration'); ?>
            </td>
            <td class="desc">Change the duration of the initial fade animation when the page loads. Enter 0 to disable fading.</td>
        </tr>

        <tr>
            <td>
                Custom slider CSS <br>
            </td>
            <td colspan="2">
                <?php echo $form->textArea($SliderSetting, 'sliderstyle',array('class'=>'span12 col-sm-12')); ?>
            </td>
        </tr>
    </tbody>
</table>