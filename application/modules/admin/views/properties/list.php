<div class="content ">
  <div class="jumbotron lg-m-b-0" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
      <div class="inner">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
          <li><a class="active">Imóveis</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="panel panel-transparent">
      <div class="panel-body">
        <h1>Imóveis
          <a href="<?php echo base_url('admin/imoveis/adicionar'); ?>" class="btn btn-xs btn-primary">Adicionar imóvel</a>
        </h1>

        <?php
        if(isset($properties['results']) && !empty($properties['results'])){
          ?>
          <div class="table-responsive">
            <table class="table table-hover table-condensed" id="detailedTable">
              <thead>
                <tr>
                  <th><a href="<?php echo base_url('admin/imoveis/?orderby=property_id' . ($this->input->get('orderby') && $this->input->get('orderby') == 'property_id' ? ($this->input->get('order') && $this->input->get('order') == 'DESC' ? '' : '&order=DESC') : '')); ?>">ID</a></th>
                  <th>Tipo</th>
                  <th>Referência</th>
                  <th>Cidade</th>
                  <th>Bairro</th>
                  <th><a href="<?php echo base_url('admin/imoveis/?orderby=' . ($this->input->get('orderby') && $this->input->get('orderby') == 'lowest_price' ? 'biggest_price' : 'lowest_price')); ?>">Valor</a></th>
                  <th class="hidden-xs">Imagens</th>
                  <th><a href="<?php echo base_url('admin/imoveis/?orderby=update_date' . ($this->input->get('orderby') && $this->input->get('orderby') == 'update_date' ? ($this->input->get('order') && $this->input->get('order') == 'DESC' ? '' : '&order=DESC') : '')); ?>">Data</a></th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($properties['results'] as $property) {
                  // print_l($property);
                  ?>
                  <tr class="property-row" data-row_property_id="<?php echo $property['id']; ?>">
                    <td><?php echo $property['id']; ?></td>
                    <td class="v-align-middle bold"><?php echo $property['tipo']; ?></td>
                    <td class="v-align-middle semi-bold"><?php echo $property['referencia']; ?></td>
                    <td class="v-align-middle"><?php echo $property['endereco_cidade']; ?></td>
                    <td class="v-align-middle semi-bold"><?php echo $property['endereco_bairro']; ?></td>
                    <td class="v-align-middle"><?php echo $property['valor']; ?></td>
                    <td class="hidden-xs v-align-middle"><?php echo isset($property['imagens']) ? count($property['imagens']) : 0; ?></td>
                    <td><?php echo date('d/m H:i', strtotime($property['data_atualizado'])); ?></td>
                    <td><?php
                      switch ($property['status']) {
                        case 0:
                          ?>
                          <a href="javascript: void(0);" data-property_status="0" class="label label-danger alterar-status">Despublicado</a>
                          <?php
                        break;

                        case 1:
                          ?>
                          <a href="javascript: void(0);" data-property_status="1" class="label label-success alterar-status">Publicado</a>
                          <?php
                        break;
                      }
                    ?></td>
                    <td>
                      <a href="<?php echo base_url('admin/imoveis/'. $property['id'] .'/editar'); ?>" class="btn btn-info btn-xs">Editar</a>
                      <a href="javascript: void(0);" data-property_id="<?php echo $property['id']; ?>" data-property_reference="<?php echo $property['referencia']; ?>" class="btn btn-danger btn-xs btn-delete">Excluir</a>
                    </td>
                  </tr>
                  <?php

                }
                ?>
              </tbody>
            </table>
          </div>

          <?php echo $properties['pagination']; ?>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</a>
