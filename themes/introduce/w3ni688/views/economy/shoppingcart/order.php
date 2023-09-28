<div class="w3n-order">
     <h2>Thông tin đơn hàng số #<?php echo $order['order_id']; ?></h2>
     <table width="100%" cellpadding="5" cellspacing="5"
            style=" border-collapse: inherit;border-spacing: 5px;">
          <tbody>
          <tr>
               <td colspan="2">
                    <table width="100%" border="0" cellspacing="5"
                           style=" border-collapse: inherit;border-spacing: 5px;">
                         <tr>
                              <td width="50%">
                                   <h3><?php echo Yii::t('shoppingcart', 'billing-text') ?></h3>
                                   <div><?php echo $order['billing_name'] ?></div>
                                   <div><?php echo $order['billing_address'] ?></div>
                                   <div><?php
                                        $province = LibProvinces::getProvinceDetail($order['billing_city']);
                                        echo $province['name'];
                                        ?></div>
                                   <div><?php echo $order['billing_phone'] ?></div>
                                   <div><?php echo $order['billing_email'] ?></div>
                              </td>
                              <td style="border: none;">
                                   <h3><?php echo Yii::t('shoppingcart', 'shipping-text') ?></h3>
                                   <div><?php echo $order['shipping_name'] ?></div>
                                   <div><?php echo $order['shipping_address'] ?></div>
                                   <div><?php
                                        $province = LibProvinces::getProvinceDetail($order['shipping_city']);
                                        echo $province['name'];
                                        ?></div>
                                   <div><?php echo $order['shipping_phone'] ?></div>
                                   <?php
                                   $now = time();
                                   $now_start = date('Y-m-d', $now);
                                   $order_created = date('Y-m-d', $order['created_time']);

                                   $to = date_create($now_start);
                                   $from = date_create($order_created);
                                   $diff = date_diff($to, $from);
                                   ?>
<!--                                   <div><b>Thời gian bảo hành còn lại: --><?php //echo $diff->format('%a Ngày'); ?><!--</b></div>-->
                              </td>
                         </tr>
                    </table>
               </td>
          </tr>
          <tr>
               <td colspan="2">
                    <b><?php echo Yii::t('shoppingcart', 'order-time'); ?>
                         : </b><?php echo date('d-m-Y H:i:s', $order['created_time']); ?>
                    <br/>
                    <b><?php echo Yii::t('shoppingcart', 'payment_method'); ?>
                         : </b><?php echo $paymentmethod; ?>
                    <br/>
                    <b><?php echo Yii::t('shoppingcart', 'transport_method'); ?>
                         : </b><?php echo $transportmethod['name']; ?>
               </td>
          </tr>
          <tr style="border-top: 1px solid #DDD;">
               <td colspan="2">
                    <?php
                    $this->renderPartial('_product', array(
                         'products' => $products,
                    ));
                    ?>
               </td>
          </tr>
          <tr class="sc-totalprice-row">
               <td align="right">
                    <div class="sc-totalprice-text">
                         <span>Thành tiền:</span>
                    </div>
                    <div class="sc-totalprice-text">
                         <span>Tổng tiền thanh toán:</span>
                    </div>
               </td>
               <td width="110" align="right">
                    <div class="sc-totalprice"><?php echo Product::getPriceText(array('price' => $order['order_total'])); ?></div>
                    <div class="sc-totalprice"><?php echo Product::getPriceText(array('price' => $order['order_total'])); ?></div>
               </td>
          </tr>
          <tr>
               <td colspan="2">
                    <b><?php echo Yii::t('common', 'note'); ?></b>
                    <p class="bg-success" style="padding:0px 10px;">
                         <?php echo $order['note']; ?>
                    </p>
               </td>
          </tr>
          </tbody>
     </table>
</div>
<div class="row">
     <div class="col-xs-12">
          </br>
          <button class="btn btn-info pull-right"
                  id="printorder"><?php echo Yii::t('shoppingcart', 'order_print'); ?></button>
     </div>
</div>
<script>
    jQuery('#printorder').on('click', function () {
        w = window.open();
        w.document.write($('.w3n-order').html());
        w.print();
        w.close();
    });
</script>