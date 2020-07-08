<?php

class ControllerModuleProductsReplace extends Controller {

    private $error = array();

    public function index() {
        
        $this->load->language('module/products_replace');
        

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('module/products_replace');
        $this->load->model('catalog/category');
        
        $filters['sort'] = 'name';
        $filters['start'] = 0;        
        $filters['limit'] = 1000;        
        $data['categories']  = $this->model_catalog_category->getCategories($filters);

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/products_replace', 'token=' . $this->session->data['token'] , true)
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
        $data['is_fail'] = $data['is_success'] = false;
        
        


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        

        $this->response->setOutput($this->load->view('module/products_replace', $data));
    }
    
    
    public function start() {
        
        var_dump($this->request->post);
        
    }

}
