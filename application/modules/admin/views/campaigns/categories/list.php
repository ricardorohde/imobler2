<div class="content ">
  <div class="jumbotron lg-m-b-0" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
          <li><a class="active">Categorias de campanhas</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="panel panel-transparent">
      <div class="panel-body">
        <h1>Categorias de campanhas</h1>

        <?php
        if(isset($categories['results']) && !empty($categories['results'])){
          ?>
          <div class="table-responsive">
            <table class="table table-hover table-condensed" id="detailedTable">
              <thead>
                <tr>
                  <th><a href="<?php echo base_url('admin/campanhas/categorias/?orderby=campanhas_categorias.id' . ($this->input->get('orderby') && $this->input->get('orderby') == 'campanhas_categorias.id' ? ($this->input->get('order') && $this->input->get('order') == 'DESC' ? '' : '&order=DESC') : '')); ?>">ID</a></th>
                  <th>Nome</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($categories['results'] as $campaign) {
                  // print_l($campaign);
                  ?>
                  <tr>
                    <td><?php echo $campaign['id']; ?></td>
                    <td class="v-align-middle bold"><?php echo $campaign['nome']; ?></td>
                    <td>
                      <?php
                      if($campaign['id'] != 1){
                        ?>
                        <a href="javascript: void(0);" data-category_id="<?php echo $campaign['id']; ?>" data-category_name="<?php echo $campaign['nome']; ?>" class="btn btn-danger btn-xs btn-delete">Excluir</a>
                        <a href="<?php echo base_url('admin/campanhas/categorias/'. $campaign['id'] .'/editar'); ?>" class="btn btn-info btn-xs">Editar</a>
                        <?php
                      }
                      ?>
                    </td>
                  </tr>
                  <?php

                }
                ?>
              </tbody>
            </table>
          </div>

          <?php echo isset($campaign['pagination']) ? $campaign['pagination'] : ''; ?>
          <?php
        }else{
          ?>
          <div class="alert alert-danger">Nenhuma categoria de campanha encontrada. <a href="<?php echo base_url('admin/campanhas/campanhas/adicionar'); ?>" class="alert-link">Clique aqui</a> para adicionar uma categoria de campanha.</div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</a>
