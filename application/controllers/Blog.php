<?php

include_once('Snaildom_Controller.php');

class Blog extends Snaildom_Controller {
  public function __construct() {
    parent::__construct('blog');

    $this->load->model('post_model');
    $this->load->model('user_model');

    $this->load->library('ci_purifier');
  }

  public function view($page = 'blog', $data = array(), $overrideMethod = NULL) {
    $pages = [
      'login' => [
        'session' => FALSE
      ],
      'panel' => [
        'session' => TRUE
      ],
      'new' => [
        'session' => TRUE
      ],
      'edit' => [
        'session' => TRUE
      ]
    ];
    $pageObj = isset($pages[$page]) ? $pages[$page] : NULL;
    $loggedIn = $this->isLoggedIn();

    if(!empty($pageObj)) {
      if($pageObj['session'] === TRUE) {
        if(!$loggedIn) {
          redirect(base_url('blog/login'));

          return;
        }
      } elseif($pageObj['session'] === FALSE) {
        if($loggedIn) {
          redirect(base_url('blog/panel'));

          return;
        }
      }
    }

    $data['loggedIn'] = $loggedIn;
    $method = !empty($overrideMethod) ? $overrideMethod : $this->input->method(TRUE);

    switch($page) {
      case 'login':
        if($method == 'POST') {
          $this->login();

          return;
        }
      break;
      case 'logout':
        return $this->logout();
      break;
      case 'blog':
        $data['posts'] = $this->post_model->fetch_posts(1); // Page 1
      break;
      case 'new':
        if($method == 'POST') {
          $this->new_post();

          return;
        }
    }

    $this->render($page, $data);
  }

  private function login() {
    if($this->isLoggedIn())
      return redirect(base_url('/blog/panel'));

    $username = $this->input->post('username');
    $password = $this->input->post('password');

    if(!empty($username) && !empty($password)) {
      $user = $this->user_model->fetch_user(array('ID', 'Password', 'Rank'), array('Username' => $username));

      if(!empty($user)) {
        if(password_verify($password, $user->Password) && $user->Rank > 2) {
          $this->session->set_userdata(array(
            'ID' => $user->ID,
            'logged_in' => TRUE
          ));

          return redirect(base_url('/blog/panel'));
        }
      }

      return $this->view('login', array(
        'error' => 'Invalid username or password.'
      ), 'GET');
    } else
      $this->view('login', array(
        'error' => 'Please fill all the fields.'
      ), 'GET');
  }

  private function new_post() {
    $title = $this->input->post('title');
    $content = $this->input->post('content');

    if(empty($title) || empty($content) || ctype_space($content))
      return $this->view('new', ['error' => 'Please fill all the fields.'], 'GET');

    $content = $this->ci_purifier->purify($content);
    $this->post_model->insert([
      'Title' => $title,
      'Content' => $content,
      'Author' => $this->myUser->ID
    ]);

    redirect(base_url('blog'));
  }

  public function edit($id) {
    if(!$this->isLoggedIn())
      return redirect(base_url('blog/login'));

    $method = $this->input->method(TRUE);

    if($method == 'POST') {
      $content = $this->input->post('content');
      $content = $this->ci_purifier->purify($content);

      $title = $this->input->post('title');
      $post = ['Content' => $content];

      if(isset($title) && !empty($title)) $post['Title'] = $title;

      $this->post_model->edit($post, $id);

      redirect(base_url('blog'));
    } else {
      $data['Post'] = $this->post_model->fetch_post($id);
      $data['editMode'] = TRUE;

      $this->view('new', $data);
    }
  }

  public function delete($id) {
    if(!$this->isLoggedIn())
      return redirect(base_url('blog/login'));

    $this->post_model->delete($id);
    redirect(base_url('blog'));
  }

  public function logout() {
    session_destroy();

    redirect(base_url('blog'));
  }
}