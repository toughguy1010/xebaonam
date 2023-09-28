<table>
    <tbody class="active">
        <tr><th colspan="3">Appearance</th></tr>
        <tr>
            <td>Thumbnail navigation</td>
            <td>
                <?php echo $form->dropDownList($SliderSetting, 'thumb_nav', $SliderSetting->getThumbnailNavigationArr()); ?>
            </td>
            <td class="desc"></td>
        </tr>
        <tr>
            <td>Thumbnail container width</td>
            <td>
                <?php echo $form->textField($SliderSetting, 'thumb_container_width'); ?>
            </td>
            <td class="desc">The width of the thumbnail area.</td>
        </tr>
        <tr><th colspan="3">Thumbnail dimensions</th></tr>
        <tr>
            <td>Thumbnail width</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'thumb_width'); ?>
            </td>
            <td class="desc">The width of thumbnails in the navigation area.</td>
        </tr>
        <tr>
            <td>Thumbnail height</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'thumb_height'); ?>
            </td>
            <td class="desc">The height of thumbnails in the navigation area.</td>
        </tr>
        <tr><th colspan="3">Thumbnail appearance</th></tr>
        <tr>
            <td>Active thumbnail opacity</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'thumb_active_opacity'); ?>
            </td>
            <td class="desc">Opacity in percentage of the active slide's thumbnail.</td>
        </tr>
        <tr>
            <td>Inactive thumbnail opacity</td>
            <td>
                <?php echo $form->numberField($SliderSetting, 'thumb_inactive_opacity'); ?>
            </td>
            <td class="desc">Opacity in percentage of inactive slide thumbnails.</td>
        </tr>
    </tbody>
</table>