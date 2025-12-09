<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
  <title>خانه - اکانتسرا</title>
  <link rel="stylesheet" href="/assets/css/bootstrap.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
@include("Pages.layouts.header")

  <!-- Preloader -->
  <div class="preloader">
    <div class="loader">
      <span></span>
    </div>
  </div>

  <!-- cursor effect-->
  <div class="cursor"></div>
  <!-- Header area  -->

@yield("content")

  <!-- call to action section end -->

@include("Pages.layouts.footer")

  <!-- ==== js dependencies start ==== -->
  <!-- jquery  -->
  <script src="/assets/js/jquery.min.js"></script>
  <!-- gsap  -->
  <script src="/assets/js/gsap.min.js"></script>
  <!-- gsap scroll trigger -->
  <script src="/assets/js/ScrollTrigger.min.js"></script>
  <!-- lenis  -->
  <script src="/assets/js/lenis.min.js"></script>
  <!-- tilt js -->
  <script src="/assets/js/vanilla-tilt.js"></script>
  <!-- scroll magic -->
  <script src="/assets/js/ScrollMagic.min.js"></script>
  <!-- animation.gsap -->
  <script src="/assets/js/animation.gsap.min.js"></script>
  <!-- gsap customization  -->
  <script src="/assets/js/gsap-customization.js"></script>
  <!-- apex chart  -->
  <script src="/assets/js/apexcharts.js"></script>
  <!-- swiper js -->
  <script src="/assets/js/swiper-bundle.min.js"></script>
  <!-- magnific popup  -->
  <script src="/assets/js/magnific-popup.js_1.1.0_jquery.magnific-popup.min.js"></script>
  <!-- bootstrap js -->
  <script src="/assets/js/bootstrap.bundle.min.js"></script>
  <!-- main js  -->
  <script src="/assets/js/main.js"></script>
  @yield("script")
</body>

</html>
