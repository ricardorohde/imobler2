<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaigns__categories__list extends Admin_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($page = 1) {
    $this->site->user_logged(FALSE, TRUE);

    $data = array(
      'page' => array(
        'one' => 'campaigns',
        'two' => 'categories',
        'three' => 'list'
      ),

      'section' => array(),

      'assets' => array(
          'styles' => array(
          array('plugins/sweetalert2/sweetalert2.min.css')
        ),

        'scripts' => array(
          array('plugins/sweetalert2/sweetalert2.min.js')
        ),

        'script_page' => 'js/campaigns_categories_list.js'
      ),
    );

    $orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'campanhas_categorias.id';
    $orderdir = $this->input->get('order') ? $this->input->get('order') : 'ASC';

    $data['categories'] = $this->registros_model->registros(
      'campanhas_categorias',
      array(
        'pagging' => true
      ),
      false,
      'campanhas_categorias.*',
      array(
      ),
      array($orderby => $orderdir)
    );

    $this->template->view('admin/master', 'admin/campaigns/categories/list', $data);
  }
}
