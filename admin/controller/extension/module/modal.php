<?php
class ControllerExtensionModuleModal extends Controller {
    private $error = array();   // Установка ошибки, если есть

    public function index() {
        $this->load->language('extension/module/modal');    // Загрузка файла языка

        $this->document->setTitle($this->language->get('heading_title'));   // Устанавливаем заголовок страницы  в шапке файла языка

        $this->load->model('setting/setting');  // Загружаем Setting Model (все модели и общие настройки сохраняются с помощью этой модели)

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {    // Валидация и проверка данных если они переданы методом POST
            $this->model_setting_setting->editSetting('modal', $this->request->post);   //Анализ и передача входящих данных в Setting Model для сохранения в базе данных

            $this->session->data['success'] = $this->language->get('text_success'); // Для вывода текста о том что данные успешно сохранены

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)); // редирект в директорию Extensions
        }

        // Назначаем данные языка для анализа и передачи их в представление
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_image'] = $this->language->get('entry_image');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        // Этот блок возвращает предупреждение
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // Создание хлебных крошек для вывода их на сайте
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/modal', 'token=' . $this->session->data['token'], true)
        );

        // URL-адрес, на который будет перенаправление при нажатии кнопки сохранения
        $data['action'] = $this->url->link('extension/module/modal', 'token=' . $this->session->data['token'], true);
        // URL-адрес, на который будет перенаправление при нажатии кнопки отмены
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

        // Проверка статуса
        if (isset($this->request->post['modal_status'])) {
            $data['modal_status'] = $this->request->post['modal_status'];
        } else {
            $data['modal_status'] = $this->config->get('modal_status');
        }

        // Проверка пути
        if (isset($this->request->post['modal_path'])) {
            $data['modal_path'] = $this->request->post['modal_path'];
        } else {
            $data['modal_path'] = $this->config->get('modal_path');
        }

        $this->load->model('tool/image');   // Загружаем модель макета дизайна

        if (isset($this->request->post['modal_path']) && is_file(DIR_IMAGE . $this->request->post['modal_path'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['modal_path'], 100, 100);
        } elseif ($this->config->get('modal_path') && is_file(DIR_IMAGE . $this->config->get('modal_path'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('modal_path'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // Отображение
        $this->response->setOutput($this->load->view('extension/module/modal.tpl', $data));
    }

    /**
     * @return bool
     * Проверка прав пользователя для работы с модулем
     */
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/modal')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}