<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaigns__list extends Admin_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($page = 1) {
    $this->site->user_logged(FALSE, TRUE);

    $data = array(
      'page' => array(
        'one' => 'campaigns',
        'two' => 'list'
      ),

      'section' => array(),

      'assets' => array(
          'styles' => array(
          array('plugins/sweetalert2/sweetalert2.min.css')
        ),

        'scripts' => array(
          array('plugins/sweetalert2/sweetalert2.min.js')
        ),

        'script_page' => 'js/properties_list.js'
      ),
    );

    $orderby = $this->input->get('orderby') ? $this->input->get('orderby') : 'campanhas.id';
    $orderdir = $this->input->get('order') ? $this->input->get('order') : 'ASC';

    $data['campaigns'] = $this->registros_model->registros(
      'campanhas',
      array(
        'where' => array()
      ),
      false,
      'campanhas.*, campanhas_categorias.nome as categoria_nome',
      array(
        array('campanhas_categorias', 'campanhas.categoria = campanhas_categorias.id', 'inner')
      ),
      array($orderby => $orderdir)
    );

    $this->template->view('admin/master', 'admin/campaigns/list', $data);
  }
}
