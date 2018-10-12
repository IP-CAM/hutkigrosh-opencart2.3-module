<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 12:38
 */

namespace esas\hutkigrosh\controllers;


use CMain;
use COption;
use esas\hutkigrosh\lang\TranslatorBitrix;
use esas\hutkigrosh\lang\TranslatorOpencart;
use esas\hutkigrosh\wrappers\ConfigurationWrapperBitrix;
use esas\hutkigrosh\wrappers\ConfigurationWrapperOpencart;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Registry;

class ControllerWebpayFormOpencart extends ControllerWebpayForm
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * ControllerWebpayFormOpencart constructor.
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct();
        $this->registry = $registry;
    }


    /**
     * Основная часть URL для возврата с формы webpay (чаще всего current_url)
     * @return string
     */
    public function getReturnUrl(OrderWrapper $orderWrapper)
    {
        $url = $this->registry->get("url");
        return $url->link('extension/payment/hutkigrosh/pay') . "&" . "purchaseid=" . $orderWrapper->getOrderId(); //todo вместо callback возвращаться на pay
    }
}