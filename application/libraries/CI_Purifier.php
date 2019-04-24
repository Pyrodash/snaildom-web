<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/third_party/htmlpurifier/library/HTMLpurifier.auto.php';

class CI_Purifier {
  public function __construct() {
    $this->config = HTMLPurifier_HTML5Config::createDefault();

    $this->config->set('HTML.Allowed', 'p,b,strong,i,u,s,strike,img[src],figure[class],figcaption,em,ul,li,a[href|title]');
    $this->config->set('AutoFormat.AutoParagraph', TRUE);
    $this->config->set('AutoFormat.Linkify', TRUE);

    $this->purifier = new HTMLPurifier($this->config);
  }

  public function purify($dirty) {
    return $this->purifier->purify($dirty);
  }
}