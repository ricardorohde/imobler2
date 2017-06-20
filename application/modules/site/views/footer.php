<footer class="footer-v2">
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="footer-widget widget-about">
            <div class="widget-top">
              <h3 class="widget-title">Sobe a Mediz</h3>
            </div>
            <div class="widget-body">
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry ipsum has been the industry.</p>
              <p class="read"><a href="<?php echo base_url('quem-somos'); ?>">Conheça-nos <i class="fa fa-caret-right"></i></a></p>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="footer-widget widget-contact">
            <div class="widget-top">
              <h3 class="widget-title">Entre em contato</h3>
            </div>
            <div class="widget-body">
              <ul class="list-unstyled">
                <li><i class="fa fa-location-arrow"></i> Rua Durval Fernandes Chaves, 188<br>Jd. Santo Elias - Pirituba</li>
                <li><i class="fa fa-phone"></i> (11) 3902-7180</li>
                <li><i class="fa fa-envelope-o"></i> <a href="mailto:contato@medizimoveis.com.br">contato@medizimoveis.com.br</a></li>
              </ul>
              <p class="read"><a href="<?php echo base_url('fale-conosco'); ?>">Fale conosco <i class="fa fa-caret-right"></i></a></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="footer-widget widget-newsletter">
            <div class="widget-top">
              <h3 class="widget-title">Assine nossa newsletter</h3>
            </div>
            <div class="widget-body">
              <form>
                <div class="table-list">
                  <div class="form-group table-cell">
                    <div class="input-email input-icon">
                      <input class="form-control" placeholder="Enter your email">
                    </div>
                  </div>
                  <div class="table-cell">
                    <button class="btn btn-primary">Enviar</button>
                  </div>
                </div>
              </form>
              <p>Pode ficar tranquilo! Nos responsabilizamos em não enviar nenhum SPAN e também em não divulgar seu e-mail à ninguém.</p>
              <ul class="social">
                <li>
                  <a target="_blank" href="<?php echo $this->config->item('link_social_facebook'); ?>" class="btn-facebook"><i class="fa fa-facebook-square"></i></a>
                </li>
                <li>
                  <a target="_blank" href="<?php echo $this->config->item('link_social_twitter'); ?>" class="btn-twitter"><i class="fa fa-twitter-square"></i></a>
                </li>
                <li>
                  <a target="_blank" href="<?php echo $this->config->item('link_social_instagram'); ?>" class="btn-instagram"><i class="fa fa-instagram"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4">
          <div class="footer-col">
            <p><?php echo $this->config->item('site_nome'); ?> - Todos os direitos reservados</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="footer-col">
            <div class="navi">
              <ul id="footer-menu" class="">
                <li><a href="<?php echo base_url('politica-de-privacidade'); ?>">Política de privacidade</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="footer-col foot-social">
            <p>
              <a target="_blank" class="btn-facebook" href="<?php echo $this->config->item('link_social_facebook'); ?>"><i class="fa fa-facebook-square"></i></a>
              <a target="_blank" class="btn-twitter" href="<?php echo $this->config->item('link_social_twitter'); ?>"><i class="fa fa-twitter-square"></i></a>
              <a target="_blank" class="btn-instagram" href="<?php echo $this->config->item('link_social_instagram'); ?>"><i class="fa fa-instagram"></i></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer><!--/footer-->
