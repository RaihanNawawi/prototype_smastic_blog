<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
include_once "../include/koneksi.php";
include_once "../include/function.php";
function getPostTags($postId)
{
  global $kon;
  $tags = [];

  // Gunakan DISTINCT untuk memastikan tag tidak duplikat
  $result = $kon->query("SELECT DISTINCT t.id, t.name FROM tags t
       JOIN post_tags pt ON t.id = pt.id_tag
       WHERE pt.id_posts = '$postId'");

  // Iterasi hasil query dan masukkan ke dalam array
  while ($row = mysqli_fetch_assoc($result)) {
    $tags[] = [
      'id' => $row['id'],
      'name' => $row['name']
    ];
  }

  return $tags;
}
?>
<!DOCTYPE html>
<html
  lang="en" class="light-style layout-menu-fixed" dir="ltr"
  data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>
    Admin Panel
  </title>
  <meta name="description" content="" />
  <!-- Admin Panel Icon -->
  <link rel="icon" type="image/x-icon" href="../img/admin_panel.png" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <!-- Add JS -->
  <script src="../assets/vendor/js/script.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
  <!-- CKEditor CDN -->
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Aside -->
      <?php include "layout/aside.php"; ?>
      <!-- / Aside -->
      <!-- Layout container -->
      <div class="layout-page">


        <!-- Navbar -->
        <?php include "layout/navbar.php"; ?>
        <!-- / Navbar -->

        <!-- Controler -->
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
          // Default to dashboard.php if no page is specified
          include "dashboard.php";
        }
        ?>
        <!-- / Controller -->

        <?php include "layout/footer.php"; ?>
      </div>
      <!-- / Layout page -->
    </div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'), {
        ckfinder: {
          uploadUrl: 'upload.php'
        },
        toolbar: ['heading', '|', 'bold', 'italic', '|', 'link', 'uploadImage', 'blockQuote', 'mediaEmbed', 'codeBlock', 'undo', 'redo'],
        mediaEmbed: {
          previewsInData: true // Preview video seperti YouTube di dalam editor
        },
        codeBlock: true,
        htmlSupport: {
          allow: [{
            name: 'iframe',
            attributes: true,
            classes: true,
            styles: true
          }]
        }
      })
      .catch(error => {
        console.error(error);
      });
    CKEDITOR.config.baseHref = 'http://localhost/myblog/';
  </script>


  <!-- build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>