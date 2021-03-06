<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site {
  function __construct(){
    $this->ci =& get_instance();
    // $this->router =& load_class('Router', 'core');
    // $router

    // $module = ($force_module ? $force_module : $this->ci->router->fetch_module());
//
/*    // Tentar Autologin
    if(!$this->ci->session->userdata('tentativa_autologin')){
      $this->autologin();
    }*/
  }

  public function create_pagination($page, $limit, $total_rows, $base_url, $num_links = 5, $url_suffix = null){
    $this->ci->load->library('pagination');

    $config = array();
    $config["cur_page"] = $page;
    $config["base_url"] = $base_url; // Set base_url for every links
    if($url_suffix){
      $config['suffix'] = '?_=' . $url_suffix;//$url_suffix;
      $config['first_url'] = $config['base_url'] . $config['suffix'];
    }
    $config["total_rows"] = $total_rows; // Set total rows in the result set you are creating pagination for.
    $config["per_page"] = $limit; // Number of items you intend to show per page.
    $config['reuse_query_string'] = TRUE;
    $config['use_page_numbers'] = TRUE; // Use pagination number for anchor URL.
    $config['rel'] = FALSE; // Use pagination number for anchor URL.
    $config['num_links'] = $num_links; //Set that how many number of pages you want to view.
    $config['full_tag_open'] = '<hr><div class="pagination-main"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></div><!--pagination-->';
    $config['first_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
    $config['first_tag_open'] = '<li class="prev page">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
    $config['last_tag_open'] = '<li class="next page">';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = '<span aria-hidden="true"><i class="fa fa-angle-right"></i></span>';
    $config['next_tag_open'] = '<li class="next page">';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>';
    $config['prev_tag_open'] = '<li class="prev page">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page">';
    $config['num_tag_close'] = '</li>';
    $config['anchor_class'] = 'follow_link';
    $config['attributes'] = array('class' => 'pagination-item');

    // To initialize "$config" array and set to pagination library.
    $this->ci->pagination->initialize($config);

    return $this->ci->pagination->create_links();
  }

  public function mustache($template, $data = null){
    // $entry = new Mustache_Engine;

    $entry = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(get_asset('templates', 'path')),
    ));

    // $this->ci->load->helper('file');
    // $template = read_file(get_asset("templates/" . $template . ".mustache", 'path'));

    $data['site_base_url'] = base_url();

    $rendered = $entry->render($template, $data);

    return $rendered;
  }

  public function create_url_filter($route_params) {
    $return = array();

    if(isset($route_params['campaign'])){
      $uri = '/' . $route_params['campaign'] . '/';
    }else{
      $uri = '/';

      if(isset($route_params['params']['transaction'])){
        $uri .= $route_params['params']['transaction'] . '/';
      }

      if(isset($route_params['params']['location'][0])){
        if(isset($route_params['params']['location'][0]['state'])){
          $uri .= $route_params['params']['location'][0]['state'] . '/';
        }
        if(isset($route_params['params']['location'][0]['city'])){
          $uri .= $route_params['params']['location'][0]['city'] . '/';
        }
        if(isset($route_params['params']['location'][0]['district'])){
          $uri .= $route_params['params']['location'][0]['district'] . '/';
        }
      }

      if(isset($route_params['params']['properties_types'][0])){
        $uri .= $route_params['params']['properties_types'][0] . '/';
      }
    }

    $return['uri'] = $uri;

    if(isset($route_params['page'])){
      $return['page'] = $route_params['page'];
    }

    $route_params['orderby'] = isset($route_params['orderby']) ? $route_params['orderby'] : 'lowest_price';

    $return['filter'] = base64url_encode(json_encode($route_params));

    $return['uri_full'] = $uri . (isset($route_params['page']) ? $route_params['page'] : '') . '?_=' . $return['filter'];

    return $return;
  }

  public function user_logged($condition = TRUE, $redirect = NULL, $section = null){
    $section = ($section ? $section : ($this->ci->router->fetch_module() == 'site' ? 'usuario_logado' : 'admin_logado'));

    $login_check = $this->ci->session->userdata($section);
    $is_logged = $login_check ? TRUE : FALSE;

    if($is_logged == $condition){
      if($redirect){
        if($redirect === TRUE){
          $redirect = ($this->ci->router->fetch_module() == 'site' ? 'minha-conta/login' : 'admin/login');
        }
        $this->ci->session->set_flashdata('redirect', base_url($this->ci->uri->uri_string()));
        redirect(base_url($redirect), 'location');
      }
      return TRUE;
    }
    return FALSE;
  }

  public function userinfo($slug, $section = null){
    $section = ($section ? $section : ($this->ci->router->fetch_module() == 'site' ? 'usuario_logado' : 'admin_logado'));
    if($this->user_logged(TRUE, NULL, $section)){
      $usuario = $this->ci->session->userdata($section);
      if(isset($usuario[$slug])){
        return $usuario[$slug];
      }
    }
    return false;
  }

  public function get_redirect($local = null) {
    $redirect = base_url($local ? $local : '');
    if($this->ci->input->post("redirect")) {
      $redirect = $this->ci->input->post("redirect");
    }else{
      if($this->ci->session->tempdata('redirect')) {
        $redirect = $this->ci->session->tempdata('redirect');
        $this->ci->session->unset_tempdata('redirect');
      }
    }
    return $redirect;
  }

  public function form_error($erros){
    $return = array();
    $erro_item = '';
    if($erros){
      foreach($erros as $key => $value){
        $erro_item .= '&bull; ' . $value . '<br>';
        $return['erros'][$key] = $value;
      }
    }

    $return['alerta'] = array(
      'type' => 'danger',
      'message' => $erro_item,
      'status' => 'visible'
    );

    return $return;
  }

  public function alerta_redirect($alertaClass = 'danger', $mensagem = 'Ocorreu um erro inesperado.', $redirect = null, $status = 'visible', $extraClass = array()){
    $alerta = array(
      'alerta' => array(
        'type' => $alertaClass,
        'message' => $mensagem,
        'status' => $status,
        'class' => $extraClass
      )
    );

    if($redirect){
      $this->ci->session->set_flashdata('alerta', $alerta);
      $redirect = (strpos($redirect, '//') === false) ? base_url($redirect) : $redirect;
      redirect($redirect, 'location');
      exit;
    }

    return $alerta;
  }

  public function curl_get_result($url, $vars = '', $http_method = '') {
    $ch = curl_init();
    $timeout = 5;

    curl_setopt($ch,CURLOPT_URL, $url);

    if($http_method){
      if($http_method == 'POST'){
        curl_setopt($ch, CURLOPT_POST, 1);
      }else{
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
      }
    }

    if($vars){
      curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }


/*
  public function autologin(){
    if($this->user_logged(FALSE)){
      $this->ci->load->model('account_model');

      $get_cookie = get_cookie($this->ci->config->item('login_cookie_name'));
      if($get_cookie){
        if($usuario = $this->ci->account_model->login(array('login_cookie' => $get_cookie))){
          $this->ci->account_model->login_process($usuario);
        }else{
          $this->ci->session->set_userdata('tentativa_autologin', true);
        }
      }else{
        $this->ci->session->set_userdata('tentativa_autologin', true);
      }
    }
  }


  public function get_property_url($property = 0){
    $this->ci->load->model('properties_model');
    return $this->ci->properties_model->get_property_permalink($property);
  }

  public function get_filter($item, $params = array()) {
    $return = '';

    if($item == 'property_types'){
      $return = $this->ci->properties_model->get_property_types($params);
    }

    if($item == 'property_location'){
      $return = $this->ci->properties_model->get_location($params);
    }

    if($item == 'property_features'){
      $return = $this->ci->properties_model->get_properties_features(array(), true);
    }

    return $return;
  }

  public function get_filters($item = 'all', $params = array()){
    $this->ci->load->model('properties_model');

    if($item != 'all'){
      $return = $this->get_filter($item, $params);
    }else{
      foreach(array('property_types', 'property_location', 'property_features') as $filter){
        $return[$filter] = $this->get_filter($filter, $params);
      }
    }

    return $return;
  }

  public function get_templates($templates = array()) {
    if(!empty($templates)){
      foreach ($templates as $template) {
        ?>
        <script id="template__<?php echo $template; ?>" type="x-tmpl-mustache">
          <?php $this->ci->load->view('site/includes/templates/'. $template .'.mustache'); ?>
        </script>
        <?php
      }
    }
  }




*/
}
