<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_detail extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

	public function index($params = null) {
    if($params) $params = json_decode($params, true);

    print_l($params);

    $data = array(
      'page' => array(
        'one' => 'home'
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
        ),

        'scripts' => array(
          array('js/pages/home.js')
        )
      )
    );

    print_l($this->properties_model->properties((isset($params['route_params']) ? $params['route_params'] : null), true));

		// $this->template->view('site/master', 'site/properties/search', $data);
	}
}
