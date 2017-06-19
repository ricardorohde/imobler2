<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Site_Controller {
  public function __construct() {
    parent::__construct();
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

  public function logout() {
    $this->session->sess_destroy();
    redirect(base_url(), 'location');
  }
}
