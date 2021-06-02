<?php


namespace frontend\controllers;


use common\models\CartItem;
use common\models\Order;
use common\models\OrderAddresse;
use common\models\Product;
use common\models\User;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends \frontend\base\Controller
{

    public static function getTotalQuantity()
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
    }

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST', 'DELETE'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
        } else {
            $cartItems = CartItem::getCartItems();
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
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $elementKey = array_search($id, array_column($cartItems, 'id'));
            if ($elementKey !== false) {
                $itemToUpdate = $cartItems[$elementKey];
                $itemToUpdate['quantity']++;
                $cartItems[$elementKey] = $itemToUpdate;
                \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
            } else {
                $cartItem = [
                    'id' => $id,
                    'cart_item_id' => $id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => 1,
                    'total_price' => $product->price
                ];
                $cartItems[] = $cartItem;
                \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
            }
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

    public function actionDelete($id)
    {
        if (\Yii::$app->user->isGuest) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY);
            foreach ($cartItems as $key => $cartItem) {
                if ($cartItem['id'] == $id) {
                    $keyToRemove = $key;
                }
            }
            if (isset($keyToRemove)) {
                unset($cartItems[$keyToRemove]);
                \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
            }
            return $this->redirect(['/cart/index']);
        } else {
            $cartItem = CartItem::find()->where(["id" => intval($id)])->one();
            $cartItem->delete();
            return $this->redirect(['/cart/index']);
        }
    }

    public function actionChangeQuantity()
    {
        $itemId = \Yii::$app->request->post('itemId');
        $newQuantity = \Yii::$app->request->post('quantity');
        if (\Yii::$app->user->isGuest) {
            $cartItems = \Yii::$app->session->get(CartItem::SESSION_KEY);
            foreach ($cartItems as $key => $cartItem) {
                if ($cartItem['id'] == $itemId) {
                    $itemToUpdateKey = $key;
                }
            }
            if (isset($itemToUpdateKey)) {
                $itemToUpdate = $cartItems[$itemToUpdateKey];
                $itemToUpdate['quantity'] = $newQuantity ? $newQuantity : 1;
                $cartItems[$itemToUpdateKey] = $itemToUpdate;
                \Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
            }
        } else {
            $userId = \Yii::$app->user->id;
            $itemToUpdate = CartItem::find()->userId($userId)->andWhere(['product_id' => $itemId])->one();
            $itemToUpdate->quantity = $newQuantity ? $newQuantity : 1;
            $itemToUpdate->save();
        }

        return CartItem::getTotalQuantity();
    }


    public function actionCheckout(){
        $order = new Order();
        $orderAddress = new OrderAddresse();

        if (!\Yii::$app->user->isGuest){
            $user = \Yii::$app->user->identity;
            $userAddress = $user->getAddress();
            $order->firstname = $user->firstname;
            $order->lastname = $user->lastname;
            $order->email = $user->email;
            $order->status = Order::STATUS_DRAFT;

            $orderAddress->address = $userAddress->address ;
            $orderAddress->city = $userAddress->city ;
            $orderAddress->state = $userAddress->state ;
            $orderAddress->country = $userAddress->country ;
            $orderAddress->zipcode = $userAddress->zipcode ;

            $totalQuantity = CartItem::getTotalQuantity();

            return $this->render('checkout',[
                'order'=>$order,
                'orderAddress'=>$orderAddress,
                'cartItems'=>CartItem::getCartItems(),
                'totalQuantity'=>$totalQuantity,
                'totalPrice'=>CartItem::getTotalPrice()
            ]);
        }else{
            return $this->render('checkout',[
                'order'=>$order,
                'orderAddress'=>$orderAddress,
                'cartItems'=>CartItem::getCartItems(),
                'totalQuantity'=>CartItem::getTotalQuantity(),
                'totalPrice'=>CartItem::getTotalPrice()
            ]);
        }

    }
}