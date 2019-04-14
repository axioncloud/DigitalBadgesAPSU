<?php
include 'framework.globals.php';
// check if the token is already set to false
// if it is, skip this
if (isset($_SESSION["TOKEN"])) {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_session");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  $response  = curl_exec($ch);
  preg_match('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
  $curl_info = curl_getinfo($ch);
  $code = intval($curl_info["http_code"]);
  curl_close($ch);
  if ($code === 200) {
    unset($_SESSION["TOKEN"]);
    unset($_SESSION["ROLES"]);
    header("Location: /");
  }
} else {
  header('HTTP/1.0 404 Not Found');
  include '../error.php';
}
?>
