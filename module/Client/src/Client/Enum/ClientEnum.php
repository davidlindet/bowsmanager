<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 17:37
 * To change this template use File | Settings | File Templates.
 */

namespace Client\Enum;

class ClientEnum {
    const NEW_CLIENT = 0;

    // Client List sort mode
    const SORT_NATIVE = 0;
    const SORT_AZ = 1;
    const SORT_ZA = 2;

    private static $filters = array('ALL', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    public static function FILTERS() {
        return self::$filters;
    }
}