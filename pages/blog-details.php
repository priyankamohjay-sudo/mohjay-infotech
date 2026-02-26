<?php
require_once dirname(__DIR__) . '/includes/config.php';

$slug = $_GET['slug'] ?? '';

if (!$slug) {
    header("Location: " . BASE_URL . "blog");
    exit;
}

// Fetch current blog
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ? AND deleted_at IS NULL LIMIT 1");
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    header("HTTP/1.0 404 Not Found");
    include dirname(__DIR__) . '/pages/404.php';
    exit;
}

// Fetch Previous and Next Blogs for navigation
$stmt_prev = $pdo->prepare("SELECT title, slug, featured_image FROM blogs WHERE id < ? AND deleted_at IS NULL ORDER BY id DESC LIMIT 1");
$stmt_prev->execute([$blog['id']]);
$prev_blog = $stmt_prev->fetch();

$stmt_next = $pdo->prepare("SELECT title, slug, featured_image FROM blogs WHERE id > ? AND deleted_at IS NULL ORDER BY id ASC LIMIT 1");
$stmt_next->execute([$blog['id']]);
$next_blog = $stmt_next->fetch();

$title = $blog['meta_title'] ?: $blog['title'] . " | Mohjay Infotech";
$description = $blog['meta_description'] ?: "";
$tags = $blog['meta_tags'] ?: "";

include dirname(__DIR__) . '/includes/header.php'; ?>

<style>
  @media (min-width: 992px) {
    .blog-sidebar-wrapper-box {
      height: 100%;
    }
    /* Reset sticky CSS as it conflicts with GSAP pinning */
    .blog-sidebar-wrapper {
      position: relative !important;
      top: 0 !important;
    }
  }
</style>

