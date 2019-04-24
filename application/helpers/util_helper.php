<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('startsWith')) {
  function startsWith($startString, $string) {
    $len = strlen($startString);

    return (substr($string, 0, $len) === $startString);
  }
}

if(!function_exists('endsWith')) {
  function endsWith($endString, $string) {
    $len = strlen($endString);
    if ($len == 0) return true;
    return (substr($string, -$len) === $endString);
  }
}

if(!function_exists('build_url')) {
  function build_url($path = '', $appendTrailingSlash, $baseURL) {
    if(endsWith('/', $baseURL))
      $baseURL = substr($baseURL, 0, -1);

    $ext = pathinfo(basename($path), PATHINFO_EXTENSION);
    $isQuery = startsWith('?', $path);
    $isFile = $ext ? true : false;

    if(!startsWith('/', $path) && !$isQuery)
      $path = '/' . $path;

    $url = $baseURL . $path;

    if($isQuery || $isFile)
      $appendTrailingSlash = FALSE;

    if(!endsWith('/', $url) && $appendTrailingSlash === TRUE)
      $url .= '/';

    return $url;
  }
}

if(!function_exists('game_url')) {
  function game_url($path = '', $appendTrailingSlash = TRUE) {
    $ci =& get_instance();
    $playURL = $ci->config->item('game_url');

    return build_url($path, $appendTrailingSlash, $playURL);
  }
}

if(!function_exists('play_url')) {
  function play_url($path = '', $appendTrailingSlash = TRUE) {
    $ci =& get_instance();
    $playURL = $ci->config->item('play_url');
    $url = isset($playURL) && !empty($playURL) ? $playURL : base_url('play');

    return build_url($path, $appendTrailingSlash, $url);
  }
}

if(!function_exists('join_paths')) {
  function join_paths(...$paths) {
    return preg_replace('~[/\\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $paths));
  }
}

if(!function_exists('str_insert')) {
  function str_insert($insertstring, $intostring, $offset) {
     $part1 = substr($intostring, 0, $offset);
     $part2 = substr($intostring, $offset);

     $part1 = $part1 . $insertstring;
     $whole = $part1 . $part2;
     return $whole;
  }
}