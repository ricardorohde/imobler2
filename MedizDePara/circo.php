<?php
function print_l($_array = null){
  if($_array){
    echo '<pre>' . print_r($_array, true) . '</pre>';
  }
}
require ('meekrodb.2.3.class.php');
$antigo = new MeekroDB('localhost', 'root', 'adm5135', 'medizdepara', '3306', 'utf8');
$novo = new MeekroDB('localhost', 'root', 'adm5135', 'mediz_imobler', '3306', 'utf8');

echo date('d/m/Y h:i:s', time());

$imovel_id = 0;

if(isset($_GET['clear']) && $_GET['clear'] == 754){
  $novo->query('delete from bairros');
  $novo->query('delete from campanhas');
  $novo->query('delete from cidades');
  $novo->query('delete from enderecos');
  $novo->query('delete from imoveis');
  $novo->query('delete from tags');
  $novo->query('delete from imoveis_imagens');

  $novo->query('ALTER TABLE bairros AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE campanhas AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE cidades AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE enderecos AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_imagens AUTO_INCREMENT = 1');

  $novo->query('ALTER TABLE imoveis_caracteristicas AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_despesas AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_enderecos AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_favoritos AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_imagens AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_negociacoes AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_observacoes AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE imoveis_tags AUTO_INCREMENT = 1');
  $novo->query('ALTER TABLE tags AUTO_INCREMENT = 1');

  exit;
}

