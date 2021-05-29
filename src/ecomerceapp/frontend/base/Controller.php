<?php

namespace frontend\base;

use common\models\CartItem;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $cartItemsCount = 0;
        if (\Yii::$app->user->isGuest) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY);
            if ($cartItems) {
                foreach ($cartItems as $cartItem) {
                    $cartItemsCount += $cartItem['quantity'];
                }
            }
        } else {
            $cartItemsCount = CartItem::find()->userId(\Yii::$app->user->id)->sum('quantity');
        }
        $this->view->params['cartItemCount'] = $cartItemsCount;
        return parent::beforeAction($action);
    }
}