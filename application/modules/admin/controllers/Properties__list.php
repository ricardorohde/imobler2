<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties__list extends Admin_Controller {
  function __construct() {
    parent::__construct();
  }

  function index() {
    $data = array(
      'page' => array(
        'one' => 'properties',
        'two' => 'list'
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
        ),

        'scripts' => array(
          array('plugins/jquery-datatable/media/js/jquery.dataTables.min.js')
        ),

        'script_page' => 'js/properties_list.js'
      ),
    );

    $this->template->view('admin/master', 'admin/properties/list', $data);
  }
}
