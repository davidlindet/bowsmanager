<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 17:37
 * To change this template use File | Settings | File Templates.
 */

namespace Bill\Enum;

class BillPaymentTypeEnum {

    const UNKNOWN = null;
    const CASH = "CASH";
    const CHECK = "CHECK";
    const BANK_TRANSFERT = "BANK_TRANSFERT";


    private static $types = array(
        null => 'Inconnu',
        "CASH"  => 'Cash',
        "CHECK" => 'Check',
        "BANK_TRANSFERT" => 'Bank Transfert',
    );

    public static function TYPES($removeUnknown = false) {
        $types = self::$types;
        if($removeUnknown){
            unset($types[null]);
        }
        return $types;
    }

    public static function TYPE($type) {
        return self::$types[$type];
    }
}