<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {
  public function __construct() {
    parent::__construct();
  }

  public function add_user($params) {
    $user = array();

    $user['perfil'] = 1;

    $nome = explode(" ", $params['nome']);
    $user['nome'] = $nome[0];
    $user['sobrenome'] = $nome[count($nome) - 1];

    $user['email'] = $params['email'];

    if(isset($params['facebook_id'])){
        $user['facebook_id'] = $params['facebook_id'];
    }else{
        $user['senha'] = md5($params['senha']);
    }

    if(isset($params['imagem'])){
        $user['imagem'] = $params['imagem'];
    }

    $user['status'] = 0;

    $this->db->set('data_criado', 'NOW()', FALSE);
    $this->db->insert('usuarios', $user);

    $user['id'] = $this->db->insert_id();
    $user['perfil'] = 'Visitante';
    unset($user['senha']);

    return $user;
  }

  // public function insert_facebook_login($params){
  //   $usuario = array(
  //     'nome' => $params['first_name'],
  //     'sobrenome' => $params['last_name'],
  //     'email' => $params['email'],
  //     'facebook_id' => $params['id'],
  //     'imagem' => $params['picture']['data']['url'],
  //     'status' => 1
  //   );

  //   $this->db->set('data_criado', 'NOW()', FALSE);
  //   $this->db->insert('usuarios', $usuario);

  //   $usuario['id'] = $this->db->insert_id();

  //   return $usuario;
  // }

  public function login_facebook() {
    $post = $this->input->post();



    if($usuario_check = $this->get_login(array('facebook_id' => $post['id']))){
      $usuario = $usuario_check;
    }else{
      $usuario = $this->insert_facebook_login($post);
    }

    return $this->login_process($usuario);
  }

}
?>
