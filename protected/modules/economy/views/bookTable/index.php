<div class="main-franchise-en">
    <style type="text/css">
        .item-reservation .form-control{
            margin-bottom: 5px;
        }
        .form-horizontal .col-xs-6 {
            margin-bottom: 25px;
        }
        .form-horizontal .col-xs-6 textarea{
            margin-bottom: 30px;
        }
    </style>
    <div class="container">
        <div class="catepage-cont">
        </div>
        <div class="main-reservation">
            <div class="container">
                <div class="title-reservation">
                </div>
                <div class="content-reservation clearfix">
                    <div class="cont">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'book-table',
                            'htmlOptions' => array('class' => 'form-horizontal'),
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                        ));
                        ?>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->textField($model, 'name', array(
                                                'class' => 'form-control w3-form-input input-text',
                                                'placeholder' => 'Họ và tên'
                                            ));
                                            echo $form->error($model, 'name');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->textField($model, 'email', array(
                                                'class' => 'form-control w3-form-input input-email',
                                                'placeholder' => 'Email'
                                            ));
                                            echo $form->error($model, 'email');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-6">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->textField($model, 'phone', array(
                                                'class' => 'form-control w3-form-input input-text',
                                                'placeholder' => 'Điện thoại'
                                            ));
                                            echo $form->error($model, 'phone');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->textField($model, 'quantity', array(
                                                'class' => 'form-control w3-form-input input-text',
                                                'placeholder' => 'Số khách'
                                            ));
                                            echo $form->error($model, 'quantity');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-6">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->textField($model, 'book_time', array(
                                                'class' => 'form-control w3-form-input input-text',
                                                'placeholder' => 'Thời gian'
                                            ));
                                            echo $form->error($model, 'book_time');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->textField($model, 'book_date', array(
                                                'class' => 'form-control w3-form-input datepicker-here',
                                                'placeholder' => 'Ngày',
                                                'data-language' => 'en'
                                            ));
                                            echo $form->error($model, 'book_date');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12">
                                        <div class="item-reservation">
                                            <?php
                                            echo $form->dropDownList($model, 'branch', $option_stores, array(
                                                'class' => 'form-control w3-form-input input-text',
                                                'style' => '-webkit-appearance: none; -moz-appearance: none;appearance: none;'
                                            ));
                                            echo $form->error($model, 'branch');
                                            ?>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="item-reservation">
                                        <?php
                                        echo $form->textArea($model, 'message', array(
                                            'class' => 'form-control w3-form-input input-textarea',
                                            'placeholder' => 'Tin nhắn'
                                        ));
                                        echo $form->error($model, 'message');
                                        ?>
                                    </div>
                                    <div class="item-submit">
                                        <input type="submit" class="btn  btn-primary w3-btn w3-btn-sb continue" value="Đặt bàn">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>            
</div>
</div>