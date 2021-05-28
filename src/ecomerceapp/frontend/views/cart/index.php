<?php
/**
 * @var \common\models\CartItem[] $cartItems
 */
?>

<div class="card">
    <div class="card-header">
        <h3>CART ITEMS</h3>
    </div>
    <div class="card-body p-0">
        <table class="table-hover table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $cartItem): ?>
                <tr class="text-center align-content-center">
                    <td><?= $cartItem['name'] ?></td>
                    <td>
                        <?= \yii\helpers\Html::img(Yii::$app->params['frontendURL'] . 'storage' . $cartItem['image'], [
                            'style' => 'width:100px;height:50px'
                        ]) ?>
                    </td>
                    <td><?= $cartItem['price'] ?></td>
                    <td><?= $cartItem['quantity'] ?></td>
                    <td><?= $cartItem['total_price'] ?></td>
                    <td>
                        <?= \yii\helpers\Html::a('Delete', ['/cart/delete', 'id' => $cartItem['id']], [
                            'class' => 'btn btn-outline-danger btn-small',
                            'data-method'=>'post',
                            'data-confirm'=>"Are you sure you want to remove this item from your cart"
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="card-body text-center">
            <a href="<?= \yii\helpers\Url::to(['/cart/checkout'])?>" class="btn btn-primary">Checkout</a>
        </div>
    </div>
</div>