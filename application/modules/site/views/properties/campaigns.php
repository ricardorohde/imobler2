<section id="section-body">
  <div class="container">
    <div class="page-title breadcrumb-top">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb"><li ><a href="/"><i class="fa fa-home"></i></a></li><li class="active"><?php echo $campaign['title']; ?></li></ol>
          <div class="page-title-left">
              <h2><?php echo $campaign['title']; ?></h2>
          </div>
          <div class="page-title-right">
            <div class="view hidden-xs">
              <div class="table-cell">
                <span class="view-btn btn-list"><i class="fa fa-th-list"></i></span>
                <span class="view-btn btn-grid"><i class="fa fa-th-large"></i></span>
                <span class="view-btn btn-grid-3-col active"><i class="fa fa-th"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <form id="properties-list-form" method="post" action="<?php echo base_url('buscar-imoveis'); ?>">
        <input type="hidden" name="campaign" value="<?php echo $campaign['permalink']; ?>">

        <div class="col-lg-12 col-md-12 col-sm-12 list-grid-area">
          <div id="content-area">

            <div class="list-tabs table-list full-width">
                <div class="tabs table-cell">
                    <ul>
                        <li>
                            <a href="#" class="active">À VENDA</a>
                        </li>
                    </ul>
                </div>
                <div class="sort-tab table-cell text-right">
                    <?php
                    if(isset($filters['orderby']) && !empty($filters['orderby'])){
                        ?>
                        <select name="orderby" class="selectpicker bs-select-hidden" id="property-listing-order" title="Ordenar por" data-live-search-style="begins" data-live-search="false">
                            <?php
                            foreach($filters['orderby'] as $orderby){
                                ?><option value="<?php echo $orderby['slug']; ?>" <?php echo isset($orderby['selected']) && $orderby['selected'] ? 'selected="true"' : ''; ?>><?php echo $orderby['name']; ?></option><?php
                            }
                            ?>
                        </select>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="property-listing grid-view grid-view-3-col">
                <div id="properties-list" class="row">
                    <?php echo isset($properties) ? $this->site->mustache('properties-search__property-item', $properties) : 'Nada encontrado'; ?>
                </div>
            </div>

            <div id="properties-pagination">
                <?php echo isset($properties['pagination']) ? $properties['pagination'] : ''; ?>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div>
</section>