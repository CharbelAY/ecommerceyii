<?php


namespace frontend\controllers;


use common\models\CartItem;
use yii\web\Controller;

class CartController extends Controller
{
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {

        } else {
            $cartItems = CartItem::findBySql("
            SELECT
                c.product_id as id,
                p.name,
                p.price,
                p.image,
                p.description,
                c.quantity,
                c.quantity*p.price as total_price
            FROM
                cart_items c
            LEFT JOIN products p on p.id = c.product_id
            WHERE c.created_by = :userId",['userId'=>\Yii::$app->user->id])->asArray()->all();
        }

        return $this->render('index', [
            'cartItems' => $cartItems
        ]);
    }
}