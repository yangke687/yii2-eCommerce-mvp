<?php


/* @var $this \yii\web\View */
/* @var $user \common\models\User */
/* @var $address \common\models\UserAddress */

?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Address Info
            </div>
            <div class="card-body">
                <?php echo $this->render('user_address', compact('address')); ?>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <div class="card-header">
                Account Info
            </div>

            <div class="card-body">
                <?php echo $this->render('user_account', compact('user')); ?>
            </div>
        </div>
    </div>
</div>
