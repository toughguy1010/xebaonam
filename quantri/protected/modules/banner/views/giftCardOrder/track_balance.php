<div class="widget-box">
    <div class="widget-header">
        <h4>
            Balance Tracking
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Certificate</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= strtoupper($model['id']) ?></td>
                        <td>
                            <?= $model['owner'] ?>
                            <br>
                            <i><?= $order['email'] ?></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <br>

    <div class="widget-header">
        <h4>
            Apply Charge
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'track-balance-form',
                'htmlOptions' => array('class' => 'form-horizontal'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
            ));
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Purchased Value</th>
                        <th>Charge Date</th>
                        <th>Certificate Value</th>
                        <th>Charge Amount</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $model['total_price'] ?> USD</td>
                        <td>
                            <?php
                            $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                'model' => $charge, //Model object
                                'name' => 'GiftCardCharge[charge_date]', //attribute name
                                'mode' => 'date', //use "time","date" or "datetime" (default)
                                'value' => ((int) $charge->charge_date > 0 ) ? date('d-m-Y', (int) $charge->charge_date) : date('d-m-Y'),
                                'language' => 'vi',
                                'options' => array(
                                    'dateFormat' => 'dd-mm-yy',
//                                    'timeFormat' => 'HH:mm:ss',
                                    'controlType' => 'select',
                                    'stepHour' => 1,
                                    'stepMinute' => 1,
                                    'stepSecond' => 1,
                                    //'showOn' => 'button',
                                    'showSecond' => false,
                                    'changeMonth' => true,
                                    'changeYear' => false,
                                    'tabularLevel' => null,
                                //'addSliderAccess' => true,
                                //'sliderAccessArgs' => array('touchonly' => false),
                                ), // jquery plugin options
                                'htmlOptions' => array(
                                    'class' => 'span12 col-sm-12',
                                )
                            ));
                            ?>
                            <?php echo $form->error($charge, 'charge_date'); ?>
                        </td>
                        <td><?= $model['balance'] ?> USD</td>
                        <td>
                            <?php echo $form->textField($charge, 'charge_amount', array('class' => 'span12 col-sm-12')); ?>
                            <?php echo $form->error($charge, 'charge_amount'); ?>
                        </td>
                        <td><button class="btn btn-primary btn-sm" type="submit">Update</button></td>
                    </tr>
                </tbody>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </div>

    <br>

    <div class="widget-header">
        <h4>
            Charge History
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date Charged</th>
                        <th>Value</th>
                        <th>- Charged</th>
                        <th>= Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($charge_history) && $charge_history) {
                        foreach ($charge_history as $history) {
                            ?>
                            <tr>
                                <td><?php echo date('F j, Y', $history['charge_date']) ?></td>
                                <td><?php echo $history['value'] ?> USD</td>
                                <td><?php echo $history['charge_amount'] ?> USD</td>
                                <td><?php echo $history['balance'] ?> USD</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>