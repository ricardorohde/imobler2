<?php
require_once 'meekrodb.2.3.class.php';
DB::$user = 'medizimoveis';
DB::$password = 'imoveis5678';
DB::$dbName = 'medizimoveis';
DB::$host = '200.234.202.96';
DB::$encoding = 'utf8';

function get_imagens($ids, $request){
  $return = $request;

  $imagens = DB::query("
    SELECT
      imoveis_imagens.padrao,
      imoveis_imagens.imovel,
      imoveis_imagens.legenda,
      imoveis_imagens.arquivo
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

  return $return;
}

function get_caracteristicas($ids, $request){
  $return = $request;

  $caracteristicas = DB::query("
    SELECT
      imoveis_caracteristicas.imovel,
      imoveis_caracteristicas.caracteristica,
      caracteristicas.nome_vivareal
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
      $return[$caracteristica['imovel']]['caracteristicas'][] = $caracteristica['nome_vivareal'];
    }
  }

  return $return;
}

function get_imoveis() {
  $return = array();
  $imoveis_ids = array();

  $query = "
    SELECT
      tb_imoveis.*,
      tb_tipos_de_imoveis.nome as tipo_de_imovel_nome,
      tb_tipos_de_imoveis.slug AS tipo_de_imovel,
      tb_tipos_de_imoveis.slug_ingles AS tipo_de_imovel_ingles,
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
      tb_imoveis.status = 1
    AND
      (
        (
          tb_imoveis.mapa_latitude != 0.00000000
        AND
          tb_imoveis.mapa_longitude != 0.00000000
        )
      OR
        (
          tb_imoveis.logradouro != ''
        AND
          tb_imoveis.numero != ''
        )
      )
  ";

  $imoveis = DB::query($query);

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


function print_l($array = array()){
  if($array){
    echo '<pre>' . print_r($array, true) . '</pre>';
  }
}

function correct_encoding($text) {
    $current_encoding = mb_detect_encoding($text, 'auto');
    $text = iconv($current_encoding, 'UTF-8', $text);
    return $text;
}

function limpa_texto($string = '') {
  return correct_encoding(trim(strip_tags($string)));
  //return correct_encoding(trim(strip_tags(html_entity_decode($string))));
}


$array = array();

$imoveis = get_imoveis();

if(isset($_GET['dev']) && $_GET['dev'] == 1){
  print_l($imoveis);
  exit;
}

header('Content-Type: text/xml; charset=utf-8');

if($imoveis){
  ?>
  <ListingDataFeed xmlns="http://www.vivareal.com/schemas/1.0/VRSync"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.vivareal.com/schemas/1.0/VRSync  http://xml.vivareal.com/vrsync.xsd">
    <Header>
      <Provider><![CDATA[<?php echo 'Mediz Imóveis'; ?>]]></Provider>
      <Email><![CDATA[marcos@medizimoveis.com.br]]></Email>
    </Header>
    <Listings>
      <?php
      foreach($imoveis as $imovel){
        $locationView = 'All';

        $permalink_url = 'http://www.medizimoveis.com.br';
        $permalink = $permalink_url . '/imoveis-a-venda/' . $imovel['cidade'] . '/' . $imovel['bairro'] . '/' . $imovel['tipo_de_imovel'] . '/' . $imovel['id'] . '/';
        if(!empty($imovel['permalink'])){
          $permalink = $permalink_url . '/' . $imovel['permalink'];
          $permalink = str_replace('-id-' . $imovel['id'], '', $permalink);
          $permalink .= '-id-' . $imovel['id'];
        }

        // Tipo de imóvel
        $areaTag = 'LivingArea';
        if(in_array($imovel['tipo_de_imovel'], array('galpao'))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Commercial / Industrial';
        }else if(in_array($imovel['tipo_de_imovel'], array('salao-salas'))){
          $tipoImovel = 'Commercial / Office';
        }else if(in_array($imovel['tipo_de_imovel'], array('imovel-comercial','imovel-industrial'))){
          $tipoImovel = 'Commercial / Building';
        }else if(in_array($imovel['tipo_de_imovel'], array('apartamento','lancamentos-e-plantoes'))){
          $tipoImovel = 'Residential / Apartment';
        }else if(in_array($imovel['tipo_de_imovel'], array('sobrado'))){
          $tipoImovel = 'Residential / Sobrado';
        }else if(in_array($imovel['tipo_de_imovel'], array('casa'))){
          $tipoImovel = 'Residential / Home';
        }else if(in_array($imovel['tipo_de_imovel'], array('chacara', 'sitio', 'fazenda', ))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Commercial / Agricultural';
        }else if(in_array($imovel['tipo_de_imovel'], array('terreno'))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Residential / Land Lot';
        }else if(in_array($imovel['tipo_de_imovel'], array('area-comercial','area-industrial'))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Commercial / Land Lot';
        }else{
          $tipoImovel = 'Residential / Home';
        }
        ?>
          <Listing>
            <ListingID><![CDATA[<?php echo $imovel["id"]; ?>]]></ListingID>
            <Title><![CDATA[<?php echo limpa_texto($imovel["tipo_de_imovel_nome"]) . ' à venda em ' . limpa_texto($imovel["bairro_nome"]); ?>]]></Title>
            <TransactionType>For Sale</TransactionType>
            <DetailViewUrl><![CDATA[<?php echo $permalink; ?>]]></DetailViewUrl>
            <?php
            if(isset($imovel['imagens']) && !empty($imovel['imagens'])){
              ?>
              <Media>
                <?php
                foreach ($imovel['imagens'] as $imagem) {
                  ?>
                  <Item medium="image" caption="<?php echo limpa_texto($imagem['legenda']); ?>"<?php echo $imagem['padrao'] == 1 ? ' primary="true"' : ''; ?>><?php echo 'http://www.medizimoveis.com.br/uploads/imoveis/'. $imovel['id'] .'/' . $imagem['arquivo']; ?></Item>
                  <?php
                }
                ?>
              </Media>
              <?php
            }
            ?>
            <Details>
              <PropertyType><?php echo $tipoImovel; ?></PropertyType>
              <Description><![CDATA[<?php echo limpa_texto($imovel["descricao"]); ?>]]></Description>
              <ListPrice currency="BRL"><?php echo number_format($imovel['valor'], 0, '', ''); ?></ListPrice>
              <?php
              if($imovel['area'] > 5){
                ?>
                <<?php echo $areaTag; ?> unit="square metres"><![CDATA[<?php echo $imovel['area']; ?>]]></<?php echo $areaTag; ?>>
                <?php
              }
              ?>
              73
              <Bedrooms><?php echo limpa_texto($imovel['dormitorios']); ?></Bedrooms>
              <Bathrooms><?php echo limpa_texto($imovel['banheiros']); ?></Bathrooms>
              <Suites><?php echo limpa_texto($imovel['suites']); ?></Suites>
              <Garage type="Parking Space"><?php echo limpa_texto($imovel['garagens']); ?></Garage>

              <?php
              if($imovel['condominio_valor'] > 0.00){
                ?>
                <PropertyAdministrationFee currency="BRL"><?php echo number_format($imovel['condominio_valor'], 0); ?></PropertyAdministrationFee>
                <?php
              }
              ?>

              <?php
              if($imovel['iptu_valor'] > 0.00){
                ?>
                <YearlyTax currency="BRL"><?php echo number_format($imovel['iptu_valor'], 0); ?></YearlyTax>
                <?php
              }
              ?>

              <?php
              if(isset($imovel['caracteristicas'])){
                ?>
                <Features>
                  <?php
                  foreach ($imovel['caracteristicas'] as $value) {
                    ?>
                    <Feature><?php echo $value; ?></Feature>
                    <?php
                  }

                  if($imovel['mobiliado'] == 1){
                    ?>
                    <Feature>Furnished</Feature>
                    <?php
                  }
                  ?>
                </Features>
                <?php
              }else{
                if($imovel['mobiliado'] == 1){
                  ?>
                  <Features>
                    <Feature>Furnished</Feature>
                  </Features>
                  <?php
                }
              }
              ?>
            </Details>


            <Location displayAddress="<?php echo $locationView; ?>">
              <Country abbreviation="BR">Brasil</Country>
              <State abbreviation="<?php echo limpa_texto($imovel['estado_sigla']); ?>"><?php echo limpa_texto($imovel['estado_nome']); ?></State>
              <City><?php echo limpa_texto($imovel['cidade_nome']); ?></City>
              <Neighborhood><?php echo limpa_texto($imovel['bairro_nome']); ?></Neighborhood>
              <?php
              if($imovel['zona'] != 0){
                ?>
                <Zone><?php echo $imovel['zona_nome']; ?></Zone>
                <?php
              }
              ?>
              <?php
              if($imovel['logradouro'] != null){
                ?>
                <Address><?php echo $imovel['logradouro']; ?></Address>
                <?php
                if($imovel['numero'] != null){
                  ?>
                  <StreetNumber><?php echo $imovel['numero']; ?></StreetNumber>
                  <?php
                }
              }
              ?>
              <?php
              if($imovel['mapa_latitude'] != 0.00000000 && $imovel['mapa_longitude'] != 0.00000000){
                ?>
                <Latitude><![CDATA[<?php echo $imovel['mapa_latitude']; ?>]]></Latitude>
                <Longitude><![CDATA[<?php echo $imovel['mapa_longitude']; ?>]]></Longitude>
                <?php
              }
              ?>
            </Location>

            <ContactInfo>
              <Name><![CDATA[<?php echo 'Mediz Imóveis'; ?>]]></Name>
              <Email><![CDATA[marcos@medizimoveis.com.br]]></Email>
            </ContactInfo>
          </Listing>
        <?php
      }
      ?>
    </Listings>
  </ListingDataFeed>
  <?php
}
?>
