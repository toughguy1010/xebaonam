<?php
$roomModel = new TourHotelRoom();
?>
<?php
if (isset($rooms) && count($rooms)) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th align="left"><?php echo $roomModel->getAttributeLabel('name'); ?></th>
                <th>Khách sạn</th>
                <th>Ngày nhận</th>
                <th>Ngày trả</th>
                <th width="80" align="left"><?php echo Yii::t('common', 'quantity'); ?></th>
                <th width="110" align="left"><?php echo $roomModel->getAttributeLabel('price'); ?></th>
                <th width="110" align="left"><?php echo Yii::t('common', 'total'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($rooms as $room) { ?>
                <tr>
                    <td>
                        <a href="<?php echo Yii::app()->createUrl('tour/tourHotelRoom/update', array('id' => $room['id'])); ?>">
                            <?php echo $room["name"]; ?>
                        </a>
                    </td>
                    <td>
                        <?php
                        echo TourHotel::getNameById($room['hotel_id']);
                        ?>
                    </td>
                    <td><?php echo date('d-m-Y', $model->checking_in); ?></td>
                    <td><?php echo date('d-m-Y', $model->checking_out); ?></td>
                    <td>
                        <?php echo ($room["room_qty"]); ?>
                    </td>
                    <td><?php echo Product::getPriceText($room); ?></td>
                    <td><?php echo Product::getTotalPrice($room, $room["room_qty"]); ?></td>
                </tr>
            <?php }; ?>		  
        </tbody>
    </table>
<?php } ?>