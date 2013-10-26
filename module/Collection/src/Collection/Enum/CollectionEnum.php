<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 17:37
 * To change this template use File | Settings | File Templates.
 */

namespace Collection\Enum;

class CollectionEnum {
    const NEW_COLLECTION = 0;

    const NO_RETURN_TIME = -1;

    //sort mode
    const SORT_NATIVE = 0;
    const SORT_OLD_TO_NEW = 1;
    const SORT_NEW_TO_OLD = 2;

    const ATTR_ID = "id";
    const ATTR_OWNER = "owner";
    const ATTR_RECEPTION_TIME = "reception_time";
    const ATTR_RETURN_TIME = "return_time";
    const ATTR_PACKAGE_NUMBER = "package_number";
    const ATTR_BILL_REFERENCE = "bill_reference";
    const ATTR_BILL_AMOUNT = "bill_amount";
    const ATTR_PAID_STATUS = "paid_status";
}