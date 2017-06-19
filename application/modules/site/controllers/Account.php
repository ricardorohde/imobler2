<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Site_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('account_model');
  }

  public function login() {
    $return = array();
    $post = $this->input->post();

    if($user = $this->registros_model->registros('usuarios', array('where' => array('usuarios.email' => $post['email'], 'usuarios.senha' => md5($post['senha']))), true, 'usuarios.id, usuarios.nome, usuarios.sobrenome, usuarios.email, usuarios.imagem, usuarios.status, usuarios_perfis.nome as perfil', array(
      array('usuarios_perfis', 'usuarios.perfil = usuarios_perfis.id', 'inner')
    ))){
      $return = $user;
      $this->session->set_userdata('usuario_logado', $user);

      $return['success'] = 'Login realizado com sucesso.';
    }else{
      $return['error'] = 'Login e/ou Senha inválidos';
    }

    echo json_encode($return);
  }

  public function cadastro() {
    $return = array();
    $post = $this->input->post();

    $config = array(
      array(
        'field' => 'nome',
        'label' => 'Nome completo',
        'rules' => 'required'
      ),

      array(
        'field' => 'email',
        'label' => 'E-mail',
        'rules' => 'required|valid_email|is_unique[usuarios.email]',
        'errors' => array(
          'is_unique' => 'Já existe um cadastro com este e-mail.'
        )
      ),

      array(
        'field' => 'senha',
        'label' => 'Senha',
        'rules' => 'required'
      )
    );

    $this->form_validation->set_rules($config);

    if ($this->form_validation->run()) {
      echo json_encode($this->account_model->add_user($post));
    }else{
      echo json_encode(array('errors' => $this->form_validation->error_array()));
    }
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect(base_url(), 'location');
  }
}
