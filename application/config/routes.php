<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();

$transactions = ['venda'];

$route['api/(:any)'] = 'site/tools/$1';
$route['minha-conta'] = 'site/account';
$route['minha-conta/(login|login_facebook|cadastro)']['post'] = 'site/account/$1';
$route['minha-conta/favoritos'] = 'site/account/favoritos';
$route['minha-conta/favoritos/(:num)'] = 'site/account/favoritos/$1';
$route['minha-conta/(:any)'] = 'site/account/$1';

// Integrações
$route['vivareal.xml'] = 'site/properties_integrations/index/vivareal';
$route['mercado.xml'] = 'site/properties_integrations/index/mercado-livre';
$route['properati'] = 'site/properties_integrations/index/properati';


// == PÁGINAS ESTÁTICAS  == \\
foreach(array(
  'quem-somos' => 'who_we_are',
  'termos-de-uso' => 'terms_of_use',
  'politica-de-privacidade' => 'privacy_policy'
) as $slug => $page){
  $route[$slug] = 'site/pages/index/' . $page;
}

// == CONTATOS == \\
$route['fale-conosco'] = 'site/contacts/contact_us'; //Fale conosco
$route['trabalhe-conosco'] = 'site/contacts/work_with_us'; //Trabalhe conosco

// Formulário para os usuários enviarem indformações de imóveis a venda
$route['anunciar-imovel'] = 'site/properties_add'; //Anunciar um imóvel

$states = $db->get('estados')->result_array();
$states_arr = [];
foreach($states as $state){
  $states_arr[] = $state['sigla'];
}
$states = implode('|', $states_arr);

$cities = $db->get('cidades')->result_array();
$cities_arr = [];
foreach($cities as $city){
  $cities_arr[] = $city['slug'];
}
$cities = implode('|', $cities_arr);

$campaigns = $db->select('campanhas.permalink')->get_where('campanhas', array('status' => 1))->result_array();
$campaigns_arr = [];
foreach($campaigns as $campaign){
  $campaigns_arr[] = $campaign['permalink'];
}
$campaigns = implode('|', $campaigns_arr);

$types = $db->get('imoveis_tipos')->result_array();
$types_arr = [];
foreach($types as $type){
  $types_arr[] = $type['slug'];
}
$types = implode('|', $types_arr);

$paging = ':num';

$route['default_controller'] = 'site/home';
$route['404_override'] = 'site/errors/error_404';
$route['translate_uri_dashes'] = TRUE;

$route['configjs'] = 'site/tools/configjs';

$route['buscar-imoveis'] = 'site/tools/buscar-imoveis';

//.../venda/
$route['('. implode('|', $transactions) .')'] = function ($transaction){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/ - Paginação
$route['('. implode('|', $transactions) .')/('.$paging.')'] = function ($transaction, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/apartamento
$route['('. implode('|', $transactions) .')/('. $types .')'] = function ($transaction, $type){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type]
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/apartamento - Paginação
$route['('. implode('|', $transactions) .')/('. $types .')/('.$paging.')'] = function ($transaction, $type, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type]
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/
$route['('. implode('|', $transactions) .')/('.$states.')'] = function ($transaction, $state){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'location' => array(
          array(
            'state' => $state
          )
      )
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/ - Paginação
$route['('. implode('|', $transactions) .')/('.$states.')/('.$paging.')'] = function ($transaction, $state, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'location' => array(
          array(
            'state' => $state
          )
      )
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/apartamento
$route['('. implode('|', $transactions) .')/('.$states.')/('. $types .')'] = function ($transaction, $state, $type){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state
          )
      )
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/apartamento - Paginação
$route['('. implode('|', $transactions) .')/('.$states.')/('. $types .')/('.$paging.')'] = function ($transaction, $state, $type, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state
          )
      )
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')'] = function ($transaction, $state, $city){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'location' => array(
          array(
            'state' => $state,
            'city' => $city
          )
      )
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/ - Paginação
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/('.$paging.')'] = function ($transaction, $state, $city, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'location' => array(
          array(
            'state' => $state,
            'city' => $city
          )
      )
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/apartamento/
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/('. $types .')'] = function ($transaction, $state, $city, $type){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state,
            'city' => $city
          )
      )
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/apartamento/ - paginação
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/('. $types .')/('.$paging.')'] = function ($transaction, $state, $city, $type, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state,
            'city' => $city
          )
      )
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/(bairro)
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/(:any)'] = function ($transaction, $state, $city, $district){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'location' => array(
          array(
            'state' => $state,
            'city' => $city,
            'district' => $district
          )
      )
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/(bairro) - Paginaçãp
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/(:any)/('.$paging.')'] = function ($transaction, $state, $city, $district, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'location' => array(
          array(
            'state' => $state,
            'city' => $city,
            'district' => $district
          )
      )
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/(bairro)/apartamento
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/(:any)/('. $types .')'] = function ($transaction, $state, $city, $district, $type){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state,
            'city' => $city,
            'district' => $district
          )
      )
    )
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

