<div class="content ">

  <!-- START JUMBOTRON -->
  <div class="jumbotron lg-m-b-0" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
          <li><a href="<?php echo base_url('admin/imoveis'); ?>">Imóveis</a></li>
          <li><a class="active">Editar</a></li>
        </ul>
        <!-- END BREADCRUMB -->
      </div>
    </div>
  </div>
  <!-- END JUMBOTRON -->
  <!-- START CONTAINER FLUID -->
  <div class="container-fluid container-fixed-lg">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->
    <!-- START PANEL -->
    <h1 class="page-title">Adicionar imóvel</h1>

    <div class="panel panel-transparent">
      <div class="">
        <div class="row">
          <div class="col-sm-10 p-t-20">

            <form id="form-work" class="form-horizontal" role="form" autocomplete="off" method="post" action="<?php echo base_url($form_action); ?>" enctype="multipart/form-data">

              <h4 class="no-margin">Localização do imóvel</h4>
              <p class="hint-text small">O endereço do imóvel só ficará visível no site se a opção "Mostrar endereço no site" estiver selecionada.</p>

              <div class="form-group">
                <label for="cep" class="col-sm-3 control-label">CEP</label>
                <div class="col-sm-9">
                  <div class="form-loading form-loading-cep">
                    <input type="text" class="form-control input-lg cep-mask" id="cep" name="localizacao[cep]" value="<?php echo isset($post['localizacao']['cep']) ? $post['localizacao']['cep'] : ''; ?>" required>
                  </div>

                  <div class="hint-text small m-t-5">Não sabe o cep? <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/" target="_blank">Clique aqui</a></div>
                </div>
              </div>

              <div class="form-group">
                <label for="logradouro" class="col-sm-3 control-label">Logradouro / Número</label>
                <div class="col-sm-9">
                  <div class="row">
                    <div class="col-xs-8 col-sm-9">
                      <input type="text" class="form-control" name="localizacao[logradouro]" id="logradouro" placeholder="Ex. Rua 25 de Março" value="<?php echo isset($post['localizacao']['logradouro']) ? $post['localizacao']['logradouro'] : ''; ?>" required>
                    </div>
                    <div class="col-xs-4 col-sm-3">
                      <input type="text" class="form-control" name="localizacao[numero]" id="numero" placeholder="Ex. 1234" value="<?php echo isset($post['localizacao']['numero']) ? $post['localizacao']['numero'] : ''; ?>">
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="complemento" class="col-sm-3 control-label">Complemento</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="complemento" name="localizacao[complemento]" value="<?php echo isset($post['localizacao']['complemento']) ? $post['localizacao']['complemento'] : ''; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="bairro" class="col-sm-3 control-label">Bairro</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="bairro" name="localizacao[bairro]" required value="<?php echo isset($post['localizacao']['bairro']) ? $post['localizacao']['bairro'] : ''; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="cidade" class="col-sm-3 control-label">Cidade</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="cidade" name="localizacao[cidade]" required value="<?php echo isset($post['localizacao']['cidade']) ? $post['localizacao']['cidade'] : ''; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="cidade" class="col-sm-3 control-label">Estado (UF)</label>
                <div class="col-sm-9">
                  <select class="full-width" name="localizacao[estado]" id="estado" required data-init-plugin="select2">
                    <option></option>
                    <?php
                    if(isset($estados) && !empty($estados)){
                      foreach ($estados as $estado) {
                        ?>
                        <option value="<?php echo $estado['id']; ?>" <?php echo isset($post['localizacao']['estado']) && $post['localizacao']['estado'] == $estado['id'] ? 'selected="true"' : ''; ?> data-sigla="<?php echo strtoupper($estado['sigla']); ?>"><?php echo $estado['nome']; ?></option>
                        <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Mostrar endereço no site</label>
                <div class="col-sm-9">
                  <div class="radio radio-success">
                    <?php
                    if($enderecos_visibilidades) {
                      foreach ($enderecos_visibilidades as $visibilidade) {
                        ?>
                        <input type="radio" value="<?php echo $visibilidade['id']; ?>" <?php echo isset($post['localizacao']['visibilidade_site']) ? ($post['localizacao']['visibilidade_site'] == $visibilidade['id'] ? 'checked="true"' : '') : ($visibilidade['id'] == 1 ? 'checked="true"' : ''); ?> name="localizacao[visibilidade_site]" id="visibilidade_<?php echo $visibilidade['slug']; ?>">
                        <label for="visibilidade_<?php echo $visibilidade['slug']; ?>"><?php echo $visibilidade['nome']; ?></label>
                        <?php
                      }
                    }
                    ?>
                  </div>
                </div>
              </div>

              <input type="text" name="localizacao[latitude]" id="latitude" value="<?php echo isset($post['localizacao']['latitude']) ? $post['localizacao']['latitude'] : ''; ?>">
              <input type="text" name="localizacao[longitude]" id="longitude" value="<?php echo isset($post['localizacao']['longitude']) ? $post['localizacao']['longitude'] : ''; ?>">
              <input type="text" name="localizacao[latitude_site]" id="latitude_site" value="<?php echo isset($post['localizacao']['latitude_site']) ? $post['localizacao']['latitude_site'] : ''; ?>">
              <input type="text" name="localizacao[longitude_site]" id="longitude_site" value="<?php echo isset($post['localizacao']['longitude_site']) ? $post['localizacao']['longitude_site'] : ''; ?>">

              <div id="localizacao_mapa_box" class="hide form-group">
                <div class="col-sm-12">
                  <p>Clique e arraste o marker no mapa, para apresentar uma localização aproximada do imóvel.</p>
                  <div id="localizacao_mapa"></div>
                </div>
              </div>

              <div class="row margin-top-30">
                <div class="col-sm-12">
                  <h4 class="no-margin">Características do imóvel</h4>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Tipo de imóvel</label>
                <div class="col-sm-9">
                  <div class="radio radio-success">


                  <select class="full-width" name="detalhes[tipo]" data-init-plugin="select2" required>
                    <option></option>
                    <?php
                    if(isset($imoveis_tipos) && !empty($imoveis_tipos)){
                      foreach ($imoveis_tipos as $imoveis_tipo) {
                        ?>
                        <optgroup label="<?php echo $imoveis_tipo['nome']; ?>">
                          <?php
                          if(isset($imoveis_tipo['tipos']) && !empty($imoveis_tipo['tipos'])){
                            foreach ($imoveis_tipo['tipos'] as $imovel_tipo) {
                              ?>
                              <option value="<?php echo $imovel_tipo['id']; ?>" <?php echo isset($post['detalhes']['tipo']) && $post['detalhes']['tipo'] == $imovel_tipo['id'] ? 'selected="true"' : ''; ?>><?php echo $imovel_tipo['nome']; ?></option>
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
                <label for="position" class="col-sm-3 control-label">Características</label>
                <div class="col-sm-9">
                  <div class="row">
                    <?php
                    foreach (array(
                      'dormitorios' => 'Dormitórios',
                      'suites' => 'Suítes',
                      'banheiros' => 'Banheiros',
                      'salas' => 'Salas',
                      'garagens' => 'Garagens',
                      'varandas' => 'Varandas'
                    ) as $key => $value) {
                      ?>
                      <div class="col-sm-2 sm-m-t-5">
                        <label class="label-sm"><?php echo $value; ?></label>
                        <input type="number" name="detalhes[<?php echo $key; ?>]" value="<?php echo isset($post['detalhes'][$key]) ? $post['detalhes'][$key] : ''; ?>" placeholder="0" class="form-control input-sm">
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="position" class="col-sm-3 control-label">Áreas</label>
                <div class="col-sm-9">
                  <div class="row">
                      <div class="col-sm-3 sm-m-t-5">
                        <label class="label-sm">*Área útil</label>
                        <div class="input-group">
                          <input type="number" name="detalhes[area_util]" value="<?php echo isset($post['detalhes']['area_util']) ? $post['detalhes']['area_util'] : ''; ?>" placeholder="0" required class="form-control area-mask input-sm">
                          <span class="input-group-addon">m²</span>
                        </div>

                      </div>

                      <div class="col-sm-3 sm-m-t-5">
                        <label class="label-sm">Área total</label>
                        <div class="input-group">
                          <input type="number" name="detalhes[area_total]" value="<?php echo isset($post['detalhes']['area_total']) ? $post['detalhes']['area_total'] : ''; ?>" placeholder="0" class="form-control area-mask input-sm">
                          <span class="input-group-addon">m²</span>
                        </div>

                      </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="position" class="col-sm-3 control-label">Benefícios do imóvel (opcional)</label>
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
                              $caracteristica_item_count = 1;
                              ?>
                              </div>
                              <div class="row">
                              <?php
                            }
                            ?>
                            <div class="col-sm-4">
                              <div class="checkbox ">
                                <input type="checkbox" name="caracteristicas[]" value="<?php echo $caracteristica_item['id']; ?>" <?php echo isset($caracteristica_item['selected']) ? 'checked="true"' : ''; ?> id="checkbox<?php echo $caracteristica_item['id']; ?>">
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

              <div class="row margin-top-30">
                <div class="col-sm-12">
                  <h4 class="no-margin">Negociação e valores</h4>
                </div>
              </div>



              <div class="form-group">
                <label for="valor" class="col-sm-3 control-label">*Valor da venda</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <span class="input-group-addon">R$</span>
                    <input type="text" class="form-control input-lg price-mask" id="valor" name="negociacao[valor]" value="<?php echo isset($post['negociacao']['valor']) ? $post['negociacao']['valor'] : ''; ?>" placeholder="0,00" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="position" class="col-sm-3 control-label">Outros valores</label>
                <div class="col-sm-9">
                  <div class="row">
                      <div class="col-sm-4 sm-m-t-5">
                        <label for="condominio" class="label-sm">*Condomínio / Mês</label>
                        <div class="input-group">
                          <span class="input-group-addon">R$</span>
                          <input type="text" class="form-control input-sm price-mask" id="condominio" name="despesas[condominio]" value="<?php echo isset($post['despesas']['condominio']) ? $post['despesas']['condominio'] : ''; ?>" placeholder="0,00">
                        </div>
                      </div>

                      <div class="col-sm-4 sm-m-t-5">
                        <label for="iptu" class="label-sm">IPTU / Ano</label>
                        <div class="input-group">
                          <span class="input-group-addon">R$</span>
                          <input type="text" class="form-control input-sm price-mask" id="iptu" name="despesas[iptu]" value="<?php echo isset($post['despesas']['iptu']) ? $post['despesas']['iptu'] : ''; ?>" placeholder="0,00">
                        </div>
                      </div>
                  </div>
                </div>
              </div>

              <div class="row margin-top-30">
                <div class="col-sm-12">
                  <h4 class="no-margin">Código, título e descrição do anúncio</h4>
                </div>
              </div>

              <div class="form-group">
                <label for="referencia" class="col-sm-3 control-label">Código de referência</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control input-sm" id="referencia" name="metas[referencia]" value="<?php echo isset($post['metas']['referencia']) ? $post['metas']['referencia'] : ''; ?>" required>
                </div>
              </div>


              <div class="form-group">
                <label for="breve_descricao" class="col-sm-3 control-label">Breve descrição</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="breve_descricao" name="metas[breve_descricao]" rows="2" maxlength="200" placeholder="Escreva uma breve descrição, com as informações mais importantes do imóvel."><?php echo isset($post['metas']['breve_descricao']) ? $post['metas']['breve_descricao'] : ''; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="descricao" class="col-sm-3 control-label">Descrição</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="descricao" name="metas[descricao]" rows="10" maxlength="3000" placeholder="Escreva uma descrição detalhada do imóvel, seu estado de conservação, localização, comércio próximo e todas as informações que achar relevante."><?php echo isset($post['metas']['descricao']) ? $post['metas']['descricao'] : ''; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="descricao" class="col-sm-3 control-label">Descrição</label>
                <div class="col-sm-9">

<div class="property-uploads dropzone">
</div>

<ul class="visualizacao sortable dropzone-previews" style="border:1px solid #000">
</ul>

<div id="image-preview-template" class="hide">
  <li class="ui-state-default">
    <div>
      <div class="dz-preview dz-file-preview">
        <span data-dz-remove>Some</span>
        <div class="dz-details">
          <div class="dz-filename"><span data-dz-name></span></div>
          <div class="dz-size" data-dz-size></div>
          <img data-dz-thumbnail />
        </div>
        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
        <div class="dz-success-mark"><span>✔</span></div>
        <div class="dz-error-mark"><span>✘</span></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
      </div>
    </div>
  </li>
</div>

<!--
  <li>
    <div>
      <div class="dz-preview dz-file-preview">
        <img data-dz-thumbnail />
        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
        <div class="dz-success-mark"><span>✔</span></div>
        <div class="dz-error-mark"><span>✘</span></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
      </div>
    </div>
  </li> -->


                </div>
              </div>

              <br>
              <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9">
                  <button class="btn btn-success" type="submit">Submit</button>
                  <button class="btn btn-default"><i class="pg-close"></i> Clear</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- END PANEL -->
    <!-- END PLACE PAGE CONTENT HERE -->
  </div>
  <!-- END CONTAINER FLUID -->
</div>
