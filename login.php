<!DOCTYPE html>
<?php require 'framework/framework.globals.php'; ?>
<?php
if (isset($_SESSION["TOKEN"])) {
  if ($_SESSION["TOKEN"] !== "false") {
    header("Location: /dashboard.php");
  } else if ($_SESSION["TOKEN"] === "false") {
    unset($_SESSION["TOKEN"]);
  }
}
?>
<?php $_SESSION["PAGE_NAME"] = "LOGIN"; ?>
<html lang="en">
  <?php include 'framework/framework.head.php'; ?>
  <body>
    <?php include 'framework/template.navbar.php'; ?>
    <?php include 'framework/template.content.php'; ?>
    <?php include 'framework/template.footer.php'; ?>

  </body>
</html>
