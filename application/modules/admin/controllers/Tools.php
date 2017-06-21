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

  function buscar_coordenadas($endereco, $echo = true, $format = 'json'){
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
    print_l($this->input->post());
    echo FCPATH . 'assets/ulpad';
    // $targetDir = "uploads/";
    // $fileName = $_FILES['file']['name'];
    // $targetFile = $targetDir . $fileName;

    // if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
    //   echo $fileName;
    //     // $conn->query("INSERT INTO files (file_name, uploaded) VALUES('".$fileName."','".date("Y-m-d H:i:s")."')");
    // }
  }
}
