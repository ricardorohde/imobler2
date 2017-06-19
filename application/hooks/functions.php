<?php
function print_l($_array = null){
	if($_array){
		echo '<pre>' . print_r($_array, true) . '</pre>';
	}
}

function get_asset($path = null, $type = 'url', $force_module = false) {
  $router =& load_class('Router', 'core');
  $module = ($force_module ? $force_module : $router->fetch_module());

  return ($type == 'url' ? base_url('assets/' . $module) : FCPATH . 'assets/' . $module) . ($path ? '/' . $path : '');
}

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function get_current_url($field = null) {
  $return = array();

  $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
  $return['protocol'] = $protocol;

  $host = $_SERVER['HTTP_HOST'];
  $return['host'] = $host;

  $uri = ltrim(strtok($_SERVER["REQUEST_URI"], '?'), '/');
  if($uri){
    $return['uri'] = $uri;
  }

  $query_string = $_SERVER['QUERY_STRING'];
  if($query_string) {
    $return['query_string'] = $query_string;
  }

  $url = $return['protocol'] . '://' . $return['host'] . ($uri ? '/' . $return['uri'] : '') . ($query_string ? '?' . $return['query_string'] : '');
  $return['url'] = $url;

  $domain = implode('.', array_slice(explode('.', parse_url($url, PHP_URL_HOST)), -2));
  $return['domain'] = $domain;

  $subdomain = explode(".", $host);
  $subdomain = array_shift($subdomain);
  $return['subdomain'] = $subdomain === 'www' ? 'site' : $subdomain;

  if($field){
    if(isset($return[$field])){
      $return = $return[$field];
    }
  }

  return $return;
}
?>
