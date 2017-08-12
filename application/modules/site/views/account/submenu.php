<ul class="profile-menu-tabs">
  <li class="<?php echo isset($page['two']) && $page['two'] == 'profile' ? 'active': ''; ?>">
    <a href="<?php echo base_url('minha-conta'); ?>">Minha Conta</a>
  </li>
  <li class="<?php echo isset($page['two']) && $page['two'] == 'favorites' ? 'active': ''; ?>">
    <a href="<?php echo base_url('minha-conta/favoritos'); ?>">Imóveis favoritos</a>
  </li>
  <li> <a href="<?php echo base_url('anunciar-imovel'); ?>"> Anunciar imóvel </a></li>
</ul>

