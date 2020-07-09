<?php

class ControllerModuleProductsReplace extends Controller {    

    public function index() {

        $this->load->language('module/products_replace');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/category');

        $filters['sort'] = 'name';
        $filters['start'] = 0;
        $filters['limit'] = 1000;
        $data['categories'] = $this->model_catalog_category->getCategories($filters);

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/products_replace', 'token=' . $this->session->data['token'], true)
        );

        $data['start'] = $this->url->link('module/products_replace/start', 'token=' . $this->session->data['token'], true);
        $data['token'] = $this->session->data['token'];

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_success'] = $this->language->get('text_success');
        $data['text_fail'] = $this->language->get('text_fail');
        $data['text_categories_from'] = $this->language->get('text_categories_from');
        $data['text_category_to'] = $this->language->get('text_category_to');

        $data['text_start'] = $this->language->get('text_start');
        $data['text_replace_to'] = $this->language->get('text_replace_to');
        $data['text_replace_to_desc'] = $this->language->get('text_replace_to_desc');
        $data['text_replace_from'] = $this->language->get('text_replace_from');
        $data['text_replace_from_desc'] = $this->language->get('text_replace_from_desc');
        $data['text_warning'] = $this->language->get('text_warning');

        if (isset($this->session->data['is_fail'])) {
            $data['is_fail'] = $this->session->data['is_fail'];
            unset($this->session->data['is_fail']);
        } else {
            $data['is_fail'] = '';
        }
        if (isset($this->session->data['is_success'])) {
            $data['is_success'] = $this->session->data['is_success'];
            unset($this->session->data['is_success']);
        } else {
            $data['is_success'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/products_replace', $data));
    }

    public function start() {
        $this->load->language('module/products_replace');
        $this->load->model('module/products_replace');

        if (isset($this->request->post['categories']) && isset($this->request->post['to_category_id'])) {

            $category_to = (int) $this->request->post['to_category_id'];
            $categories = $this->request->post['categories'];

            $replace_to = (isset($this->request->post['replace_to'])) ? 1 : 0;
            $replace_from = (isset($this->request->post['replace_from'])) ? 1 : 0;

            $this->model_module_products_replace->startReplace($categories, $category_to, $replace_to, $replace_from);

            $this->session->data['is_success'] = $this->language->get('text_success');
        } else {
            $this->session->data['is_fail'] = $this->language->get('text_fail');
        }
        $this->response->redirect($this->url->link('module/products_replace', 'token=' . $this->session->data['token'], true));
    }

}
