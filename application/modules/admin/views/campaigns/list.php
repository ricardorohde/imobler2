<div class="content ">
  <div class="jumbotron lg-m-b-0" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
          <li><a class="active">Campanhas</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="panel panel-transparent">
      <div class="panel-body">
        <h1>Campanhas</h1>

        <?php
        if(isset($campaigns['results']) && !empty($campaigns['results'])){
          ?>
          <div class="table-responsive">
            <table class="table table-hover table-condensed" id="detailedTable">
              <thead>
                <tr>
                  <th><a href="<?php echo base_url('admin/campanhas/?orderby=campanhas.id' . ($this->input->get('orderby') && $this->input->get('orderby') == 'campanhas.id' ? ($this->input->get('order') && $this->input->get('order') == 'DESC' ? '' : '&order=DESC') : '')); ?>">ID</a></th>
                  <th>Categoria</th>
                  <th>Nome</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($campaigns['results'] as $campaign) {
                  // print_l($campaign);
                  ?>
                  <tr>
                    <td><?php echo $campaign['id']; ?></td>
                    <td class="v-align-middle bold"><?php echo $campaign['categoria_nome']; ?></td>
                    <td class="v-align-middle semi-bold"><?php echo $campaign['titulo']; ?></td>
                    <td class="v-align-middle"><?php echo ($campaign['status'] == 1 ? '<span class="label label-success">Publicado</span>' : '<span class="label label-danger">Despublicado</span>'); ?></td>
                    <td>
                      <a href="<?php echo base_url('admin/campanhas/'. $campaign['id'] .'/editar'); ?>" class="btn btn-info btn-xs">Editar</a>
                      <a href="javascript: void(0);" data-campaign_id="<?php echo $campaign['id']; ?>" data-campaign_title="<?php echo $campaign['titulo']; ?>" class="btn btn-danger btn-xs btn-delete">Excluir</a>
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
          <div class="alert alert-danger">Nenhuma campanha encontrada. <a href="<?php echo base_url('admin/campanhas/adicionar'); ?>" class="alert-link">Clique aqui</a> para adicionar uma campanha.</div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</a>
