<?php


namespace app\widgets;


use Codeception\PHPUnit\ResultPrinter\HTML;
use yii\base\Widget;

class BgWidget extends Widget
{

    public $bgColor='white';
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        ob_start();
    }

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        $output = ob_get_clean();

        return $this->render('test',[
            'message'=>$output,
            'bgColor'=>$this->bgColor
        ]);
//        return \yii\helpers\Html::tag('div',$output,[
//            'style'=>'background-color:'.$this->bgColor
//        ]);

    }


}