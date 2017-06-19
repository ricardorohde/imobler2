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

    $user['senha'] = md5($params['senha']);

    $user['status'] = 0;

    $this->db->set('data_criado', 'NOW()', FALSE);
    $this->db->insert('usuarios', $user);

    $user['id'] = $this->db->insert_id();
    $user['perfil'] = 'Visitante';
    unset($user['senha']);

    $this->session->set_userdata('usuario_logado', $user);

    $user['success'] = 'Cadastro realizado com sucesso.';

    return $user;



    // if($this->site->user_logged() && isset($params['property_id']) && $params['property_id'] && isset($params['status']) && $params['status']){
    //   $user_id = $this->site->userinfo('id');
    //   $return = array('property_id' => $params['property_id']);
    //   $liked = $this->property_like_check($user_id, $params['property_id']);

    //   if($params['status'] == 'unliked'){
    //     if(!$liked){
    //
    //     }
    //     $return['status'] = 'liked';
    //   }else{
    //     if($liked){
    //       $this->db->delete('imoveis_favoritos', array('imovel' => $params['property_id'], 'usuario' => $user_id));
    //     }
    //     $return['status'] = 'unliked';
    //   }

    //   return $return;
    // }

    // return false;
  }

}
?>