function get_imagens($ids, $request){
  global $antigo;
  $return = $request;

  if(!empty($ids)){
    $imagens = $antigo->query("
      SELECT
        imoveis_imagens.padrao,
        imoveis_imagens.imovel,
        imoveis_imagens.legenda,
        imoveis_imagens.arquivo,
        imoveis_imagens.ordem
      FROM
        imoveis_imagens
      WHERE
        imoveis_imagens.imovel IN (". implode(',', $ids) .")
      ORDER BY
        imoveis_imagens.padrao DESC, imoveis_imagens.ordem ASC
    ");

    if($imagens){
      foreach ($imagens as $imagem) {
        $return[$imagem['imovel']]['imagens'][] = $imagem;
      }
    }
  }


  return $return;
}

function get_caracteristicas($ids, $request){
  global $antigo;
  $return = $request;

  if(!empty($ids)){
    $caracteristicas = $antigo->query("
      SELECT
        imoveis_caracteristicas.imovel,
        imoveis_caracteristicas.caracteristica,
        caracteristicas.nome
      FROM
        imoveis_caracteristicas
      INNER JOIN
        caracteristicas
      ON
        imoveis_caracteristicas.caracteristica = caracteristicas.id
      WHERE
        imoveis_caracteristicas.imovel IN (". implode(',', $ids) .")
      AND
        caracteristicas.nome_vivareal IS NOT NULL
      ORDER BY
        imoveis_caracteristicas.imovel
    ");

    if($caracteristicas){
      foreach ($caracteristicas as $caracteristica) {
        $return[$caracteristica['imovel']]['caracteristicas'][] = $caracteristica['nome'];
      }
    }
  }

  return $return;
}

function get_imoveis() {
  global $antigo;
  global $imovel_id;
  $return = array();
  $imoveis_ids = array();

  $where_imovel_id = '';
  if($imovel_id){
    $where_imovel_id = "
      AND
        tb_imoveis.id = ". $imovel_id ."
    ";
  }else{
  }

  $query = "
    SELECT
      tb_imoveis.*,
      tb_tipos_de_imoveis.nome as tipo_de_imovel_nome,
      tb_tipos_de_imoveis.nome_plural as tipo_de_imovel_nome_plural,
      tb_tipos_de_imoveis.slug AS tipo_de_imovel,
      tb_tipos_de_imoveis.slug_ingles AS tipo_de_imovel_ingles,
      tb_tipos_de_imoveis.titulo AS meta_title,
      tb_tipos_de_imoveis.descricao AS meta_description,
      tb_cidades.nome as cidade_nome,
      tb_cidades.slug AS cidade,
      tb_bairros.nome as bairro_nome,
      tb_bairros.slug AS bairro,
      tb_estados.nome as estado_nome,
      tb_estados.sigla as estado_sigla,
      tb_zonas.nome as zona_nome
    FROM
      imoveis tb_imoveis
    INNER JOIN
      tipos_de_imoveis tb_tipos_de_imoveis
    ON
      tb_imoveis.tipo_de_imovel = tb_tipos_de_imoveis.id
    INNER JOIN
      cidades tb_cidades
    ON
      tb_imoveis.cidade = tb_cidades.id
    INNER JOIN
      estados tb_estados
    ON
      tb_imoveis.estado = tb_estados.id
    INNER JOIN
      bairros tb_bairros
    ON
      tb_imoveis.bairro = tb_bairros.id
    LEFT JOIN
      zonas tb_zonas
    ON
      tb_imoveis.zona = tb_zonas.id
    WHERE
      tb_imoveis.status_depara = 0
    ". $where_imovel_id ."
    LIMIT
      1
  ";

  $imoveis = $antigo->query($query);

  if($imoveis){
    foreach ($imoveis as $imovel) {
      $imoveis_ids[] = $imovel['id'];
      $return[$imovel['id']] = $imovel;
    }
  }

  $result = get_imagens($imoveis_ids, $return);
  $result = get_caracteristicas($imoveis_ids, $result);

  return $result;
}




function correct_encoding($text) {
    $current_encoding = mb_detect_encoding($text, 'auto');
    $text = iconv($current_encoding, 'UTF-8', $text);
    return $text;
}

function limpa_texto($string = '') {
  $string = str_replace('&nbsp;', ' ', $string);

  $string = html_entity_decode($string);

  return correct_encoding(trim(strip_tags($string)));
  //return correct_encoding(trim(strip_tags(html_entity_decode($string))));
}

function format_uri( $string, $separator = '-' )
{
    $string = limpa_texto($string);
    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = array( '&' => 'and', "'" => '');
    $string = mb_strtolower( trim( $string ), 'UTF-8' );
    $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
    $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
    $string = preg_replace("/[$separator]+/u", "$separator", $string);
    $string = mb_strtolower( rtrim($string, '-'), 'UTF-8' );
    return $string;
}

$imoveis = get_imoveis();

if(!empty($imoveis)){
  foreach($imoveis as $imovel){

    $imovel_tipo_id = $novo->queryFirstField("SELECT id FROM imoveis_tipos WHERE nome = %s", $imovel['tipo_de_imovel_nome']);
    if(!$imovel_tipo_id){

      $imovel_tipo_adicionado = array(
        'segmento' => 1,
        'nome' => limpa_texto($imovel['tipo_de_imovel_nome']),
        'nome_plural' => limpa_texto($imovel['tipo_de_imovel_nome_plural']),
        'slug' => format_uri($imovel['tipo_de_imovel_nome']),
        'slug_ingles' => limpa_texto($imovel['tipo_de_imovel_ingles']),

        'meta_title' => limpa_texto($imovel['meta_title']),
        'meta_description' => limpa_texto($imovel['meta_description']),
      );

      // echo 'imovel_tipo adicionada:';

      // print_l($imovel_tipo_adicionado);

      $novo->insert('imoveis_tipos', $imovel_tipo_adicionado);

      $imovel_tipo_id = $novo->insertId();
    }


    $imovel_array = array(
      'id' => $imovel['id'],
      'guid' => $imovel['guid'],
      'tipo' => $imovel_tipo_id,

      'dormitorios' => ($imovel['dormitorios'] != 0 ? $imovel['dormitorios'] : NULL),
      'salas' => ($imovel['salas'] != 0 ? $imovel['salas'] : NULL),
      'banheiros' => ($imovel['banheiros'] != 0 ? $imovel['banheiros'] : NULL),
      'suites' => ($imovel['suites'] != 0 ? $imovel['suites'] : NULL),
      'garagens' => ($imovel['garagens'] != 0 ? $imovel['garagens'] : NULL),
      'varandas' => ($imovel['varandas'] != 0 ? $imovel['varandas'] : NULL),

      'idade' => ($imovel['idade'] != 0 ? $imovel['idade'] : NULL),
      'area_util' => ($imovel['area'] != 0 ? $imovel['area'] : NULL),

      'condominio' => ($imovel['condominio'] != 0 ? $imovel['condominio'] : NULL),
      'mobiliado' => ($imovel['mobiliado'] != 0 ? $imovel['mobiliado'] : NULL),
      'ocupado' => ($imovel['ocupado'] != 0 ? $imovel['ocupado'] : NULL),

      'destaque' => ($imovel['destaque'] != 0 ? $imovel['destaque'] : NULL),
      'oferta' => ($imovel['oferta'] != 0 ? $imovel['oferta'] : NULL),
      'lancamento' => ($imovel['lancamento'] != 0 ? $imovel['lancamento'] : NULL),

      'breve_descricao' => limpa_texto(!empty($imovel['breve_descricao']) ? $imovel['breve_descricao'] : NULL),
      'descricao' => limpa_texto(!empty($imovel['descricao']) ? $imovel['descricao'] : NULL),

      'data_criado' => (!empty($imovel['data_atualizado']) && $imovel['data_atualizado'] != '0000-00-00' ? $imovel['data_atualizado'] : new DateTime("now")),
      'data_atualizado' => (!empty($imovel['data_atualizado']) && $imovel['data_atualizado'] != '0000-00-00' ? $imovel['data_atualizado'] : new DateTime("now")),

      'status' => $imovel['status'],

      'old_titulo' => limpa_texto(!empty($imovel['titulo']) ? $imovel['titulo'] : NULL),

    );

    $novo->insert('imoveis', $imovel_array);

    $imovel_negociacao_array = array(
      'imovel' => $imovel['id'],
      'transacao' => 1,
      'valor' => $imovel['valor'],
      'periodo' => 1,
      'referencia' => $imovel['referencia'],
      'permalink' => $imovel['permalink'],
    );

    $novo->insert('imoveis_negociacoes', $imovel_negociacao_array);

    $despesas = array();

    if(!empty($imovel['iptu_valor']) && $imovel['iptu_valor'] != '0.00'){
      $despesas[] = array(
        'imovel' => $imovel['id'],
        'tipo' => 1,
        'valor' => $imovel['iptu_valor'],
        'periodo' => 2
      );
    }

    if(!empty($imovel['condominio_valor']) && $imovel['condominio_valor'] != '0.00'){
      $despesas[] = array(
        'imovel' => $imovel['id'],
        'tipo' => 2,
        'valor' => $imovel['condominio_valor'],
        'periodo' => 3
      );
    }

    if(!empty($despesas)){
      $novo->insert('imoveis_despesas', $despesas);
    }

    if($imovel['google']){
      $novo->insert('imoveis_tags', array('imovel' => $imovel['id'], 'tag' => 1));
    }

    if(isset($imovel['caracteristicas']) && !empty($imovel['caracteristicas'])){
      $caracteristicas_array = array();
      foreach ($imovel['caracteristicas'] as $value) {
        $caracteristica_id = $novo->queryFirstField("SELECT id FROM caracteristicas WHERE nome = %s", $value);
        $caracteristicas_array[] = array(
          'imovel' => $imovel['id'],
          'caracteristica' => $caracteristica_id
        );
      }
      // echo 'imoveis caracteristicas';
      // print_l($caracteristicas_array);
      $novo->insert('imoveis_caracteristicas', $caracteristicas_array);
    }

    if(isset($imovel['imagens']) && !empty($imovel['imagens'])){
      $novo->insert('imoveis_imagens', $imovel['imagens']);
    }


    $cidade_id = $novo->queryFirstField("SELECT id FROM cidades WHERE estado = %i AND nome = %s", $imovel['estado'], $imovel['cidade_nome']);
    if(!$cidade_id){
      $cidade_adicionada = array(
        'estado' => $imovel['estado'],
        'nome' => limpa_texto($imovel['cidade_nome']),
        'slug' => format_uri($imovel['cidade_nome'])
      );
      // echo 'Cidade adicionada:';
      // print_l($cidade_adicionada);

      $novo->insert('cidades', $cidade_adicionada);

      $cidade_id = $novo->insertId();
    }

    $bairro_id = $novo->queryFirstField("SELECT id FROM bairros WHERE cidade = %i AND nome = %s", $cidade_id, $imovel['bairro_nome']);
    if(!$bairro_id){
      $bairro_adicionado = array(
        'cidade' => $cidade_id,
        'nome' => limpa_texto($imovel['bairro_nome']),
        'slug' => format_uri($imovel['bairro_nome'])
      );
      // echo 'bairro adicionado:';
      // print_l($bairro_adicionado);

      $novo->insert('bairros', $bairro_adicionado);

      $bairro_id = $novo->insertId();
    }

    $imovel_endereco_array = array(
      'cep' => (!empty($imovel['cep']) ? $imovel['cep'] : NULL),
      'logradouro' => (!empty($imovel['logradouro']) ? $imovel['logradouro'] : NULL),
      'complemento' => (!empty($imovel['complemento']) ? $imovel['complemento'] : NULL),
      'numero' => (!empty($imovel['numero']) ? ($imovel['numero'] != 0 ? $imovel['numero'] : NULL) : NULL),
      'estado' => $imovel['estado'],
      'cidade' => $cidade_id,
      'bairro' => $bairro_id,
      'zona' => ($imovel['zona'] != 0 ? $imovel['zona'] : NULL),

      'latitude' => ($imovel['latitude'] != 0.00000000 ? $imovel['latitude'] : NULL),
      'longitude' => ($imovel['longitude'] != 0.00000000 ? $imovel['longitude'] : NULL),

      'latitude_site' => ($imovel['mapa_latitude'] != 0.00000000 ? ($imovel['mapa_latitude'] != $imovel['latitude'] ? $imovel['latitude'] : NULL) : NULL),
      'longitude_site' => ($imovel['mapa_longitude'] != 0.00000000 ? ($imovel['mapa_longitude'] != $imovel['longitude'] ? $imovel['longitude'] : NULL) : NULL),

      'visibilidade_site' => ($imovel['mapa'] == 0 ? 1 : 3),
    );

    $imovel_endereco_id = $novo->queryFirstField("SELECT endereco FROM imoveis_enderecos WHERE imovel = %i", $imovel['id']);

    if(!$imovel_endereco_id){
      $novo->insert('enderecos', $imovel_endereco_array);
      $endereco_id = $novo->insertId();
      $novo->insert('imoveis_enderecos', array('imovel' => $imovel['id'], 'endereco' => $endereco_id));
    }else{
      $novo->update('enderecos', $imovel_endereco_array, "id=%i", $imovel_endereco_id);
    }


    //OBSERVACOES
    if(!empty($imovel['observacoes'])){
      $observacoes_array = array(
        'imovel' => $imovel['id'],
        'usuario' => 1,
        'data_criado' => new DateTime("now"),
        'observacao' => limpa_texto($imovel['observacoes'])
      );
      // echo 'observacao:';
      // print_l($observacoes_array);

      $novo->insert('imoveis_observacoes', $observacoes_array);
    }

    // print_l($imovel);
    // print_l($imovel_array);
    // print_l($imovel_negociacao_array);
    // print_l($imovel_endereco_array);


    $antigo->update('imoveis', array('status_depara' => 1), "id=%i", $imovel['id']);

  }
}


?>

<meta http-equiv="refresh" content="1;url=circo.php" />
