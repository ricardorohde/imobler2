<div class="modal fade" id="pop-login" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <ul class="login-tabs">
          <li class="active">Entrar</li>
          <li>Cadastro</li>
        </ul>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
      </div>

      <div class="modal-body login-block">
        <div class="tab-content">
          <div class="tab-pane tab-pane-login fade in active">

            <div class="message">
              <p class="message-text"></p>
            </div>

            <form id="pop-login-form" method="post" action="<?php echo base_url('minha-conta/login'); ?>">
              <div class="form-group field-group">
                <div class="input-user input-icon">
                  <input type="text" name="email" required placeholder="E-mail">
                </div>

                <div class="input-pass input-icon">
                  <input type="password" name="senha" required="" placeholder="Senha">
                </div>
              </div>

              <div class="forget-block clearfix">
                <div class="form-group pull-left">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="lembrar" value="1">
                      Lembrar senha
                    </label>
                  </div>
                </div>

                <div class="form-group pull-right">
                  <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#pop-reset-pass">Esqueceu a senha?</a>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>

            <hr>
            <a href="#" class="btn btn-social btn-bg-facebook btn-block"><i class="fa fa-facebook"></i> Acessar com Facebook</a>
          </div>

          <div class="tab-pane tab-pane-register fade">
            <div class="message">
              <p class="message-text"></p>
            </div>

            <form id="pop-cadastro-form" method="post" action="<?php echo base_url('minha-conta/cadastro'); ?>">
              <div class="form-group field-group">
                <div class="input-user input-icon">
                  <input type="text" name="nome" required placeholder="Nome completo">
                </div>
                <div class="input-email input-icon">
                  <input type="email" name="email" required placeholder="E-mail">
                </div>
                <div class="input-pass input-icon">
                  <input type="password" name="senha" required placeholder="Senha">
                </div>
              </div>
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="termos" value="1">
                    Li e concordo com os <a href="<?php echo base_url('termos-e-condicoes'); ?>" target="_blank">Termos e Condições</a>.
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
            </form>
            <hr>

            <a href="#" class="btn btn-social btn-bg-facebook btn-block"><i class="fa fa-facebook"></i> Acessar com Facebook</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pop-reset-pass" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <ul class="login-tabs">
          <li class="active">Reset Password</li>
        </ul>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
      </div>
      <div class="modal-body">
        <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
        <form>
          <div class="form-group">
            <div class="input-user input-icon">
              <input placeholder="Enter your username or email" class="form-control">
            </div>
          </div>
          <button class="btn btn-primary btn-block">Get new password</button>
        </form>
      </div>
    </div>
  </div>
</div>
