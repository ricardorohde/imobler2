<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

	public function index($params = null) {
    if($params) $params = json_decode($params, true);

    print_l();

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
      ),

      'properties_types' => $this->properties_model->filters_properties_types()
    );

    $data['featured'] = $this->properties_model->properties(array(
      'orderby' => 'featured'
    ));

    $data['campaigns'] = $this->registros_model->registros('campanhas', array('where' => array('campanhas.status' => 1, 'campanhas_categorias.id' => 1)), false, 'campanhas.*, campanhas_categorias.nome as categoria', array(
      array('campanhas_categorias', 'campanhas.categoria = campanhas_categorias.id', 'inner')
    ));

    // print_l($this->properties_model->properties((isset($params['route_params']) ? $params['route_params'] : null)));

		$this->template->view('site/master', 'site/home', $data);
	}
}
