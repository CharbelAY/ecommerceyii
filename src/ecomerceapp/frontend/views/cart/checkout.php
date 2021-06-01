<?php
/**
 * @var \common\models\Order $order
 * @var \common\models\OrderAddresse $orderAddress
 * @var array $cartItems
 * @var int $totalQuantity
 * @var float $totalPrice
 */

use yii\bootstrap4\ActiveForm;

?>


<?php $form = ActiveForm::begin([
    'action' => ['/samir'],
]); ?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Account Information
            </div>
            <div class="card-body">
                <?= $form->field($order, 'firstname')->textInput() ?>
                <?= $form->field($order, 'lastname')->textInput() ?>
                <?= $form->field($order, 'email')->textInput() ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Address Information
            </div>
            <div class="card-body">
                <?= $form->field($orderAddress, 'address')->textInput() ?>
                <?= $form->field($orderAddress, 'city')->textInput() ?>
                <?= $form->field($orderAddress, 'state')->textInput() ?>
                <?= $form->field($orderAddress, 'country')->textInput() ?>
                <?= $form->field($orderAddress, 'zipcode')->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4>Order Summary</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td> <?php echo $totalQuantity ?> Products</td>
                    </tr>
                    <tr>
                        <td> Total Price</td>
                        <td class="text-right">
                            <?= $totalPrice ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

<button class="btn btn-success">Continue</button>
<?php ActiveForm::end(); ?>
