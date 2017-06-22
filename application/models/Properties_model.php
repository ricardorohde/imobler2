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
    $return = array();

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
      DATE_FORMAT(imoveis.data_atualizado,'%d/%m/%Y') as data_atualizado_formatada,
      imoveis.status as status,

      format(sum(imoveis_negociacoes.valor), 0, 'de_DE') as valor,
      imoveis_negociacoes.valor as valor_real,
      imoveis_negociacoes.permalink as imovel_permalink,
      imoveis_negociacoes.referencia as referencia,

      transacoes.nome as transacao,
      transacoes.slug as transacao_slug,

      imoveis_tipos.nome as tipo,
      imoveis_tipos.nome_plural as tipo_plural,
      imoveis_tipos.slug as tipo_slug,
      imoveis_tipos.id as tipo_id,

      enderecos.cep as endereco_cep,
      enderecos.logradouro as endereco_logradouro,
      enderecos.numero as endereco_numero,
      enderecos.complemento as endereco_complemento,
      enderecos.latitude as endereco_latitude,
      enderecos.longitude as endereco_longitude,
      enderecos.latitude_site as endereco_latitude_site,
      enderecos.longitude_site as endereco_longitude_site,
      enderecos_visibilidades.slug as endereco_visibilidade,
      enderecos_visibilidades.id as endereco_visibilidade_id,

      UCASE(estados.sigla) as endereco_estado,
      estados.id as endereco_estado_id,
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
    $this->db->join("enderecos_visibilidades", "enderecos.visibilidade_site = enderecos_visibilidades.id", "inner"); // Endereços visibilidade
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

    if(isset($request['params']['property_features']) && !empty($request['params']['property_features'])){
      $this->db->join("imoveis_caracteristicas", "imoveis_caracteristicas.imovel = imoveis.id", "inner"); // Imóveis características
      $this->db->join("caracteristicas", "imoveis_caracteristicas.caracteristica = caracteristicas.id", "inner"); // Características
      $this->db->where_in('caracteristicas.slug', $request['params']['property_features']);
    }

    // Características
//     if(isset($request['params']['property_features']) && !empty($request['params']['property_features'])){
//       $this->db->join("imoveis_caracteristicas", "imoveis_caracteristicas.imovel = imoveis.id", "inner"); // Imóveis características
//       $this->db->join("caracteristicas", "imoveis_caracteristicas.caracteristica = caracteristicas.id", "inner"); // Características

//       $this->db->group_start();

//       $feature_count = 0;
// print_l($request['params']['property_features']);
//       foreach ($request['params']['property_features'] as $feature) {
//         if(!$feature_count){
//           // $this->db->group_start();
//         }else{
//           // $this->db->or_group_start();
//         }

//         // $this->db->where('caracteristicas.slug', $feature);

//         // $this->db->group_end();
//         $feature_count++;
//       }

