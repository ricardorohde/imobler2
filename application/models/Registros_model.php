<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registros_model extends CI_Model {
  public function __construct() {
    parent::__construct();
  }

  public function registros_count($sql){
    $query = $this->db->query($sql);
    return $query->num_rows();
  }

  public function registros($table, $params = array(), $row = false, $select = '*', $join = false, $order = false) {
    $return = array();

    // SELECT
    $this->db->select($select);

    // FROM
    $this->db->from($table);

    // JOIN
    if($join && is_array($join)){
      foreach($join as $join_item){
        $this->db->join($join_item[0], $join_item[1], $join_item[2]);
      }
    }

    // WHERE
    if(isset($params['where']) && !empty($params['where'])){
      foreach($params['where'] as $key => $value){
        $this->db->where($key, $value);
      }
    }

    // WHERE IN
    if(isset($params['where_in']) && !empty($params['where_in'])){
      foreach ($params['where_in'] as $key => $value) {
        $this->db->where_in($key, $value);
      }
    }

    // // WHERE IN
    // if(isset($params['limit']) && !empty($params['limit'])){
    //   $this->db->limit($params['limit']);
    // }

    if(!$row){
      $limit = (isset($params['limit']) ? (is_numeric($params['limit']) ? $params['limit'] : ($this->router->fetch_module() == 'admin' ? $this->config->item('property_list_limit_admin') : $this->config->item('property_list_limit'))) : null);
      $page = isset($params['page']) ? $params['page'] : 1;

      if($limit){
          // PAGINATION
        if(isset($params['pagging']) && $params['pagging'] == true){
          $return['total_rows'] = $this->registros_count($this->db->_compile_select());
          $return['total_pages'] = ceil($return['total_rows'] / $limit);
          $return['current_page'] = $page;
          $return['pagination'] = $this->site->create_pagination($page, $limit, $return['total_rows'], rtrim((isset($params['base_url']) ? $params['base_url'] : current_url()), "/" . $page), $this->config->item('property_pagination_links'), (isset($params['url_suffix']) ? $params['url_suffix'] : null));
        }

        $page = max(0, ($page - 1) * $limit);
        $this->db->limit($limit, $page);
      }
    }

    //ORDER
    if($order){
      foreach($order as $key => $value){
        $this->db->order_by($key, $value);
      }
    }

    //GROUP
    if(isset($params['group_by']) && !empty($params['group_by'])){
      $this->db->group_by($params['group_by']);
    }

    // $sql = $this->db->_compile_select();
    // echo $sql;

    $query = $this->db->get();

    if($query->num_rows() > 0) {

      if($row){
        if($row === TRUE){
          return $query->row_array();
        }else{
          $row_field = $query->row_array();
          if(isset($row_field[$row])){
            return $row_field[$row];
          }
          return false;
        }
      }

      $return['results'] = $query->result_array();

      return $return;
    }
    return false;
  }
}
