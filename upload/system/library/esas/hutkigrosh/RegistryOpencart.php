<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 12:05
 */

namespace esas\hutkigrosh;


use esas\hutkigrosh\lang\TranslatorOpencart;
use esas\hutkigrosh\wrappers\ConfigurationWrapperOpencart;
use esas\hutkigrosh\wrappers\OrderWrapper;
use esas\hutkigrosh\wrappers\OrderWrapperOpencart;

class RegistryOpencart extends Registry
{
    private $registry;

    /**
     * RegistryOpencart constructor.
     * @param $registry
     */
    public function __construct($registry)
    {
        $this->registry = $registry;
    }


    public function createConfigurationWrapper()
    {
        $loader = $this->registry->get("load");
        $loader->model('setting/setting');
        return new ConfigurationWrapperOpencart($this->registry->get("model_setting_setting")->getSetting('hutkigrosh'));
    }

    public function createTranslator()
    {
        return new TranslatorOpencart($this->registry);
    }

    /**
     * По локальному номеру счета (номеру заказа) возвращает wrapper
     * @param $orderId
     * @return OrderWrapper
     */
    public function getOrderWrapper($orderNumber)
    {
        return new OrderWrapperOpencart($orderNumber, $this->registry);
    }
}