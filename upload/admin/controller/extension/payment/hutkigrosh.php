<?php

use esas\hutkigrosh\utils\Logger as HutkigroshLogger;
use esas\hutkigrosh\Registry as HutkigroshRegistry;
use Throwable as Th;

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/system/library/esas/hutkigrosh/init.php');

class ControllerExtensionPaymentHutkiGrosh extends Controller
{

    /**
     * ControllerExtensionPaymentHutkiGrosh constructor.
     */
    public function index()
    {

        try {
            $this->load->language('extension/payment/hutkigrosh');
            $this->document->setTitle($this->language->get('heading_title'));
            $configForm = HutkigroshRegistry::getRegistry()->getConfigForm();
            $data['configForm'] = $configForm;// Сохранение или обновление данных
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($configForm->validateAll($this->request->post))) {
                $this->load->model('setting/setting');
                $this->model_setting_setting->editSetting('hutkigrosh', $this->request->post);
                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', 'SSL'));
            }// Установка языковых констант
            $data['heading_title'] = $this->language->get('heading_title');// Генерация хлебных крошек
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            );
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_extension'),
                'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', 'SSL'),
            );
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/payment/hutkigrosh', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            );// Кнопки
            $data['action'] = $this->url->link('extension/payment/hutkigrosh', 'token=' . $this->session->data['token'], 'SSL');
            $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', 'SSL');// Рендеринг шаблона
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');
            $this->response->setOutput($this->load->view('extension/payment/hutkigrosh.tpl', $data));
        } catch (Th $e) {
            HutkigroshLogger::getLogger("ControllerExtensionPaymentHutkiGrosh")->error("Exception", $e);
        } catch (Exception $e) { // для совместимости с php 5
            HutkigroshLogger::getLogger("ControllerExtensionPaymentHutkiGrosh")->error("Exception", $e);
        }
    }
}