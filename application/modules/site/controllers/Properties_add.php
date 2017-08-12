<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_add extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  public function index() {
    $data = array(
      'page' => array(
        'one' => 'anunciar-imoveis'
      ),
      'section' => array(
        'body_id' => 'anunciar-imoveis',
        'body_class' => array(
        )
      ),
      'assets' => array(
        'styles' => array(
          'css/sweetalert2.min.css'
        ),

        'scripts' => array(
          array('js/jquery.mask.js'),
          array('js/sweetalert2.min.js'),
          array('js/bootstrap-maxlength.js'),
          array('js/pages/properties__add.js')
        )
      ),
      'estados' => $this->registros_model->registros('estados'),
      'filters' =>  $this->properties_model->filters()
    );


    if($this->input->post()){
      $mensagem = '<table border="1" cellpadding="5" cellspacing="1">';

      foreach ($this->input->post() as $key => $value) {
        $mensagem .= '<tr><td>' . strtoupper(str_replace('_', ' ', $key)) . '</td><td>' . $value . '</td></tr>';
      }

      $mensagem .= '</table>';

      send_mail(config_item('site_email_destinatario'), 'Anúncio de imóvel - '. $this->input->post('nome'), $mensagem);

      $this->site->alerta_redirect('success', 'Os dados do imóvel foram enviados com sucesso. Em breve, um de nossos corretores entrará em contato com você.', 'anunciar-imovel', 'visible');
    }

    $this->template->view('site/master', 'site/properties/add_properties', $data);
  }
}
