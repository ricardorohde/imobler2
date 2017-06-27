<div class="content ">
  <div class="jumbotron lg-m-b-0" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
          <li><a href="<?php echo base_url('admin/campanhas'); ?>">Campanhas</a></li>
          <li><a class="active"><?php echo $action == 'edit' ? 'Editando campanha' . (isset($post['titulo']) ? ' "' . $post['titulo'] . '"' : '') : 'Adicionar campanha'; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="panel panel-transparent">
      <div class="panel-body">
        <h1 class="margin-bottom-50"><?php echo $action == 'edit' ? 'Editando campanha' . (isset($post['titulo']) ? ' <strong>"' . $post['titulo'] . '"</strong>' : '') : 'Adicionar campanha'; ?></h1>

        <?php $this->load->view('admin/includes/alertas', $this->_ci_cached_vars); ?>

        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" method="post" action="<?php echo base_url($form_action); ?>" enctype="multipart/form-data">

          <input type="hidden" name="parametros[transaction]" value="venda">

          <div class="form-group">
            <label for="titulo" class="col-sm-3 control-label">Título</label>
            <div class="col-sm-9">
              <div class="form-loading">
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo isset($post['titulo']) ? $post['titulo'] : ''; ?>" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="descricao" class="col-sm-3 control-label">Descrição</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="descricao" name="descricao" rows="5" maxlength="1000" placeholder="Escreva uma breve descrição, com as informações mais importantes da campanha."><?php echo isset($post['descricao']) ? $post['descricao'] : ''; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="categoria" class="col-sm-3 control-label">Categoria</label>
            <div class="col-sm-9">
              <select class="full-width" name="categoria" id="categoria" required data-init-plugin="select2" required>
                <option></option>
                <?php
                if(isset($campanhas_categorias) && !empty($campanhas_categorias)){
                  foreach ($campanhas_categorias as $categoria) {
                    ?>
                    <option value="<?php echo $categoria['id']; ?>" <?php echo isset($categoria['selected']) && $categoria['selected'] ? 'selected="true"' : ''; ?>><?php echo $categoria['nome']; ?></option>
                    <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="permalink" class="col-sm-3 control-label">Permalink</label>
            <div class="col-sm-9">
              <div class="input-group">
                <span class="input-group-addon"><?php echo base_url(); ?></span>
                <input type="text" class="form-control" id="permalink" name="permalink" value="<?php echo isset($post['permalink']) ? $post['permalink'] : ''; ?>" required>
                <span class="input-group-addon"><a href="javascript: void(0);" class="copy-permalink"><i class="fa fa-clipboard" aria-hidden="true"></i></a></span>

              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="localizacao" class="col-sm-3 control-label">Localização</label>
            <div class="col-sm-9">
              <div class="form-loading">
                <input type="text" class="input-search-local form-control" id="localizacao">
              </div>

              <div class="hint-text small m-t-5">Você pode escolher uma ou mais localizações para esta campanha.</div>

              <div id="property-location-items">
                <?php echo isset($post['parametros']) ? $this->site->mustache('campaigns-location-item.mustache', $post['parametros']) : ''; ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Tipos de imóveis</label>
            <div class="col-sm-9">
              <div class="radio radio-success">

              <select class="full-width" name="parametros[properties_types][]" multiple data-init-plugin="select2" >
                <option></option>
                <?php
                if(isset($imoveis_tipos) && !empty($imoveis_tipos)){
                  foreach ($imoveis_tipos as $imoveis_tipo) {
                    ?>
                    <optgroup label="<?php echo $imoveis_tipo['segmento']; ?>">
                      <?php
                      if(isset($imoveis_tipo['imoveis_tipos']) && !empty($imoveis_tipo['imoveis_tipos'])){
                        foreach ($imoveis_tipo['imoveis_tipos'] as $imovel_tipo) {
                          ?>
                          <option value="<?php echo $imovel_tipo['slug']; ?>" <?php echo isset($imovel_tipo['selected']) ? 'selected="true"' : ''; ?>><?php echo $imovel_tipo['nome']; ?></option>
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

          <div class="form-group">
            <label for="position" class="col-sm-3 control-label">Área útil</label>
            <div class="col-sm-9">
              <div class="row">
                  <div class="col-sm-3 sm-m-t-5">
                    <label class="label-sm">Área útil mínima</label>
                    <div class="input-group">
                      <input type="text" name="parametros[min_area]" value="<?php echo isset($post['parametros']['min_area']) ? $post['parametros']['min_area'] : ''; ?>" placeholder="0"  class="form-control area-mask input-sm">
                      <span class="input-group-addon">m²</span>
                    </div>

                  </div>

                  <div class="col-sm-3 sm-m-t-5">
                    <label class="label-sm">Área útil máxima</label>
                    <div class="input-group">
                      <input type="text" name="parametros[max_area]" value="<?php echo isset($post['parametros']['max_area']) ? $post['parametros']['max_area'] : ''; ?>" placeholder="0" class="form-control area-mask input-sm">
                      <span class="input-group-addon">m²</span>
                    </div>

                  </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="position" class="col-sm-3 control-label">Características</label>
            <div class="col-sm-9">
              <div class="row">
                <?php
                foreach (array(
                  'bedrooms' => 'Dormitórios',
                  'suites' => 'Suítes',
                  'bathrooms' => 'Banheiros',
                  'garages' => 'Garagens'
                ) as $key => $value) {
                  ?>
                  <div class="col-sm-2 sm-m-t-5">
                    <label class="label-sm"><?php echo $value; ?></label>
                    <input type="number" name="parametros[<?php echo $key; ?>]" value="<?php echo isset($post['parametros'][$key]) ? $post['parametros'][$key] : ''; ?>" placeholder="0" class="form-control input-sm">
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="position" class="col-sm-3 control-label">Valor</label>
            <div class="col-sm-9">
              <div class="row">
                  <div class="col-sm-3 sm-m-t-5">
                    <label class="label-sm">Valor mínimo</label>
                    <div class="input-group">
                      <span class="input-group-addon">R$</span>
                      <input type="text" name="parametros[min_price]" value="<?php echo isset($post['parametros']['min_price']) ? $post['parametros']['min_price'] : ''; ?>" placeholder="0"  class="form-control price-mask input-sm">
                    </div>

                  </div>

                  <div class="col-sm-3 sm-m-t-5">
                    <label class="label-sm">Valor máximo</label>
                    <div class="input-group">
                      <span class="input-group-addon">R$</span>
                      <input type="text" name="parametros[max_price]" value="<?php echo isset($post['parametros']['max_price']) ? $post['parametros']['max_price'] : ''; ?>" placeholder="0" class="form-control price-mask input-sm">
                    </div>

                  </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="position" class="col-sm-3 control-label">Benefícios do campanha (opcional)</label>
            <div class="col-sm-9">
                <?php
                if(isset($caracteristicas) && !empty($caracteristicas)){
                  $caracteristica_count = 0;
                  foreach ($caracteristicas as $caracteristica) {
                    if($caracteristica_count){
                      ?>
                      <hr>
                      <?php
                    }
                    ?>
                    <h5><?php echo $caracteristica['tipo']; ?></h5>
                    <div class="row">
                      <?php
                      $caracteristica_item_count = 0;
                      foreach ($caracteristica['caracteristicas'] as $caracteristica_item) {
                        if($caracteristica_item_count == 3){
                          $caracteristica_item_count = 0;
                          ?>
                          </div>
                          <div class="row">
                          <?php
                        }
                        ?>
                        <div class="col-sm-4">
                          <div class="checkbox ">
                            <input type="checkbox" name="parametros[property_features][]" value="<?php echo $caracteristica_item['slug']; ?>" <?php echo isset($caracteristica_item['selected']) ? 'checked="true"' : ''; ?> id="checkbox<?php echo $caracteristica_item['id']; ?>">
                            <label for="checkbox<?php echo $caracteristica_item['id']; ?>"><?php echo $caracteristica_item['nome']; ?></label>
                          </div>
                        </div>
                        <?php
                        $caracteristica_item_count++;
                      }
                      ?>
                    </div>
                    <?php
                    $caracteristica_count++;
                  }
                }
                ?>

            </div>
          </div>

          <div class="form-group">
            <label for="position" class="col-sm-3 control-label">Outras informações</label>
            <div class="col-sm-9">
              <div class="row">

                <?php
                $informacoes = array(
                  'condominium' => 'Imóveis em condomínio',
                  'offer' => 'Imóveis em oferta',
                  'featured' => 'Imóveis em destaque',
                  'release' => 'Imóveis em lançamento'
                );
                foreach ($informacoes as $key => $value) {
                  ?>
                  <div class="col-sm-3">
                    <div class="checkbox">
                      <input type="checkbox" name="parametros[<?php echo $key; ?>]" id="informacao_<?php echo $key; ?>" <?php echo isset($post['parametros'][$key]) && $post['parametros'][$key] == 1 ? 'checked="true"' : ''; ?> value="1">
                      <label for="informacao_<?php echo $key; ?>"><?php echo $value; ?></label>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="imagem_arquivo" class="col-sm-3 control-label">Foto da campanha</label>
            <div class="col-sm-9">
              <?php
              if(isset($post['imagem_arquivo']) && !empty($post['imagem_arquivo'])){
                ?>
                <input type="hidden" name="imagem_arquivo_existente" value="<?php echo $post['imagem_arquivo']; ?>">
                <p><img src="<?php echo base_url('imagens/campanhas/' . $post['id'] . '/150/150/100/0/' . $post['imagem_arquivo']); ?>" class="img-thumbnail"></p>
                <?php
              }
              ?>
              <input type="file" class="form-control" id="imagem_arquivo" name="imagem_arquivo" value="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Publicar campanha?</label>
            <div class="col-sm-9">
              <input type="checkbox" name="status" value="1" <?php echo isset($post['status']) && $post['status'] == 1 ? 'checked="true"' : ''; ?> data-init-plugin="switchery" data-size="large" data-color="info" />
            </div>
          </div>

          <br>

          <div class="row">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9">
              <button class="btn btn-success" type="submit"><?php echo $action == 'edit' ? 'Atualizar' : 'Adicionar campanha'; ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>