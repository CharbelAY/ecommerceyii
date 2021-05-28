<?php
/**
 *
 * @var \common\models\UserAddress $userAddress
 *
 * @var \yii\web\View $this
 */

use yii\bootstrap4\ActiveForm;

?>



<?php if (isset($success) && $success): ?>
    <div class="alert alert-success">
        Address was sucessfully updated
    </div>
<?php endif; ?>


<?php $addressForm = ActiveForm::begin([
    'action' => ['/profile/update-address'],
    'options' => [
        'data-pjax' => 1
    ]
]); ?>
<?= $addressForm->field($userAddress, 'address')->textInput() ?>
<?= $addressForm->field($userAddress, 'city')->textInput() ?>
<?= $addressForm->field($userAddress, 'state')->textInput() ?>
<?= $addressForm->field($userAddress, 'country')->textInput() ?>
<?= $addressForm->field($userAddress, 'zipcode')->textInput() ?>
<button class="btn btn-primary">Update</button>
<?php ActiveForm::end(); ?>
