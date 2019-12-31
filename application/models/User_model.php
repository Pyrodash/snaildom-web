<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
  public function __construct() {
    parent::__construct();

    $this->load->database();
  }

  public function fetch_user($select = '*', $where = array(), $limit = 1) {
    $this->db->select($select);
    $this->db->from('users');
    $this->db->where($where);
    $this->db->limit($limit);

    $query = $this->db->get();

    if($limit == 1)
      return $query->row();
    else
      return $query->result_array();
  }

  public function fetch_user_by($col, $val, $select = '*', $limit = 1) {
    return $this->fetch_user(
      $select, //select
      array($col => $val), //where
      $limit
    );
  }

  public function fetch_staff() {
    $ranks = [
      2 => '#0099FF',
      3 => '#FF0000'
    ];
    $rows = $this->db->select('Username, Rank, Color')
      ->from('users')
      ->where('Rank >', 1)
      ->order_by('Rank DESC, ID ASC')
      ->get();

    $staff = array();

    foreach($rows->result() as $Row) {
      $color = $Row->Color;

      if(empty($color))
        $color = $ranks[$Row->Rank];

      $color = strtoupper($color);

      if(startsWith('0X', $color))
        $color = str_replace('0X', '#', $color);

      $staff[] = '<span style="color:' . $color . '">' . $Row->Username . '</span>';
    }

    return $staff;
  }

  public function update($update, $where) {
    if(is_numeric($where))
      $where = array('ID' => $where);

    $this->db->set($update);
    $this->db->where($where);
    $this->db->update('users');
  }

  public function insert($user) {
    $this->db->insert('users', $user);
  }
}
