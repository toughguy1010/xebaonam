<?php

class GiftCardOrderController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        // breadcrumbs
        $this->breadcrumbs = array(
            'Gift Certificates - Transactions' => Yii::app()->createUrl('banner/giftCardOrder/'),
        );
        //
        $orders = GiftCardOrder::getOrders();
        //
        $this->render('index', array(
            'orders' => $orders,
        ));
    }

    public function actionItemDetail($id) {
        $model = GiftCardOrderItem::model()->findByPk($id);
        // breadcrumbs
        $this->breadcrumbs = array(
            'Gift Certificates - Certificates' => Yii::app()->createUrl('banner/giftCardOrder/itemDetail', array('id' => $id)),
        );
        //
        $order = GiftCardOrder::model()->findByPk($model->order_id);
        //
        $this->render('item_detail', array(
            'model' => $model,
            'order' => $order
        ));
    }

    public function actionBlockCertificate($id) {
        $model = GiftCardOrderItem::model()->findByPk($id);
        $model->block = ActiveRecord::STATUS_ACTIVED;
        $model->save();
        $this->redirect(Yii::app()->createUrl('/banner/giftCardOrder/itemDetail', array('id' => $id)));
    }

    public function actionUnlockCertificate($id) {
        $model = GiftCardOrderItem::model()->findByPk($id);
        $model->block = ActiveRecord::STATUS_DEACTIVED;
        $model->save();
        $this->redirect(Yii::app()->createUrl('/banner/giftCardOrder/itemDetail', array('id' => $id)));
    }

    public function actionDeleteCertificate($id) {
        $model = GiftCardOrderItem::model()->findByPk($id);
        if ($model->delete()) {
            $this->redirect(Yii::app()->createUrl('/banner/giftCardOrder'));
        }
    }

    public function actionRedeemCertificate($id) {
        $model = GiftCardOrderItem::model()->findByPk($id);
        $sql = 'DELETE FROM gift_card_charge WHERE order_item_id="' . $id . '"';
        Yii::app()->db->createCommand($sql)->execute();
        $flexible_price = $model->flexible_price;
        $model->total_price = $flexible_price;
        $model->balance = $flexible_price;
        $model->block = ActiveRecord::STATUS_DEACTIVED;
        $model->save();
        $this->redirect(Yii::app()->createUrl('/banner/giftCardOrder/itemDetail', array('id' => $id)));
    }

    public function actionTrackBalance($id) {
        $model = GiftCardOrderItem::model()->findByPk($id);
        // breadcrumbs
        $this->breadcrumbs = array(
            'Balance Tracking' => Yii::app()->createUrl('banner/giftCardOrder/trackBalance', array('id' => $id)),
        );
        //
        $order = GiftCardOrder::model()->findByPk($model->order_id);
        //
        $charge = new GiftCardCharge();
        if (isset($_POST['GiftCardCharge'])) {
            //
            $charge->attributes = $_POST['GiftCardCharge'];
            $charge->order_item_id = $model->id;
            $charge->value = $model->balance;
            $charge->balance = $model->balance - $charge->charge_amount;
            //
            if ($charge->charge_date && $charge->charge_date != '' && (int) strtotime($charge->charge_date)) {
                $charge->charge_date = (int) strtotime($charge->charge_date);
            }
            //
            if ($charge->save()) {
                $model->balance = $charge->balance;
                $model->save();
                $url = Yii::app()->createUrl('banner/giftCardOrder/trackBalance', array('id' => $model->id));
                $this->redirect($url);
            }
        }
        //
        $charge_history = GiftCardCharge::getHistory($id);
        //
        $this->render('track_balance', array(
            'model' => $model,
            'order' => $order,
            'charge' => $charge,
            'charge_history' => $charge_history
        ));
    }

}
