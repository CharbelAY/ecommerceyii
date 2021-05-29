<?php

namespace frontend\base;

use common\models\CartItem;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $cartItemsCoun = CartItem::find()->userId(\Yii::$app->user->id)->sum('quantity');
        $this->view->params['cartItemCount']=$cartItemsCoun;
        return parent::beforeAction($action);
    }
}