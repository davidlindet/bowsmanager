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

class SectionName extends AbstractHelper
{
    protected $routeMatch;

    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function __invoke()
    {
        if ($this->routeMatch) {
            $params = $this->routeMatch->getParams();
            $controller = explode("\\", $params["controller"]);
            $section = strtolower($controller[2] . "-" . $params['action']);
            return $section;
        }
    }
}
