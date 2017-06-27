var campaigns_list = app['campaigns_list'] = {};

$(function(){

  // Init
  campaigns_list.init = function(){



    $('.btn-delete').on('click', function(){
      var $this = $(this);

      swal({
        title: 'Você tem certeza?',
        text: 'Quer mesmo excluir definitivamente a campanha ' + $this.data('campaign_title') + ' e todo seu histórico? Essa ação não poderá ser revertida.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#666',
        confirmButtonText: 'Sim, pode excluir tudo',
        cancelButtonText: 'Cancelar'
      }).then(function () {
        window.location.href = app.base_url('admin/campanhas/' + $this.data('campaign_id') + '/excluir');
      });
    });


  };

  campaigns_list.init();

}); //$function
