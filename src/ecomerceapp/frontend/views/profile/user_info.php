<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;

/** @var \common\models\User $user */
?>



<?php if (isset($success) && $success): ?>
    <div class="alert alert-success">
        Your information has been updated
    </div>
<?php endif; ?>


<?php
$form = ActiveForm::begin([
    'action' => ['/profile/update-account'],
    'options' => [
        'data-pjax' => 1
    ]
]);
?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($user, 'firstname')->textInput(['autofocus' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($user, 'lastname')->textInput(['autofocus' => true]) ?>
    </div>
</div>

<?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($user, 'email') ?>

<?= $form->field($user, 'password')->passwordInput() ?>
<?= $form->field($user, 'passwordConfirm')->passwordInput() ?>


<div class="form-group">
    <button class="btn btn-primary">Update</button>
</div>

<?php ActiveForm::end(); ?>

