<?php
// print_l($properties['results']);
// exit;
if(isset($properties['results']) && !empty($properties['results'])){
  ?>
  <ads>
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
    ?>
    <ad>
      <id><![CDATA[<?php echo $property["id"]; ?>]]></id>
      <url><![CDATA[<?php echo $property['imovel_permalink']; ?>]]></url>
      <title><![CDATA[<?php echo correct_encoding($property_title); ?>]]></title>
      <content><![CDATA[<?php echo correct_encoding($property["descricao"]); ?>]]></content>
      <type><![CDATA[for sale]]></type>
      <property_type><![CDATA[<?php echo $property['tipo_slug_ingles']; ?>]]></property_type>
      <address><![CDATA[<?php echo correct_encoding($property['endereco_logradouro'] . ($property['endereco_numero'] != null ? ', ' . $property['endereco_numero'] : '') . ($property['endereco_complemento'] != null ? ' - ' . $property['endereco_complemento'] : '')); ?>]]></address>
      <region><![CDATA[<?php echo correct_encoding($property['endereco_estado']); ?>]]></region>
      <city><![CDATA[<?php echo correct_encoding($property['endereco_cidade']); ?>]]></city>
      <city_area><![CDATA[<?php echo correct_encoding($property['endereco_bairro']); ?>]]></city_area>
      <postcode><![CDATA[<?php echo correct_encoding($property['endereco_cep']); ?>]]></postcode>
      <country><![CDATA[Brasil]]></country>
      <?php
      if($property['endereco_latitude'] != 0.00000000 && $property['endereco_longitude'] != 0.00000000){
        ?>
        <latitude><![CDATA[<?php echo $property['endereco_latitude']; ?>]]></latitude>
        <longitude><![CDATA[<?php echo $property['endereco_longitude']; ?>]]></longitude>
        <?php
      }
      ?>

      <?php
      if(!empty($property['area_util'])){
        ?>
        <floor_area><![CDATA[<?php echo $property['area_util']; ?>]]></floor_area>
        <?php
      }
      ?>

      <?php
      if(isset($property['imagens']) && !empty($property['imagens'])){
        ?>
        <pictures>
          <?php
          foreach ($property['imagens'] as $imagem) {
            ?>
            <picture featured="true">
              <picture_url><?php echo base_url('assets/uploads/imoveis/'. $property['id'] .'/' . $imagem['arquivo']); ?></picture_url>
              <picture_title><![CDATA[<?php echo correct_encoding($imagem['legenda']); ?>]]></picture_title>
            </picture>
            <?php
          }
          ?>
        </pictures>
        <?php
      }
      ?>

      <agency>
        <id><![CDATA[1]]></id>
        <name><![CDATA[<?php echo 'Mediz Imóveis'; ?>]]></name>
        <phone><![CDATA[11-3902-7180]]></phone>
        <email><![CDATA[marcos@medizimoveis.com.br]]></email>
        <address><![CDATA[<?php echo correct_encoding('Rua Durval Fernandes Chaves, 188'); ?>]]></address>
        <city_area><![CDATA[<?php echo correct_encoding('Jd. Santo Elias'); ?>]]></city_area>
        <city><![CDATA[<?php echo ('São Paulo'); ?>]]></city>
        <region><![CDATA[<?php echo correct_encoding('SP'); ?>]]></region>
        <country><![CDATA[<?php echo correct_encoding('Brasil'); ?>]]></country>
      </agency>

      <price currency="BRL"><![CDATA[<?php echo number_format($property['valor_real'], 0, '', ''); ?>]]></price>

      <?php
      if($property['dormitorios']){
        ?>
        <bedrooms><?php echo correct_encoding($property['dormitorios']); ?></bedrooms>
        <?php
      }
      ?>

      <?php
      if($property['banheiros']){
        ?>
        <bathrooms><?php echo correct_encoding($property['banheiros']); ?></bathrooms>
        <?php
      }
      ?>

      <?php
      if($property['garagens']){
        ?>
        <parking><?php echo correct_encoding($property['garagens']); ?></parking>
        <?php
      }
      ?>
    </ad>
    <?php
  }
  ?>
  </ads>
  <?php
}
?>
