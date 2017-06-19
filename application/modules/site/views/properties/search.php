<section id="section-body">
    <div class="container">
        <div class="page-title breadcrumb-top">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb"><li ><a href="/"><i class="fa fa-home"></i></a></li><li class="active">Simple Listing – List View</li></ol>
                    <div class="page-title-left">
                        <h2>Simple Listing – List View</h2>
                    </div>
                    <div class="page-title-right">
                        <div class="view hidden-xs">
                            <div class="table-cell">
                                <span class="view-btn btn-list active"><i class="fa fa-th-list"></i></span>
                                <span class="view-btn btn-grid"><i class="fa fa-th-large"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form id="properties-list-form" method="post" action="<?php echo base_url('buscar-imoveis'); ?>">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 list-grid-area container-contentbar">
                    <div id="content-area">
                        <!--start list tabs-->
                        <div class="list-tabs table-list full-width">
                            <div class="tabs table-cell">
                                <ul>
                                    <li>
                                        <a href="#" class="active">À VENDA</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="sort-tab table-cell text-right">
                                <select name="params[orderby]" class="selectpicker bs-select-hidden" id="property-listing-order" title="Ordenar por" data-live-search-style="begins" data-live-search="false">
                                    <option value="most_recent">Mais recentes</option>
                                    <option value="lowest_price">Preço menor pro maior</option>
                                    <option value="biggest_price">Preço maior pro menor</option>
                                </select>
                            </div>
                        </div>
                        <!--end list tabs-->

                        <div class="property-listing grid-view">
                            <div id="properties-list" class="row">
                                <?php echo isset($properties) ? $this->site->mustache('properties-search__property-item', $properties) : 'Nada encontrado'; ?>
                            </div>
                        </div>

                        <div id="properties-pagination">
                            <?php echo isset($properties['pagination']) ? $properties['pagination'] : ''; ?>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 col-md-offset-0 col-sm-offset-3 container-sidebar">
                    <aside id="sidebar" class="sidebar-white">
                        <div class="widget widget-range">
                            <div class="widget-body">

                                <input type="hidden" id="search-transaction" name="params[transaction]" value="venda" />

                                <dir class="row">
                                    <div class="col-xs-12">
                                        <h4>Localização do imóvel</h4>
                                        <div class="form-group no-margin">
                                            <input type="text" class="input-search-local form-control" name="location" placeholder="Adicione uma localização">
                                        </div>

                                        <div id="property-location-items">
                                            <?php echo $this->site->mustache('properties-search__filter-location', $filters['params']); ?>
                                        </div>

                                    </div>
                                </dir>

                                <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4>Tipo de imóvel</h4>
                                        <div id="properties_types__container" class="form-group no-margin">
                                            <select class="selectpicker form-control" name="params[properties_types][]" id="properties_types" title="Selecione um tipo" multiple>
                                                <?php
                                                if(isset($filters['params']['properties_types']) && !empty($filters['params']['properties_types'])){
                                                    foreach($filters['params']['properties_types'] as $properties_type){
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
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <dir class="row">
                                    <div class="properties-search-double-left col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h4>Preço Mínimo</h4>
                                        <div class="form-group">
                                            <input id="search-min_price" class="form-control price-mask" name="params[min_price]" placeholder="R$ 200.000" value="<?php echo isset($filters['params']['min_price']) ? $filters['params']['min_price'] : ''; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="properties-search-double-right col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h4>Preço Máximo</h4>
                                        <div class="form-group">
                                            <input id="search-max_price" class="form-control price-mask" name="params[max_price]" placeholder="R$ 2.000.000" value="<?php echo isset($filters['params']['max_price']) ? $filters['params']['max_price'] : ''; ?>" type="text">
                                        </div>
                                    </div>
                                </dir>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4>Dormitórios</h4>
                                        <ul class="radio-as-button red">
                                            <?php
                                            for($bedrooms = 1 ; $bedrooms <= 5 ; $bedrooms++){
                                                ?><li>
                                                    <input type="radio" id="bedrooms<?php echo $bedrooms; ?>" value="<?php echo $bedrooms; ?>" name="params[bedrooms]" <?php echo isset($filters['params']['bedrooms']) && $filters['params']['bedrooms'] == $bedrooms ? 'checked="true"' : ''; ?> />
                                                    <label for="bedrooms<?php echo $bedrooms; ?>" class="btn btn-rounded btn-default"><?php echo $bedrooms; ?>+</label>
                                                </li><?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <hr class="properties-search-hr">

                                <div class="row">
                                    <div class="properties-data col-xs-12">
                                        <h4>Vagas de garagem</h4>
                                        <ul class="radio-as-button red">
                                            <?php
                                            for($garages = 1 ; $garages <= 5 ; $garages++){
                                                ?><li>
                                                    <input type="radio" id="garages<?php echo $garages; ?>" value="<?php echo $garages; ?>" name="params[garages]" <?php echo isset($filters['params']['garages']) && $filters['params']['garages'] == $garages ? 'checked="true"' : ''; ?> />
                                                    <label for="garages<?php echo $garages; ?>" class="btn btn-rounded btn-default"><?php echo $garages; ?>+</label>
                                                </li><?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <hr class="properties-search-hr">

                                <div class="row">
                                    <div class="properties-data col-xs-12">
                                        <h4>Banheiros</h4>
                                        <ul class="radio-as-button red">
                                            <?php
                                            for($bathrooms = 1 ; $bathrooms <= 5 ; $bathrooms++){
                                                ?><li>
                                                    <input type="radio" id="bathrooms<?php echo $bathrooms; ?>" value="<?php echo $bathrooms; ?>" name="params[bathrooms]" <?php echo isset($filters['params']['bathrooms']) && $filters['params']['bathrooms'] == $bathrooms ? 'checked="true"' : ''; ?> />
                                                    <label for="bathrooms<?php echo $bathrooms; ?>" class="btn btn-rounded btn-default"><?php echo $bathrooms; ?>+</label>
                                                </li><?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                <hr class="properties-search-hr">

                                <dir class="row">
                                    <div class="properties-search-double-left col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h4>Área Mínima</h4>
                                        <div class="form-group">
                                            <input id="search-min_area" class="form-control area-mask" name="params[min_area]" placeholder="0 m²" value="<?php echo isset($filters['params']['min_area']) ? $filters['params']['min_area'] : ''; ?>" type="text">
                                        </div>
                                    </div>
                                    <div class="properties-search-double-right col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <h4>Área Máxima</h4>
                                        <div class="form-group">
                                            <input id="search-max_area" class="form-control area-mask" name="params[max_area]" placeholder="ilimitado m²" value="<?php echo isset($filters['params']['max_area']) ? $filters['params']['max_area'] : ''; ?>" type="text">
                                        </div>
                                    </div>
                                </dir>

                                <div class="range-block rang-form-block">
                                    <div class="row">

                                        <div class="col-sm-12 col-xs-12">
                                            <label class="advance-trigger btn-other-features"><i class="fa fa-plus-square"></i> Outras características </label>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="features-list field-expand">
                                                <?php
                                                if(isset($filters['params']['property_features']) && !empty($filters['params']['property_features'])){
                                                    foreach($filters['params']['property_features'] as $feature){
                                                        ?><label class="checkbox-inline"><input name="params[property_features][]" data-search="property_features" <?php echo isset($feature['selected']) && $feature['selected'] ? 'checked="true"' : ''; ?> id="feature-<?php echo $feature['slug']; ?>" value="<?php echo $feature['slug']; ?>" type="checkbox"><?php echo $feature['nome']; ?></label><?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <button type="submit" class="btn btn-secondary btn-block"> Buscar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </aside>
                </div><!--/.container-sidebar-->
            </form>
        </div>
    </div>
</section>