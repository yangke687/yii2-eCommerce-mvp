<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


/* @var $this \yii\web\View */
/* @var $address \common\models\UserAddress */
/* @var $success bool */

?>

<?php \yii\widgets\Pjax::begin([
    'id' => 'for-user-address',
    'enablePushState' => false,
]); ?>

<?php if (isset($success) && $success): ?>
    <div class="alert alert-success">
        Your address was successfully updated
    </div>
<?php endif ?>

<?php $addressForm = ActiveForm::begin([
    'id' => 'form-address',
    'action' => ['/profile/update-address'],
    'options' => [
        'data-pjax' => 1
    ]
]); ?>

<?= $addressForm->field($address, 'address'); ?>
<?= $addressForm->field($address, 'city'); ?>
<?= $addressForm->field($address, 'state'); ?>
<?= $addressForm->field($address, 'country'); ?>
<?= $addressForm->field($address, 'zipcode'); ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end(); ?>