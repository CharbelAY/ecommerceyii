<?php


namespace frontend\controllers;


use common\models\CartItem;
use common\models\Product;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends \frontend\base\Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {

        } else {
            $cartItems = CartItem::findBySql("
            SELECT
                c.product_id as id,
                c.id as cart_item_id,
                p.name,
                p.price,
                p.image,
                p.description,
                c.quantity,
                c.quantity*p.price as total_price
            FROM
                cart_items c
            LEFT JOIN products p on p.id = c.product_id
            WHERE c.created_by = :userId", ['userId' => \Yii::$app->user->id])->asArray()->all();
        }

        return $this->render('index', [
            'cartItems' => $cartItems
        ]);
    }

    public function actionAdd()
    {
        $id = \Yii::$app->request->post("id");
        $product = Product::find()->id($id)->published()->one();
        if (!$product) {
            throw new NotFoundHttpException();
        }

        if (\Yii::$app->user->isGuest) {
            //save in session
        } else {
            $cartItem = CartItem::find()->userId(\Yii::$app->user->id)->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity = $cartItem->quantity + 1;
                $cartItem->save();
                return [
                    'success' => true
                ];
            } else {
                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->created_by = \Yii::$app->user->id;
                $cartItem->quantity = 1;
            }
            if ($cartItem->save()) {
                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $cartItem->errors
                ];
            }
        }
    }

    public function actionDelete($id){
        $cartItem = CartItem::find()->where(["id"=> intval($id)])->one();
        $cartItem->delete();
        return $this->redirect(['/cart/index']);
    }
}