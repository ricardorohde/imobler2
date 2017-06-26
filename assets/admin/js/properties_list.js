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


  };

  properties_list.init();

}); //$function
