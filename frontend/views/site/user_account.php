<?php


/* @var $this \yii\web\View */
/* @var $user \common\models\User */

/* @var $success bool */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<?php \yii\widgets\Pjax::begin([
    'id' => 'for-user-account',
    'enablePushState' => false
]); ?>

<?php if (isset($success) && $success): ?>
    <div class="alert alert-success">
        Your account was successfully updated
    </div>
<?php endif ?>

<?php $form = ActiveForm::begin([
    'id' => 'form-account',
    'action' => ['/profile/update-account'],
    'options' => [
        'data-pjax' => 1
    ]
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($user, 'firstname')->textInput()->label('First Name') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($user, 'lastname')->textInput()->label('Last Name') ?>
    </div>
</div>

<?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($user, 'email') ?>

<div class="row">
    <div class="col">
        <?= $form->field($user, 'password')->passwordInput() ?>
    </div>
    <div class="col">
        <?= $form->field($user, 'passwordConfirm')->passwordInput() ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end(); ?>
