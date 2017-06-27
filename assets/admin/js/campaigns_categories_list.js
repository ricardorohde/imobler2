var campaigns_categories_list = app['campaigns_categories_list'] = {};

$(function(){

  // Init
  campaigns_categories_list.init = function(){



    $('.btn-delete').on('click', function(){
      var $this = $(this);

      swal({
        title: 'Você tem certeza?',
        text: 'Quer mesmo excluir definitivamente a categoria ' + $this.data('category_name') + '? Ao excluir uma categoria, você também excluirá todas as campanhas relacionadas a ela e essa ação não poderá ser revertida.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#666',
        confirmButtonText: 'Sim, pode excluir tudo',
        cancelButtonText: 'Cancelar'
      }).then(function () {
        window.location.href = app.base_url('admin/campanhas/categorias/' + $this.data('category_id') + '/excluir');
      });
    });


  };

  campaigns_categories_list.init();

}); //$function
