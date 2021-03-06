<?php

 namespace App\Controllers;
 
 class Category extends BaseController {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->cek_status();
    }
 
    public function index()
    {
        $data['categories'] = $this->category_model->get('category');
        $this->load->view('category/index', $data);
    }
?>