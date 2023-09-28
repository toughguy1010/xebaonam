<div class="widget-box">
    <div class="widget-header">
        <h4>
            Gift Certificates - Transactions
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Certificates</th>
                        <th>Payer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $order) {
                        ?>
                        <tr>
                            <td>
                                <?php
                                if ($order['items']) {
                                    $i = 0;
                                    foreach ($order['items'] as $item) {
                                        $i++;
                                        echo $i > 1 ? '<br>' : '';
                                        ?>
                                        <a href="<?php echo Yii::app()->createUrl('banner/giftCardOrder/itemDetail', array('id' => $item['id'])) ?>"><?php echo strtoupper($item['id']) ?></a>
                                        <?php
                                    }
                                }
                                ?>
                            </td>
                            <td></td>
                            <td><?= $order['total_price'] ?> USD</td>
                            <td>Complete</td>
                            <td><?= date('Y-m-d H:i:s', $order['created_time']) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>