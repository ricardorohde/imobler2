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


  //return ($type == 'url' ? base_url('assets/' . $module) : FCPATH . $module) . ($path ? '/' . $path : '');
}
?>
