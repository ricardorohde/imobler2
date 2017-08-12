    <section id="section-body">

        <div class="container">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-left">
                            <h1 class="title-head">Olá, <?php echo $this->site->userinfo('nome'); ?></h1>
                        </div>
                        <div class="page-title-right">
                            <ol class="breadcrumb"><li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a></li><li class="active">Minha Conta</li></ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-dashboard-full">
                <?php $this->load->view('site/account/submenu', $this->_ci_cached_vars); ?>

                <div class="profile-area-content">
                    <div class="profile-area account-block white-block">
                        <form method="post" action="<?php echo base_url('minha-conta'); ?>">
                            <div class="row">
                              <div class="col-md-12">
                                  <h4>Informações</h4>

                                  <?php $this->load->view('site/includes/alertas', $this->_ci_cached_vars); ?>

                                  <div class="row">
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label for="nome">Nome</label>
                                              <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $usuario['nome']; ?>">
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label for="sobrenome">Sobrenome</label>
                                              <input type="text" id="sobrenome" name="sobrenome" class="form-control" value="<?php echo $usuario['sobrenome']; ?>">
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label for="email">E-mail</label>
                                              <input type="email" id="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>">
                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <label for="telefone">Telefone</label>
                                              <input type="telefone" id="telefone" name="telefone" class="form-control phone-mask" value="<?php echo $usuario['telefone']; ?>">
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-sm-12 col-xs-12 text-right">
                                  <button type="submit" name="alterar-infos" class="btn btn-primary">Salvar</button>
                              </div>
                            </div>
                        </form>
                    </div>
                    <div class="profile-area account-block white-block">
                        <h4>Alterar senha</h4>
                        <form method="post" action="<?php echo base_url('minha-conta'); ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nova_senha">Nova senha</label>
                                        <input type="password" id="nova_senha" name="nova_senha" class="form-control" value="<?php echo $this->input->post('nova_senha'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="repetir_nova_senha">Repetir nova senha</label>
                                        <input type="password" id="repetir_nova_senha" name="repetir_nova_senha" class="form-control" value="<?php echo $this->input->post('repetir_nova_senha'); ?>">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="alterar-senha" class="btn btn-primary">Alterar senha</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </section>
