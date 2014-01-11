<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 24/10/13
 * Time: 00:21
 * To change this template use File | Settings | File Templates.
 */
namespace Application\View\Helper;

use Application\Enum\DeviseEnum;
use Zend\View\Helper\AbstractHelper;

class Devise extends AbstractHelper
{
    public function getDeviseSymbol($type) {
        switch($type){
            case DeviseEnum::EUR:
                $symbol = DeviseEnum::EUR_SYMBOL;
                break;
            case DeviseEnum::GBP:
                $symbol = DeviseEnum::GBP_SYMBOL;
                break;
            case DeviseEnum::USD:
                $symbol = DeviseEnum::USD_SYMBOL;
                break;
            default:
                $symbol = "";
        }

        return $symbol;
    }

    public function getDeviseList(){
        return array(
            DeviseEnum::EUR => DeviseEnum::EUR_SYMBOL,
            DeviseEnum::GBP => DeviseEnum::GBP_SYMBOL,
            DeviseEnum::USD => DeviseEnum::USD_SYMBOL,
        );
    }

    public function formatPrice($price, $deviseType) {
        switch($deviseType){
            case DeviseEnum::EUR:
                $price = $price . DeviseEnum::EUR_SYMBOL;
                break;
            case DeviseEnum::GBP:
                $price = DeviseEnum::GBP_SYMBOL . $price;
                break;
            case DeviseEnum::USD:
                $price = DeviseEnum::USD_SYMBOL . $price;
                break;
            default:
                $price = $price;
        }

        return $price;
    }

}
