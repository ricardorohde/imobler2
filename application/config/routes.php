<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'site/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['configjs'] = 'site/tools/configjs';



$route['teste'] = function (){


  $params = array('route_params' => array(
    'limit' => 1,
    'params' => array(
      'property_type' => ['casa'],
      'bathrooms' => 3,
      'features' => ['piscina']
    ),
    'row' => true
  ));


  return 'site/home/index/' . json_encode($params);
};