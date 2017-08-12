<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_details extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

	public function index($params = null) {
    if($params) $params = json_decode($params, true);

    $property = $this->properties_model->properties((isset($params['route_params']) ? $params['route_params'] : null), true);

    if(!$property){
      show_404();
    }

    $data = array(
      'page' => array(
        'one' => 'home'
      ),

      'section' => array(
        'canonical' => $property['imovel_permalink']
      ),

      'assets' => array(
        'styles' => array(
          'css/slick.css'
        ),

        'scripts' => array(
          array('js/slick.min.js'),
          array('js/jquery.prettyPhoto.js'),
          array('https://maps.googleapis.com/maps/api/js?key='. $this->config->item('google_api_key') .'&sensor=false&libraries=places', true),
          array('js/jquery.mask.js'),
          array('js/pages/properties__details.js', true)
        )
      ),
      'property' => $property,
    );

    $data['featured'] = $this->properties_model->properties(array(
      'params' => array(
        'properties_types' => array(
          $property['tipo_slug']
        ),
      ),
      'limit' => 3,
      'orderby' => 'featured',
      'not_in' => array(
        'imoveis.id' => array($property['id'])
      ),
    ));

    $data['recommended'] = $this->properties_model->properties(array(
      'params' => array(
        'location' => array(
          array(
            'state' => strtolower($property['endereco_estado']),
            'city' => $property['endereco_cidade_slug'],
            'district' => $property['endereco_bairro_slug']
          )
        ),
        'properties_types' => array(
          $property['tipo_slug']
        ),
      ),
      'limit' => 3,
      'orderby' => 'recommended',
      'not_in' => array(
        'imoveis.id' => array($property['id'])
      ),
    ));

    $data['campaigns'] = $this->registros_model->registros('campanhas', array('where' => array('campanhas.status' => 1, 'campanhas_categorias.id' => 1), 'limit' => 5) , false, 'campanhas.*, campanhas_categorias.nome as categoria', array(
      array('campanhas_categorias', 'campanhas.categoria = campanhas_categorias.id', 'inner')
    ));

    if($this->input->post()){
      $mensagem = '<table border="1" cellpadding="5" cellspacing="1">';

      foreach ($this->input->post() as $key => $value) {
        if($key == 'imovel_id'){
          $mensagem .= '<tr><td>Imóvel</td><td><a href="'. $property['imovel_permalink'] .'" target="_blank">'. $property['referencia'] .'</td></tr>';
        }else{
          $mensagem .= '<tr><td>' . strtoupper(str_replace('_', ' ', $key)) . '</td><td>' . $value . '</td></tr>';
        }
      }

      $mensagem .= '</table>';

      send_mail(config_item('site_email_destinatario'), 'Detalhes do imóvel - '. $this->input->post('nome'), $mensagem, $this->input->post('email'));

      $this->site->alerta_redirect('success', 'Sua mensagem foi enviada com sucesso. Em breve, entraremos em contato com você.', $property['imovel_permalink'] . '#entre-em-contato', 'visible');
    }

      // print_l($data['campaigns']);



    // print_l($data['property']);

		$this->template->view('site/master', 'site/properties/details', $data);
	}

  public function redirect($params = array()){
    if($params) $params = json_decode($params, true);

    $property_permalink = $this->properties_model->properties_permalink((isset($params['route_params']) ? $params['route_params'] : null), true);

    redirect(($property_permalink ? $property_permalink : base_url('venda')), 'location', 301);
  }
}
