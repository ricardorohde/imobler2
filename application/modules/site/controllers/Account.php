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

    if($user = $this->registros_model->registros('usuarios', array('where' => array('usuarios.email' => $post['email'], 'usuarios.senha' => md5($post['senha']))), true, 'usuarios.*, usuarios_perfis.nome as perfil', array(
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
      if($user = $this->account_model->add_user($post)){
        $this->session->set_userdata('usuario_logado', $user);

        $user['success'] = 'Cadastro realizado com sucesso.';

        echo json_encode($user);
      }
    }else{
      echo json_encode(array('errors' => $this->form_validation->error_array()));
    }
  }

  public function login_facebook(){
    $post = $this->input->post();

    if($user = $this->registros_model->registros('usuarios', array('where' => array('usuarios.facebook_id' => $post['id'])), true, 'usuarios.id, usuarios.nome, usuarios.sobrenome, usuarios.email, usuarios.imagem, usuarios.status, usuarios_perfis.nome as perfil', array(
      array('usuarios_perfis', 'usuarios.perfil = usuarios_perfis.id', 'inner')
    ))){
      $return = $user;
      $this->session->set_userdata('usuario_logado', $user);
      $return['success'] = 'Login realizado com sucesso.';
      echo json_encode($return);
    }else{
      $user_array = array(
        'nome' => $post['name'],
        'email' => $post['email'],
        'facebook_id' => $post['id'],
        'imagem' => $post['picture']['data']['url']
      );

      if($user = $this->account_model->add_user($user_array)){
        $this->session->set_userdata('usuario_logado', $user);

        $user['success'] = 'Cadastro realizado com sucesso.';

        echo json_encode($user);
      }else{
        echo json_encode(array('errors' => array('Ocorreu um erro inesperado.')));
      }
    }
  }

  public function index() {
    $this->site->user_logged(FALSE, '/');

    $usuario = $this->registros_model->registros('usuarios', array('where' => array('usuarios.id' => $this->site->userinfo('id'))), true, 'usuarios.*, usuarios_perfis.nome as perfil', array(
      array('usuarios_perfis', 'usuarios.perfil = usuarios_perfis.id', 'inner')
    ));

    $data = array(
      'page' => array(
        'one' => 'account',
        'two' => 'profile'
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
        ),

        'scripts' => array(
          array('js/jquery.mask.js'),
          array('js/pages/account__profile.js')
        )
      )
    );

    if($this->input->post()){

      if($this->input->post('alterar-infos')) {
        $usuario = $this->input->post();

        $config = array(
          array(
            'field' => 'nome',
            'label' => 'Nome',
            'rules' => 'required'
          ),

          array(
            'field' => 'sobrenome',
            'label' => 'Sobrenome',
            'rules' => 'required'
          ),

          array(
            'field' => 'email',
            'label' => 'E-mail',
            'rules' => 'required|valid_email',
            'errors' => array(
              'required' => 'O %s é obrigatório',
              'valid_email' => 'O %s informado está inválido'
            )
          )
        );

        $this->form_validation->set_rules($config);

        if($this->form_validation->run() == TRUE) {
          unset($usuario['alterar-infos']);
          $this->db->update('usuarios', $usuario, array('id' => $this->site->userinfo('id')));
          $this->site->alerta_redirect('success', 'Seus dados foram atualizados com sucesso.', 'minha-conta', 'visible');
        }else{
          $data = array_merge($data, $this->site->form_error($this->form_validation->error_array()));
        }
      }else{
        $data['post'] = $this->input->post();

        $config = array(
          array(
            'field' => 'nova_senha',
            'label' => 'Nova senha',
            'rules' => 'required'
          ),

          array(
            'field' => 'repetir_nova_senha',
            'label' => 'Repetir nova senha',
            'rules' => 'required|matches[nova_senha]'
          )
        );

        $this->form_validation->set_rules($config);

        if($this->form_validation->run() == TRUE) {
          $this->db->update('usuarios', array('senha' => md5($this->input->post('nova_senha'))), array('id' => $this->site->userinfo('id')));
          $this->site->alerta_redirect('success', 'Sua senha foi alterada com sucesso.', 'minha-conta', 'visible');
        }else{
          $data = array_merge($data, $this->site->form_error($this->form_validation->error_array()));
        }
      }
    }

    $data['usuario'] = $usuario;

    $this->template->view('site/master', 'site/account/profile', $data);
  }

  public function favoritos($page = 1) {
    $this->site->user_logged(FALSE, '/');
    $this->load->model('properties_model');

    $data = array(
      'page' => array(
        'one' => 'account',
        'two' => 'favorites'
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
        ),

        'scripts' => array(
          array('js/jquery.mask.js'),
          array('js/sweetalert2.min.js'),
          array('js/pages/account__favorites.js')
        )
      ),

      'properties' => $this->properties_model->properties(array('page' => $page, 'favorites' => true))
    );

    $this->template->view('site/master', 'site/account/favorites', $data);

  }

  public function logout() {
    $this->session->sess_destroy();
    redirect(base_url(), 'location');
  }
}
