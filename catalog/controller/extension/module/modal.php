<?php
class ControllerExtensionModuleModal extends Controller {
    public function index() {
        $this->load->language('extension/module/modal');    // Загрузка файла языка

        $data['modal_path'] = DIR_IMAGE . $this->config->get('modal_path'); // Путь к изображению

        if ($data['modal_path']) {
            return $this->load->view('extension/module/modal', $data);
        }
    }
}