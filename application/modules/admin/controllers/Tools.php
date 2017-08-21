<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Admin_Controller {
	function __construct() {
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

	function configjs() {
		$this->load->view('admin/configjs');
	}

  function menu_pin($status) {

    if($status == 'true'){
      $status = 'fixed';
      set_cookie('menu-pin', true, (60*60*24*30*3), '', '/admin');
    }else{
      $status = 'unfixed';
      delete_cookie('menu-pin', '', '/admin');
    }

    echo json_encode(array('status' => $status));
  }

  function buscar_coordenadas($endereco = null, $echo = true, $format = 'json'){
    $endereco = ($endereco ? $endereco : ($this->input->post('endereco') ? $this->input->post('endereco') : ''));

    $response = $this->site->curl_get_result("http://maps.google.com/maps/api/geocode/json?region=BR&address=". str_replace(" ", "+", $endereco) ."&sensor=false", "", "GET");
    $response = json_decode($response, true);

    if(isset($response["results"][0]["geometry"]["location"])){
      $return = array(
        'latitude' => $response["results"][0]["geometry"]["location"]["lat"],
        'longitude' => $response["results"][0]["geometry"]["location"]["lng"]
      );
    }else{
      $return = array('error' => 'A coordenada não foi encontrada.');
    }

    if($echo && $format == 'json'){
      echo json_encode($return);
    }else{
      return $format == 'json' ? json_encode($return) : $return;
    }
  }

  function buscar_cep($cep){
    $cep = preg_replace('/[^0-9]/','', $cep);
    $response = json_decode($this->site->curl_get_result('https://viacep.com.br/ws/'. $cep . '/json/', '', 'GET'), true);

    if(!isset($response['erro'])){
      $coordenadas = $this->buscar_coordenadas($response['logradouro'] . '+-+' . $response['bairro'] . '+-+' . $response['localidade'], false, 'array');
      if(!isset($coordenadas['error'])){
        $response['coordenadas'] = $coordenadas;
      }
    }

    echo json_encode($response);
  }

  function enviar_imagens() {
    $return = array();
    $image_array = array();

    $upload_folder = $this->input->post('upload_folder');

    if($this->input->post('property_id')){
      $property_id = $this->input->post('property_id');
      $image_array['imovel'] = $property_id;
    }else{
      $property_guid = $this->input->post('property_guid');
      $image_array['imovel_temp'] = $property_guid;
    }

    $path_uri = 'assets/uploads/' . $upload_folder . '/' . (isset($property_id) ? $property_id : $property_guid) . '/';
    $path_upload = FCPATH . $path_uri;

    if(!file_exists($path_upload)) {
      mkdir($path_upload, 0755, true);
    }

    $file_name = $_FILES["file"]["name"];
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    $return['arquivo'] = md5((isset($property_id) ? $property_id : $property_guid) . $file_name . microtime(false) . rand(0,9999))  . '.' . $file_extension;

    $image_array['arquivo'] = $return['arquivo'];

    if(move_uploaded_file($_FILES["file"]["tmp_name"], $path_upload . $return['arquivo'])){
      $return['success'] = true;

      $this->load->model('properties_model');

      if(isset($property_id)){
        $property_id = $this->input->post('property_id');
      }else{
        $property_guid = $this->input->post('property_guid');
      }

      $return['id'] = $this->properties_model->add_property_image($image_array);
    }

    echo json_encode($return);
  }

  function imagens() {
    $this->load->model('properties_model');

    $imagens = $this->properties_model->properties_images_uploads($this->input->post());

    echo json_encode($imagens);
  }

  function excluir_imagens() {
    $this->load->model('properties_model');
    $this->properties_model->properties_excluir_images($this->input->post());
    echo json_encode(array('success'));
  }

  function atualizar_imagem() {
    $this->load->model('properties_model');
    echo $this->properties_model->properties_atualizar_images($this->input->post());
  }

  function ordenar_imagens() {
    $imagens = $this->input->post('imagens');
    foreach ($imagens as $key => $value) {
      $this->db->update('imoveis_imagens', array('ordem' => $key), array('id' => $value));
    }
  }

  function alterar_status() {
    $this->db->update('imoveis', array('status' => $this->input->post('property_status')), array('id' => $this->input->post('property_id')));
    echo json_encode(array('status' => 'success'));
  }
}
