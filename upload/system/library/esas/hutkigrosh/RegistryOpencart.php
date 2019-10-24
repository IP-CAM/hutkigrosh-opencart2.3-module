<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 12:05
 */

namespace esas\hutkigrosh;


use esas\hutkigrosh\lang\TranslatorOpencart;
use esas\hutkigrosh\view\client\CompletionPanelOpencart;
use esas\hutkigrosh\view\admin\ConfigFormOpencart;
use esas\hutkigrosh\view\admin\fields\ConfigFieldList;
use esas\hutkigrosh\view\admin\fields\ConfigFieldNumber;
use esas\hutkigrosh\view\admin\fields\ListOption;
use esas\hutkigrosh\view\admin\validators\ValidatorInteger;
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

    public function createConfigForm()
    {
        $language = $this->registry->get('language');
        $language->load('extension/payment/hutkigrosh');
        $configForm = new ConfigFormOpencart($this->registry);
        $configForm->addRequired();
        $configForm->addField(new ConfigFieldNumber(
            "hutkigrosh_sort_order",
            $language->get('module_sort_order_label'),
            $language->get('module_sort_order_description'),
            true,
            new ValidatorInteger(1, 20),
            1,
            20));
        $configForm->addField(new ConfigFieldList(
            "hutkigrosh_status",
            $language->get('module_status_label'),
            $language->get('module_status_description'),
            true, [
            new ListOption("1", $language->get('module_status_enable')),
            new ListOption("0", $language->get('module_status_disable'))]));
        return $configForm;
    }

    public function getCompletionPanel($orderWrapper)
    {
        $completionPanel = new CompletionPanelOpencart($orderWrapper);
        return $completionPanel;
    }


}