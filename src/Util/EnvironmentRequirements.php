<?php

namespace BlueMedia\OnlinePayments\Util;

/**
 * Class EnvironmentRequirements.
 * @package BlueMedia\OnlinePayments\Util
 */
class EnvironmentRequirements
{

    /**
     * @return bool
     */
    public static function hasSupportedPhpVersion()
    {
        return !version_compare(PHP_VERSION, '5.5', '>=');
    }

    /**
     * @param  string $extensionName
     * @return bool
     */
    public static function hasPhpExtension($extensionName)
    {
        return extension_loaded($extensionName);
    }
}
