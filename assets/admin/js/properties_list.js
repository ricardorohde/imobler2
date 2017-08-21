var properties_list = app['properties_list'] = {};

$(function(){

  // Init
  properties_list.init = function(){



    $('.btn-delete').on('click', function(){
      var $this = $(this);

      swal({
        title: 'Você tem certeza?',
        text: 'Quer mesmo excluir definitivamente o imóvel ' + $this.data('property_reference') + ' e todo seu histórico? Essa ação não poderá ser revertida.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#666',
        confirmButtonText: 'Sim, pode excluir tudo',
        cancelButtonText: 'Cancelar'
      }).then(function () {
        window.location.href = app.base_url('admin/imoveis/' + $this.data('property_id') + '/excluir');
      });
    });

    $('.alterar-status').on('click', function() {
      var $this = $(this);
      var property_id = $this.closest('.property-row').data('row_property_id');
      var property_status = $this.attr('data-property_status') == 0 ? 1 : 0;

      $.ajax({
        url: app.base_url('admin/api/alterar-status'),
        data: {
          'property_id': property_id,
          'property_status': property_status
        },
        method: 'post',
        dataType: 'json'
      }).done(function() {
        $this.attr('data-property_status', property_status).removeClass('label-danger label-success').addClass(property_status == 0 ? 'label-danger' : 'label-success').html(property_status == 0 ? 'Despublicado' : 'Publicado').blur();
      });

    });
  };

  properties_list.init();

}); //$function
