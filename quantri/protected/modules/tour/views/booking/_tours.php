<?php
$tourModel = new Tour();
?>
<?php
if (isset($tours) && count($tours)) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th align="left"><?php echo $tourModel->getAttributeLabel('name'); ?></th>
                <th width="80" align="left"><?php echo Yii::t('common', 'quantity'); ?></th>
                <th>Ngày khởi hành</th>
                <th width="110" align="left"><?php echo $tourModel->getAttributeLabel('price'); ?></th>
                <th width="110" align="left"><?php echo Yii::t('common', 'total'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tours as $tour) { ?>
                <tr>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('tour/tour/update', array('id' => $tour['id'])); ?>">
                            <?php echo $tour["name"]; ?>
                        </a>
                    </td>
                    <td>
                        <?php echo ($tour["tour_qty"]); ?>
                    </td>
                    <td><?php echo date('d-m-Y', $model->departure_date); ?></td>
                    <td><?php echo Product::getPriceText($tour); ?></td>
                    <td><?php echo Product::getTotalPrice($tour, $tour["tour_qty"]); ?></td>
                </tr>
            <?php }; ?>		  
        </tbody>
    </table>
<?php } ?>