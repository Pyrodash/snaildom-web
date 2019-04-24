<?php

include_once('Snaildom_Controller.php');

class Pages extends Snaildom_Controller {
  public function __construct() {
    parent::__construct();

    $this->load->model('user_model');
    $this->load->model('post_model');
  }

  public function view($page = 'home', $data = array()) {
    $data['RECAPTCHA_SITE_KEY'] = $this->config->item('recaptcha_site_key');
    $data['SUPPORT_EMAIL'] = $this->config->item('support_email');

    switch(strtolower($page)) {
      case 'play':
        $data['staff'] = $this->user_model->fetch_staff();
        $data['header'] = FALSE;
    }

    $this->render($page, $data);
  }

  public function play($create = FALSE) {
    $data['create'] = $create ? TRUE : FALSE;

    $this->view('play', $data);
  }
}