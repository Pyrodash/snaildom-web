<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Post_model extends CI_Model {
  public function __construct() {
    parent::__construct();

    $this->load->database();
  }

  public function fetch_posts($page = 1) {
    $maxPosts = 10;
    $offset = ($page - 1) * $maxPosts;

    return $this->db->select('*')
      ->from('blog_posts')
      ->where('Deleted', 0)
      ->order_by('ID DESC')
      ->limit($maxPosts, $offset)
      ->get()
      ->result();
  }

  public function fetch_post($id, $select = '*') {
    return $this->db->select($select)
      ->from('blog_posts')
      ->where('ID', $id)
      ->get()
      ->row();
  }

  public function insert($post) {
    $this->db->insert('blog_posts', $post);
  }

  public function edit($edit, $id) {
    $this->db->set($edit);
    $this->db->where('ID', $id);
    $this->db->update('blog_posts');
  }

  public function delete($id) {
    $this->edit(['Deleted' => 1], $id);
  }
}
