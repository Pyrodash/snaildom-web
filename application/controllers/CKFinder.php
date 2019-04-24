<?php
class CKFinder extends CI_Controller {
  public function __construct() {
    parent::__construct();

    $this->load->library('ci_ckfinder');
  }

  public function connector() {
    $this->ci_ckfinder->load();
  }
}