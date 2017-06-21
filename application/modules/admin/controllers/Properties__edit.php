<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties__edit extends Admin_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('properties_model');
  }

  function index($property_id = null) {
    $data = array(
      'page' => array(
        'one' => 'properties',
        'two' => ($property_id ? 'edit' : 'add')
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
        ),

        'scripts' => array(
          array('plugins/jquery.mask/jquery.mask.min.js'),
          array('plugins/bootstrap-maxlength.js'),
          array('https://maps.googleapis.com/maps/api/js?key='. $this->config->item('google_api_key') /*.'&callback=properties_edit__init_mapa'*/, array('attributes' => array('async', 'defer')))
        ),

        'script_page' => 'js/properties_edit.js'
      ),

      'form_action' => ($property_id ? 'admin/imoveis/'. $property_id .'/editar' : 'admin/imoveis/adicionar'),

      'estados' => $this->registros_model->registros('estados'),
      'caracteristicas' => $this->registros_model->registros('caracteristicas')
    );

    if($property_id){
      $post = array();
      $property = $this->properties_model->properties(array('params' => array('property_id' => $property_id)), true);

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

      if(isset($property['despesas'])){
        foreach ($property['despesas'] as $despesa_slug => $despesa) {
          $post['despesas'][$despesa_slug] = $despesa['valor'];
        }
      }

      $post['negociacao']['valor'] = $property['valor_real'];

      $metas = array(
        'breve_descricao' => 'breve_descricao',
        'descricao' => 'descricao',
        'referencia' => 'referencia'
      );
      foreach ($metas as $de => $para) {
        $post['metas'][$para] = $property[$de];
      }

      print_l($property);

      if(isset($property['caracteristicas'])){
        foreach ($property['caracteristicas'] as $caracteristica) {
          $post['caracteristicas'][] = $caracteristica['id'];
        }
      }
    }

    if($this->input->post()){
      $post = $this->input->post();

      $this->properties_model->check_locality($post['localizacao']['estado'], $post['localizacao']['cidade'], $post['localizacao']['bairro']);
    }

    $caracteristicas = $this->registros_model->registros(
      'caracteristicas',
      array('group_by' => 'caracteristicas.id'),
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

    if($caracteristicas){
      $caracteristicas_count = 0;
      foreach ($caracteristicas as $caracteristica) {
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
    foreach($imoveis_tipos_segmentos as $tipo) {
        $imoveis_tipos[$tipo['segmento_slug']]['nome'] = $tipo['segmento'];
        $imoveis_tipos[$tipo['segmento_slug']]['tipos'][] = $tipo;
    }

    $data['imoveis_tipos'] = $imoveis_tipos;



    if(isset($post)){
      $data['post'] = $post;
    }

    // print_l($post);

    $this->template->view('admin/master', 'admin/properties/edit', $data);
  }
}
