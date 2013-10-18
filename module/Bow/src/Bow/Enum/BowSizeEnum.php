<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 17:37
 * To change this template use File | Settings | File Templates.
 */

namespace Bow\Enum;

class BowSizeEnum {

    const UNKNOWN = null;
    const QUARTER = 0;
    const HALF = 1;
    const THREE_QUARTERS = 2;
    const FOUR_QUARTERS = 3;
    const BAROQUE = 4;

    private static $copies = array(
        null => 'Inconnu',
        0  => '1/4',
        1 => '1/2',
        2 => '3/4',
        3 => '4/4',
        4 => 'Baroque',
    );

    public static function COPIES($removeUnknown = false) {
        $copies = self::$copies;
        if($removeUnknown){
            unset($copies[null]);
        }
        return $copies;
    }

    public static function COPY($type) {
        return self::$copies[$type];
    }
}