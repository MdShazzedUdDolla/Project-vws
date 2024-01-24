<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Virtual Wellness System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="shortcut icon" type="image/png" href="./Assets/img/favicon-16x16.png">
  <?php 
     if (session_status() === PHP_SESSION_NONE) {
      session_start();
      session_destroy();
       
    }else{
      session_destroy();
    }

  ?>

  <!-- Favicons -->
  <!-- <link href="Assets/img/favicon.png" rel="icon">
  <link href="Assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="Assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="Assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="Assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="Assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="Assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="Assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="Assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="Style/VWS_CSS/style_IndexPage.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Selecao - v4.10.0
  * Template URL: https://bootstrapmade.com/selecao-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
    <?php 
        include_once "./Components/StartPage/navbar.php"
    ?>

  <!-- ======= Hero Section ======= -->
  <?php 
        include_once "./Components/StartPage/introduction.php"
  ?>

  <main id="main">


    <!-- ======= Services Section ======= -->
    <?php 
        include_once "./Components/StartPage/offeredServices.php";
    
    ?>

    <!-- ======= F.A.Q Section ======= -->
    <?php 
        include_once "./Components/StartPage/FAQ.php";
    
    ?>

    <!-- ======= Contact Section ======= -->
   <?php 
        include_once "./Components/StartPage/contactForm.php";
   ?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
    <?php
        include_once "./Components/StartPage/footer.php";
    ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="Assets/vendor/aos/aos.js"></script>
  <script src="Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="Assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="Assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="Assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="Js_Script/VWS_JS/main.js"></script>

</body>

</html>
