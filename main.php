<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
include "include/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMASTIC Blog - Prototype</title>
  <link rel="icon" href="img/ic3.png" type="image/x-icon">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script href="script.js"></script>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Header Section -->
  <?php include_once "layout/navbar.php"; ?>


  <!-- Controller -->
  <?php
  if (!empty($_GET["p"])) {
    $page = $_GET["p"];
    $file = $page . ".php";

    if (file_exists($file)) {
      include_once $file;
    } else {
      // Show a 404 error page if the requested page doesn't exist
      include "404.php";
    }
  } else {
    // Default to home.php if no page is specified
    include "home.php";
  }
  ?>


  <!-- Footer Section -->
  <?php include_once "layout/footer.php"; ?>

</body>

</html>