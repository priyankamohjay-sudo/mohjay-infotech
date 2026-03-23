  <!-- footer-3 area start  -->
      <footer class="footer-3-area">
        <!-- <div class="footer-3-newsletter-box">
          <div class="container rr-container-1410">
            <div class="footer-3-newsletter-wrapper">
              <div class="footer-3-newsletter-content">
                <div class="icon">
                  <img src="assets/imgs/icon/icon-26.webp" alt="image">
                </div>
                <div class="content">
                  <h3 class="title">Sign Up To Our Newsletters.</h3>
                  <p class="text">Subscribe to our Newsletter & Event Right Now to be Updated</p>
                </div>
              </div>
              <div class="footer-3-newsletter-form">
                <form action="#" class="footer-3-subscribe-form">
                  <div class="input-field">
                    <input type="email" placeholder="Enter Your Email">
                    <button type="submit" class="rr-btn">
                      <span class="btn-wrap">
                        <span class="text-one">Subscribe Now</span>
                        <span class="text-two">Subscribe Now</span>
                      </span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div> -->
        <div class="footer-3-widget-wrapper-box">
          <div class="container rr-container-1410">
            <div class="footer-3-widget-wrapper">
              <div class="footer-3-widget-box">
                <div class="footer-3-logo">
                  <a href="<?= BASE_URL ?>index.html"><img src="<?= BASE_URL ?>assets/imgs/logo/mohjaylogo-white.png" alt="image"></a>
                </div>
                <div class="footer-3-text">
                  <p class="text text-white">As a reputable IT software company, we are dedicated to forming enduring alliances that support our clients long-term success.</p>
                </div>
                <div class="footer-3-social">
                   <a href="https://www.facebook.com/mohjayinfotechpvtltd" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>               
                  <a href="https://www.instagram.com/mohjayinfotech/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                  <a href="https://www.linkedin.com/company/mohjay-infotech/posts/?feedView=all" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
              </div>
              <div class="footer-3-widget-box">
                <h2 class="footer-3-widget-title">Company Information</h2>
                <ul class="footer-3-meta-list">
                 <li><span class="icon"><i class="fa-solid fa-location-dot"></i></span><span class="text text-white">Anand Arcade, 305, Canal Rd, near Rajpur Road, Kishanpur, Dehradun, Uttarakhand 248009</span></li>
                  <!-- <li><span class="icon"><i class="fa-solid fa-phone"></i></span><span class="text text-white"><a
                        href="tel:7349369477">7349369477</a></span>
                  </li> -->
                  <li><span class="icon"><i class="fa-solid fa-envelope"></i></span><span class="text text-white"><a
                        href="mailto:support@mohjayinfotech.com">support@mohjayinfotech.com</a></span>
                  </li>
                  <!-- <li><span class="icon"><i class="fa-solid fa-clock"></i></span><span class="text text-white"> Office : 10:00 AM -
                      6:00 PM</span></li> -->
                </ul>
              </div>
              <div class="footer-3-widget-box">
                <h2 class="footer-3-widget-title">Our Services</h2>
                <ul class="footer-3-nav-list">
                <li><a href="<?= BASE_URL ?>services/web-development"><i class="fa-solid fa-chevron-right"></i>Web Development</a></li>
                  <li><a href="<?= BASE_URL ?>services/digital-marketing"><i class="fa-solid fa-chevron-right"></i>Digital Marketing</a></li>
                  <li><a href="<?= BASE_URL ?>services/app-development"><i class="fa-solid fa-chevron-right"></i>App Development</a></li>
                  <li><a href="<?= BASE_URL ?>services/social-media-optimization"><i class="fa-solid fa-chevron-right"></i>SEO Optimization</a></li>
                  <li><a href="<?= BASE_URL ?>services/graphic-designing"><i class="fa-solid fa-chevron-right"></i>Graphic Designing</a></li>
                  <li><a href="<?= BASE_URL ?>services/social-media-marketing"><i class="fa-solid fa-chevron-right"></i>Social Media Marketing</a></li>
                </ul>
              </div>
              <div class="footer-3-widget-box">
                <h2 class="footer-3-widget-title">Latest Posts</h2>
                <div class="footer-3-blog-wrapper-box">
                  <div class="footer-3-blog-wrapper">
                    <?php 
                    // Fetch 3rd and 4th latest blogs (Offset 2)
                    $stmt_footer_blogs = $pdo->prepare("SELECT * FROM blogs WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 2 OFFSET 2");
                    $stmt_footer_blogs->execute();
                    $footer_blogs = $stmt_footer_blogs->fetchAll();
                    foreach ($footer_blogs as $fblog): ?>
                    <article class="footer-3-blog">
                      <div class="thumb">
                        <a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($fblog['slug']) ?>"><img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($fblog['featured_image']) ?>" alt="<?= htmlspecialchars($fblog['title']) ?>" style="width: 80px; height: 80px; object-fit: cover;"></a>
                      </div>
                      <div class="content">
                        <div class="meta">
                          <span class="date"><i class="fa-regular fa-clock"></i><?= date('d M, Y', strtotime($fblog['created_at'])) ?></span>
                        </div>
                        <h2 class="title"><a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($fblog['slug']) ?>"><?= htmlspecialchars(mb_strimwidth($fblog['title'], 0, 40, '...')) ?></a>
                        </h2>
                        <a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($fblog['slug']) ?>" class="blog-btn">Read More <i
                            class="fa-solid fa-arrow-right"></i></a>
                      </div>
                    </article>
                    <?php endforeach; ?>
                    <?php if (empty($footer_blogs)): ?>
                        <p class="text-white-50">Visit our <a href="<?= BASE_URL ?>blog">Blog</a> for more updates.</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="copyright-3-area">
          <div class="container rr-container-1410">
            <div class="copyright-3-area-inner">
              <div class="copyright-3-text">
                <p class="text">Copyright &copy;  Mohjay Infotech Pvt. Ltd. | All Rights Reserved.</p>
              </div>
              <div class="copyright-3-link">
                <a href="<?= BASE_URL ?>privacy-policy">Privacy policy</a>
                <a href="<?= BASE_URL ?>terms-and-conditions">Terms of use</a>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- footer-3 area end  -->

    </div>
  </div>



  <!-- Dependencies JS Files -->
  <script src="<?= BASE_URL ?>assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/jquery.magnific-popup.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/swiper-bundle.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/odometer.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/waypoints.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/progressbar.js"></script>
  <script src="<?= BASE_URL ?>assets/js/gsap.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/ScrollSmoother.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/ScrollTrigger.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/SplitText.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/TextPlugin.js"></script>
  <script src="<?= BASE_URL ?>assets/js/customEase.js"></script>
  <script src="<?= BASE_URL ?>assets/js/jquery.meanmenu.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/backToTop.js"></script>
  <script src="<?= BASE_URL ?>assets/js/jquery.nice-select.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/wow.min.js"></script>
  <!-- Template Main JS File -->
  <script src="<?= BASE_URL ?>assets/js/main.js"></script>



</body>

</html>