<?php
if(isset($properties['results']) && !empty($properties['results'])){
  ?>
  <ListingDataFeed xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://dev-test.mercadolibre.com/apps/validator.xsd">
    <imoveis>
      <email>marcos@medizimoveis.com.br</email>
      <?php
      foreach($properties['results'] as $property){
        $property_title = array();
        $property_title[] = $property['tipo'] . ' à ' . strtolower($property['transacao']);
        if($property['area_util']){
          $property_title[] = $property['area_util'] . ' m²';
        }
        if($property['dormitorios']){
          $property_title[] = ($property['dormitorios'] == 1 ? '1 quarto' : $property['dormitorios'] . ' quartos');
        }
        if($property['banheiros']){
          $property_title[] = ($property['banheiros'] == 1 ? '1 banheiro' : $property['banheiros'] . ' banheiros');
        }
        if($property['suites']){
          $property_title[] = ($property['suites'] == 1 ? '1 suíte' : $property['suites'] . ' suítes');
        }
        if(!empty($property_title)){
          $property_title = implode(', ', $property_title);
        }else{
          $property_title = $proeprty['referencia'];
        }

        // Tipo de imóvel
        if(in_array($property['tipo_slug'], array('galpao'))){
          $tipoImovel = 'Galpões > Venda';
        }else if(in_array($property['tipo_slug'], array('salao-salas'))){
          $tipoImovel = 'Salas Comerciais > Venda';
        }else if(in_array($property['tipo_slug'], array('imovel-comercial'))){
          $tipoImovel = 'Lojas Comerciais > Venda';
        }else if(in_array($property['tipo_slug'], array('imovel-industrial'))){
          $tipoImovel = 'Galpões > Venda';
        }else if(in_array($property['tipo_slug'], array('apartamento','lancamentos-e-plantoes'))){
          $tipoImovel = 'Apartamentos > Venda';
        }else if(in_array($property['tipo_slug'], array('sobrado'))){
          $tipoImovel = 'Casas > Venda';
        }else if(in_array($property['tipo_slug'], array('casa'))){
          $tipoImovel = 'Casas > Venda';
        }else if(in_array($property['tipo_slug'], array('chacara'))){
          $tipoImovel = 'Chácaras > Venda';
        }else if(in_array($property['tipo_slug'], array('sitio'))){
          $tipoImovel = 'Sítios > Venda';
        }else if(in_array($property['tipo_slug'], array('fazenda'))){
          $tipoImovel = 'Fazendas > Venda';
        }else if(in_array($property['tipo_slug'], array('terreno'))){
          $tipoImovel = 'Terrenos > Venda';
        }else{
          $tipoImovel = 'Outros Imóveis > Venda';
        }
        ?>
        <imovel>
          <imovelId><![CDATA[<?php echo $property["id"]; ?>]]></imovelId>
          <title><![CDATA[<?php echo correct_encoding($property_title); ?>]]></title>
          <category><?php echo $tipoImovel; ?></category>
          <price><?php echo number_format($property['valor_real'], 0, '', ''); ?></price>
          <listingType>silver</listingType>
          <?php
          if(isset($property['imagens']) && !empty($property['imagens'])){
            ?>
            <pictures>
              <?php
              foreach ($property['imagens'] as $imagem) {
                ?>
                <imageURL><?php echo base_url('assets/uploads/imoveis/'. $property['id'] .'/' . $imagem['arquivo']); ?></imageURL>
                <?php
              }
              ?>
            </pictures>
            <?php
          }
          ?>

          <sellerContact>
            <contact>Mediz Imóveis</contact>
            <areaCode>11</areaCode>
            <phone>(11) 3902-7180</phone>
            <email>marcos@medizimoveis.com.br</email>
            <webpage>http://www.medizimoveis.com.br</webpage>
          </sellerContact>

          <location>
            <?php
            if(isset($property['endereco_logradouro']) && $property['endereco_logradouro'] != null){
              ?>
              <addressLine><?php echo $property['endereco_logradouro'];
              if($property['endereco_numero'] != null){
                ?>
                , <?php echo $property['endereco_numero']; ?>
                <?php
              }
              ?></addressLine><?php
            }
            ?>

            <zipCode><?php echo correct_encoding($property['endereco_cep']); ?></zipCode>
            <neighborhood><?php echo correct_encoding($property['endereco_bairro']); ?></neighborhood>
            <city><?php echo correct_encoding($property['endereco_cidade']); ?></city>
            <state><?php echo correct_encoding($property['endereco_estado']); ?></state>
            <country>Brasil</country>
            <?php
            if($property['endereco_latitude'] != 0.00000000 && $property['endereco_longitude'] != 0.00000000){
              ?>
              <Latitude><![CDATA[<?php echo $property['endereco_latitude']; ?>]]></Latitude>
              <Longitude><![CDATA[<?php echo $property['endereco_longitude']; ?>]]></Longitude>
              <?php
            }
            ?>
          </location>

          <attributes>
            <?php
            if($property['dormitorios']){
              ?>
              <attribute>
                <name>Quartos</name>
                <value><?php echo correct_encoding($property['dormitorios']); ?></value>
              </attribute>
              <?php
            }
            ?>

            <?php
            if($property['banheiros']){
              ?>
              <attribute>
                <name>Banheiros</name>
                <value><?php echo correct_encoding($property['banheiros']); ?></value>
              </attribute>
              <?php
            }
            ?>

            <?php
            if($property['suites']){
              ?>
              <attribute>
                <name>Suítes</name>
                <value><?php echo correct_encoding($property['suites']); ?></value>
              </attribute>
              <?php
            }
            ?>

            <?php
            if($property['garagens']){
              ?>
              <attribute>
                <name>Garagens</name>
                <value><?php echo correct_encoding($property['garagens']); ?></value>
              </attribute>
              <?php
            }
            ?>

            <?php
            if(isset($property['caracteristicas'])){
              foreach ($property['caracteristicas'] as $caracteristica) {
                ?>
                <attribute>
                  <name><?php echo $caracteristica['nome']; ?></name>
                  <value>1</value>
                </attribute>
                <?php
              }
            }
            ?>
          </attributes>
          <description><![CDATA[<?php echo correct_encoding($property["descricao"]); ?>]]></description>
        </imovel>
        <?php
      }
      ?>
    </imoveis>
  </ListingDataFeed>
  <?php
}
?>
