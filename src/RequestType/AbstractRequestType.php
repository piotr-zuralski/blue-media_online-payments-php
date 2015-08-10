<?php

namespace BlueMedia\OnlinePayments\RequestType;

use BlueMedia\OnlinePayments\Model\AbstractModel;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\RequestType
 * @since     2015-08-08
 * @version   2.3.1
 */
abstract class AbstractRequestType
{

//    abstract public function start

    /**
     * (description)
     *
     * @param AbstractModel $model
     * @param string $fieldName
     *
     * @return null|string
     */
    final protected function getValueFromObject(AbstractModel $model, $fieldName)
    {
        $methodName = sprintf('get%s', ucfirst($fieldName));
        if (!method_exists($model, $methodName)) {
            return null;
        }
        $methodValue = trim(call_user_func([$model, $fieldName]));
        if (empty($methodValue)) {
            return null;
        }
        return $methodValue;
    }

    public function parseRequestXML()
    {

    }

    public function makeRequestXML()
    {

    }

} 