//       $this->db->group_end();
//     }

    //- Tipo de imóvel
    if(isset($request['params']['properties_types']) && !empty($request['params']['properties_types'])){
      $this->db->where_in('imoveis_tipos.slug', $request['params']['properties_types']);
    }

    //- Imóvel ID
    if(isset($request['params']['property_id']) && !empty($request['params']['property_id'])){
      $this->db->where('imoveis.id', $request['params']['property_id']);
    }

    //- Imóvel Permalink
    if(isset($request['params']['property_permalink']) && !empty($request['params']['property_permalink'])){
      $this->db->where('imoveis_negociacoes.permalink', $request['params']['property_permalink']);
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

        case 'recommended':
          $this->db->order_by('imoveis.id', 'RANDOM');
        break;

      }
    }

    // GROUP BY
    $this->db->group_by('imoveis.id');



    // PAGINATION
    $limit = (isset($request['limit']) && !empty($request['limit']) ? $request['limit'] : $this->config->item('property_list_limit'));
    $page = isset($request['page']) ? $request['page'] : 1;
    $return['total_rows'] = $this->get_rows_count($this->db->_compile_select());
    $return['total_pages'] = ceil($return['total_rows'] / $limit);
    $return['current_page'] = $page;
    $return['pagination'] = $this->site->create_pagination($page, $limit, $return['total_rows'], rtrim((isset($request['base_url']) ? $request['base_url'] : current_url()), "/" . $page), $this->config->item('property_pagination_links'), (isset($request['url_suffix']) ? $request['url_suffix'] : null));
    $page = max(0, ($page - 1) * $limit);
    $this->db->limit($limit, $page);


    $return['sql'] = $this->db->_compile_select();
    // echo $return['sql'];


    $query = $this->db->get();

    if($query->num_rows() > 0){
      $return['results'] = array();

      $return_ids = array();
      $return_count = 0;



      foreach($query->result_array() as $result){

        if($this->router->fetch_module() == 'site'){
          $endereco_label = '';
          $endereco_fields = array('endereco_cep', 'endereco_logradouro', 'endereco_numero', 'endereco_complemento', 'endereco_bairro', 'endereco_cidade', 'endereco_estado');

          switch ($result['endereco_visibilidade']) {
            case 'apenas-rua':
              $endereco_visibilidade = array('endereco_cep', 'endereco_logradouro', 'endereco_bairro', 'endereco_cidade', 'endereco_estado');
              $endereco_label = '%endereco_logradouro% - %endereco_bairro%';
            break;

            case 'completo':
              $endereco_visibilidade = array('endereco_cep', 'endereco_logradouro', 'endereco_numero', 'endereco_complemento', 'endereco_bairro', 'endereco_cidade', 'endereco_estado');
              $endereco_label = '%endereco_logradouro%, %endereco_numero% - %endereco_bairro%';
            break;

            default:
               $endereco_visibilidade = array('endereco_bairro', 'endereco_cidade', 'endereco_estado');
               $endereco_label = '%endereco_bairro%';
          }

          foreach ($endereco_fields as $field) {
            if(!in_array($field, $endereco_visibilidade)){
              unset($result[$field]);
            }


            $endereco_label = str_replace('%'. $field .'%', (isset($result[$field]) && !empty($result[$field]) ? $result[$field] : ''), $endereco_label);
          }

          $result['endereco_label'] = $endereco_label;

          $result['endereco_latitude'] = (!empty($result['endereco_latitude_site']) ? $result['endereco_latitude_site'] : $result['endereco_latitude']);
          $result['endereco_longitude'] = (!empty($result['endereco_longitude_site']) ? $result['endereco_longitude_site'] : $result['endereco_longitude']);
          unset($result['endereco_latitude_site']);
          unset($result['endereco_longitude_site']);
        }

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

      $return = $this->properties_features($return_ids, false, $return);
      $return = $this->properties_images($return_ids, $return);
      $return = $this->properties_expenses($return_ids, $return);

      // Favorites
      if($this->site->user_logged()){
        $return = $this->properties_favorites($return_ids, $return);
      }

      if($row){
        $return = isset($return['results'][0]) ? $return['results'][0] : false;
      }
    }

    return $return;

  }//Properties

  public function property_like_check($user_id, $property_id) {
    $this->db->select("*");

    $this->db->where(array(
      'imoveis_favoritos.imovel' => $property_id,
      'imoveis_favoritos.usuario' => $user_id
    ));

    $query = $this->db->get("imoveis_favoritos");

    if ($query->num_rows() > 0) {
      return $query->row_array();
    }

    return false;
  }

  public function property_like($params) {
    if($this->site->user_logged() && isset($params['property_id']) && $params['property_id'] && isset($params['status']) && $params['status']){
      $user_id = $this->site->userinfo('id');
      $return = array('property_id' => $params['property_id']);
      $liked = $this->property_like_check($user_id, $params['property_id']);

      if($params['status'] == 'unliked'){
        if(!$liked){
          $this->db->insert('imoveis_favoritos', array('imovel' => $params['property_id'], 'usuario' => $user_id));
        }
        $return['status'] = 'liked';
      }else{
        if($liked){
          $this->db->delete('imoveis_favoritos', array('imovel' => $params['property_id'], 'usuario' => $user_id));
        }
        $return['status'] = 'unliked';
      }

      return $return;
    }

    return false;
  }

  public function properties_favorites($properties_ids, $return = null) {
    if($this->site->user_logged()){
      $user_id = $this->site->userinfo('id');

      $this->db->select("imoveis_favoritos.imovel");

      $this->db->from("imoveis_favoritos");

      $this->db->where_in('imoveis_favoritos.imovel', $properties_ids);

      $this->db->where('imoveis_favoritos.usuario', $user_id);

      // $sql = $this->db->_compile_select();
      // echo $sql;

      $query = $this->db->get();

      if ($query->num_rows() > 0) {

        if($return){
          foreach ($query->result_array() as $imovel_favorito) {
            if(isset($return['results'])){
              $property_key = array_search($imovel_favorito['imovel'], $properties_ids);
              $return['results'][$property_key]['imovel_favorito'] = true;
            }else{
              $return['imovel_favorito'] = true;
            }
          }
          return $return;
        }
        return $query->result_array();
      }else{
        if($return) return $return;
      }
    }
  }

  public function properties_permalink($request = array()) {

    // SELECT
    $this->db->select((isset($request['select']) ? $request['select'] : "
      imoveis.id as id,
      imoveis_negociacoes.permalink as imovel_permalink,
      transacoes.slug as transacao_slug,
      UCASE(estados.sigla) as endereco_estado,
      cidades.slug as endereco_cidade_slug,
      bairros.slug as endereco_bairro_slug,
      imoveis_tipos.slug as tipo_slug,
    "));

    //- Imóvel ID
    if(isset($request['params']['property_id']) && !empty($request['params']['property_id'])){
      $this->db->where('imoveis.id', $request['params']['property_id']);
    }

    //- Imóvel Permalink
    if(isset($request['params']['property_permalink']) && !empty($request['params']['property_permalink'])){
      $this->db->where('imoveis_negociacoes.permalink', $request['params']['property_permalink']);
    }

    $this->db->from('imoveis');

    // JOINS
    $this->db->join("imoveis_tipos", "imoveis.tipo = imoveis_tipos.id", "inner"); // Negociações
    $this->db->join("imoveis_negociacoes", "imoveis_negociacoes.imovel = imoveis.id", "inner"); // Negociações
    $this->db->join("transacoes", "imoveis_negociacoes.transacao = transacoes.id", "inner"); // Transações
    $this->db->join("imoveis_enderecos", "imoveis_enderecos.imovel = imoveis.id", "inner"); // Endereços (Relação)
    $this->db->join("enderecos", "imoveis_enderecos.endereco = enderecos.id", "inner"); // Endereços
    $this->db->join("estados", "enderecos.estado = estados.id", "inner"); // Estados
    $this->db->join("cidades", "enderecos.cidade = cidades.id", "inner"); // Cidades
    $this->db->join("bairros", "enderecos.bairro = bairros.id", "inner"); // Bairros

    // $sql = $this->db->_compile_select();
    // echo $sql;

    $query = $this->db->get();

    if($query->num_rows()){
      $result = $query->row_array();
      $return = '';

      // Permalink
      if(!empty($result['imovel_permalink'])){
        $return = base_url($this->config->item('property_detail_url_prefix') . '/' . $result['imovel_permalink']);
      }else{
        $url = array($this->config->item('property_detail_url_prefix'));
        $url_parts = array('transacao_slug', 'endereco_estado', 'endereco_cidade_slug', 'endereco_bairro_slug', 'tipo_slug', 'id');
        foreach($url_parts as $part){
          $url[] = strtolower($result[$part]);
        }
        $return = base_url(implode('/', $url));
      }

      return $return;
    }

    return base_url();
  }

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

    $this->db->order_by('caracteristicas.nome ASC');

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

  public function add_property_image($params = array()) {
    $this->db->insert('imoveis_imagens', $params);
    return $this->db->insert_id();
  }

  public function add_locality($table, $params = array()) {
    $this->db->insert($table, $params);
    return $this->db->insert_id();
  }

  public function check_locality($estado_id, $cidade_nome, $bairro_nome) {
    // Cidade
    $cidade = $this->registros_model->registros('cidades', array('where' => array('cidades.estado' => $estado_id, 'cidades.nome' => trim($cidade_nome))), true);
    if($cidade){
      $cidade_id = $cidade['id'];
    }else{
      $cidade_id = $this->add_locality('cidades', array(
        'estado' => $estado_id,
        'nome' => trim($cidade_nome),
        'slug' => sanitize_string(trim($cidade_nome))
      ));
    }

    // Bairro
    $bairro = $this->registros_model->registros('bairros', array('where' => array('bairros.cidade' => $cidade_id, 'bairros.nome' => trim($bairro_nome))), true);
    if($bairro){
      $bairro_id = $bairro['id'];
    }else{
      $bairro_id = $this->add_locality('bairros', array(
        'cidade' => $cidade_id,
        'nome' => trim($bairro_nome),
        'slug' => sanitize_string(trim($bairro_nome))
      ));
    }

    return array('estado_id' => $estado_id, 'cidade_id' => $cidade_id, 'bairro_id' => $bairro_id);
  }

  public function get_locations_by_term() {

    $this->db->select("
      UCASE(estados.sigla) as estado_sigla,
      estados.sigla as estado_slug,
      cidades.nome as cidade_nome,
      cidades.slug as cidade_slug,
      '' as bairro_nome,
      '' as bairro_slug,
      'city' as category
    ");

    $this->db->from('estados');
    $this->db->join("cidades", "cidades.estado = estados.id", "inner");

    $this->db->like('cidades.nome', $this->input->get('term'));

    $this->db->limit(3);

    $query_city = $this->db->get_compiled_select();

    $this->db->select("
      UCASE(estados.sigla) as estado_sigla,
      estados.sigla as estado_slug,
      cidades.nome as cidade_nome,
      cidades.slug as cidade_slug,
      bairros.nome as bairro_nome,
      bairros.slug as bairro_slug,
      'district' as category
    ");

    $this->db->from('estados');
    $this->db->join("cidades", "cidades.estado = estados.id", "inner");
    $this->db->join("bairros", "bairros.cidade = cidades.id", "inner");

    $this->db->like('bairros.nome', $this->input->get('term'));

    $this->db->limit(6);

    $query_district = $this->db->get_compiled_select();

    $query = $this->db->query($query_city ." UNION ". $query_district);

    // echo $query_city ." UNION ". $query_district;

    if($query->num_rows() > 0) {
      $return = array();

      foreach($query->result_array() as $row){
        array_push($return, array(
          'label' => ($row['category'] == 'city' ? $row['cidade_nome'] . ' ('. $row['estado_sigla'] .')' : $row['bairro_nome'] . ' ('. $row['cidade_nome'] . ', ' . $row['estado_sigla'] .')'),
          'location' => array(
            'state' => $row['estado_slug'],
            'city' => $row['cidade_slug'],
            'district' => $row['bairro_slug']
          ),
          'category' => array(
            'slug' => $row['category'],
            'name' => ($row['category'] == 'city' ? 'Cidades' : 'Bairros')
          )
        ));
      }

      return json_encode($return);
    }
  }

  public function filters_properties_types($request = array()) {
    $this->db->select("
      imoveis_tipos.nome,
      imoveis_tipos.slug,
      imoveis_tipos_segmentos.nome as segmento_nome,
      imoveis_tipos_segmentos.slug as segmento_slug
    ");

    $this->db->from("imoveis_tipos");

    $this->db->join("imoveis_tipos_segmentos", "imoveis_tipos.segmento = imoveis_tipos_segmentos.id", "inner");

    $query = $this->db->get();

    // $return = array();

    $return = array();
    if ($query->num_rows() > 0) {
      $count = 0;
      foreach ($query->result_array() as $properties_types) {
        if(!isset($return[$properties_types['segmento_slug']])){
          $return[$properties_types['segmento_slug']] = array(
            'segmento' => $properties_types['segmento_nome']
          );
        }

        $return[$properties_types['segmento_slug']]['tipos'][$count] = array(
          'nome' => $properties_types['nome'],
          'slug' => $properties_types['slug']
        );

        if(!empty($request)){
          if(in_array($properties_types['slug'], $request)){
            $return[$properties_types['segmento_slug']]['tipos'][$count]['selected'] = true;
          }
        }

        $count++;
      }
    }

    return $return;
  }

  public function filters_location($location = null) {
    if($location){

      $label = '';

      if(isset($location['state'])){
        $this->db->select("UCASE(estados.sigla) as state");
        $this->db->from('estados');
        $this->db->where('estados.sigla', strtolower($location['state']));
        $label = '%state%';
      }

      if(isset($location['city'])){
        $this->db->select("cidades.nome as city");
        $this->db->join("cidades", "cidades.estado = estados.id", "inner");
        $this->db->where('cidades.slug', $location['city']);
        $label = '%city% (%state%)';
      }


      if(isset($location['district'])){
        $this->db->select("bairros.nome as district");
        $this->db->join("bairros", "bairros.cidade = cidades.id", "inner");
        $this->db->where('bairros.slug', $location['district']);
        $label = '%district% (%city%, %state%)';
      }

      $query = $this->db->get();

      if ($query->num_rows() > 0) {
        $row = $query->row_array();

        foreach ($row as $key => $value) {
          $label = str_replace('%'. $key .'%', $value, $label);
        }

        $location['label'] = $label;

        return $location;
      }


    }
  }

  public function filters_properties_features($request = array()) {
    $features = $this->properties_features(null, true);
    $return = array();
    if(!empty($features)){
      foreach ($features as $key => $feature) {
        $return[$key] = $feature;

        if(!empty($request)){
          if(in_array($feature['slug'], $request)){
            $return[$key]['selected'] = true;
          }
        }
      }
    }
    return $return;
  }

  public function filters_properties_orderby($request = null) {
    $orderby_array = array(
      'most_recent' => 'Mais recentes',
      'lowest_price' => 'Preço menor pro maior',
      'biggest_price' => 'Preço maior pro menor'
    );

    $return = array();
    $count = 0;
    foreach($orderby_array as $orderby_key => $orderby_label){
      $return[$count] = array(
        'slug' => $orderby_key,
        'name' => $orderby_label
      );

      if(!empty($request)){
        if($request == $orderby_key){
          $return[$count]['selected'] = true;
        }
      }

      $count++;
    }

    return $return;
  }

  public function filters($request = null) {
    $return['params'] = array();

    if(!isset($request['campaign'])){
      if(isset($request['params']['location'])){
        $count = 0;
        foreach ($request['params']['location'] as $location) {
          if(!isset($location['label'])){
            $get_location = $this->filters_location($location);
            if($get_location){
              $return['params']['location'][$count] = $get_location;
            }
          }else{
            $return['params']['location'][$count] = $location;
          }

          $return['params']['location'][$count]['index'] = $count;

          $count++;
        }
      }

      $return['params']['property_features'] = $this->filters_properties_features(isset($request['params']['property_features']) ? $request['params']['property_features'] : null);

      $return['params']['properties_types'] = $this->filters_properties_types(isset($request['params']['properties_types']) ? $request['params']['properties_types'] : null);

      foreach (array('bedrooms','garages','bathrooms','min_price','max_price','min_area','max_area') as $field) {
        if(isset($request['params'][$field])) {
          $return['params'][$field] = $request['params'][$field];
        }
      }
    }

    if(isset($request['params']['transaction'])) {
      $return['params']['transaction'] = $request['params']['transaction'];
    }

    $return['orderby'] = $this->filters_properties_orderby(isset($request['orderby']) ? $request['orderby'] : null);

    if(isset($request['page'])){
      $return['page'] = $request['page'];
    }

    if(isset($request['campaign'])){
      $return['campaign'] = $request['campaign'];
    }

    return $return;

  }
}
?>
