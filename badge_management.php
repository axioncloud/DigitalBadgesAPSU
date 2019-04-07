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
// TODO: Also check if user is an issuer; if not, redirect to dashboard.
?>
<?php $_SESSION["PAGE_NAME"] = "BADGE_MANAGEMENT"; ?>
<html lang="en">
  <?php include 'framework/framework.head.php'; ?>
  <body>
    <?php include 'framework/template.navbar.php'; ?>
    <?php include 'framework/template.content.php'; ?>
    <?php include 'framework/template.footer.php'; ?>
  </body>
</html>
