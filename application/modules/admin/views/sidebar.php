<!-- BEGIN SIDEBPANEL-->
<nav class="page-sidebar" data-pages="sidebar">
  <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
  <div class="sidebar-overlay-slide from-top" id="appMenu">
    <div class="row">
      <div class="col-xs-6 no-padding">
        <a href="#" class="p-l-40"><img src="<?php echo get_asset('img/demo/social_app.svg'); ?>" alt="socail">
        </a>
      </div>
      <div class="col-xs-6 no-padding">
        <a href="#" class="p-l-10"><img src="<?php echo get_asset('img/demo/email_app.svg'); ?>" alt="socail">
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 m-t-20 no-padding">
        <a href="#" class="p-l-40"><img src="<?php echo get_asset('img/demo/calendar_app.svg'); ?>" alt="socail">
        </a>
      </div>
      <div class="col-xs-6 m-t-20 no-padding">
        <a href="#" class="p-l-10"><img src="<?php echo get_asset('img/demo/add_more.svg'); ?>" alt="socail">
        </a>
      </div>
    </div>
  </div>
  <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
  <!-- BEGIN SIDEBAR MENU HEADER-->
  <div class="sidebar-header">
    <img src="<?php echo get_asset('img/logo_white.png'); ?>" alt="logo" class="brand" data-src="<?php echo get_asset('img/logo_white.png'); ?>" data-src-retina="<?php echo get_asset('img/logo_white_2x.png'); ?>" width="78" height="22">
    <div class="sidebar-header-controls">
      <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
      </button>
      <button type="button" class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
      </button>
    </div>
  </div>
  <!-- END SIDEBAR MENU HEADER-->
  <!-- START SIDEBAR MENU -->
  <div class="sidebar-menu">
    <!-- BEGIN SIDEBAR MENU ITEMS-->
    <ul class="menu-items">

      <li class="m-t-30 <?php echo isset($page['one']) && $page['one'] == 'dashboard' ? 'active' : ''; ?>">
        <a href="<?php echo base_url('admin'); ?>">
          <span class="title">Dashboard</span>
        </a>
        <span class="bg-info icon-thumbnail"><i class="pg-home"></i></span>
      </li>

      <li class="<?php echo isset($page['one']) && $page['one'] == 'properties' ? 'open active' : ''; ?>">
        <a href="javascript:;"><span class="title">Imóveis</span>
        <span class="<?php echo isset($page['one']) && $page['one'] == 'properties' ? 'open' : ''; ?> arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-building-o"></i></span>

        <ul class="sub-menu">
          <li class="<?php echo isset($page['two']) && $page['two'] == 'list' && isset($page['one']) && $page['one'] == 'properties' ? 'active' : ''; ?>">
            <a href="<?php echo base_url('admin/imoveis'); ?>">Todos os imóveis</a>
            <span class="icon-thumbnail">ti</span>
          </li>

          <li class="<?php echo isset($page['two']) && $page['two'] == 'add' && isset($page['one']) && $page['one'] == 'properties' ? 'active' : ''; ?>">
            <a href="<?php echo base_url('admin/imoveis/adicionar'); ?>">Adicionar imóvel</a>
            <span class="icon-thumbnail">ai</span>
          </li>
        </ul>
      </li>

      <li class="<?php echo isset($page['one']) && $page['one'] == 'campaigns' ? 'open active' : ''; ?>">
        <a href="javascript:;"><span class="title">Campanhas</span><span class="<?php echo isset($page['one']) && $page['one'] == 'campaigns' ? 'open' : ''; ?> arrow"></span></a>
        <span class="icon-thumbnail"><i class="fa fa-building-o"></i></span>

        <ul class="sub-menu">
          <li class="<?php echo isset($page['two']) && $page['two'] == 'list' && isset($page['one']) && $page['one'] == 'campaigns' ? 'active' : ''; ?>">
            <a href="<?php echo base_url('admin/campanhas'); ?>">Todas as campanhas</a>
            <span class="icon-thumbnail">tc</span>
          </li>

          <li class="<?php echo isset($page['two']) && $page['two'] == 'add' && isset($page['one']) && $page['one'] == 'campaigns' ? 'active' : ''; ?>">
            <a href="<?php echo base_url('admin/campanhas/adicionar'); ?>">Adicionar campanha</a>
            <span class="icon-thumbnail">ac</span>
          </li>

          <li class="<?php echo isset($page['two']) && $page['two'] == 'categories' && isset($page['one']) && $page['one'] == 'campaigns' ? 'active' : ''; ?>">
            <a href="javascript:;"><span class="title">Categorias</span><span class="arrow"></span></a>
            <span class="icon-thumbnail">cc</span>

            <ul class="sub-menu">
              <li class="<?php echo isset($page['three']) && $page['three'] == 'list' && isset($page['two']) && $page['two'] == 'categories' && isset($page['one']) && $page['one'] == 'campaigns' ? 'active' : ''; ?>">
                <a href="<?php echo base_url('admin/campanhas/categorias'); ?>">Todas as categorias</a>
                <span class="icon-thumbnail">tc</span>
              </li>

              <li class="<?php echo isset($page['three']) && $page['three'] == 'add' && isset($page['two']) && $page['two'] == 'categories' && isset($page['one']) && $page['one'] == 'campaigns' ? 'active' : ''; ?>">
                <a href="<?php echo base_url('admin/campanhas/categorias/adicionar'); ?>">Adicionar categoria</a>
                <span class="icon-thumbnail">ac</span>
              </li>
            </ul>
          </li>
        </ul>
      </li>

      <li class="<?php echo isset($page['one']) && $page['one'] == 'users' ? 'open active' : ''; ?>">
        <a href="<?php echo base_url('admin/usuarios'); ?>">
          <span class="title">Usuários</span>
        </a>
        <span class="icon-thumbnail"><i class="fa fa-user"></i></span>
      </li>

    </ul>

    <div class="clearfix"></div>
  </div>
  <!-- END SIDEBAR MENU -->
</nav>
<!-- END SIDEBAR -->
<!-- END SIDEBPANEL-->