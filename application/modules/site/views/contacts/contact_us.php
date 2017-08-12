<div class="header-media">
  <div class="banner-parallax" style="height: 300px;">
    <div class="banner-bg-wrap">
      <div class="banner-inner" style="background-image: url('https://unsplash.it/1600/500/');"></div>
    </div>
  </div>
  <div class="banner-caption">
    <h1>Fale conosco</h1>
  </div>
</div><!--/.header-media-->

<section id="section-body">
  <div class="container">
    <div class="page-title breadcrumb-top">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i></a></li>
            <li class="active">Fale conosco</li>
          </ol>
          <div class="page-title-left">
            <h2>Fale conosco</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div id="content-area" class="contact-area">
          <div class="white-block">
            <div class="row">
              <div class="col-sm-4 col-xs-12 contact-block-inner">
                <?php $this->load->view('site/includes/alertas', $this->_ci_cached_vars); ?>
                <form id="contact_form" method="post" action="<?php echo base_url('fale-conosco'); ?>">
                  <div class="form-group">
                    <label class="control-label" for="nome">Nome</label>
                    <input class="form-control" type="text" title="Preencha o nome" name="nome" id="nome" value="<?php echo $this->input->post('nome'); ?>" required>
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="email">E-mail</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $this->input->post('email'); ?>">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="telefone">Telefone</label>
                    <input class="form-control phone-mask" type="text" name="telefone" id="telefone" value="<?php echo $this->input->post('telefone'); ?>">
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="mensagem">Mensagem</label>
                    <textarea class="form-control" name="mensagem" rows="4" id="mensagem" required><?php echo $this->input->post('mensagem'); ?></textarea>
                  </div>
                  <button type="submit" class="btn btn-secondary btn-long">Enviar</button>
                </form>
              </div>
              <div class="col-sm-4 col-xs-12 contact-block-inner">
                <div class="contact-info-block">
                  <h4 class="contact-info-title">Em que podemos ajudar?</h4>
                  <p>Se você esqueceu sua senha ou deseja alterar seus dados de cadastro, use os links abaixo:</p>
                  <ul>
                    <li><a href="<?php echo base_url('quem-somos')?>">Quer saber mais sobre a Mediz?</a></li>
                    <li><a href="#" data-toggle="modal" data-dismiss="modal" data-target="#pop-reset-pass">Esqueceu sua senha?</a></li>
                    <li><a href="<?php echo base_url('minha-conta')?>">Deseja atualizar seus dados de cadastro?</a></li>
                  </ul>
                </div>

                <div class="contact-info-block">
                  <?php
                  if(isset($campaigns['results']) && !empty($campaigns['results'])){
                    ?>
                    <ul>
                      <?php
                      foreach ($campaigns['results'] as $key => $campaign) {
                        ?>
                        <li><a href="<?php echo base_url($campaign['permalink']); ?>"><?php echo $campaign['titulo']; ?></a></li>
                        <?php
                      }
                      ?>
                    </ul>
                    <?php
                  }
                  ?>
                </div>

                <div class="contact-info-block">
                  <h4 class="contact-info-title">Ainda precisa de ajuda?</h4>
                  <p>Se você não encontrou a resposta para sua pergunta, entre em contato conosco e alguém da Mediz irá entrar em contato com você.</p>
                </div>
              </div>
              <div class="col-sm-4 col-xs-12 contact-block-inner">
                <div class="contact-info-block alert alert-info">
                  <p class="padding-top">
                    <strong>Endereço:</strong><br>
                    Rua Durval Fernandes Chaves, 188<br>
                    Jd. Santo Elias - Pirituba
                  </p>
                </div>

                <div class="contact-info-block alert alert-info">
                  <p class="padding-top">
                    <strong>Telefone:</strong><br>
                    (11) 3902-7180
                  </p>
                </div>

                <div class="contact-info-block alert alert-info">
                  <p class="padding-top">
                    <strong>E-mail:</strong><br>
                    <a href="mailto:contato@medizimoveis.com.br" class="text-info">contato@medizimoveis.com.br</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!--/.section-body-->