//.../venda/sp/sao-paulo/(bairro)/apartamento - Paginação
$route['('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/(:any)/('. $types .')/('.$paging.')'] = function ($transaction, $state, $city, $district, $type, $page){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state,
            'city' => $city,
            'district' => $district
          )
      )
    ),
    'page' => $page
  ));
  return 'site/properties_search/index/' . json_encode($params);
};

// Atalho para ficha do imóvel - Ex: /3456 -- Redireciona para URL da Ficha do imóvel (Slug ou Estruturado)
$route['(:num)'] = function ($property_id){
  $params = array('route_params' => array(
    'params' => array(
      'property_id' => $property_id
    )
  ));

  return 'site/properties_details/redirect/' . json_encode($params);
};

//.../imovel/venda/sp/sao-paulo/parque-sao-domingos/apartamento/7319
$route['imovel/('. implode('|', $transactions) .')/('.$states.')/('.$cities.')/(:any)/('. $types .')/(:num)'] = function ($transaction, $state, $city, $district, $type, $property_id){
  $params = array('route_params' => array(
    'params' => array(
      'transaction' => $transaction,
      'properties_types' => [$type],
      'location' => array(
          array(
            'state' => $state,
            'city' => $city,
            'district' => $district
          )
      ),
      'property_id' => $property_id
    )
  ));
  return 'site/properties_details/index/' . json_encode($params);
};

// Ficha do imóvel - Slug - Ex: /imovel/apartamento-a-venda-no-portal-dos-bandeirantes-id-2349
$route['imovel/(:any)-id-(:num)'] = function ($property_permalink, $property_id){
  $params = array('route_params' => array(
    'params' => array(
      'property_permalink' => $property_permalink,
      'property_id' => $property_id
    )
  ));

  return 'site/properties_details/index/' . json_encode($params);
};

// Ficha do imóvel - Antigo - Ex: /cobertura-moooca-id-1234
$route['(:any)-id-(:num)'] = function ($property_permalink, $property_id){
  $params = array('route_params' => array(
    'params' => array(
      'property_permalink' => $property_permalink,
      'property_id' => $property_id,
    )
  ));

  return 'site/properties_details/redirect/' . json_encode($params);
};

//.../apartamentos-2-dorms-parque-sao-domingos/
$route['('. $campaigns .')'] = function ($campaign_permalink){
  $params = array('route_params' => array(
    'campaign' => $campaign_permalink
  ));
  return 'site/properties_campaigns/index/' . json_encode($params);
};

//.../apartamentos-2-dorms-parque-sao-domingos/2 - Paginação
$route['('. $campaigns .')/('.$paging.')'] = function ($campaign_permalink, $page){
  $params = array('route_params' => array(
    'campaign' => $campaign_permalink,
    'page' => $page
  ));
  return 'site/properties_campaigns/index/' . json_encode($params);
};


// ADMIN
$route['admin/api/(:any)'] = 'admin/tools/$1';
$route['admin'] = 'admin/dashboard';

$route['admin/login'] = 'admin/Account__login';
$route['admin/logout'] = 'admin/Account__logout';
$route['admin/esqueci-minha-senha'] = 'admin/Account__forgot_password';



// Imoveis
$route['admin/imoveis'] = 'admin/properties__list';
$route['admin/imoveis/(:num)'] = 'admin/properties__list/index/$1';
$route['admin/imoveis/adicionar'] = 'admin/properties__edit';
$route['admin/imoveis/(:num)/editar'] = 'admin/properties__edit/index/$1';
$route['admin/imoveis/(:num)/excluir'] = 'admin/properties__edit/excluir/$1';

// Campanhas
$route['admin/campanhas'] = 'admin/campaigns__list';
$route['admin/campanhas/(:num)'] = 'admin/campaigns__list/index/$1';
$route['admin/campanhas/adicionar'] = 'admin/campaigns__edit';
$route['admin/campanhas/(:num)/editar'] = 'admin/campaigns__edit/index/$1';
$route['admin/campanhas/(:num)/excluir'] = 'admin/campaigns__edit/excluir/$1';

$route['admin/campanhas/categorias'] = 'admin/campaigns__categories__list';
$route['admin/campanhas/categorias/(:num)'] = 'admin/campaigns__categories__list/index/$1';
$route['admin/campanhas/categorias/adicionar'] = 'admin/campaigns__categories__edit';
$route['admin/campanhas/categorias/(:num)/editar'] = 'admin/campaigns__categories__edit/index/$1';
$route['admin/campanhas/categorias/(:num)/excluir'] = 'admin/campaigns__categories__edit/excluir/$1';

