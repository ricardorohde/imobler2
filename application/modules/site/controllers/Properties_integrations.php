<?php
set_time_limit(0);
ini_set('memory_limit', '1024M');
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_integrations extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
    header('Content-Type: text/xml; charset=utf-8');
    $this->output->enable_profiler(false);
  }

	public function index($portal) {

    $campaign = $this->registros_model->registros('campanhas', array('where' => array('campanhas.permalink' => 'integracoes', 'campanhas.status' => 1)), true, 'campanhas.*, campanhas_categorias.nome as categoria', array(
      array('campanhas_categorias', 'campanhas.categoria = campanhas_categorias.id', 'inner')
    ));

    if(isset($campaign['parametros'])){
      $route_params['params'] = json_decode($campaign['parametros'], true);
      $route_params['limit'] = 'all';

      $data['properties'] = $this->properties_model->properties($route_params);

      $this->load->view('site/integrations/' . $portal, $data);
    }
	}
}
