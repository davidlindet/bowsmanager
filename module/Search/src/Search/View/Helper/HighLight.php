<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 21/10/13
 * Time: 17:25
 * To change this template use File | Settings | File Templates.
 */
namespace Search\View\Helper;

use Zend\View\Helper\AbstractHelper;

class HighLight extends AbstractHelper
{
    public function __invoke($copy, $query)
    {
       $position = strpos(strtolower($copy), strtolower($query));

        $result = $copy;

       if($position !== false) {
           $startString = ($position > 0) ? substr($copy , 0, $position) : "";
           $middleString = substr($copy , $position, strlen($query));
           $endString = substr($copy , $position + strlen($query));

           $result = $startString . "<span class='highlight'>" .$middleString . "</span>" . $endString;
       }
       return $result;
    }
}