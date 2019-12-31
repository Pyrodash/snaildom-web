<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ban_model extends CI_Model {
  public function __construct() {
    parent::__construct();

    $this->load->database();
  }

  public function fetch_ban($select = '*', $where = array(), $limit = 1) {
    if(!array_key_exists('Active', $where))
      $where['Active'] = 1;

    $this->db->select($select);
    $this->db->from('bans');
    $this->db->where($where);
    $this->db->limit($limit);

    $query = $this->db->get();

    if($limit == 1)
      return $query->row();
    else
      return $query->result_array();
  }

  public function fetch_bans_by($col, $val, $select = '*', $limit = 0) {
    return $this->fetch_ban(
      $select, //select
      array($col => $val), //where
      $limit
    );
  }

  public function update($update, $where) {
    if(is_numeric($where))
      $where = array('ID' => $where);

    $this->db->set($update);
    $this->db->where($where);
    $this->db->update('bans');
  }

  public function deactivate($id) {
    $this->update(['Active' => 0], $id);
  }
}
