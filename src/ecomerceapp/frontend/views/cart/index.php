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
        <?php if (!($cartItems === [])): ?>
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
                    <tr data-id="<?= $cartItem['id'] ?>" data-url="<?= \yii\helpers\Url::to(['/cart/change-quantity'])?>" class="text-center align-content-center">
                        <td><?= $cartItem['name'] ?></td>
                        <td>
                            <?= \yii\helpers\Html::img(Yii::$app->params['frontendURL'] . 'storage' . $cartItem['image'], [
                                'style' => 'width:100px;height:50px'
                            ]) ?>
                        </td>
                        <td><?= $cartItem['price'] ?></td>
                        <td><input type="number" min="0" class="form-control item-quantity" style="width: 100px"
                                   value="<?= $cartItem['quantity'] ?>"></td>
                        <td><?= $cartItem['total_price'] ?></td>
                        <td>
                            <?= \yii\helpers\Html::a('Delete', ['/cart/delete', 'id' => $cartItem['cart_item_id']], [
                                'class' => 'btn btn-outline-danger btn-small',
                                'data-method' => 'post',
                                'data-confirm' => "Are you sure you want to remove this item from your cart"
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="card-body text-center">
                <a href="<?= \yii\helpers\Url::to(['/cart/checkout']) ?>" class="btn btn-primary">Checkout</a>
            </div>
        <?php else: ?>
            <h3 class="text-center text-muted p-5">No items in cart</h3>
        <?php endif; ?>

    </div>
</div>