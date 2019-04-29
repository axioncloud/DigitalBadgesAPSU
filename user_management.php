<!DOCTYPE html>
<?php require 'framework/framework.globals.php'; ?>
<?php
if (isset($_SESSION["TOKEN"])) {
  if ($_SESSION["TOKEN"] === "false") {
    header("Location: /");
  }
} else if (!isset($_SESSION["TOKEN"])) {
    header("Location: /");
}
if (isset($_SESSION["ROLES"])) {
  if ($_SESSION["ROLES"][0] !== "_admin") {
    header("Location: /");
  }
}
?>
<?php $_SESSION["PAGE_NAME"] = "USER_MANAGEMENT"; ?>
<html lang="en">
  <?php include 'framework/framework.head.php'; ?>
  <body>
    <?php include 'framework/template.navbar.php'; ?>
    <?php include 'framework/template.content.php'; ?>
    <?php include 'framework/template.footer.php'; ?>
    <script src="/js/search_users.js"></script>
  </body>
</html>
