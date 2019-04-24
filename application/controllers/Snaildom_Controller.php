<?php
class Snaildom_Controller extends CI_Controller {
  public function __construct($folder = NULL) {
    parent::__construct();
    $this->load->model('user_model');

    if(!empty($folder))
      $this->folder = $folder;
    if($this->isLoggedIn()) {
      $this->myUser = $this->user_model->fetch_user_by('ID', $this->session->userdata('ID'));

      if(empty($this->myUser))
        redirect(base_url('blog/logout'));
    }
  }

  public function isLoggedIn() {
    $loggedIn = $this->session->userdata('logged_in');

    if(isset($loggedIn) && $loggedIn === TRUE) {
      $myID = $this->session->userdata('ID');

      if(!empty($myID) && is_numeric($myID))
        return TRUE;
      else
        return FALSE;
    }
  }

  public function render($page, $data = array()) {
    $data['title'] = ucfirst($page);
    $data['page'] = $page;

    if(isset($this->myUser))
      $data['Self'] = $this->myUser;

    $pagePath = 'pages/';
    if(isset($this->folder)) $pagePath .= $this->folder . '/';
    $pagePath .= $page;

    if(!file_exists(APPPATH . 'views/' . $pagePath . '.php'))
      show_404();

    $this->load->view('templates/header', $data);
    $this->load->view($pagePath, $data);
    $this->load->view('templates/footer', $data);
  }
}