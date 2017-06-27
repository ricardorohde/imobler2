<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaigns__categories__edit extends Admin_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($category_id = null) {
    $this->site->user_logged(FALSE, TRUE);

    $data = array(
      'page' => array(
        'one' => 'campaigns',
        'two' => 'categories',
        'three' => ($category_id ? 'edit' : 'add')
      ),

      'section' => array(
        'data' => array(
          'property_id' => $category_id
        )
      ),

      'action' => ($category_id ? 'edit' : 'add'),

      'assets' => array(
        'styles' => array(
          array('plugins/jquery-ui2/jquery-ui.min.css'),
          array('plugins/sweetalert2/sweetalert2.min.css')
        ),

        'scripts' => array(
          array('plugins/jquery.mask/jquery.mask.min.js'),
          array('plugins/bootstrap-maxlength.js'),
          array('plugins/notify.min.js'),
          array('plugins/jquery-ui2/jquery-ui.min.js'),
          array('plugins/sweetalert2/sweetalert2.min.js'),
          array('plugins/mustache.min.js'),
          array('plugins/clipboard.min.js')
        ),

        'script_page' => 'js/campaigns_edit.js'
      ),

      'form_action' => ($category_id ? 'admin/campanhas/categorias/'. $category_id .'/editar' : 'admin/campanhas/categorias/adicionar')
    );

    if($category_id){
      $post = $this->registros_model->registros(
        'campanhas_categorias',
        array(
          'where' => array(
            'campanhas_categorias.id' => $category_id
          )
        ),
        true
      );
    }

    if($this->input->post()){
      $post = $this->input->post();

      $category = $post;

      if($category_id){
        $this->db->update('campanhas_categorias', $category, array('id' => $category_id));
        $campaign_edit_id = $category_id;
      }else{
        $this->db->insert('campanhas_categorias', $category);
        $campaign_edit_id = $this->db->insert_id();
      }

      $this->site->alerta_redirect('success', ($category_id ? 'A categoria de campanha foi atualizada com sucesso.' : 'A categoria de campanha foi adicionada com sucesso.'), 'admin/campanhas/categorias/' . $campaign_edit_id . '/editar', 'visible');

    }

    $data['post'] = isset($post) ? $post : null;

    $this->template->view('admin/master', 'admin/campaigns/categories/edit', $data);
  }

  function excluir($category_id) {
    if($category_id != 1){
      $this->db->delete('campanhas_categorias', array('id' => $category_id));
    }

    $this->site->alerta_redirect('success', 'Categoria de campanha ecluída com sucesso!', 'admin/campanhas/categorias', 'visible');
  }
}
