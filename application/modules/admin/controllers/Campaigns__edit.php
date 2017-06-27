<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaigns__edit extends Admin_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($campaign_id = null) {
    $this->site->user_logged(FALSE, TRUE);

    $data = array(
      'page' => array(
        'one' => 'campaigns',
        'two' => ($campaign_id ? 'edit' : 'add')
      ),

      'section' => array(
        'data' => array(
          'property_id' => $campaign_id
        )
      ),

      'action' => ($campaign_id ? 'edit' : 'add'),

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

      'form_action' => ($campaign_id ? 'admin/campanhas/'. $campaign_id .'/editar' : 'admin/campanhas/adicionar')
    );

    if($campaign_id){
      $post = $this->registros_model->registros(
        'campanhas',
        array(
          'where' => array(
            'campanhas.id' => $campaign_id
          )
        ),
        true
      );

      $post['parametros'] = json_decode($post['parametros'], true);

      if(isset($post['parametros']['location']) && !empty($post['parametros']['location'])){
        $location = array();
        foreach ($post['parametros']['location'] as $key => $value) {
          $location[$key] = $value;
          $location[$key]['index'] = $key;
        }

        $post['parametros']['location'] = $location;
      }
    }

    if($this->input->post()){
      $post = $this->input->post();

      $campaign = $post;

      $parametros = array();
      foreach ($post['parametros'] as $key => $value) {
        if(!empty($value)){

          if(in_array($key, array('min_price', 'max_price'))){
            $parametros[$key] = str_replace('.', '', $value);
          }else{
            $parametros[$key] = $value;
          }

        }
      }

      $campaign['status'] = (isset($campaign['status']) ? 1 : 0);

      $campaign['parametros'] = json_encode($parametros);

      if(isset($campaign['imagem_arquivo_existente'])){
        $imagem_arquivo_existente = $campaign['imagem_arquivo_existente'];
        unset($campaign['imagem_arquivo_existente']);
      }

      if($campaign_id){
        $this->db->set('data_atualizado', 'NOW()', FALSE);
        $this->db->update('campanhas', $campaign, array('id' => $campaign_id));
        $campaign_edit_id = $campaign_id;
      }else{
        $this->db->set('data_atualizado', 'NOW()', FALSE);
        $this->db->insert('campanhas', $campaign);
        $campaign_edit_id = $this->db->insert_id();
      }

      if(isset($_FILES['imagem_arquivo']['error']) && $_FILES['imagem_arquivo']['error'] == 0){

        $path_uri = 'assets/uploads/campanhas/' . $campaign_edit_id . '/';
        $path_upload = FCPATH . $path_uri;

        if(!file_exists($path_upload)) {
          mkdir($path_upload, 0755, true);
        }

        if(isset($imagem_arquivo_existente)){
          if(file_exists($path_upload . $imagem_arquivo_existente)) {
            unlink($path_upload . $imagem_arquivo_existente);
          }
        }

        $file_name = $_FILES["imagem_arquivo"]["name"];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        $imagem_arquivo = md5($campaign_edit_id . $file_name . microtime(false) . rand(0,9999))  . '.' . $file_extension;

        if(move_uploaded_file($_FILES["imagem_arquivo"]["tmp_name"], $path_upload . $imagem_arquivo)){
          $this->db->update('campanhas', array('imagem_arquivo' => $imagem_arquivo), array('id' => $campaign_edit_id));
        }

      }

      $this->site->alerta_redirect('success', ($campaign_id ? 'A campanha foi atualizada com sucesso.' : 'A campanha foi adicionada com sucesso.'), 'admin/campanhas/' . $campaign_edit_id . '/editar', 'visible');

    }

    $campanhas_categorias = $this->registros_model->registros(
      'campanhas_categorias'
    );

    $campanhas_categorias_array = array();
    if(isset($campanhas_categorias['results'])){
      foreach ($campanhas_categorias['results'] as $key => $value) {
        $campanhas_categorias_array[$key] = $value;

        if(isset($post['categoria']) && $post['categoria'] == $value['id']){
          $campanhas_categorias_array[$key]['selected'] = true;
        }
      }
    }

    $data['campanhas_categorias'] = $campanhas_categorias_array;



    $imoveis_tipos = $this->registros_model->registros(
      'imoveis_tipos',
      array(
        'group_by' => 'imoveis_tipos.id'
      ),
      false,
      'imoveis_tipos.*, imoveis_tipos_segmentos.nome as segmento_nome',
      array(
        array('imoveis_tipos_segmentos', 'imoveis_tipos.segmento = imoveis_tipos_segmentos.id', 'inner')
      ),
      array(
        'imoveis_tipos_segmentos.ordem' => 'ASC',
        'imoveis_tipos.nome' => 'ASC'
      )
    );

    $imoveis_tipos_array = array();

    if(isset($imoveis_tipos['results'])){
      $imoveis_tipos_count = 0;
      foreach ($imoveis_tipos['results'] as $imovel_tipo) {
        if(!isset($imoveis_tipos_array[$imovel_tipo['segmento']])){
          $imoveis_tipos_array[$imovel_tipo['segmento']]['segmento'] = $imovel_tipo['segmento_nome'];
        }

        $imoveis_tipos_array[$imovel_tipo['segmento']]['imoveis_tipos'][$imoveis_tipos_count] = array(
          'id' => $imovel_tipo['id'],
          'slug' => $imovel_tipo['slug'],
          'nome' => $imovel_tipo['nome'],
        );

        if(isset($post['parametros']['properties_types']) && in_array($imovel_tipo['slug'], $post['parametros']['properties_types'])){
          $imoveis_tipos_array[$imovel_tipo['segmento']]['imoveis_tipos'][$imoveis_tipos_count]['selected'] = true;
        }

        $imoveis_tipos_count++;
      }
    }

    $data['imoveis_tipos'] = $imoveis_tipos_array;

    $caracteristicas = $this->registros_model->registros(
      'caracteristicas',
      array(
        'group_by' => 'caracteristicas.id'
      ),
      false,
      'caracteristicas.*, caracteristicas_tipos.nome as tipo_nome',
      array(
        array('caracteristicas_tipos', 'caracteristicas.tipo = caracteristicas_tipos.id', 'inner')
      ),
      array(
        'caracteristicas_tipos.ordem' => 'ASC',
        'caracteristicas.nome' => 'ASC'
      )
    );

    $caracteristicas_array = array();

    if(isset($caracteristicas['results'])){
      $caracteristicas_count = 0;
      foreach ($caracteristicas['results'] as $caracteristica) {
        if(!isset($caracteristicas_array[$caracteristica['tipo']])){
          $caracteristicas_array[$caracteristica['tipo']]['tipo'] = $caracteristica['tipo_nome'];
        }

        $caracteristicas_array[$caracteristica['tipo']]['caracteristicas'][$caracteristicas_count] = array(
          'id' => $caracteristica['id'],
          'slug' => $caracteristica['slug'],
          'nome' => $caracteristica['nome'],
        );

        if(isset($post['parametros']['property_features']) && in_array($caracteristica['slug'], $post['parametros']['property_features'])){
          $caracteristicas_array[$caracteristica['tipo']]['caracteristicas'][$caracteristicas_count]['selected'] = true;
        }

        $caracteristicas_count++;
      }
    }

    $data['caracteristicas'] = $caracteristicas_array;

    $data['post'] = isset($post) ? $post : null;

    $this->template->view('admin/master', 'admin/campaigns/edit', $data);
  }

  function excluir($campaign_id) {
    $campaign = $this->registros_model->registros(
      'campanhas',
      array(
        'where' => array(
          'campanhas.id' => $campaign_id
        )
      ),
      true
    );

    if($campaign){
      if(isset($campaign['imagem_arquivo']) && !empty($campaign['imagem_arquivo'])){
        if(file_exists(get_asset('campanhas/' . $campaign['id'] . '/' . $campaign['imagem_arquivo'], 'path', 'uploads'))){
          unlink(get_asset('campanhas/' . $campaign['id'] . '/' . $campaign['imagem_arquivo'], 'path', 'uploads'));
        }
      }

      $this->db->delete('campanhas', array('id' => $campaign['id']));

      $this->site->alerta_redirect('success', 'Campanha ecluída com sucesso!', 'admin/campanhas', 'visible');
    }

  }
}
