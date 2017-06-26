<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties__list extends Admin_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($page = 1) {
    $this->site->user_logged(FALSE, TRUE);

    $data = array(
      'page' => array(
        'one' => 'properties',
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

    $data['properties'] = $this->properties_model->properties(array(
      'order' => ($this->input->get('order') ? $this->input->get('order') : 'ASC'),
      'orderby' => ($this->input->get('orderby') ? $this->input->get('orderby') : 'most_recent'),
      'page' => $page
    ));



    $this->template->view('admin/master', 'admin/properties/list', $data);
  }
}
