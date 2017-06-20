<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_search extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

	public function index($params = null) {
    if($params) $params = json_decode($params, true);

    $route_params = isset($params['route_params']) ? $params['route_params'] : null;

    // $route_params['params']['location'][] = array(
    //   'state' => 'sp',
    //   'city' => 'campo-limpo-paulista',
    //   'district' => 'ville-saint-james-ii'
    // );

    // $route_params['params']['properties_types'][] = 'casa';

    // $route_params['params']['bedrooms'] = 5;
    // $route_params['params']['garages'] = 4;
    // $route_params['params']['bathrooms'] = 3;

    // $route_params['params']['min_price'] = 1000000;
    // $route_params['params']['max_price'] = 3500000;

    // $route_params['params']['min_area'] = 100;
    // $route_params['params']['max_area'] = 200;

    // $route_params['params']['property_features'] = array('piscina');


    // print_l($route_params);

    // print_l($route_params);

    if($this->input->get('_')){
      $route_params = json_decode(base64url_decode($this->input->get('_')), true);
    }else{
      $url_filter = $this->site->create_url_filter($route_params);
      redirect(base_url($url_filter['uri_full']), 'location');
    }

    $data = array(
      'page' => array(
        'one' => 'home'
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
          'css/sweetalert2.min.css'
        ),

        'scripts' => array(
          array('js/jquery.mask.js'),
          array('js/sweetalert2.min.js'),
          array('js/pages/properties__search.js')
        )
      ),

      'filters' =>  $this->properties_model->filters($route_params),
      'properties' => $this->properties_model->properties($route_params)
    );

    // print_l($data);

		$this->template->view('site/master', 'site/properties/search', $data);
	}
}
