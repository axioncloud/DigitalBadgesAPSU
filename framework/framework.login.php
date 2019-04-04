<?php
  require 'framework.cookiemanagement.php';
  // username field from login form
  $uname = $_POST["username"];
  // password field from login form
  $pw = $_POST["password"];

  if (!preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $uname)) {
    $_SESSION["TOKEN"] = "false";
  }
  if (!preg_match("/^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=[#?!@$%^&*-]*)\S{8,}$/", $pw)) {
    $_SESSION["TOKEN"] = "false";
  }

  // check if the token is already set to false
  // if it is, skip this
  if (!isset($_SESSION["TOKEN"])) {
    $data = array('username' => $uname,'password' => $pw);
    $data_json = json_encode($data);
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_session"); // use couchdb session database for login
    curl_setopt($ch, CURLOPT_HEADER, true); // get the header with the request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true); // set POST as our request type
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    preg_match('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
    $curl_info = curl_getinfo($ch);
    $code = intval($curl_info["http_code"]);

    if ($code === 200) {
      $_SESSION["TOKEN"] = $matches[1];
      header("Location: /");
    }
    else if ($code === 401) {
      $_SESSION["TOKEN"] = "false";
    }
    curl_close($ch);
  }

  // If login is incorrect or $_SESSION["TOKEN"] is set to false return to the login page
  if (isset($_SESSION["TOKEN"])) {
    if ($_SESSION["TOKEN"] === "false") {
      $_SESSION["STORED_POST"] = $_POST;
      header("Location: /login.php");
    }
  }
?>
