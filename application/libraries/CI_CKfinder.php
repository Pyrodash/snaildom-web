<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('CKFINDER_PATH', APPPATH . '/third_party/ckfinder');
define('CKFINDER_CONFIG_PATH', APPPATH . '/config/ckfinder.php');

class CI_CKFinder {
  public function load() {
    require_once CKFINDER_PATH . '/connector.php';
  }
}