<?php

namespace BlueMedia\OnlinePayments\Model;

/**
 * Abstract model class.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.3
 */
abstract class AbstractModel
{
    abstract public function validate();
}
