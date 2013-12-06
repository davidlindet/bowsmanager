<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 24/10/13
 * Time: 00:21
 * To change this template use File | Settings | File Templates.
 */
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Upload\Enum\UploadEnum;

class FileType extends AbstractHelper
{
    public function isImage($fileName) {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $results = false;
        if($ext == "jpg" || $ext == "png" || $ext == "gif") {
            $results = true;
        }

        return $results;
    }

    public function getOriginalName($fileName) {
        $nameArray = explode(UploadEnum::SEPARATOR, $fileName);
        $originalName = ($nameArray[0] == UploadEnum::TYPE_BILL) ? "Page ".($nameArray[2]+1) ." - ". $nameArray[4] : $nameArray[4];
        return $originalName;
    }
}
