<?php
  require 'framework.globals.php';
  $name = $_POST['name'];
  $description = $_POST['description'];
  // $image = $_POST['image'];
  $criteria = $_POST['criteria'];
  $alignment = $_POST['alignment'];
  $tags = $_POST['tags'];

  $tags = explode(',', $tags);
  $tags = preg_replace('/\s*,\s*/', ',', $tags);
  $alignment = explode(',', $alignment);
  $alignment = preg_replace('/\s*,\s*/', ',', $alignment);
  chdir("../"); //required to move image to directory
  $id = strtolower($name);
  $id = str_replace(' ', '', $id);
  if ($_SESSION['PAGE_NAME'] === 'BADGE_CREATE') {
    $badgeImage = 'img/badges/'.$id.".png";
    move_uploaded_file($_FILES['image']['tmp_name'], $badgeImage);
    $image_url = 'https://ioncloud64.com/'.$badgeImage;

    createBadge($id, $name, $description, $image_url, $criteria, $alignment, $tags);
  } else if ($_SESSION['PAGE_NAME'] === 'BADGE_EDIT') {
    if (!empty($_FILES)) { // uploading an image
      $badgeImage = 'img/badges/'.$id.".png";
      $isMoved = move_uploaded_file($_FILES['image']['tmp_name'], $badgeImage);
      $image_url = 'https://ioncloud64.com/'.$badgeImage;

      editBadge($id, $name, $description, $image_url, $criteria, $alignment, $tags);
    } else { // no image provided
      editBadge($id, $name, $description, $_POST['image_url'], $criteria, $alignment, $tags);
    }
  }
  header("Location: /badge_management.php");
?>
