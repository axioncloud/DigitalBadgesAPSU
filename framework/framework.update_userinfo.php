<?php
  require 'framework.globals.php';
  $username = $_POST["username"];
  $fName = $_POST["fName"];
  $lName = $_POST["lName"];
  $role = $_POST["role"];

  $ch = curl_init();
  if (!isset($_POST["password"])) {
    curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_users/org.couchdb.user:".$username); // use couchdb session database for login
    curl_setopt($ch, CURLOPT_HEADER, true); // get the header with the request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"]));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    preg_match('/\{(?:[^{}]|(?R))*\}/', $response, $regex_match_roles);
    $doc = json_decode($regex_match_roles[0], true);
    var_dump($doc);

    $data = array('_id' => "org.couchdb.user:".$username, '_rev' => $doc['_rev'], 'name' => $username, 'type' => 'user', 'fName' => $fName, 'lName' => $lName, 'roles' => array($role), 'password_scheme' => $doc['password_scheme'], 'iterations' => $doc['iterations'], 'derived_key' => $doc['derived_key'], 'salt' => $doc['salt']);
    $data_json = json_encode($data);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    $response  = curl_exec($ch);
    var_dump($response);
    $curl_info = curl_getinfo($ch);
    $code = intval($curl_info["http_code"]);
    curl_close($ch);
    if ($code === 200 || $code === 201) {
      header("Location: /user_management.php");
    }
  } else {

    $data = array('_id' => "org.couchdb.user:".$username, 'name' => $username, 'type' => 'user', 'fName' => $fName, 'lName' => $lName, 'roles' => array($role), 'password' => $_POST['password']);
    $data_json = json_encode($data);
    curl_setopt($ch, CURLOPT_URL, $_SESSION["COUCHDB"]."/_users"); // use couchdb session database for login
    curl_setopt($ch, CURLOPT_HEADER, true); // get the header with the request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Cookie: '.$_SESSION["TOKEN"]));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    $response  = curl_exec($ch);
    var_dump($response);
    $curl_info = curl_getinfo($ch);
    $code = intval($curl_info["http_code"]);
    curl_close($ch);
    if ($code === 200 || $code === 201) {
      header("Location: /user_management.php");
    }
  }

?>
