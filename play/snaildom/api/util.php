<?php
function startsWith($startString, $string) {
  $len = strlen($startString);

  return (substr($string, 0, $len) === $startString);
}

function endsWith($endString, $string) {
  $len = strlen($endString);
  if ($len == 0) return true;
  return (substr($string, -$len) === $endString);
}

function base_url($path = '', $appendTrailingSlash = TRUE) {
  $ext = pathinfo(basename($path), PATHINFO_EXTENSION);
  $isQuery = startsWith('?', $path);
  $isFile = $ext ? true : false;

  if(!startsWith('/', $path) && !$isQuery)
    $path = '/' . $path;

  $url = baseURL . $path;

  if($isQuery || $isFile)
    $appendTrailingSlash = FALSE;

  if(!endsWith('/', $url) && $appendTrailingSlash === TRUE)
    $url .= '/';

  return $url;
}
function play_url($path = '', $appendTrailingSlash = TRUE) {
  $ext = pathinfo(basename($path), PATHINFO_EXTENSION);
  $isQuery = startsWith('?', $path);
  $isFile = $ext ? true : false;

  if(!startsWith('/', $path) && !$isQuery)
    $path = '/' . $path;

  $url = playURL . $path;

  if($isQuery || $isFile)
    $appendTrailingSlash = FALSE;

  if(!endsWith('/', $url) && $appendTrailingSlash === TRUE)
    $url .= '/';

  return $url;
}
?>