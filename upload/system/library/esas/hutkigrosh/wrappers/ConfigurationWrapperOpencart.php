<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.09.2018
 * Time: 12:31
 */

namespace esas\hutkigrosh\wrappers;


use esas\hutkigrosh\lang\TranslatorOpencart;
use esas\hutkigrosh\Registry;
use Exception;

class ConfigurationWrapperOpencart extends ConfigurationWrapper
{
    private $config;

    /**
     * ConfigurationWrapperOpencart constructor.
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }


    /**
     * @param $key
     * @return string
     * @throws Exception
     */
    public function getCmsConfig($key)
    {
        if (array_key_exists($key, $this->config))
            return $this->config[$key];
        else
            return "";
    }

    /**
     * @param $cmsConfigValue
     * @return bool
     * @throws Exception
     */
    public function convertToBoolean($cmsConfigValue)
    {
        return $cmsConfigValue; //уже boolean
    }
}