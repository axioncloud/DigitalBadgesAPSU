<?php
require 'framework.globals.php';
$badgeid =  $_POST["badgeid"];
$username = $_POST["username"];
$expirationDate = $_POST["expirationDate"];

if (!is_null($badgeid) || !is_null($username)) {
  $respone = issueBadge($username, $badgeid, $expirationDate);
  var_dump($respone);
  header("Location: /badge_management.php");
}
?>
