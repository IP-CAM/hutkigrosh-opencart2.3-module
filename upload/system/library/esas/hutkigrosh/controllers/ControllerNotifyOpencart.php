<?php

namespace esas\hutkigrosh\controllers;
use esas\hutkigrosh\wrappers\OrderWrapperOpencart;
use Registry;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:55
 */

class ControllerNotifyOpencart extends ControllerNotify
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * ControllerNotifyOpencart constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct();
        $this->registry = $registry;
    }


    /**
     * По локальному идентификатору заказа возвращает wrapper
     * @param $orderId
     * @return \esas\hutkigrosh\wrappers\OrderWrapper
     */
    public function getOrderWrapperByOrderNumber($orderNumber)
    {
        return new OrderWrapperOpencart($orderNumber, $this->registry);
    }
}