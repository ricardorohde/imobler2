<div class="content ">
  <div class="jumbotron lg-m-b-0" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
          <li><a href="<?php echo base_url('admin/campanhas/categorias'); ?>">Categorias de campanhas</a></li>
          <li><a class="active"><?php echo $action == 'edit' ? 'Editando categoria de campanha ' . (isset($post['nome']) ? ' "' . $post['nome'] . '"' : '') : 'Adicionar categoria de campanha'; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="panel panel-transparent">
      <div class="panel-body">
        <h1 class="margin-bottom-50"><?php echo $action == 'edit' ? 'Editando categoria de campanha' . (isset($post['nome']) ? ' <strong>"' . $post['nome'] . '"</strong>' : '') : 'Adicionar categoria de campanha'; ?></h1>

        <?php $this->load->view('admin/includes/alertas', $this->_ci_cached_vars); ?>

        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" method="post" action="<?php echo base_url($form_action); ?>" enctype="multipart/form-data">

          <div class="form-group">
            <label for="nome" class="col-sm-3 control-label">Nome</label>
            <div class="col-sm-9">
              <div class="form-loading">
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo isset($post['nome']) ? $post['nome'] : ''; ?>" required>
              </div>
            </div>
          </div>

          <br>

          <div class="row">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-9">
              <button class="btn btn-success" type="submit"><?php echo $action == 'edit' ? 'Atualizar' : 'Adicionar campanha'; ?></button>
              <a href="<?php echo base_url('admin/campanhas/categorias'); ?>" class="btn btn-info">Cancelar</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>