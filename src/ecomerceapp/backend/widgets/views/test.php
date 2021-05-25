<?php

/** @var $message
 * @var $bgColor
 */

echo \yii\helpers\Html::tag('div',$message,[
   'style'=>'background-color:'.$bgColor
]);