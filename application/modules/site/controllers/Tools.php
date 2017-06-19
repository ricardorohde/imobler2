<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Site_Controller {
	function __construct() {
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

  function configjs() {
    $this->load->view('site/configjs');
  }

  function buscar_imoveis() {
    if(!$this->input->post()) redirect(base_url(), 'location');

    $this->load->model('properties_model');

    $post = $this->input->post();

    $route_params = $post;

    if($this->input->post('_')){
      $route_params = json_decode(base64url_decode($this->input->post('_')), true);
    }

    if(isset($post['page'])){
      $route_params['page'] = $post['page'];
    }

    $route_params_filter = $this->site->create_url_filter($route_params);

    $route_params['base_url'] = base_url($route_params_filter['uri_full']);
    $route_params['url_suffix'] = $route_params_filter['filter'];

    if(!isset($post['ajaxsubmit'])){
      redirect(base_url($route_params_filter['uri_full']), 'location');
    }

    $properties = $this->properties_model->properties($route_params);

    $return = $properties;
    $return['url_new'] = $route_params_filter['uri_full'];

    echo json_encode($return);
  }

  public function get_locations(){
    header('Content-Type: application/json');
    $this->load->model('properties_model');
    echo $this->properties_model->get_locations_by_term();
  }

  public function property_like() {
    if($this->site->user_logged()){
      $this->load->model('properties_model');
      if($like = $this->properties_model->property_like($this->input->post())){
        echo json_encode($like);
      }
    }
  }
}
