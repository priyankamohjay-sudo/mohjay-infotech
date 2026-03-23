<?php 
$url = $_SERVER['REQUEST_URI'];
require_once 'config.php'; 

?>


<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= $description ?? '' ?>">
  <meta name="keywords" content="<?= $tags ?? '' ?>">

  <title><?= $title ?? 'Mohjay Infotech Pvt Ltd - mohjayinfotech.com' ?></title>

  <!-- Fav Icon -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>assets/imgs/logo/mohjay-favicon.png">


  <!-- Dependencies CSS Files -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/fontawesome-pro.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/progressbar.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/meanmenu.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/magnific-popup.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/animate.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/odometer-theme-default.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/nice-select.css">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">


</head>


<body class="body-wrapper <?= $url != "/mohjay-infotech/" ? 'page-inner' : '' ?>">

  <div class="loader-wrap">
    <svg viewBox="0 0 1000 1000" preserveAspectRatio="none">
      <path id="svg" d="M0,1005S175,995,500,995s500,5,500,5V0H0Z"></path>
    </svg>

    <div class="loader-wrap-heading">
      <div class="load-text">
        <span>M</span>
        <span>O</span>
        <span>H</span>
        <span>J</span>
        <span>A</span>
        <span>Y</span>
        <span>I</span>
        <span>N</span>
        <span>F</span>
        <span>O</span>
        <span>T</span>
        <span>E</span>
        <span>C</span>
        <span>H</span>
      </div>
    </div>
  </div>


  <!-- Sroll to top -->
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
    </svg>
  </div>


  <!-- side toggle start -->
  <aside class="fix">
    <div class="side-info">
      <div class="side-info-content">
        <div class="offset-widget offset-header">
          <div class="offset-logo">
            <a href="<?= BASE_URL ?>index.php">
              <img src="<?= BASE_URL ?>assets/imgs/logo/mohjaylogo-dark.png" alt="site logo">
            </a>
          </div>
          <button id="side-info-close" class="side-info-close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="mobile-menu fix"></div>
        <div class="offset-button">
          <a href="<?= BASE_URL ?>contact.php" class="rr-btn">
            <span class="btn-wrap">
              <span class="text-one">Get Started</span>
              <span class="text-two">Get Started</span>
            </span>
          </a>
        </div>
        <div class="offset-widget-box">
          <h2 class="title">Contact US</h2>
           <div class="header-note">
            <p class="text">We are a software development company focused on creating innovative, scalable, and high-performance digital solutions. Our mission is to help businesses with technology that drives growth, improves efficiency, and boosts customer experiences.</p>
           </div>
          <div class="contact-meta pt-4">
            <div class="contact-item">
              <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
              <span class="text">Canal Rd, Dehradun - 248009</span>
            </div>
            <div class="contact-item">
              <span class="icon"><i class="fa-solid fa-envelope"></i></span>
              <span class="text"><a href="mailto:support@mohjayinfotech.com">support@mohjayinfotech.com</a></span>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </aside>
  <div class="offcanvas-overlay"></div>
  <!-- side toggle end -->




  <div class="has-smooth" id="has_smooth"></div>
  <div id="smooth-wrapper">
    <div id="smooth-content">

        <!-- Header-2 area start -->
      <header class="header-2-area">
        <div class="header-2-top">
          <div class="container rr-container-1410">
            <div class="header-2-top-inner">
              <div class="header-2-contact-meta">
                <!-- <div class="header-2-contact-item">
                  <span class="icon"><i class="fa-solid fa-phone"></i></span>
                  <span class="text"><a href="tel:(+256)32542598">(+256) 3254 2598</a></span>
                </div> -->
                <div class="header-2-contact-item">
                  <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                  <span class="text"><a href="https://maps.app.goo.gl/XWi1nNvkV5owDr939" target="_blank">Canal Rd, Dehradun - 248009</a></span>
                </div>
                <div class="header-2-contact-item">
                  <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                  <span class="text"><a href="mailto:support@mohjayinfotech.com">support@mohjayinfotech.com</a></span>
                </div>
              </div>
              <div class="header-2-social">
                <span class="text">Follow Us On:</span>
                <a href="https://www.facebook.com/mohjayinfotechpvtltd" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/mohjayinfotech/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/mohjay-infotech/posts/?feedView=all" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                <!-- <a href="https://www.linkedin.com/"><i class="fa-brands fa-youtube"></i></a> -->
              </div>
            </div>
          </div>
        </div>
        <div class="header-2-main">
          <div class="container rr-container-1410">
            <div class="header-2-main-inner">
              <div class="header-2-logo">
                <a href="<?= BASE_URL ?>/">
                  <img src="<?= BASE_URL ?>assets/imgs/logo/mohjaylogo-dark.png" class="normal-logo" alt="Site Logo">
                </a>
              </div>
              <div class="header-2-nav">
                <nav class="main-menu">
                  <ul>
                    <li><a href="<?= BASE_URL ?>">Home</a> </li>
                   <li><a href="<?= BASE_URL ?>about">About Us</a></li>
                    <li class="menu-item-has-children">
                      <a href="<?= BASE_URL ?>service">Services</a>
                      <ul class="dp-menu">
                        <li><a href="<?= BASE_URL ?>services/web-development">Web Development</a></li>
                        <li><a href="<?= BASE_URL ?>services/digital-marketing">Digital Marketing</a></li>
                        <li><a href="<?= BASE_URL ?>services/app-development">App Development</a></li>
                        <li><a href="<?= BASE_URL ?>services/social-media-optimization">SEO Optimization</a></li>
                        <li><a href="<?= BASE_URL ?>services/graphic-designing">Graphic Designing</a></li>
                        <li><a href="<?= BASE_URL ?>services/social-media-marketing">Social Media Marketing</a></li>
                      </ul>
                    </li>
                     <li><a href="<?= BASE_URL ?>project">Project</a></li>                     
                       <li><a href="<?= BASE_URL ?>blog">Blog</a></li>
                      <li><a href="<?= BASE_URL ?>locations">Locations</a></li>
                    
                  </ul>
                </nav>
              </div>
              <div class="header-2-cta">
                <span class="call-box"><a href="<?= BASE_URL ?>contact">Contact Us</a> </span>
              </div>
              <div class="header-2-offfcanvas">
                <button class="side-toggle">
                  <i class="fa-solid fa-bars"></i></button>
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- Header-2 area end -->