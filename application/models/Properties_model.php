<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_model extends CI_Model {
  public function __construct() {
    parent::__construct();
  }

  public function get_rows_count($sql){
    $query = $this->db->query($sql);
    return $query->num_rows();
  }

  public function properties($request = array(), $row = false) {

    if(isset($request['row']) && $request['row'] == true){
      $row = true;
    }

    // SELECT
    $this->db->select((isset($request['select']) ? $request['select'] : "

      imoveis.id as id,
      imoveis.guid as guid,
      imoveis.tipo as tipo,
      imoveis.dormitorios as dormitorios,
      imoveis.salas as salas,
      imoveis.banheiros as banheiros,
      imoveis.suites as suites,
      imoveis.garagens as garagens,
      imoveis.varandas as varandas,
      imoveis.mobiliado as mobiliado,
      imoveis.ocupado as ocupado,
      imoveis.idade as idade,
      imoveis.condominio as condominio,
      imoveis.area_util as area_util,
      imoveis.area_total as area_total,
      imoveis.breve_descricao as breve_descricao,
      imoveis.descricao as descricao,
      imoveis.oferta as oferta,
      imoveis.destaque as destaque,
      imoveis.lancamento as lancamento,
      imoveis.data_criado as data_criado,
      imoveis.data_atualizado as data_atualizado,
      imoveis.status as status,

      format(sum(imoveis_negociacoes.valor), 0, 'de_DE') as valor,
      imoveis_negociacoes.permalink as permalink,
      imoveis_negociacoes.referencia as referencia,

      transacoes.nome as transacao,
      transacoes.slug as transacao_slug,

      imoveis_tipos.nome as tipo,
      imoveis_tipos.nome_plural as tipo_plural,
      imoveis_tipos.slug as tipo_slug,


      enderecos.cep as endereco_cep,
      enderecos.logradouro as endereco_logradouro,
      enderecos.numero as endereco_numero,
      enderecos.latitude as endereco_latitude,
      enderecos.longitude as endereco_longitude,
      enderecos.latitude_site as endereco_latitude_site,
      enderecos.longitude_site as endereco_longitude_site,

      UCASE(estados.sigla) as endereco_estado,
      estados.nome as endereco_estado_nome,

      cidades.nome as endereco_cidade,
      cidades.slug as endereco_cidade_slug,

      bairros.nome as endereco_bairro,
      bairros.slug as endereco_bairro_slug,

      periodos.nome as periodo,
      periodos.slug as periodo_slug
    "));

    $this->db->from('imoveis');

    // JOINS
    $this->db->join("imoveis_tipos", "imoveis.tipo = imoveis_tipos.id", "inner"); // Negociações
    $this->db->join("imoveis_negociacoes", "imoveis_negociacoes.imovel = imoveis.id", "inner"); // Negociações
    $this->db->join("periodos", "imoveis_negociacoes.periodo = periodos.id", "inner"); // Períodos
    $this->db->join("transacoes", "imoveis_negociacoes.transacao = transacoes.id", "inner"); // Transações
    $this->db->join("imoveis_enderecos", "imoveis_enderecos.imovel = imoveis.id", "inner"); // Endereços (Relação)
    $this->db->join("enderecos", "imoveis_enderecos.endereco = enderecos.id", "inner"); // Endereços
    $this->db->join("estados", "enderecos.estado = estados.id", "inner"); // Estados
    $this->db->join("cidades", "enderecos.cidade = cidades.id", "inner"); // Cidades
    $this->db->join("bairros", "enderecos.bairro = bairros.id", "inner"); // Bairros

    // PARAMS

    //- Localização
    if(isset($request['params']['location']) && !empty($request['params']['location'])){
      $this->db->group_start();

      $location_count = 0;
      foreach($request['params']['location'] as $location){
        if(!$location_count){
          $this->db->group_start();
        }else{
          $this->db->or_group_start();
        }
        // Estado
        if(isset($location['state']) && !empty($location['state'])){
          $this->db->where('estados.sigla', $location['state']);
        }
        // Cidade
        if(isset($location['city']) && !empty($location['city'])){
          $this->db->where('cidades.slug', $location['city']);
        }
        // Bairro
        if(isset($location['district']) && !empty($location['district'])){
          $this->db->where('bairros.slug', $location['district']);
        }
        $this->db->group_end();
        $location_count++;
      }
      $this->db->group_end();
    }

    // Características
    if(isset($request['params']['features']) && !empty($request['params']['features'])){
      $this->db->join("imoveis_caracteristicas", "imoveis_caracteristicas.imovel = imoveis.id", "inner"); // Imóveis características
      $this->db->join("caracteristicas", "imoveis_caracteristicas.caracteristica = caracteristicas.id", "inner"); // Características
      $this->db->group_start();
      $feature_count = 0;
      foreach ($request['params']['features'] as $feature) {
        if(!$feature_count){
          $this->db->group_start();
        }else{
          $this->db->or_group_start();
        }
        $this->db->where('caracteristicas.slug', $feature);
        $this->db->group_end();
        $feature_count++;
      }
      $this->db->group_end();
      $this->db->having('COUNT(imoveis.id)', count($request['params']['features']));
    }

    //- Imóvel ID
    if(isset($request['params']['property_id']) && !empty($request['params']['property_id'])){
      $this->db->where('imoveis.id', $request['params']['property_id']);
    }

    //- Preço Mínimo
    if(isset($request['params']['min_price']) && !empty($request['params']['min_price'])){
      $this->db->where('imoveis_negociacoes.valor >=', preg_replace("/[^0-9]/", "", $request['params']['min_price']));
    }

    //- Preço Máximo
    if(isset($request['params']['max_price']) && !empty($request['params']['max_price'])){
      $this->db->where('imoveis_negociacoes.valor <=', preg_replace("/[^0-9]/", "", $request['params']['max_price']));
    }

    //- Área mínima
    if(isset($request['params']['min_area']) && !empty($request['params']['min_area'])){
      $this->db->where('imoveis.area_util >=', preg_replace("/[^0-9]/", "", $request['params']['min_area']));
    }

    //- Área máxima
    if(isset($request['params']['max_area']) && !empty($request['params']['max_area'])){
      $this->db->where('imoveis.area_util <=', preg_replace("/[^0-9]/", "", $request['params']['max_area']));
    }

    //- Dormitórios
    if(isset($request['params']['bedrooms']) && !empty($request['params']['bedrooms'])){
      $this->db->where('imoveis.dormitorios >=', $request['params']['bedrooms']);
    }

    //- Banheiros
    if(isset($request['params']['bathrooms']) && !empty($request['params']['bathrooms'])){
      $this->db->where('imoveis.banheiros >=', $request['params']['bathrooms']);
    }

    //- Garagens
    if(isset($request['params']['garages']) && !empty($request['params']['garages'])){
      $this->db->where('imoveis.garagens >=', $request['params']['garages']);
    }

    // Visibilidade no site
    $visibility = (isset($request['params']['visibility']) ? $request['params']['visibility'] : 1);
    $this->db->where('imoveis.status', $visibility);

    //- Tipo de imóvel
    if(isset($request['params']['property_type']) && !empty($request['params']['property_type'])){
      $this->db->where_in('imoveis_tipos.slug', $request['params']['property_type']);
    }

    //- Transação
    if(isset($request['params']['transaction']) && !empty($request['params']['transaction'])){
      $this->db->where_in('transacoes.slug', $request['params']['transaction']);
    }


    // WHERE
    if(isset($request['where']) && !empty($request['where'])){
      $this->db->where($request['where']);
    }

    // WHERE IN
    if(isset($request['where_in']) && !empty($request['where_in'])){
      foreach ($request['where_in'] as $key => $value) {
        $this->db->where_in($key, $value);
      }
    }

    // NOT IN
    if(isset($request['not_in']) && !empty($request['not_in'])){
      foreach ($request['not_in'] as $key => $value) {
        $this->db->where_not_in($key, $value);
      }
    }

    // ORDER BY
    if(isset($request['orderby']) && !empty($request['orderby'])){
      switch ($request['orderby']) {

        case 'lowest_price':
          $this->db->order_by('imoveis_negociacoes.valor ASC');
        break;

        case 'biggest_price':
          $this->db->order_by('imoveis_negociacoes.valor DESC');
        break;

        case 'most_recent':
          $this->db->order_by('imoveis.id DESC');
        break;

        case 'featured':
          $this->db->where('destaque', 1);
          $this->db->order_by('imoveis.id', 'RANDOM');
        break;

        case 'recommend':
          $this->db->order_by('imoveis.id', 'RANDOM');
        break;

      }
    }

    // GROUP BY
    $this->db->group_by('imoveis.id');

    // GET ROWS COUNT

    $limit = (isset($request['limit']) && !empty($request['limit']) ? $request['limit'] : $this->config->item('property_list_limit'));

    // PAGINATION
    if(isset($request['page']) && $request['page']){
      $return['total_rows'] = $this->get_rows_count($this->db->_compile_select());
      $return['total_pages'] = ceil($return['total_rows'] / $limit);

      $return['pagination'] = $this->site->create_pagination($limit, $return['total_rows'], rtrim((isset($request['params']['base_url']) ? base_url($request['params']['base_url']) : current_url()), "/" . $request['page']), 5, (isset($request['params']['url_suffix']) ? $request['params']['url_suffix'] : null));

      $page = max(0, ($request['page'] - 1) * $limit);
    }

    if(isset($page) && !empty($page)){
      $this->db->limit($limit, $page);
    }else{
      $this->db->limit($limit);
    }

    // $return['sql'] = $this->db->_compile_select();


    $query = $this->db->get();

    if($query->num_rows()){
      if($row){
        $return = $query->row_array();
        $return_ids = array($return['id']);
      }else{
        $return['results'] = array();

        $return_ids = array();
        $return_count = 0;
        foreach($query->result_array() as $result){
          $return['results'][$return_count] = $result;

          // Permalink
          if(!empty($result['imovel_permalink'])){
            $return['results'][$return_count]['imovel_permalink'] = base_url($this->config->item('property_detail_url_prefix') . '/' . $result['imovel_permalink']);
          }else{
            $url = array($this->config->item('property_detail_url_prefix'));
            $url_parts = array('transacao_slug', 'endereco_estado', 'endereco_cidade_slug', 'endereco_bairro_slug', 'tipo_slug', 'id');
            foreach($url_parts as $part){
              $url[] = strtolower($result[$part]);
            }
            $return['results'][$return_count]['imovel_permalink'] = base_url(implode('/', $url));
          }

          $return_ids[$return_count] = $result['id'];
          $return_count++;
        }
      }

      $return = $this->properties_features($return_ids, false, $return);
      $return = $this->properties_images($return_ids, $return);
      $return = $this->properties_expenses($return_ids, $return);

      return $return;
    }

  }//Properties

  public function properties_features($properties_ids = array(), $filters = false, $return = false) {
    $this->db->select("caracteristicas.id, caracteristicas.nome, caracteristicas.nome_vivareal, caracteristicas.slug");
    $this->db->from('caracteristicas');

    if(!empty($properties_ids)){
      $this->db->select("imoveis_caracteristicas.imovel");
      $this->db->join("imoveis_caracteristicas", "imoveis_caracteristicas.caracteristica = caracteristicas.id", "inner");
      $this->db->where_in('imoveis_caracteristicas.imovel', $properties_ids);
    }

    if($filters){
      $this->db->where('caracteristicas.filtro', 1);
    }

    $this->db->order_by('imoveis_caracteristicas.imovel ASC, caracteristicas.nome ASC');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      $results = $query->result_array();

      if($return){
        foreach ($results as $imovel_feature) {
          $imovel_feature_return = array(
            'id' => $imovel_feature['id'],
            'nome' => $imovel_feature['nome'],
            'nome_vivareal' => $imovel_feature['nome_vivareal'],
            'slug' => $imovel_feature['slug']
          );

          if(isset($return['results'])){
            $property_key = array_search ($imovel_feature['imovel'], $properties_ids);
            $return['results'][$property_key]['caracteristicas'][] = $imovel_feature_return;
          }else{
            $return['caracteristicas'][] = $imovel_feature_return;
          }
        }
        return $return;
      }

      return $query->result_array();
    }else{
      if($return) return $return;
    }

    return false;
  }// features

  public function properties_images($properties_ids, $return = null) {
    $this->db->select("*");

    $this->db->where_in('imoveis_imagens.imovel', $properties_ids);

    $this->db->order_by('imoveis_imagens.padrao DESC, imoveis_imagens.ordem ASC');

    $query = $this->db->get("imoveis_imagens");

    if ($query->num_rows() > 0) {
      if($return){
        foreach ($query->result_array() as $imovel_imagem) {
          if(isset($return['results'])){
            $property_key = array_search ($imovel_imagem['imovel'], $properties_ids);
            $return['results'][$property_key]['imagens'][] = $imovel_imagem;
          }else{
            $return['imagens'][] = $imovel_imagem;
          }
        }
        return $return;
      }

      return $query->result_array();
    }else{
      if($return) return $return;
    }

    return false;
  }// images

  public function properties_expenses($properties_ids, $return = null) {
    $this->db->select("
      imoveis_despesas.imovel,
      imoveis_despesas.valor,
      despesas_tipos.nome as tipo,
      despesas_tipos.slug as tipo_slug,
      periodos.nome as periodo,
      periodos.nome_curto as periodo_curto,
    ");

    $this->db->where_in('imoveis_despesas.imovel', $properties_ids);

    $this->db->join("despesas_tipos", "imoveis_despesas.tipo = despesas_tipos.id", "inner");
    $this->db->join("periodos", "imoveis_despesas.periodo = periodos.id", "inner");

    $this->db->order_by('despesas_tipos.ordem ASC');

    $query = $this->db->get("imoveis_despesas");

    if ($query->num_rows() > 0) {
      if($return){
        foreach ($query->result_array() as $imovel_despesa) {
          if(isset($return['results'])){
            $property_key = array_search ($imovel_despesa['imovel'], $properties_ids);
            $return['results'][$property_key]['despesas'][$imovel_despesa['tipo_slug']] = $imovel_despesa;
          }else{
            $return['despesas'][$imovel_despesa['tipo_slug']] = $imovel_despesa;
          }
        }
        return $return;
      }

      return $query->result_array();
    }else{
      if($return) return $return;
    }

    return false;
  }
}
?>
