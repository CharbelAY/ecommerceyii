<?php

/**
 * @var \common\models\User $user
 * @var \common\models\UserAddress $userAddress
 * @var \yii\web\View $this
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>


<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Address Information
            </div>
            <div class="card-body">
                <?= $this->render('user_address',[
                        'userAddress'=>$userAddress
                ]) ?>

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                Account Information
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['/site/update-account']
                ]); ?>

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
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>