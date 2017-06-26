<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties__edit extends Admin_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($property_id = null) {
    $this->site->user_logged(FALSE, TRUE);

    $data = array(
      'page' => array(
        'one' => 'properties',
        'two' => ($property_id ? 'edit' : 'add')
      ),

      'section' => array(
        'data' => array(
          'property_id' => $property_id
        )
      ),

      'action' => ($property_id ? 'edit' : 'add'),

      'assets' => array(
        'styles' => array(
          array('plugins/dropzone2/min/dropzone.min.css'),
          array('plugins/sweetalert2/sweetalert2.min.css')
        ),

        'scripts' => array(
          // array('plugins/mustache.min.js'),
          array('plugins/jquery.mask/jquery.mask.min.js'),
          array('plugins/bootstrap-maxlength.js'),
          array('plugins/dropzone2/min/dropzone.min.js'),
          array('plugins/notify.min.js'),
          array('plugins/sweetalert2/sweetalert2.min.js'),
          array('https://maps.googleapis.com/maps/api/js?key='. $this->config->item('google_api_key') /*.'&callback=properties_edit__init_mapa'*/, array('attributes' => array('async', 'defer')))
        ),

        'script_page' => 'js/properties_edit.js'
      ),

      'form_action' => ($property_id ? 'admin/imoveis/'. $property_id .'/editar' : 'admin/imoveis/adicionar'),

      'estados' => $this->registros_model->registros('estados'),
      // 'caracteristicas' => $this->registros_model->registros('caracteristicas')
    );

    if($property_id){
      $post = array();

      $property = $this->properties_model->properties(array('params' => array('property_id' => $property_id)), true);

      // print_l($property);

      $post['guid'] = $property['guid'];

      $post['status'] = $property['status'];

      $localizacao = array(
        'endereco_cep' => 'cep',
        'endereco_logradouro' => 'logradouro',
        'endereco_numero' => 'numero',
        'endereco_complemento' => 'complemento',
        'endereco_latitude' => 'latitude',
        'endereco_longitude' => 'longitude',
        'endereco_latitude_site' => 'latitude_site',
        'endereco_longitude_site' => 'longitude_site',
        'endereco_estado_id' => 'estado',
        'endereco_cidade' => 'cidade',
        'endereco_bairro' => 'bairro',
        'endereco_zona_id' => 'zona',
        'endereco_visibilidade_id' => 'visibilidade_site'
      );
      foreach ($localizacao as $de => $para) {
        $post['localizacao'][$para] = $property[$de];
      }

      $detalhes = array(
        'tipo_id' => 'tipo',
        'dormitorios' => 'dormitorios',
        'salas' => 'salas',
        'banheiros' => 'banheiros',
        'suites' => 'suites',
        'garagens' => 'garagens',
        'varandas' => 'varandas',

        'area_util' => 'area_util',
        'area_total' => 'area_total'
      );
      foreach ($detalhes as $de => $para) {
        $post['detalhes'][$para] = $property[$de];
      }

      $informacoes = array(
        'mobiliado',
        'ocupado',
        'condominio',
        'oferta',
        'destaque',
        'lancamento'
      );
      foreach ($informacoes as $informacao) {
        $post['informacoes'][$informacao] = $property[$informacao];
      }

      if(isset($property['despesas'])){
        foreach ($property['despesas'] as $despesa_slug => $despesa) {
          $post['despesas'][$despesa_slug] = $despesa['valor'];
        }
      }

      $post['negociacao']['valor'] = $property['valor_real'];
      $post['observacoes'] = $property['observacoes'];

      $metas = array(
        'breve_descricao' => 'breve_descricao',
        'descricao' => 'descricao',
        'referencia' => 'referencia',
        'permalink' => 'permalink'
      );
      foreach ($metas as $de => $para) {
        $post['metas'][$para] = $property[$de];
      }

      // print_l($property);

      if(isset($property['caracteristicas'])){
        foreach ($property['caracteristicas'] as $caracteristica) {
          $post['caracteristicas'][] = $caracteristica['id'];
        }
      }

      if(isset($property['tags'])){
        foreach ($property['tags'] as $tag) {
          $post['tags'][] = $tag['tag'];
        }
      }

      if(isset($property['imagens'])){
        $post['imagens'] = $property['imagens'];
      }
    }

    if($this->input->post()){
      $post = $this->input->post();

      $processa = true;
      if($processa){

        $informacoes = array(
          'mobiliado',
          'ocupado',
          'condominio',
          'oferta',
          'destaque',
          'lancamento'
        );

        foreach ($informacoes as $informacao) {
          $post['informacoes'][$informacao] = (isset($post['informacoes'][$informacao]) ? 1 : null);
        }

        $imoveis = array_merge($post['detalhes'], $post['informacoes']);
        $imoveis['guid'] = $post['guid'];
        $imoveis['breve_descricao'] = $post['metas']['breve_descricao'];
        $imoveis['descricao'] = $post['metas']['descricao'];
        $imoveis['status'] = isset($post['status']) ? 1 : 0;

        if($property_id){
          $this->db->set('data_atualizado', 'NOW()', FALSE);
          $this->db->update('imoveis', $imoveis, array('id' => $property_id));
          $property_edit_id = $property_id;
        }else{
          $this->db->set('data_atualizado', 'NOW()', FALSE);
          $this->db->set('data_criado', 'NOW()', FALSE);
          $this->db->insert('imoveis', $imoveis);
          $property_edit_id = $this->db->insert_id();
        }

        // echo '>>>'.$property_edit_id;

        $this->db->flush_cache();

        $localidade = $this->properties_model->check_locality($post['localizacao']['estado'], $post['localizacao']['cidade'], $post['localizacao']['bairro']);

        if($post['localizacao']['latitude_site'] == '' || $post['localizacao']['latitude_site'] == '0.000000'){
          $post['localizacao']['latitude_site'] = null;
        }

        if($post['localizacao']['longitude_site'] == '' || $post['localizacao']['longitude_site'] == '0.000000'){
          $post['localizacao']['longitude_site'] = null;
        }

        $endereco = array_merge($post['localizacao'], array('cidade' => $localidade['cidade_id'], 'bairro' => $localidade['bairro_id']));

        $check_endereco = $this->db->get_where('imoveis_enderecos', array('imovel' => $property_edit_id));
        if($check_endereco->num_rows()){
          $endereco_edit = $check_endereco->row_array();
          $this->db->update('enderecos', $endereco, array('id' => $endereco_edit['endereco']));
        }else{
          $this->db->insert('enderecos', $endereco);
          $endereco_id = $this->db->insert_id();
          $this->db->insert('imoveis_enderecos', array('imovel' => $property_edit_id, 'endereco' => $endereco_id));
        }

        $this->db->flush_cache();

        $this->db->update('imoveis_caracteristicas', array('update' => 1), array('imovel' => $property_edit_id));

        if(isset($post['caracteristicas'])){
          foreach ($post['caracteristicas'] as $caracteristica) {
            $check_caracteristica = $this->db->get_where('imoveis_caracteristicas', array('imovel' => $property_edit_id, 'caracteristica' => $caracteristica));
            if($check_caracteristica->num_rows()){
              $this->db->update('imoveis_caracteristicas', array('update' => 0), array('imovel' => $property_edit_id, 'caracteristica' => $caracteristica));
            }else{
              $this->db->insert('imoveis_caracteristicas', array('imovel' => $property_edit_id, 'caracteristica' => $caracteristica, 'update' => 0));
            }
          }
        }

        $this->db->delete('imoveis_caracteristicas', array('imovel' => $property_edit_id, 'update' => 1));

        $this->db->flush_cache();


        if(isset($post['despesas']['iptu'])){
          $despesa = array(
            'imovel' => $property_edit_id,
            'tipo' => 1,
            'valor' => str_replace(',', '.', str_replace('.', '', $post['despesas']['iptu'])),
            'periodo' => 2
          );

          $check_despesa = $this->db->get_where('imoveis_despesas', array('imovel' => $property_edit_id, 'tipo' => 1));
          if($check_despesa->num_rows()){
            $this->db->update('imoveis_despesas', $despesa, array('imovel' => $property_edit_id, 'tipo' => 1));
          }else{
            $this->db->insert('imoveis_despesas', $despesa);
          }
        }

        $this->db->flush_cache();

        if(isset($post['despesas']['condominio'])){
          $despesa = array(
            'imovel' => $property_edit_id,
            'tipo' => 2,
            'valor' => str_replace(',', '.', str_replace('.', '', $post['despesas']['condominio'])),
            'periodo' => 3
          );

          $check_despesa = $this->db->get_where('imoveis_despesas', array('imovel' => $property_edit_id, 'tipo' => 2));
          if($check_despesa->num_rows()){
            $this->db->update('imoveis_despesas', $despesa, array('imovel' => $property_edit_id, 'tipo' => 2));
          }else{
            $this->db->insert('imoveis_despesas', $despesa);
          }
        }

        $this->db->flush_cache();

        $negociacao = array(
          'imovel' => $property_edit_id,
          'transacao' => 1,
          'valor' => str_replace(',', '.', str_replace('.', '', $post['negociacao']['valor'])),
          'periodo' => 1,
          'referencia' => trim($post['metas']['referencia']),
          'permalink' => trim($post['metas']['permalink'])
        );

        $check_negociacao = $this->db->get_where('imoveis_negociacoes', array('imovel' => $property_edit_id));
        if($check_negociacao->num_rows()){
          $this->db->update('imoveis_negociacoes', $negociacao, array('imovel' => $property_edit_id));
        }else{
          $this->db->insert('imoveis_negociacoes', $negociacao);
        }

        $this->db->flush_cache();

        if(isset($post['observacoes'])){
          if(empty($post['observacoes'])){
            $this->db->delete('imoveis_observacoes', array('imovel' => $property_edit_id));
          }else{
            $observacoes = array(
              'imovel' => $property_edit_id,
              'usuario' => $this->site->userinfo('id'),
              'observacao' => trim($post['observacoes'])
            );

            $check_observacoes = $this->db->get_where('imoveis_observacoes', array('imovel' => $property_edit_id));
            if($check_observacoes->num_rows()){
              $this->db->set('data_criado', 'NOW()', FALSE);
              $this->db->update('imoveis_observacoes', $observacoes, array('imovel' => $property_edit_id));
            }else{
              $this->db->set('data_criado', 'NOW()', FALSE);
              $this->db->insert('imoveis_observacoes', $observacoes);
            }
          }

        }

        $this->db->flush_cache();

        $check_imagens = $this->db->get_where('imoveis_imagens', array('imovel_temp' => $post['guid']));
        if($check_imagens->num_rows()){
          $this->db->update('imoveis_imagens', array('imovel' => $property_edit_id, 'imovel_temp' => null), array('imovel_temp' => $post['guid']));
          $folder = get_asset('imoveis', 'path', 'uploads');
          rename($folder . '/' . $post['guid'], $folder . '/' . $property_edit_id);
        }

        $this->db->flush_cache();

        $this->db->update('imoveis_tags', array('update' => 1), array('imovel' => $property_edit_id));

        if(isset($post['tags'])){
          foreach ($post['tags'] as $tag) {

            $checa_tag = $this->registros_model->registros('tags', array('where' => array('tags.tag' => $tag)), true);

            if($checa_tag){
              $checa_imovel_tag = $this->db->get_where('imoveis_tags', array('imovel' => $property_edit_id, 'tag' => $checa_tag['id']));
              if($checa_imovel_tag->num_rows()){
                $this->db->update('imoveis_tags', array('update' => null), array('tag' => $checa_tag['id']));
              }else{
                $this->db->insert('imoveis_tags', array('imovel' => $property_edit_id, 'tag' => $checa_tag['id']));
              }
            }else{
              $this->db->insert('tags', array('tag' => $tag));
              $tag_id = $this->db->insert_id();
              $this->db->insert('imoveis_tags', array('imovel' => $property_edit_id, 'tag' => $tag_id));
            }
          }
        }

        $this->db->delete('imoveis_tags', array('imovel' => $property_edit_id, 'update' => 1));

        $this->db->flush_cache();

        $this->site->alerta_redirect('success', ($property_id ? 'O imóvel foi atualizado com sucesso.' : 'O imóvel foi adicionado com sucesso.'), 'admin/imoveis/' . $property_edit_id . '/editar', 'visible');

      }

    }

    $zonas = $this->registros_model->registros(
      'zonas'
    );

    $zonas_array = array();
    if(isset($zonas['results'])){
      $zonas_count = 0;
      foreach ($zonas['results'] as $key => $value) {
        $zonas_array[$zonas_count] = $value;

        if(isset($post['localizacao']['zona']) && $post['localizacao']['zona'] == $value['id']){
          $zonas_array[$zonas_count]['selected'] = true;
        }

        $zonas_count++;
      }
    }

    $data['zonas'] = $zonas_array;

    $tags = $this->registros_model->registros(
      'tags'
    );

    $tags_array = array();
    if(isset($tags['results'])){
      $tags_count = 0;
      foreach ($tags['results'] as $key => $value) {
        $tags_array[$tags_count] = $value;

        if(isset($post['tags']) && in_array($value['tag'], $post['tags'])){
          $tags_array[$tags_count]['selected'] = true;
        }

        $tags_count++;
      }
    }

    $data['tags'] = $tags_array;

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
          'nome' => $caracteristica['nome'],
        );

        if(isset($post['caracteristicas']) && in_array($caracteristica['id'], $post['caracteristicas'])){
          $caracteristicas_array[$caracteristica['tipo']]['caracteristicas'][$caracteristicas_count]['selected'] = true;
        }

        $caracteristicas_count++;
      }
    }

    $data['caracteristicas'] = $caracteristicas_array;

    $data['enderecos_visibilidades'] = $this->registros_model->registros('enderecos_visibilidades');

    $imoveis_tipos_segmentos = $this->registros_model->registros('imoveis_tipos', array(), false, '
      imoveis_tipos.id,
      imoveis_tipos.nome,
      imoveis_tipos.slug,
      imoveis_tipos_segmentos.nome as segmento,
      imoveis_tipos_segmentos.slug as segmento_slug,
    ', array(
      array('imoveis_tipos_segmentos', 'imoveis_tipos.segmento = imoveis_tipos_segmentos.id', 'inner')
    ), array('imoveis_tipos_segmentos.ordem' => 'ASC', 'imoveis_tipos.ordem' => 'ASC', ));

    $imoveis_tipos = array();
    foreach($imoveis_tipos_segmentos['results'] as $tipo) {
        $imoveis_tipos[$tipo['segmento_slug']]['nome'] = $tipo['segmento'];
        $imoveis_tipos[$tipo['segmento_slug']]['tipos'][] = $tipo;
    }

    $data['imoveis_tipos'] = $imoveis_tipos;

    if(isset($post)){
      $data['post'] = $post;
    }

    // if(isset($post)) print_l($post);
    // if(isset($_FILES)) print_l($_FILES);

    $this->template->view('admin/master', 'admin/properties/edit', $data);
  }
}
