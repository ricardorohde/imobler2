<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();

$transactions = ['venda'];

$route['api/(:any)'] = 'site/tools/$1';
$route['minha-conta/(:any)'] = 'site/account/$1';

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

$types = $db->get('imoveis_tipos')->result_array();
$types_arr = [];
foreach($types as $type){
  $types_arr[] = $type['slug'];
}
$types = implode('|', $types_arr);

$paging = ':num';

$route['default_controller'] = 'site/home';
$route['404_override'] = '';
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
$route['imovel/(:any)'] = function ($property_permalink){
  $params = array('route_params' => array(
    'params' => array(
      'property_permalink' => $property_permalink
    )
  ));

  return 'site/properties_details/index/' . json_encode($params);
};


