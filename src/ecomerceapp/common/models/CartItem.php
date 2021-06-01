<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cart_items}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property int|null $created_by
 *
 * @property Product $product
 */
class CartItem extends \yii\db\ActiveRecord
{

    const SESSION_KEY = 'CART_ITEMS';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cart_items}}';
    }

    public static function getTotalQuantity(){
        $sum = 0;
        if (Yii::$app->user->isGuest){
            $cartItems= Yii::$app->session->get(CartItem::SESSION_KEY,[]);
            foreach ($cartItems as $cartItem){
                $sum +=$cartItem['quantity'];
            }
        }else{
            $sum = CartItem::findBySql(
                "SELECT SUM(quantity) FROM cart_items WHERE created_by = :userId", ["userId"=>Yii::$app->user->id]
            )->scalar();
        }
        return $sum;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['product_id', 'quantity', 'created_by'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CartItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CartItemQuery(get_called_class());
    }
}
