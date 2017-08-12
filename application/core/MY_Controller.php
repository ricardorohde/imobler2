<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

// Base Controller
class Default_Controller extends MX_Controller {
  function __construct() {
    parent::__construct();
    header('Content-Type: text/html; charset=utf-8');

    require_once APPPATH . 'third_party/Mustache/Autoloader.php';
    Mustache_Autoloader::register();

    require_once APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php';

    $this->output->enable_profiler(false);
  }
}

// Pages Controller
class Site_Controller extends Default_Controller {
  function __construct() {
    parent::__construct();

    $this->load->add_package_path(APPPATH . 'modules/site/');
    // $this->load->library(array('site'));
  }
}

// Admin Controller
class Admin_Controller extends Default_Controller {
  function __construct() {
    parent::__construct();
    $this->load->add_package_path(APPPATH . 'modules/admin/');
  // $this->load->library(array('admin'));
  }
}
