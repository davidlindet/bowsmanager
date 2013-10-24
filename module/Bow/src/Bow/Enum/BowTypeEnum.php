<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 17:37
 * To change this template use File | Settings | File Templates.
 */

namespace Bow\Enum;

class BowTypeEnum {

    const UNKNOWN = null;
    const VIOLIN = 0;
    const CELLO = 1;
    const ALTO = 2;
    const DOUBLE_BASS = 3;

    private static $copies = array(
        null =>  'Unknow',
        0  => 'Violin',
        1 => 'Cello',
        2 => 'Viola',
        3 => 'Doublebass',
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