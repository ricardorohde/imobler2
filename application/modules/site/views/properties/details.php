<section id="section-body"
data-property_latitude="<?php echo $property['endereco_latitude']; ?>"
data-property_longitude="<?php echo $property['endereco_longitude']; ?>">
<div class="detail-top detail-top-grid no-margin">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <div class="header-detail table-list">
          <div class="header-left">
            <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a></li>
              <li><a href="<?php echo base_url($property['transacao_slug']); ?>"><?php echo $property['transacao']; ?></a></li>
              <li><a href="<?php echo base_url($property['transacao_slug'] . '/' . strtolower($property['endereco_estado'])); ?>"><?php echo $property['endereco_estado']; ?></a></li>
              <li><a href="<?php echo base_url($property['transacao_slug'] . '/' . strtolower($property['endereco_estado']) . '/' . strtolower($property['endereco_cidade_slug'])); ?>"><?php echo $property['endereco_cidade']; ?></a></li>
              <li><a href="<?php echo base_url($property['transacao_slug'] . '/' . strtolower($property['endereco_estado']) . '/' . $property['endereco_cidade_slug'] . '/' . $property['endereco_bairro_slug']); ?>"><?php echo $property['endereco_bairro']; ?></a></li>
              <li><a href="<?php echo base_url($property['transacao_slug'] . '/' . strtolower($property['endereco_estado']) . '/' . $property['endereco_cidade_slug'] . '/' . $property['endereco_bairro_slug'] . '/' . $property['tipo_slug']); ?>"><?php echo $property['tipo']; ?></a></li>
              <li class="active"><?php echo $property['referencia']; ?></li>
            </ol>
            <h1>
              <?php echo $property['tipo']; ?> à <?php echo strtolower($property['transacao']); ?><?php echo $property['dormitorios'] ? ' com ' . $property['dormitorios'] . ' quartos' : ''; ?><?php echo $property['area_util'] ? ', ' . $property['area_util'] . ' m²' : ''; ?>
              <span class="label-wrap hidden-sm hidden-xs">
                <!--span class="label label-primary"><?php echo $property['transacao']; ?></span-->
                <?php
                if($property['destaque']){
                  ?><span class="label label-danger">Destaque</span><?php
                }
                ?>
                <?php
                if($property['lancamento']){
                  ?><span class="label label-warning">Lançamento</span><?php
                }
                ?>
              </span>
            </h1>
            <address class="property-address"><?php echo $property['endereco_label']; ?></address>
          </div>
          <div class="header-right">
            <ul class="actions">
              <li class="share-btn">
                <div class="share_tooltip tooltip_left fade">
                  <a class="share-item" href="http://www.facebook.com/share.php?u=<?php echo $property['imovel_permalink']; ?>&title=<?php echo $property['tipo']; ?><?php echo $property['dormitorios'] ? ' com ' . $property['dormitorios'] . ' quartos' : ''; ?> para <?php echo $property['transacao']; ?> em <?php echo $property['endereco_bairro']; ?><?php echo $property['area_util'] ? ', ' . $property['area_util'] . ' m²' : ''; ?>"><i class="fa fa-facebook"></i></a>
                  <a class="share-item" href="http://twitter.com/intent/tweet?status=<?php echo $property['tipo']; ?><?php echo $property['dormitorios'] ? ' com ' . $property['dormitorios'] . ' quartos' : ''; ?> para <?php echo $property['transacao']; ?> em <?php echo $property['endereco_bairro']; ?><?php echo $property['area_util'] ? ', ' . $property['area_util'] . ' m²' : ''; ?>. Acesse <?php echo $property['imovel_permalink']; ?>"><i class="fa fa-twitter"></i></a>
                  <a class="share-item" href="https://plus.google.com/share?url=<?php echo $property['imovel_permalink']; ?>"><i class="fa fa-google-plus"></i></a>
                </div>
                <span class="share-btn-item" data-placement="right" data-toggle="tooltip" data-original-title="share"><i class="fa fa-share-alt"></i></span>
              </li>
              <li>
                <span class="btn-like" data-like_status="<?php echo isset($property['imovel_favorito']) ? 'liked' : 'unliked'; ?>" data-property_id="<?php echo $property['id']; ?>"><i class="fa fa-heart-o"></i></span>
              </li>
            </ul>
            <span class="item-price">R$ <?php echo $property['valor']; ?></span>
            <?php
            if(isset($property['despesas']['iptu'])){
              ?>
              R$ <?php echo $property['despesas']['iptu']['valor']; ?>/IPTU
              <?php
            }
            ?>
            <span class="item-sub-price">

            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="section-detail-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 container-contentbar">
        <div class="detail-bar">
          <div class="detail-media detail-top-slideshow">
            <div class="tab-content">
              <?php
              if(isset($property['imagens'])){
                ?>
                <div id="gallery" class="tab-pane fade in active">
                  <div class="properties-slideshow owl-carousel owl-theme">
                    <?php
                    foreach ($property['imagens'] as $key => $image) {
                      ?>
                      <img class="owl-lazy" src="<?php echo base_url('imagens/imoveis/0/810/430/100/0/property-image.jpg'); ?>" data-src="<?php echo base_url('imagens/imoveis/' . $property['id'] . '/810/430/100/2/' . $image['arquivo']); ?>" alt="<?php echo !empty($image['legenda']) ? $image['legenda'] : $property['tipo'] . ' à ' . strtolower($property['transacao']) . ($property['dormitorios'] ? ' com ' . $property['dormitorios'] . ($property['dormitorios'] == 1 ? ' quarto' : ' quartos') : '') . ($property['area_util'] ? ', ' . $property['area_util'] . ' m²' : '') . ' - ' . $property['endereco_bairro']; ?>">
                      <?php
                    }
                    ?>
                  </div>
                </div>
                <?php
              }
              ?>
              <div id="map" class="tab-pane fade <?php echo !isset($property['imagens']) ? 'active in' : ''?>"></div>
              <div id="street-map" class="tab-pane fade"></div>
            </div>
            <div class="media-tabs">
              <ul class="media-tabs-list">
                <?php
                if(isset($property['imagens'])){
                  ?>
                  <li class="popup-trigger active" data-placement="bottom" data-toggle="tooltip" data-original-title="View Photos">
                    <a href="#gallery" data-toggle="tab">
                      <i class="fa fa-camera"></i>
                    </a>
                  </li>
                  <?php
                }
                ?>
                <li class="<?php echo !isset($property['imagens']) ? 'active' : ''?>" data-placement="bottom" data-toggle="tooltip" data-original-title="Map View">
                  <a href="#map" data-toggle="tab">
                    <i class="fa fa-map"></i>
                  </a>
                </li>
                <li data-placement="bottom" data-toggle="tooltip" data-original-title="Street View">
                  <a href="#street-map" data-toggle="tab">
                    <i class="fa fa-street-view"></i>
                  </a>
                </li>
              </ul>
              <ul class="actions">
                <li class="share-btn">
                  <div class="share_tooltip tooltip_left fade">
                    <a class="share-item" href="http://www.facebook.com/share.php?u=<?php echo $property['imovel_permalink']; ?>&title=<?php echo $property['tipo']; ?><?php echo $property['dormitorios'] ? ' com ' . $property['dormitorios'] . ' quartos' : ''; ?> para <?php echo $property['transacao']; ?> em <?php echo $property['endereco_bairro']; ?><?php echo $property['area_util'] ? ', ' . $property['area_util'] . ' m²' : ''; ?>"><i class="fa fa-facebook"></i></a>
                    <a class="share-item" href="http://twitter.com/intent/tweet?status=<?php echo $property['tipo']; ?><?php echo $property['dormitorios'] ? ' com ' . $property['dormitorios'] . ' quartos' : ''; ?> para <?php echo $property['transacao']; ?> em <?php echo $property['endereco_bairro']; ?><?php echo $property['area_util'] ? ', ' . $property['area_util'] . ' m²' : ''; ?>. Acesse <?php echo $property['imovel_permalink']; ?>"><i class="fa fa-twitter"></i></a>
                    <a class="share-item" href="https://plus.google.com/share?url=<?php echo $property['imovel_permalink']; ?>"><i class="fa fa-google-plus"></i></a>
                  </div>
                  <span class="share-btn-item" data-placement="top" data-toggle="tooltip" data-original-title="share"><i class="fa fa-share-alt"></i></span>
                </li>
                <li>
                  <span class="btn-like" data-like_status="<?php echo isset($property['imovel_favorito']) ? 'liked' : 'unliked'; ?>" data-property_id="<?php echo $property['id']; ?>"><i class="fa fa-heart-o"></i></span>
                </li>
              </ul>
            </div>
          </div>

          <div class="property-description detail-block">
            <div class="detail-title">
              <h2 class="title-left">Descrição</h2>
              <div class="title-right">
                <a href="javascript: void(0);" class="link-like" data-like_status="<?php echo isset($property['imovel_favorito']) ? 'liked' : 'unliked'; ?>" data-property_id="<?php echo $property['id']; ?>">Adicionar aos favoritos <i class="fa fa-heart"></i></a>
              </div>
            </div>
            <div class="text-justify"><?php echo nl2br($property['descricao']); ?></div>
          </div>

          <div class="detail-list detail-block">
              <div class="detail-title">
                  <h2 class="title-left">Detalhes do imóvel</h2>
                  <div class="title-right">
                  </div>
              </div>
              <ul class="list-three-col">
                  <?php
                  $caracteristicas = array(
                    array('dormitorios', 'quarto', 'quartos', '%dormitorios% %caracteristica%'),
                    array('suites', 'suíte', 'suites', '%suites% %caracteristica%'),
                    array('banheiros', 'banheiro', 'banheiros', '%banheiros% %caracteristica%'),
                    array('salas', 'sala', 'salas', '%salas% %caracteristica%'),
                    array('garagens', 'garagem', 'garagens', '%garagens% %caracteristica%'),
                    array('varandas', 'varanda', 'varandas', '%varandas% %caracteristica%'),
                    array('idade', 'ano', 'anos', '%idade% %caracteristica%'),
                    array('area_util', 'área útil ', 'área útil', '%area_util% m² %caracteristica%'),
                    array('area_total', 'área total ', 'área total', '%area_total% m² %caracteristica%'),
                    array('condominio', '', '', 'Condomínio fechado'),
                    array('mobiliado', '', '', 'Mobiliado'),
                    array('ocupado', '', '', 'Ocupado'),
                  );

                  foreach ($caracteristicas as $key => $value) {
                    if($property[$value[0]]) {
                      ?><li><?php echo str_replace('%caracteristica%', ($property[$value[0]] == 1 ? $value[1] : $value[2]), str_replace('%'. $value[0] .'%', $property[$value[0]], $value[3]) . (isset($value[4]) ? $value[4] : '')); ?></li><?php
                    }
                  }
                  ?>
              </ul>
          </div>

          <?php
          if(isset($property['caracteristicas'])){
              ?>
              <div class="detail-features detail-block">
                  <div class="detail-title">
                      <h2 class="title-left">Características</h2>
                  </div>
                  <ul class="list-three-col list-features">
                      <?php
                      foreach ($property['caracteristicas'] as $key => $feature) {
                          ?>
                          <li><i class="fa fa-check"></i><?php echo $feature['nome']; ?></li>
                          <?php
                      }
                      ?>
                  </ul>
              </div>
              <?php
          }
          ?>

          <div class="detail-address detail-block">
            <div class="detail-title">
              <h2 class="title-left">Localização</h2>
            </div>
            <ul class="list-two-col">
              <?php
              $endereco_fields = array(
                'endereco_logradouro' => 'Endereço',
                'endereco_bairro' => 'Bairro',
                'endereco_estado' => 'UF',
                'endereco_numero' => 'Número',
                'endereco_complemento' => 'Complemento',
                'endereco_cidade' => 'Cidade',
                'endereco_cep' => 'CEP',
              );
              foreach ($endereco_fields as $key => $value) {
                if(isset($property[$key]) && !empty($property[$key])){
                  ?>
                  <li><strong><?php echo $value; ?>:</strong> <?php echo $property[$key]; ?></li>
                  <?php
                }
              }
              ?>
            </ul>
          </div>

          <div id="entre-em-contato" class="detail-contact detail-block">
              <div class="detail-title">
                  <h2 class="title-left">Saiba mais sobre este imóvel</h2>
              </div>
              <?php $this->load->view('site/includes/alertas', $this->_ci_cached_vars); ?>
              <form id="property_contact_form" method="post" action="<?php echo $property['imovel_permalink']; ?>">
                <input type="hidden" name="imovel_id" value="<?php echo $property['id']; ?>">
                  <div class="row">
                      <div class="col-sm-4 col-xs-12">
                          <div class="form-group">
                            <input class="form-control" type="text" placeholder="Nome" title="Preencha o nome" name="nome" id="nome" value="<?php echo $this->input->post('nome'); ?>" required>
                          </div>
                      </div>
                      <div class="col-sm-4 col-xs-12">
                          <div class="form-group">
                              <input class="form-control phone-mask" placeholder="Telefone" type="text" name="telefone" id="telefone" value="<?php echo $this->input->post('telefone'); ?>">
                          </div>
                      </div>
                      <div class="col-sm-4 col-xs-12">
                          <div class="form-group">
                              <input class="form-control" placeholder="E-mail" type="email" name="email" id="email" value="<?php echo $this->input->post('email'); ?>">
                          </div>
                      </div>
                      <div class="col-sm-12 col-xs-12">
                          <div class="form-group">
                              <textarea class="form-control" name="mensagem" rows="4" placeholder="Mensagem" id="mensagem" required><?php echo $this->input->post('mensagem') ? $this->input->post('mensagem') : 'Olá, tenho interesse neste imóvel: '. $property['tipo'] .' à '. $property['transacao'] .' em '. $property['endereco_bairro'] .', '. $property['area_util'] .'m². Referência '. $property['referencia'] .' Aguardo o contato. Obrigado.'; ?></textarea>
                          </div>
                      </div>
                  </div>
                  <button class="btn btn-secondary">Enviar</button>
              </form>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 col-md-offset-0 col-sm-offset-3 container-sidebar">
        <aside id="sidebar">
            <?php
            if(isset($property['despesas'])){
                ?>
                <div class="widget widget-download">
                    <div class="widget-top">
                        <h3 class="widget-title">Demais despesas</h3>
                    </div>
                    <div class="widget-body">
                        <ul>
                            <?php
                            foreach ($property['despesas'] as $key => $despesa) {
                                ?>
                                <li>
                                    <div class="pull-left">
                                        <?php echo $despesa['tipo']; ?>
                                    </div>
                                    <div class="pull-right">
                                        <strong>R$ <?php echo number_format($despesa['valor'], 2, ',', '.'); ?></strong>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if(isset($recommended['results']) && !empty($recommended['results'])){
                ?>
                <div class="widget widget-recommend">
                    <div class="widget-top">
                        <h3 class="widget-title">Mais <?php echo strtolower($property['tipo_plural']); ?> em <?php echo $property['endereco_bairro']; ?></h3>
                    </div>
                    <div class="widget-body">
                        <?php
                        foreach ($recommended['results'] as $key => $property_recomended) {
                            ?>
                            <div class="media">
                                <div class="media-left">
                                      <?php
                                      $property_recomended_image_id = 0;
                                      $property_recomended_image_arquivo = 'property-image.jpg';
                                      if(isset($property_recomended['imagens'][0])){
                                        $property_recomended_image_id = $property_recomended['id'];
                                        $property_recomended_image_arquivo = $property_recomended['imagens'][0]['arquivo'];
                                      }
                                      ?>
                                    <figure class="item-thumb">
                                      <a href="<?php echo $property_recomended['imovel_permalink']; ?>" class="hover-effect">
                                        <img src="<?php echo base_url('imagens/imoveis/' . $property_recomended_image_id . '/100/75/100/0/' . $property_recomended_image_arquivo); ?>" width="100" height="75" alt="" />
                                      </a>
                                    </figure>
                                </div>
                                <div class="media-body">
                                    <h3 class="media-heading">
                                      <a href="<?php echo $property_recomended['imovel_permalink']; ?>">
                                        <?php
                                        $property_recomended_descricao = array();

                                        if($property_recomended['dormitorios']){
                                          $property_recomended_descricao[] = ($property_recomended['dormitorios'] == 1 ? '1 quarto' : $property_recomended['dormitorios'] . ' quartos');
                                        }

                                        if($property_recomended['area_util']){
                                          $property_recomended_descricao[] = $property_recomended['area_util'] . ' m²';
                                        }

                                        if($property_recomended['suites']){
                                          $property_recomended_descricao[] = ($property_recomended['suites'] == 1 ? '1 suíte' : $property_recomended['suites'] . ' suítes');
                                        }

                                        if(!empty($property_recomended_descricao)){
                                          echo implode(', ', $property_recomended_descricao);
                                        }else{
                                          $proeprty['referencia'];
                                        }
                                        ?>
                                      </a>
                                    </h3>
                                    <h4>R$ <?php echo $property_recomended['valor']; ?></h4>
                                    <div class="amenities">
                                        <p>
                                          <?php echo $property_recomended['referencia']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            if(isset($featured['results']) && !empty($featured['results'])){
                ?>
                <div class="widget widget-recommend">
                    <div class="widget-top">
                        <h3 class="widget-title"><?php echo $property['tipo_plural']; ?> em destaque</h3>
                    </div>
                    <div class="widget-body">
                        <?php
                        foreach ($featured['results'] as $key => $property_featured) {
                            ?>
                            <div class="media">
                                <div class="media-left">
                                      <?php
                                      $property_featured_image_id = 0;
                                      $property_featured_image_arquivo = 'property-image.jpg';
                                      if(isset($property_featured['imagens'][0])){
                                        $property_featured_image_id = $property_featured['id'];
                                        $property_featured_image_arquivo = $property_featured['imagens'][0]['arquivo'];
                                      }
                                      ?>
                                    <figure class="item-thumb">
                                      <a href="<?php echo $property_featured['imovel_permalink']; ?>" class="hover-effect">
                                        <img src="<?php echo base_url('imagens/imoveis/' . $property_featured_image_id . '/100/75/100/0/' . $property_featured_image_arquivo); ?>" width="100" height="75" alt="" />
                                      </a>
                                    </figure>
                                </div>
                                <div class="media-body">
                                    <h3 class="media-heading">
                                      <a href="<?php echo $property_featured['imovel_permalink']; ?>">
                                        <?php
                                        $property_featured_descricao = array();

                                        if($property_featured['dormitorios']){
                                          $property_featured_descricao[] = ($property_featured['dormitorios'] == 1 ? '1 quarto' : $property_featured['dormitorios'] . ' quartos');
                                        }

                                        if($property_featured['area_util']){
                                          $property_featured_descricao[] = $property_featured['area_util'] . ' m²';
                                        }

                                        if($property_featured['suites']){
                                          $property_featured_descricao[] = ($property_featured['suites'] == 1 ? '1 suíte' : $property_featured['suites'] . ' suítes');
                                        }

                                        if(!empty($property_featured_descricao)){
                                          echo implode(', ', $property_featured_descricao);
                                        }else{
                                          $proeprty['referencia'];
                                        }
                                        ?>
                                      </a>
                                    </h3>
                                    <h4>R$ <?php echo $property_featured['valor']; ?></h4>
                                    <div class="amenities">
                                        <p>
                                          <?php echo $property_featured['referencia']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if(isset($campaigns['results']) && !empty($campaigns['results'])){
              ?>
              <div class="widget widget-categories">
                  <div class="widget-top">
                      <h3 class="widget-title">Outra sugestões</h3>
                  </div>
                  <div class="widget-body">
                      <ul>
                        <?php
                        foreach ($campaigns['results'] as $key => $campaign) {
                          ?>
                          <li><a href="<?php echo base_url($campaign['permalink']); ?>"><?php echo $campaign['titulo']; ?></a></li>
                          <?php
                        }
                        ?>
                      </ul>
                  </div>
              </div>
              <?php

            }
            ?>
          </aside>
        </div>
      </div>
    </div>
  </section>
</section>
