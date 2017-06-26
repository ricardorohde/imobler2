<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends Site_Controller {
  public function __construct() {
    parent::__construct();
  }

  public function error_404($params = null) {
    if($params) $params = json_decode($params, true);

    $data = array(
      'page' => array(
        'one' => 'home'
      ),

      'section' => array(),

      'assets' => array(
        'styles' => array(
        ),

        'scripts' => array(
        )
      )
    );

    $this->template->view('site/master', 'site/errors/404', $data);
  }
}
