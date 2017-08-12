<!--start section page body-->
<section id="section-body">
    <div class="container">
        <div class="membership-page-top">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="membership-page-title">
                        <h1 class="page-title">Anunciar imóvel</h1>
                        <p class="page-subtitle">Informe seus dados e os dados do imóvel para que possamos entrar em contato com você.</p>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('site/includes/alertas', $this->_ci_cached_vars); ?>

        <div class="membership-content-area">
            <form method="post" action="<?php echo base_url('anunciar-imovel'); ?>">
                <div class="account-block">
                    <div class="add-title-tab">
                        <h3>Dados de contato</h3>
                    </div>
                    <div class="add-tab-content">
                        <div class="add-tab-row  push-padding-bottom">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Seu nome</label>
                                        <input type="text" required class="form-control" id="nome" name="nome" value="<?php echo $this->input->post('nome'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="neighborhood">E-mail</label>
                                        <input type="email" required class="form-control" id="email" name="email" value="<?php echo $this->input->post('email'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">Telefone</label>
                                        <input type="tel" required class="form-control phone-mask" id="telefone" name="telefone" value="<?php echo $this->input->post('telefone'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="account-block">
                    <div class="add-title-tab">
                        <h3>Informações sobre o imóvel</h3>
                    </div>
                    <div class="add-tab-content">
                        <div class="add-tab-row  push-padding-bottom">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control cep-mask" id="cep" name="cep" value="<?php echo $this->input->post('cep'); ?>" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="logradouro">Endereço</label>
                                        <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?php echo $this->input->post('logradouro'); ?>" required>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="numero">Número</label>
                                        <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $this->input->post('numero'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $this->input->post('complemento'); ?>" required>
                                    </div>
                                </div>
                              <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $this->input->post('bairro'); ?>" required>
                                    </div>
                                </div>
                               <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $this->input->post('cidade'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="country">Estado</label>
                                        <select class="selectpicker" style="display:none;" id="estado" name="estado" data-live-search="false" data-live-search-style="begins" title="Selecione um estado">
                                          <?php
                                          if(isset($estados['results']) && !empty($estados['results'])){
                                            foreach ($estados['results'] as $estado) {
                                              ?>
                                              <option value="<?php echo strtoupper($estado['sigla']); ?>" <?php echo $this->input->post('estado') == strtoupper($estado['sigla']) ? 'selected="true"' : ''; ?>><?php echo $estado['nome']; ?></option>
                                              <?php
                                            }
                                          }
                                          ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-tab-row push-padding-bottom">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="imovel_tipo">Tipo de imóvel</label>
                                        <select class="selectpicker form-control" style="display: none;" name="imovel_tipo" id="imovel_tipo" title="Selecione um tipo" data-live-search="false" data-live-search-style="begins">
                                            <?php
                                            if(isset($filters['params']['properties_types']) && !empty($filters['params']['properties_types'])){
                                                foreach($filters['params']['properties_types'] as $properties_type){
                                                    ?>
                                                    <optgroup label="<?php echo $properties_type['segmento']; ?>">
                                                        <?php
                                                        if(isset($properties_type['tipos'])){
                                                            foreach ($properties_type['tipos'] as $tipo) {
                                                                ?>
                                                                <option <?php echo ($this->input->post('imovel_tipo') == $tipo['nome'] ? 'selected="true"' : ''); ?> value="<?php echo $tipo['nome']; ?>"><?php echo $tipo['nome']; ?></option>
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="area_util">Área útil</label>
                                        <div class="input-group">
                                          <input type="text" class="form-control area-mask" id="area_util" name="area_util" value="<?php echo $this->input->post('area_util'); ?>">
                                          <span class="input-group-addon">m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="area_total">Área total</label>
                                        <div class="input-group">
                                          <input type="text" class="form-control area-mask" id="area_total" name="area_total" value="<?php echo $this->input->post('area_total'); ?>">
                                          <span class="input-group-addon">m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dormitorios">Dormitórios</label>
                                        <input type="number" class="form-control" id="dormitorios" name="dormitorios" value="<?php echo $this->input->post('dormitorios'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="banheiros">Banheiros</label>
                                        <input type="number" class="form-control" id="banheiros" name="banheiros" value="<?php echo $this->input->post('banheiros'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="suites">Suítes</label>
                                        <input type="number" class="form-control" id="suites" name="suites" value="<?php echo $this->input->post('suites'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="garagens">Garagens</label>
                                        <input type="number" class="form-control" id="garagens" name="garagens" value="<?php echo $this->input->post('garagens'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-tab-row push-padding-bottom">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="valor">Valor</label>
                                        <div class="input-group">
                                          <span class="input-group-addon">R$</span>
                                          <input type="text" class="form-control price-mask" id="valor" name="valor" value="<?php echo $this->input->post('valor'); ?>" placeholder="0,00" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="valor_condominio">Valor do condomínio (mensal)</label>
                                        <div class="input-group">
                                          <span class="input-group-addon">R$</span>
                                          <input type="text" class="form-control price-mask" id="valor_condominio" name="valor_condominio" value="<?php echo $this->input->post('valor_condominio'); ?>" placeholder="0,00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="valor_iptu">Valor do IPTU (anual)</label>
                                        <div class="input-group">
                                          <span class="input-group-addon">R$</span>
                                          <input type="text" class="form-control price-mask" id="valor_iptu" name="valor_iptu" value="<?php echo $this->input->post('valor_iptu'); ?>" placeholder="0,00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-tab-row push-padding-bottom">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="observacoes">Observações</label>
                                        <textarea class="form-control" id="observacoes" name="observacoes" rows="4" placeholder="Caso tenha alguma informação para adicionar sobre o imóvel, por favor, utilize este campo." maxlength="2000"><?php echo $this->input->post('observacoes'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="account-block text-right">
                    <button type="submit" class="btn btn-primary">Submit Property</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!--end section page body-->
