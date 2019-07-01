<?php
header('Content-Type: text/html; charset=utf-8');

use esas\hutkigrosh\controllers\ControllerAddBill;
use esas\hutkigrosh\controllers\ControllerAlfaclick;
use esas\hutkigrosh\controllers\ControllerCompletionPage;
use esas\hutkigrosh\controllers\ControllerNotify;
use esas\hutkigrosh\utils\Logger;
use esas\hutkigrosh\Registry as HutkigroshRegistry;
use esas\hutkigrosh\utils\RequestParams;
use esas\hutkigrosh\wrappers\OrderWrapperOpencart;

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/system/library/esas/hutkigrosh/init.php');

class ControllerExtensionPaymentHutkiGrosh extends Controller
{
    public function index()
    {
        $this->language->load('extension/payment/hutkigrosh');
        $data['text_testmode'] = $this->language->get('text_testmode');
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['testmode'] = HutkigroshRegistry::getRegistry()->getConfigurationWrapper()->isSandbox();
        $data['action'] = $this->url->link('extension/payment/hutkigrosh/pay');
        $data['continue'] = $this->url->link('checkout/success');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'extension/payment/hutkigrosh.tpl')) {
            return $this->load->view($this->config->get('config_template') . 'extension/payment/hutkigrosh.tpl', $data);
        } else {
            return $this->load->view('extension/payment/hutkigrosh.tpl', $data);
        }
    }


    public function pay()
    {
        try {
            $orderId = $this->session->data['order_id'];
            if (!isset($orderId)) {
                $this->redirect($this->url->link('checkout/checkout'));
                return false;
            }
            $orderWrapper = new OrderWrapperOpencart($orderId, $this->registry);
            // проверяем, привязан ли к заказу billid, если да,
            // то счет не выставляем, а просто прорисовываем старницу
            if (empty($orderWrapper->getBillId())) {
                $controller = new ControllerAddBill();
                $controller->process($orderWrapper);
            }

            $controller = new ControllerCompletionPage(
                $this->url->link('extension/payment/hutkigrosh/alfaclick'),
                $this->registry->get("url")->link('extension/payment/hutkigrosh/pay'));
            $completionPanel = $controller->process($orderId);

            $data['completionPanel'] = $completionPanel;

            $this->language->load('extension/payment/hutkigrosh');
            $this->document->setTitle($this->language->get('heading_title'));
            $data['breadcrumbs'] = $this->createBreadcrumbs();

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_continue_link'] = $this->url->link('checkout/success');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'extension/payment/hutkigrosh_checkout_success.tpl')) {
                $templateView = $this->config->get('config_template') . 'extension/payment/hutkigrosh_checkout_success.tpl';
            } else {
                $templateView = 'extension/payment/hutkigrosh_checkout_success.tpl';
            }
            $this->response->setOutput($this->load->view($templateView, $data));

        } catch (Throwable $e) {
            Logger::getLogger("payment")->error("Exception:", $e);
            return $this->failure($e->getMessage());
        } catch (Exception $e) { // для совместимости с php 5
            Logger::getLogger("payment")->error("Exception:", $e);
            return $this->failure($e->getMessage());
        }
    }

    private function createBreadcrumbs() {
        $breadcrumbs = array();
        $breadcrumbs[] = $this->createBreadcrumb('text_home','common/home');
        $breadcrumbs[] = $this->createBreadcrumb('text_basket','checkout/cart');
        $breadcrumbs[] = $this->createBreadcrumb('text_checkout','checkout/checkout');
        $breadcrumbs[] = $this->createBreadcrumb('text_success','checkout/success');
        return $breadcrumbs;
    }

    private function createBreadcrumb($text, $link) {
        return array(
            'text' => $this->language->get($text),
            'href' => $this->url->link($link)
        );
    }

    public function alfaclick()
    {
        try {
            $controller = new ControllerAlfaclick();
            $controller->process($this->request->post[RequestParams::BILL_ID], $this->request->post[RequestParams::PHONE]);
        } catch (Throwable $e) {
            Logger::getLogger("alfaclick")->error("Exception: ", $e);
        } catch (Exception $e) { // для совместимости с php 5
            Logger::getLogger("alfaclick")->error("Exception: ", $e);
        }
    }

    protected function failure($error)
    {
        $this->session->data['error'] = $error;
        $this->response->redirect($this->url->link('checkout/cart', '', true));
    }

    public function notify()
    {
        try {
            $billId = $this->request->get[RequestParams::PURCHASE_ID];
            $controller = new ControllerNotify();
            $controller->process($billId);
        } catch (Throwable $e) {
            Logger::getLogger("notify")->error("Exception:", $e);
        } catch (Exception $e) { // для совместимости с php 5
            Logger::getLogger("notify")->error("Exception:", $e);
        }
    }
}