<main>

  <!-- breadcrumb area start -->
  <section class="breadcrumb-area">
    <div class="breadcrumb-area-inner">
      <div class="breadcrumb-bg">
        <img src="<?= BASE_URL ?>assets/imgs/gallery/gallery-29.webp" alt="image">
      </div>
      <div class="container rr-container-1410">
        <div class="breadcrumb-content">
          <div class="title-wrapper">
            <h1 class="breadcrumb-title"><?= htmlspecialchars($blog['title']) ?></h1>
          </div>
          <div class="breadcrumb-wrapper">
            <ul class="rr-breadcrumb">
              <li><a href="<?= BASE_URL ?>">Home</a></li>
              <li><?= htmlspecialchars($blog['title']) ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb area end -->

  <!-- blog-details area start  -->
  <div class="blog-details-area">
    <div class="container rr-container-1410">
      <div class="blog-details-area-inner section-spacing">
        <div class="blog-details-wrapper-box">
          <div class="blog-details-wrapper fade-anim">
            <article class="blog-details">
              <div class="thumb">
                <img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($blog['featured_image']) ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
              </div>
              <div class="content">
                <h2 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h2>
                <div class="text-wrapper">
                  <?= $blog['content'] ?>
                </div>

                <?php if($blog['quote']): ?>
                <div class="author-blockquote">
                  <div class="quote-icon">
                    <i class="fa-light fa-quote-right"></i>
                  </div>
                  <div class="quote-content">
                    <p class="text">“<?= htmlspecialchars($blog['quote']) ?>”</p>
                  </div>
                </div>
                <?php endif; ?>

                <div class="tags-wrapper-box">
                  <div class="tags-wrapper">
                    <span class="title">Tags</span>
                    <div class="tags">
                      <?php 
                      if ($blog['tags']) {
                        $btags = explode(',', $blog['tags']);
                        foreach($btags as $btag): ?>
                          <span class="tag"><?= trim(htmlspecialchars($btag)) ?>,</span>
                        <?php endforeach; 
                      } ?>
                    </div>
                  </div>
                  <div class="social-wrapper">
                    <span class="title">Social Share</span>
                    <div class="blog-social">
                      <?php if($blog['facebook_url']): ?><a href="<?= htmlspecialchars($blog['facebook_url']) ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
                      <?php if($blog['twitter_url']): ?><a href="<?= htmlspecialchars($blog['twitter_url']) ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a><?php endif; ?>
                      <?php if($blog['instagram_url']): ?><a href="<?= htmlspecialchars($blog['instagram_url']) ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
                      <?php if($blog['linkedin_url']): ?><a href="<?= htmlspecialchars($blog['linkedin_url']) ?>" target="_blank"><i class="fa-brands fa-linkedin"></i></a><?php endif; ?>
                      <a href="https://x.com/intent/tweet?url=<?= urlencode(BASE_URL . "blog/" . $blog['slug']) ?>&text=<?= urlencode($blog['title']) ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </article>
            
            <!-- Dynamic Post Navigation -->
            <div class="post-navigation">
              <div class="post-nav-shape">
                <img src="<?= BASE_URL ?>assets/imgs/shape/shape-20.webp" alt="image" style="opacity: 0.1;">
              </div>
              <div class="prev-post">
                <?php if($prev_blog): ?>
                <div class="nav-post">
                  <div class="thumb">
                    <a href="<?= BASE_URL ?>blog/<?= $prev_blog['slug'] ?>"><img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($prev_blog['featured_image']) ?>" alt="image"></a>
                  </div>
                </div>
                <h3 class="title"><a href="<?= BASE_URL ?>blog/<?= $prev_blog['slug'] ?>">Previous Post</a></h3>
                <?php else: ?>
                <h3 class="title"><a href="<?= BASE_URL ?>blog">Back to List</a></h3>
                <?php endif; ?>
              </div>
              <div class="next-post">
                <?php if($next_blog): ?>
                <div class="nav-post">
                  <div class="thumb">
                    <a href="<?= BASE_URL ?>blog/<?= $next_blog['slug'] ?>"><img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($next_blog['featured_image']) ?>" alt="image"></a>
                  </div>
                </div>
                <h3 class="title"><a href="<?= BASE_URL ?>blog/<?= $next_blog['slug'] ?>">Next Post</a></h3>
                <?php else: ?>
                <h3 class="title"><a href="<?= BASE_URL ?>blog">Latest Updates</a></h3>
                <?php endif; ?>
              </div>
            </div>
          
          </div>
        </div>

        <!-- Sidebar -->
        <div class="blog-sidebar-wrapper-box">
          <div class="blog-sidebar-wrapper">
            <div class="blog-sidebar-box">
              <h3 class="sidebar-title">Search Here</h3>
              <div class="sidebar-search-box">
                <form action="<?= BASE_URL ?>blog" method="GET" class="sidebar-search-form">
                  <div class="input-field">
                    <input type="text" name="search" placeholder="Enter Keyword">
                    <button type="submit" class="search-btn">
                      <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="blog-sidebar-box">
              <h3 class="sidebar-title">Recent Posts</h3>
              <div class="sidebar-blog-wrapper-box">
                <div class="sidebar-blog-wrapper">
                  <?php 
                  $stmt_recent = $pdo->prepare("SELECT * FROM blogs WHERE deleted_at IS NULL AND id != ? ORDER BY created_at DESC LIMIT 3");
                  $stmt_recent->execute([$blog['id']]);
                  $recent_blogs = $stmt_recent->fetchAll();
                  foreach ($recent_blogs as $rblog): ?>
                  <article class="sidebar-blog">
                    <div class="thumb">
                      <a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($rblog['slug']) ?>"><img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($rblog['featured_image']) ?>" alt="<?= htmlspecialchars($rblog['title']) ?>" style="width: 80px; height: 80px; object-fit: cover;"></a>
                    </div>
                    <div class="content">
                      <h2 class="title"><a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($rblog['slug']) ?>"><?= htmlspecialchars($rblog['title']) ?></a></h2>
                    </div>
                  </article>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <div class="blog-sidebar-box">
              <h3 class="sidebar-title">Categories</h3>
              <div class="sidebar-category-box">
                <ul class="sidebar-category-list">
                  <?php 
                  $stmt_cats = $pdo->query("SELECT category, COUNT(*) as count FROM blogs WHERE deleted_at IS NULL GROUP BY category");
                  while($cat = $stmt_cats->fetch()): ?>
                  <li><a href="<?= BASE_URL ?>blog?category=<?= urlencode($cat['category']) ?>"><?= htmlspecialchars($cat['category']) ?> <span class="float-end">(<?= $cat['count'] ?>)</span></a></li>
                  <?php endwhile; ?>
                </ul>
              </div>
            </div>
            <div class="blog-sidebar-box">
              <h3 class="sidebar-title">Gallery</h3>
              <div class="sidebar-gallery-box">
                <div class="sidebar-gallery-wrapper">
                  <?php 
                  $stmt_gal = $pdo->query("SELECT featured_image, slug FROM blogs WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 6");
                  while($gal = $stmt_gal->fetch()): ?>
                  <a href="<?= BASE_URL ?>blog/<?= $gal['slug'] ?>"><img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($gal['featured_image']) ?>" alt="gallery image" style="width: 80px; height: 80px; object-fit: cover;"></a>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
            <div class="blog-sidebar-box">
              <h3 class="sidebar-title">Popular Tags</h3>
              <div class="sidebar-tags-box">
                <div class="sidebar-tags">
                  <?php 
                  $stmt_tags = $pdo->query("SELECT tags FROM blogs WHERE deleted_at IS NULL");
                  $all_tags = [];
                  while($trow = $stmt_tags->fetch()) {
                      $ts = explode(',', $trow['tags']);
                      foreach($ts as $t) {
                          $t = trim($t);
                          if($t && !in_array($t, $all_tags)) $all_tags[] = $t;
                      }
                  }
                  foreach(array_slice($all_tags, 0, 10) as $tag): ?>
                  <a href="<?= BASE_URL ?>blog?tag=<?= urlencode($tag) ?>" class="tag"><?= htmlspecialchars($tag) ?></a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- blog-details area end  -->

</main>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>

<script>
  // Wait for GSAP and main scripts to load
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      let mm = gsap.matchMedia();
      
      mm.add("(min-width: 992px)", () => {
        const sidebar = document.querySelector('.blog-sidebar-wrapper');
        const container = document.querySelector('.blog-details-area-inner');
        
        if (sidebar && container) {
          ScrollTrigger.create({
            trigger: sidebar,
            start: "top 20px",
            endTrigger: container,
            // End when the bottom of the sidebar hits the bottom of the container
            end: () => `bottom ${sidebar.offsetHeight + 20}px`,
            pin: true,
            pinSpacing: false,
            invalidateOnRefresh: true,
            onUpdate: (self) => {
              // Extra safety: ensure it doesn't stay fixed past the container
              if (self.progress === 1) {
                sidebar.style.zIndex = "1";
              } else {
                sidebar.style.zIndex = "5";
              }
            }
          });
        }
      });
    }
  });
</script>