<?php
if(isset($properties['results']) && !empty($properties['results'])){
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
      foreach($properties['results'] as $property){
        $locationView = 'All';

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
        $areaTag = 'LivingArea';
        if(in_array($property['tipo_slug'], array('galpao'))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Commercial / Industrial';
        }else if(in_array($property['tipo_slug'], array('salao-salas'))){
          $tipoImovel = 'Commercial / Office';
        }else if(in_array($property['tipo_slug'], array('imovel-comercial','imovel-industrial'))){
          $tipoImovel = 'Commercial / Building';
        }else if(in_array($property['tipo_slug'], array('apartamento','lancamentos-e-plantoes'))){
          $tipoImovel = 'Residential / Apartment';
        }else if(in_array($property['tipo_slug'], array('sobrado'))){
          $tipoImovel = 'Residential / Sobrado';
        }else if(in_array($property['tipo_slug'], array('casa'))){
          $tipoImovel = 'Residential / Home';
        }else if(in_array($property['tipo_slug'], array('chacara', 'sitio', 'fazenda', ))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Commercial / Agricultural';
        }else if(in_array($property['tipo_slug'], array('terreno'))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Residential / Land Lot';
        }else if(in_array($property['tipo_slug'], array('area-comercial','area-industrial'))){
          $areaTag = 'LotArea';
          $tipoImovel = 'Commercial / Land Lot';
        }else{
          $tipoImovel = 'Residential / Home';
        }
        ?>
          <Listing>
            <ListingID><![CDATA[<?php echo $property["id"]; ?>]]></ListingID>
            <Title><![CDATA[<?php echo correct_encoding($property_title); ?>]]></Title>
            <TransactionType>For Sale</TransactionType>
            <DetailViewUrl><![CDATA[<?php echo $property['imovel_permalink']; ?>]]></DetailViewUrl>
            <?php
            if(isset($property['imagens']) && !empty($property['imagens'])){
              ?>
              <Media>
                <?php
                foreach ($property['imagens'] as $imagem) {
                  ?>
                  <Item medium="image" caption="<?php echo correct_encoding($imagem['legenda']); ?>"<?php echo $imagem['padrao'] == 1 ? ' primary="true"' : ''; ?>><?php echo base_url('assets/uploads/imoveis/'. $property['id'] .'/' . $imagem['arquivo']); ?></Item>
                  <?php
                }
                ?>
              </Media>
              <?php
            }
            ?>
            <Details>
              <PropertyType><?php echo $tipoImovel; ?></PropertyType>
              <Description><![CDATA[<?php echo correct_encoding($property["descricao"]); ?>]]></Description>
              <ListPrice currency="BRL"><?php echo number_format($property['valor_real'], 0, '', ''); ?></ListPrice>

              <<?php echo $areaTag; ?> unit="square metres"><![CDATA[<?php echo $property['area_util']; ?>]]></<?php echo $areaTag; ?>>

              <?php
              if($property['dormitorios']){
                ?>
                <Bedrooms><?php echo correct_encoding($property['dormitorios']); ?></Bedrooms>
                <?php
              }
              ?>

              <?php
              if($property['banheiros']){
                ?>
                <Bathrooms><?php echo correct_encoding($property['banheiros']); ?></Bathrooms>
                <?php
              }
              ?>

              <?php
              if($property['suites']){
                ?>
                <Suites><?php echo correct_encoding($property['suites']); ?></Suites>
                <?php
              }
              ?>

              <?php
              if($property['garagens']){
                ?>
                <Garage type="Parking Space"><?php echo correct_encoding($property['garagens']); ?></Garage>
                <?php
              }
              ?>

              <?php
              if(isset($property['despesas']['condominio'])){
                ?>
                <PropertyAdministrationFee currency="BRL"><?php echo number_format($property['despesas']['condominio']['valor'], 0); ?></PropertyAdministrationFee>
                <?php
              }
              ?>

              <?php
              if(isset($property['despesas']['iptu'])){
                ?>
                <YearlyTax currency="BRL"><?php echo number_format($property['despesas']['iptu']['valor'], 0); ?></YearlyTax>
                <?php
              }
              ?>

              <?php
              if(isset($property['caracteristicas'])){
                ?>
                <Features>
                  <?php
                  foreach ($property['caracteristicas'] as $caracteristica) {
                    ?>
                    <Feature><?php echo $caracteristica['nome_vivareal']; ?></Feature>
                    <?php
                  }

                  if($property['mobiliado'] == 1){
                    ?>
                    <Feature>Furnished</Feature>
                    <?php
                  }
                  ?>
                </Features>
                <?php
              }else{
                if($property['mobiliado'] == 1){
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
              <State abbreviation="<?php echo correct_encoding($property['endereco_estado']); ?>"><?php echo correct_encoding($property['endereco_estado_nome']); ?></State>
              <City><?php echo correct_encoding($property['endereco_cidade']); ?></City>
              <Neighborhood><?php echo correct_encoding($property['endereco_bairro']); ?></Neighborhood>
              <?php
              if(!empty($property['endereco_zona'])){
                ?>
                <Zone><?php echo $property['endereco_zona']; ?></Zone>
                <?php
              }
              ?>
              <?php
              if(isset($property['endereco_logradouro']) && $property['endereco_logradouro'] != null){
                ?>
                <Address><?php echo $property['endereco_logradouro']; ?></Address>
                <?php
                if($property['endereco_numero'] != null){
                  ?>
                  <StreetNumber><?php echo $property['endereco_numero']; ?></StreetNumber>
                  <?php
                }
              }
              ?>
              <?php
              if($property['endereco_latitude'] != 0.00000000 && $property['endereco_longitude'] != 0.00000000){
                ?>
                <Latitude><![CDATA[<?php echo $property['endereco_latitude']; ?>]]></Latitude>
                <Longitude><![CDATA[<?php echo $property['endereco_longitude']; ?>]]></Longitude>
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
