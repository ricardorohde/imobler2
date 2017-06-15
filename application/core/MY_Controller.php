<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

// Base Controller
class Default_Controller extends MX_Controller {
  function __construct() {
    parent::__construct();
    header('Content-Type: text/html; charset=utf-8');

    $this->output->enable_profiler(FALSE);
  }
}

// Pages Controller
class Site_Controller extends Default_Controller {
  function __construct() {
    parent::__construct();

    $this->load->add_package_path(APPPATH . 'modules/site/');
    $this->load->library(array('site'));

    $config = [
      'paths' => [get_asset('templates', 'path'), VIEWPATH],
      'cache' => false
    ];

    $this->load->library('twig', $config);
  }
}
