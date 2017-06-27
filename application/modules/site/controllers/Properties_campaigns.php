<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_campaigns extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

	public function index($request = null) {
    if($request) $request = json_decode($request, true);

    $route_params = isset($request['route_params']) ? $request['route_params'] : null;

    if($this->input->get('_')){
      $route_params = json_decode(base64url_decode($this->input->get('_')), true);
    }else{
      $url_filter = $this->site->create_url_filter($route_params);
      redirect(base_url($url_filter['uri_full']), 'location');
    }

    $campaign = $this->registros_model->registros('campanhas', array('where' => array('campanhas.permalink' => $route_params['campaign'])), true, 'campanhas.*, campanhas_categorias.nome as categoria', array(
      array('campanhas_categorias', 'campanhas.categoria = campanhas_categorias.id', 'inner')
    ));

    if($campaign){
      $route_params['params'] = json_decode($campaign['parametros'], true);
    }

    $data = array(
      'page' => array(
        'one' => 'campaign'
      ),

      'section' => array(
        'title' => $campaign['titulo'],
        'description' => $campaign['descricao']
      ),

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
      'properties' => $this->properties_model->properties($route_params),
      'campaign' => $campaign
    );

    if(isset($campaign['imagem_arquivo']) && !empty($campaign['imagem_arquivo'])){
      $data['section']['image'] = 'imagens/campanhas/'. $campaign['id'] . '/400/400/100/0/' . $campaign['imagem_arquivo'];
    }

		$this->template->view('site/master', 'site/properties/campaigns', $data);
	}
}
