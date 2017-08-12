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
                    <div class="profile-top">
                      <h2 class="title">Seus imóveis favoritos</h2>
                    </div>

                    <div class="account-block">
                        <div class="property-listing list-view">
                            <div class="row">
                              <?php echo isset($properties) ? $this->site->mustache('properties-search__property-item', $properties) : 'Nada encontrado'; ?>
                            </div>
                        </div>
                    </div>

                    <?php echo isset($properties['pagination']) ? $properties['pagination'] : ''; ?>

                </div>
            </div>
        </div>

    </section>
