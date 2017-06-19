<div class="header-media">
    <div class="banner-parallax banner-parallax-fix">
        <div class="banner-bg-wrap">
            <div class="banner-inner" style="background-image: url('http://placehold.it/2000x1440')"></div>
        </div>
    </div>
    <div class="banner-caption">
        <h1>Welcome To Miami Beach</h1>
        <h2 class="banner-sub-title">Parallax banner with search and image</h2>
        <div class="banner-search-main">
            <form id="form-search-local" method="post" class="form-inline">
                <input type="text" id="banner-search-main-transaction" name="params[transaction][]" value="venda" />

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
                        <input type="text" id="banner-search-main-state" name="params[location][0][state]" value="" />
                        <input type="text" id="banner-search-main-city" name="params[location][0][city]" value="">
                        <input type="text" id="banner-search-main-district" name="params[location][0][district]" value="">

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
                              if(isset($property_featured['imagens'])){
                                ?>
                                <a href="<?php echo $property_featured['imovel_permalink']; ?>" class="hover-effect">
                                  <img src="http://placehold.it/355x240" alt="thumb">
                                </a>
                                <?php
                              }
                              ?>

                              <div class="property-featured-images owl-carousel owl-theme">
                                <?php

                                  foreach ($property_featured['imagens'] as $key => $imagem) {
                                    ?>
                                    <a href="" class="hover-effect"><img class="owl-lazy" src="<?php echo base_url('imagens/imoveis/0/355/240/90/0/property-image.jpg'); ?>" data-src="<?php echo base_url('imagens/imoveis/0/355/240/90/0/property-image.jpg');//base_url('imagens/imoveis/'. $imagem['imovel'] .'/355/240/100/0/'. $imagem['arquivo'] .''); ?>" width="355" height="240" alt="<?php echo $imagem['legenda']; ?>"></a>
                                    <?php
                                  }
                                }
                                ?>
                              </div>
                              <ul class="actions">
                                <li class="share-btn">
                                  <div class="share_tooltip fade">
                                    <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                    <a href="#"  target="_blank"><i class="fa fa-google-plus"></i></a>
                                    <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                  </div>
                                  <span data-toggle="tooltip" data-placement="top" title="share"><i class="fa fa-share-alt"></i></span>
                                </li>
                                <li>
                                  <span data-toggle="tooltip" data-placement="top" title="Favorite">
                                    <i class="fa fa-heart-o"></i>
                                  </span>
                                </li>
                                <li>
                                  <span data-toggle="tooltip" data-placement="top" title="Photos (12)">
                                    <i class="fa fa-camera"></i>
                                  </span>
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

    <!--start carousel module-->
    <div class="houzez-module-main">
        <div class="houzez-module carousel-module">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="module-title-nav clearfix">
                            <div>
                                <h2>Latest for Rent</h2>
                            </div>
                            <div class="module-nav">
                                <button class="btn btn-sm btn-crl-pprt-2-prev">Prev</button>
                                <button class="btn btn-sm btn-crl-pprt-2-next">Next</button>
                                <a href="#" class="btn btn-carousel btn-sm">All</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row grid-row">
                            <div class="carousel properties-carousel-grid-2 slide-animated">
                                <?php
                                for($loop = 1 ; $loop <= 10 ; $loop++) {
                                    ?>
                                    <div class="item">
                                        <div class="item-wrap">
                                            <div class="property-item item-grid">
                                                <div class="figure-block">
                                                    <figure class="item-thumb">
                                                        <div class="label-wrap hide-on-list">
                                                            <div class="label-status label label-default">For Rent</div>
                                                        </div>
                                                        <span class="label-featured label label-success">Featured</span>
                                                        <div class="price hide-on-list">
                                                            <h3>$350,000</h3>
                                                            <p class="rant">$21,000/mo</p>
                                                        </div>
                                                        <a href="#" class="hover-effect">
                                                            <img src="http://placehold.it/355x240" alt="thumb">
                                                        </a>
                                                        <ul class="actions">
                                                            <li class="share-btn">
                                                                <div class="share_tooltip fade">
                                                                    <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                                                    <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                                                    <a href="#"  target="_blank"><i class="fa fa-google-plus"></i></a>
                                                                    <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                                                </div>
                                                                <span data-toggle="tooltip" data-placement="top" title="share"><i class="fa fa-share-alt"></i></span>
                                                            </li>
                                                            <li>
                                                                            <span data-toggle="tooltip" data-placement="top" title="Favorite">
                                                                                <i class="fa fa-heart-o"></i>
                                                                            </span>
                                                            </li>
                                                            <li>
                                                                            <span data-toggle="tooltip" data-placement="top" title="Photos (12)">
                                                                                <i class="fa fa-camera"></i>
                                                                            </span>
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
                                                            <h2 class="property-title"><a href="#">Apartment Oceanview</a></h2>
                                                            <h4 class="property-location">7601 East Treasure Dr. Miami Beach, FL 33141</h4>
                                                        </div>
                                                        <div class="table-list full-width info-row">
                                                            <div class="cell">
                                                                <div class="info-row amenities">
                                                                    <p>
                                                                        <span>Beds: 3</span>
                                                                        <span>Baths: 2</span>
                                                                        <span>Sqft: 1,965</span>
                                                                    </p>
                                                                    <p>Single Family Home</p>
                                                                </div>
                                                            </div>
                                                            <div class="cell">
                                                                <div class="phone">
                                                                    <a href="#" class="btn btn-primary">Details <i class="fa fa-angle-right fa-right"></i></a>
                                                                    <p><a href="#">+1 (786) 225-0199</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="item-foot date hide-on-list">
                                                <div class="item-foot-left">
                                                    <p><i class="fa fa-user"></i> <a href="#">Elite Ocean View Realty LLC</a></p>
                                                </div>
                                                <div class="item-foot-right">
                                                    <p><i class="fa fa-calendar"></i> 12 Days ago </p>
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
    <!--end carousel module-->

    <!--start location module-->
    <div class="houzez-module-main module-white-bg">
        <div class="houzez-module module-title text-center">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h2>Our Locations</h2>
                        <h3 class="sub-heading">Book space in amazing locations across the world</h3>
                    </div>
                </div>
            </div>
        </div>
        <div id="location-modul" class="houzez-module location-module grid">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="location-block">
                            <figure>
                                <a href="#">
                                    <img src="http://placehold.it/370x370" width="370" height="370" alt="Image">
                                </a>
                                <div class="location-fig-caption">
                                    <h3 class="heading">Apartment</h3>
                                    <p class="sub-heading">30 Properties</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="location-block">
                            <figure>
                                <a href="#">
                                    <img src="http://placehold.it/770x370" width="770" height="370" alt="Image">
                                </a>
                                <div class="location-fig-caption">
                                    <h3 class="heading">Loft</h3>
                                    <p class="sub-heading">1 Property</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="location-block">
                            <figure>
                                <a href="#">
                                    <img src="http://placehold.it/770x370" width="770" height="370" alt="Image">
                                </a>
                                <div class="location-fig-caption">
                                    <h3 class="heading">Single Family Home</h3>
                                    <p class="sub-heading">11 Properties</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="location-block">
                            <figure>
                                <a href="#">
                                    <img src="http://placehold.it/370x370" width="370" height="370" alt="Image">
                                </a>
                                <div class="location-fig-caption">
                                    <h3 class="heading">Villa</h3>
                                    <p class="sub-heading">10 Properties</p>
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end location module-->

    <!--start property item module-->
    <div class="houzez-module-main module-gray-bg">
        <div class="houzez-module module-title text-center">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h2>Best Property Value</h2>
                        <h3 class="sub-heading">Create Your Real Estate Website or Marketplace</h3>
                    </div>
                </div>
            </div>
        </div>
        <div id="property-item-module" class="houzez-module property-item-module">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row grid-row">
                            <div class="col-sm-6">
                                <div class="item-wrap">
                                    <div class="property-item item-grid">
                                        <div class="figure-block">
                                            <figure class="item-thumb">
                                                <div class="label-wrap hide-on-list">
                                                    <div class="label-status label label-default">For Rent</div>
                                                </div>
                                                <span class="label-featured label label-success">Featured</span>
                                                <div class="price hide-on-list">
                                                    <h3>$350,000</h3>
                                                    <p class="rant">$21,000/mo</p>
                                                </div>
                                                <a href="#" class="hover-effect">
                                                    <img src="http://placehold.it/355x240" alt="thumb">
                                                </a>
                                                <ul class="actions">
                                                    <li class="share-btn">
                                                        <div class="share_tooltip fade">
                                                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                                            <a href="#"  target="_blank"><i class="fa fa-google-plus"></i></a>
                                                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                                        </div>
                                                        <span data-toggle="tooltip" data-placement="top" title="share"><i class="fa fa-share-alt"></i></span>
                                                    </li>
                                                    <li>
                                                                        <span data-toggle="tooltip" data-placement="top" title="Favorite">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </span>
                                                    </li>
                                                    <li>
                                                                        <span data-toggle="tooltip" data-placement="top" title="Photos (12)">
                                                                            <i class="fa fa-camera"></i>
                                                                        </span>
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
                                                    <h2 class="property-title"><a href="#">Apartment Oceanview</a></h2>
                                                    <h4 class="property-location">7601 East Treasure Dr. Miami Beach, FL 33141</h4>
                                                </div>
                                                <div class="table-list full-width info-row">
                                                    <div class="cell">
                                                        <div class="info-row amenities">
                                                            <p>
                                                                <span>Beds: 3</span>
                                                                <span>Baths: 2</span>
                                                                <span>Sqft: 1,965</span>
                                                            </p>
                                                            <p>Single Family Home</p>
                                                        </div>
                                                    </div>
                                                    <div class="cell">
                                                        <div class="phone">
                                                            <a href="#" class="btn btn-primary">Details <i class="fa fa-angle-right fa-right"></i></a>
                                                            <p><a href="#">+1 (786) 225-0199</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="item-foot date hide-on-list">
                                        <div class="item-foot-left">
                                            <p><i class="fa fa-user"></i> <a href="#">Elite Ocean View Realty LLC</a></p>
                                        </div>
                                        <div class="item-foot-right">
                                            <p><i class="fa fa-calendar"></i> 12 Days ago </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="item-wrap">
                                    <div class="property-item item-grid">
                                        <div class="figure-block">
                                            <figure class="item-thumb">
                                                <div class="label-wrap hide-on-list">
                                                    <div class="label-status label label-default">For Rent</div>
                                                </div>
                                                <span class="label-featured label label-success">Featured</span>
                                                <div class="price hide-on-list">
                                                    <h3>$350,000</h3>
                                                    <p class="rant">$21,000/mo</p>
                                                </div>
                                                <a href="#" class="hover-effect">
                                                    <img src="http://placehold.it/355x240" alt="thumb">
                                                </a>
                                                <ul class="actions">
                                                    <li class="share-btn">
                                                        <div class="share_tooltip fade">
                                                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                                            <a href="#"  target="_blank"><i class="fa fa-google-plus"></i></a>
                                                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                                                        </div>
                                                        <span data-toggle="tooltip" data-placement="top" title="share"><i class="fa fa-share-alt"></i></span>
                                                    </li>
                                                    <li>
                                                                        <span data-toggle="tooltip" data-placement="top" title="Favorite">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </span>
                                                    </li>
                                                    <li>
                                                                        <span data-toggle="tooltip" data-placement="top" title="Photos (12)">
                                                                            <i class="fa fa-camera"></i>
                                                                        </span>
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
                                                    <h2 class="property-title"><a href="#">Apartment Oceanview</a></h2>
                                                    <h4 class="property-location">7601 East Treasure Dr. Miami Beach, FL 33141</h4>
                                                </div>
                                                <div class="table-list full-width info-row">
                                                    <div class="cell">
                                                        <div class="info-row amenities">
                                                            <p>
                                                                <span>Beds: 3</span>
                                                                <span>Baths: 2</span>
                                                                <span>Sqft: 1,965</span>
                                                            </p>
                                                            <p>Single Family Home</p>
                                                        </div>
                                                    </div>
                                                    <div class="cell">
                                                        <div class="phone">
                                                            <a href="#" class="btn btn-primary">Details <i class="fa fa-angle-right fa-right"></i></a>
                                                            <p><a href="#">+1 (786) 225-0199</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="item-foot date hide-on-list">
                                        <div class="item-foot-left">
                                            <p><i class="fa fa-user"></i> <a href="#">Elite Ocean View Realty LLC</a></p>
                                        </div>
                                        <div class="item-foot-right">
                                            <p><i class="fa fa-calendar"></i> 12 Days ago </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end property item module-->

    <!--start agents module-->
    <div class="houzez-module module-title text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <h2>Agents</h2>
                    <h3 class="sub-heading">Here could be a nice sub title</h3>
                </div>
            </div>
        </div>
    </div>
    <div id="agents-module" class="houzez-module agents-module">
        <div class="container">
            <div class="agents-blocks-main">
                <div class="row no-margin">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="agents-block">
                            <figure class="auther-thumb">
                                <img src="http://placehold.it/71x71" alt="thumb" width="71" height="71" class="img-circle">
                            </figure>
                            <div class="web-logo text-center">
                                <img src="<?php echo get_asset('img/houzez-logo-grey.png'); ?>" alt="logo">
                            </div>
                            <div class="block-body">
                                <p class="auther-info">
                                    <span>by <span class="blue">John Doe</span></span>
                                    <span>Founder & CEO, Company Name</span>
                                </p>
                                <p class="description">Lorem ipsum dolor sit cotetur
                                    adipiscing elit. Nam solltudin
                                    nulla vitae suscipit.
                                </p>
                                <a href="#" class="view">View profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="agents-block">
                            <figure class="auther-thumb">
                                <img src="http://placehold.it/71x71" alt="thumb" width="71" height="71" class="img-circle">
                            </figure>
                            <div class="web-logo text-center">
                                <img src="<?php echo get_asset('img/houzez-logo-grey.png'); ?>?>" alt="logo">
                            </div>
                            <div class="block-body">
                                <p class="auther-info">
                                    <span>by <span class="blue">John Doe</span></span>
                                    <span>Founder & CEO, Company Name</span>
                                </p>
                                <p class="description">Lorem ipsum dolor sit cotetur
                                    adipiscing elit. Nam solltudin
                                    nulla vitae suscipit.
                                </p>
                                <a href="#" class="view">View profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="agents-block">
                            <figure class="auther-thumb">
                                <img src="http://placehold.it/71x71" alt="thumb" width="71" height="71" class="img-circle">
                            </figure>
                            <div class="web-logo text-center">
                                <img src="<?php echo get_asset('img/houzez-logo-grey.png'); ?>?>" alt="logo">
                            </div>
                            <div class="block-body">
                                <p class="auther-info">
                                    <span>by <span class="blue">John Doe</span></span>
                                    <span>Founder & CEO, Company Name</span>
                                </p>
                                <p class="description">Lorem ipsum dolor sit cotetur
                                    adipiscing elit. Nam solltudin
                                    nulla vitae suscipit.
                                </p>
                                <a href="#" class="view">View profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="agents-block">
                            <figure class="auther-thumb">
                                <img src="http://placehold.it/71x71" alt="thumb" width="71" height="71" class="img-circle">
                            </figure>
                            <div class="web-logo text-center">
                                <img src="<?php echo get_asset('img/houzez-logo-grey.png'); ?>?>" alt="logo">
                            </div>
                            <div class="block-body">
                                <p class="auther-info">
                                    <span>by <span class="blue">John Doe</span></span>
                                    <span>Founder & CEO, Company Name</span>
                                </p>
                                <p class="description">Lorem ipsum dolor sit cotetur
                                    adipiscing elit. Nam solltudin
                                    nulla vitae suscipit.
                                </p>
                                <a href="#" class="view">View profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end agents module-->

</section>
<!--end section page body-->
