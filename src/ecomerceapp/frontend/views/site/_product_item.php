<?php

/** @var \common\models\Product $model */

?>

    <div class="card h-100">
        <!-- Product image-->
        <img class="card-img-top" src="<?= $model->getImageUrl() ?>" alt="..."/>
        <!-- Product details-->
        <div class="card-body p-4">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder"><?= $model->name ?></h5>
                <!-- Product price-->
                <?= Yii::$app->formatter->asCurrency($model->price) ?>

                <div class="card-text">
                    <?= $model->getShortDescription() ?>
                </div>
            </div>
        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-right">
            <div class="text-center">
                <a class="btn btn-primary mt-auto btn-add-to-cart" href="#">Add to cart</a>
            </div>
        </div>
    </div>

