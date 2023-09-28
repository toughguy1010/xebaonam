<table>
    <tbody class="active">
        <tr>
            <td>YourLogo</td>
            <td>
                <?php echo CHtml::fileField('yourlogo', ''); ?>
                <?php echo $form->hiddenField($SliderSetting, 'yourlogo', ''); ?>
            </td>
            <td class="desc">A fixed image layer can be shown above the slider that remains still during slide progression. Can be used to display logos or watermarks.</td>
        </tr>
        <tr>
            <td>YourLogo style</td>
            <td colspan="2">
                <?php echo $form->textArea($SliderSetting, 'yourlogostyle', array('class' => 'span12 col-sm-12')); ?>
            </td>
        </tr>
        <tr>
            <td>YourLogo link</td>
            <td>
                <?php echo $form->textField($SliderSetting, 'yourlogolink', ''); ?>
            </td>
            <td class="desc">Enter an URL to link the YourLogo image.</td>
        </tr>
        <tr>
            <td>Link target</td>
            <td>
                <?php echo $form->dropDownList($SliderSetting, 'yourlogotarget', $SliderSetting->getLinkTargetArr()); ?>
            </td>
            <td class="desc"></td>
        </tr>
    </tbody>
</table>