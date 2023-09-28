<?php
$username = (Yii::app()->user->id == $this->profileinfo['user_id']) ? 'bạn' : $this->profileinfo['name'];
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title profilename">
            <?php echo $this->profileinfo['name']; ?>
        </h3>
    </div>
    <div class="panel-body">
        <div class="profilelink">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <a href="<?php echo Yii::app()->createUrl('profile/profile/view', array('id' => $this->profileinfo['user_id'])) ?>"><?php echo Yii::t('common', 'profile'); ?></a>
                        </td>
                    </tr>
                    <?php if (Yii::app()->user->id == $this->profileinfo['user_id']) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('profile/profile/changepassword') ?>"><?php echo Yii::t('common', 'user_changepassword'); ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('profile/profile/order') ?>"><?php echo Yii::t('shoppingcart', 'order_2'); ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('login/login/logout') ?>"><?php echo Yii::t('common', 'quit'); ?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>    
    </div>
</div>


