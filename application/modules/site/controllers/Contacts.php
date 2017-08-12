<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends Site_Controller {
  public function contact_us() {
    $data = array(
      'page' => array(
        'one' => 'fale-conosco'
      ),
      'section' => array(
        'body_id' => 'fale-conosco',
        'body_class' => array(
        )
      ),
      'assets' => array(
        'styles' => array(
        ),
        'scripts' => array(
          array('js/jquery.mask.js'),
          array('js/pages/contacts.js')
        )
      )
    );

    if($this->input->post()){
      $mensagem = '<table border="1" cellpadding="5" cellspacing="1">';

      foreach ($this->input->post() as $key => $value) {
        $mensagem .= '<tr><td>' . strtoupper(str_replace('_', ' ', $key)) . '</td><td>' . $value . '</td></tr>';
      }

      $mensagem .= '</table>';

      send_mail(config_item('site_email_destinatario'), 'Contato - '. $this->input->post('nome'), $mensagem, $this->input->post('email'));

      $this->site->alerta_redirect('success', 'Seus dados foram enviados com sucesso.<br>Em breve, entraremos em contato com você.', 'fale-conosco', 'visible');
    }

    $data['campaigns'] = $this->registros_model->registros('campanhas', array('where' => array('campanhas.status' => 1, 'campanhas_categorias.id' => 1), 'limit' => 3) , false, 'campanhas.*, campanhas_categorias.nome as categoria', array(
      array('campanhas_categorias', 'campanhas.categoria = campanhas_categorias.id', 'inner')
    ));

    $this->template->view('site/master', 'site/contacts/contact_us', $data);
  }

  public function work_with_us() {
    $data = array(
      'page' => array(
        'one' => 'trabalhe-conosco'
      ),
      'section' => array(
        'body_id' => 'trabalhe-conosco',
        'body_class' => array(
        )
      ),
      'assets' => array(
        'styles' => array(
        ),
        'scripts' => array(
        )
      )
    );

    $this->template->view('site/master', 'site/contacts/work_with_us', $data);
  }


}
