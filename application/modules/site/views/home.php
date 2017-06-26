<div class="header-media">
    <div class="banner-parallax banner-parallax-fix">
        <div class="banner-bg-wrap">
            <div class="banner-inner" style="background-image: url('<?php echo get_asset('img/home-banner.jpg'); ?>')"></div>
        </div>
    </div>
    <div class="banner-caption">
        <h1>Seu novo imóvel está aqui</h1>
        <h2 class="banner-sub-title">Informe o tipo e o local do imóvel que está procurando.</h2>
        <div class="banner-search-main">
            <form id="form-search-local" method="post" class="form-inline">
                <input type="hidden" id="banner-search-main-transaction" name="params[transaction][]" value="venda" />

                <div class="form-group">
                    <select class="selectpicker form-control" name="params[properties_types][]" id="banner-search-main-properties_types" title="Selecione um tipo" data-live-search="false" data-live-search-style="begins" title="Location">
                        <?php
                        if(isset($properties_types) && !empty($properties_types)){
                            foreach($properties_types as $properties_type){
                                ?>
                                <optgroup label="<?php echo $properties_type['segmento']; ?>">
                                    <?php
                                    if(isset($properties_type['tipos'])){
                                        foreach ($properties_type['tipos'] as $tipo) {
                                            ?>
                                            <option <?php echo (isset($tipo['selected']) && $tipo['selected'] ? 'selected="true"' : ''); ?> value="<?php echo $tipo['slug']; ?>"><?php echo $tipo['nome']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </optgroup>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="search input-search input-icon">
                        <input type="hidden" id="banner-search-main-state" name="params[location][0][state]" value="" />
                        <input type="hidden" id="banner-search-main-city" name="params[location][0][city]" value="">
                        <input type="hidden" id="banner-search-main-district" name="params[location][0][district]" value="">
                        <input type="text" class="form-control input-search-local" placeholder="Bairro, cidade ou referência do imóvel" autocomplete="off" />
                    </div>
                    <div class="search-btn">
                        <button class="btn btn-secondary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($featured['results']) && !empty($featured['results'])){
  ?>
  <section id="section-body">
    <div class="houzez-module-main">
      <div class="houzez-module carousel-module">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="module-title-nav clearfix">
                <div>
                  <h2>Imóveis em destaque</h2>
                </div>
                <div class="module-nav">
                  <button class="btn btn-sm btn-crl-pprt-1-prev">Anterior</button>
                  <button class="btn btn-sm btn-crl-pprt-1-next">Próximo</button>
                  <a href="<?php echo base_url('imoveis-em-destaque'); ?>" class="btn btn-carousel btn-sm">Ver todos</a>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="row grid-row">
                <div class="carousel properties-carousel-grid-1 slide-animated">
                  <?php
                  foreach ($featured['results'] as $key => $property_featured) {
                    ?>
                    <div class="item">
                      <div class="item-wrap">
                        <div class="property-item item-grid">
                          <div class="figure-block">
                            <figure class="item-thumb">
                              <div class="label-wrap hide-on-list">
                                <div class="label-status label label-default"><?php echo $property_featured['transacao']; ?></div>
                              </div>
                              <span class="label-featured label label-success">Destaque</span>
                              <div class="price hide-on-list">
                                <h3>R$ <?php echo $property_featured['valor']; ?></h3>
                              </div>
                              <?php
                              if(isset($property_featured['imagens'][0])) {
                                ?>
                                <a href="<?php echo $property_featured['imovel_permalink']; ?>" class="hover-effect"><img src="<?php echo base_url('imagens/imoveis/'. $property_featured['imagens'][0]['imovel'] .'/355/240/100/0/'. $property_featured['imagens'][0]['arquivo'] .''); ?>" width="355" height="240" alt="<?php echo $property_featured['imagens'][0]['legenda']; ?>"></a>
                                <?php
                              }
                              ?>
                              <ul class="actions">
                                <li class="share-btn">
                                  <div class="share_tooltip fade">
                                    <a class="share-item" href="http://www.facebook.com/share.php?u=<?php echo $property_featured['imovel_permalink']; ?>&title=<?php echo $property_featured['tipo']; ?><?php echo $property_featured['dormitorios'] ? ' com ' . $property_featured['dormitorios'] . ' quartos' : ''; ?> para <?php echo $property_featured['transacao']; ?> em <?php echo $property_featured['endereco_bairro']; ?><?php echo $property_featured['area_util'] ? ', ' . $property_featured['area_util'] . ' m²' : ''; ?>"><i class="fa fa-facebook"></i></a>
                                    <a class="share-item" href="http://twitter.com/intent/tweet?status=<?php echo $property_featured['tipo']; ?><?php echo $property_featured['dormitorios'] ? ' com ' . $property_featured['dormitorios'] . ' quartos' : ''; ?> para <?php echo $property_featured['transacao']; ?> em <?php echo $property_featured['endereco_bairro']; ?><?php echo $property_featured['area_util'] ? ', ' . $property_featured['area_util'] . ' m²' : ''; ?>. Acesse <?php echo $property_featured['imovel_permalink']; ?>"><i class="fa fa-twitter"></i></a>
                                    <a class="share-item" href="https://plus.google.com/share?url=<?php echo $property_featured['imovel_permalink']; ?>"><i class="fa fa-google-plus"></i></a>
                                  </div>
                                  <span class="share-btn-item" data-placement="top" data-toggle="tooltip" data-original-title="share"><i class="fa fa-share-alt"></i></span>
                                </li>
                                <li>
                                  <span class="btn-like" data-like_status="<?php echo isset($property_featured['imovel_favorito']) ? 'liked' : 'unliked'; ?>" data-property_id="<?php echo $property_featured['id']; ?>"><i class="fa fa-heart"></i></span>
                                </li>
                              </ul>
                            </figure>
                          </div>
                          <div class="item-body">

                            <div class="body-left">
                              <div class="info-row">
                                <div class="rating">
                                  <span class="bottom-ratings"><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span class="fa fa-star-o"></span><span style="width: 70%" class="top-ratings"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></span></span>
                                  <span class="star-text-right">15 Ratings</span>
                                </div>
                                <h2 class="property-title"><a href="<?php echo $property_featured['imovel_permalink']; ?>"><?php echo $property_featured['tipo']; ?> à <?php echo strtolower($property_featured['transacao']); ?><?php echo $property_featured['dormitorios'] ? ' com ' . $property_featured['dormitorios'] . ' quartos' : ''; ?><?php echo $property_featured['area_util'] ? ', ' . $property_featured['area_util'] . ' m²' : ''; ?></a></h2>
                                <h4 class="property-location"><?php echo $property_featured['endereco_label']; ?></h4>
                              </div>
                              <div class="table-list full-width info-row">
                                <div class="cell">
                                  <div class="info-row amenities">
                                    <p>
                                      <?php
                                      $caracteristicas = array(
                                        array('dormitorios', 'quarto', 'quartos', '%dormitorios% %caracteristica%'),
                                        array('banheiros', 'banheiro', 'banheiros', '%banheiros% %caracteristica%'),
                                        array('garagens', 'garagem', 'garagens', '%garagens% %caracteristica%')
                                      );

                                      foreach ($caracteristicas as $key => $value) {
                                        if($property_featured[$value[0]]) {
                                          ?><span><?php echo str_replace('%caracteristica%', ($property_featured[$value[0]] == 1 ? $value[1] : $value[2]), str_replace('%'. $value[0] .'%', $property_featured[$value[0]], $value[3]) . (isset($value[4]) ? $value[4] : '')); ?></span><?php
                                        }
                                      }
                                      ?>
                                    </p>
                                  </div>
                                </div>
                                <div class="cell">
                                  <div class="phone">
                                    <a href="<?php echo $property_featured['imovel_permalink']; ?>" class="btn btn-primary">Detalhes <i class="fa fa-angle-right fa-right"></i></a>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="item-foot date hide-on-list">
                          <div class="item-foot-left">
                            <p><i class="fa fa-calendar"></i> <?php echo $property_featured['data_atualizado_formatada']; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  ?>

  <?php
  if(isset($campaigns['results']) && !empty($campaigns['results'])){
    ?>
    <div class="houzez-module-main module-white-bg">
      <div class="houzez-module module-title text-center">
        <div class="container">
          <div class="row">
            <div class="col-sm-12 col-xs-12">
              <h2>Sugestões de imóveis para você</h2>
              <h3 class="sub-heading">Veja as listas de imóveis que separamos para você</h3>
            </div>
          </div>
        </div>
      </div>
      <div id="location-modul" class="houzez-module location-module grid">
        <div class="container">
          <div class="row">
            <?php
            foreach ($campaigns['results'] as $key => $campaign) {
              ?>
              <div class="col-sm-4">
                <div class="location-block">
                  <figure>
                    <a href="<?php echo base_url($campaign['permalink']); ?>">
                      <?php
                      $imagem_arquivo = 'http://lorempixel.com/g/370/370/city/'. rand(1,10) .'/';
                      if(!empty($campaign['imagem_arquivo'])){
                        $imagem_arquivo = base_url('imagens/campanhas/' . $campaign['id'] . '/370/370/100/' . $campaign['imagem_arquivo']);
                      }
                      ?>
                      <img src="<?php echo $imagem_arquivo; ?>" width="370" height="370" alt="<?php echo $campaign['title']; ?>">
                    </a>
                    <figcaption class="location-fig-caption">
                      <h3 class="heading"><?php echo $campaign['title']; ?></h3>
                      <!-- <p class="sub-heading">30 Properties</p> -->
                    </figcaption>
                  </figure>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <?php

  }
  ?>
</section>
<!--end section page body-->
