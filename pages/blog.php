<?php
$title="Best Software Company In India | Mohjay Infotech";
$description="We are a technology-driven IT company specializing in software development mobile applications, web solutions, and digital transformation services.";
$tags = "software development, web solutions, digital marketing, mobile app development";
include '../includes/header.php'; ?>

<style>
  @media (min-width: 992px) {
    .blog-sidebar-wrapper-box {
      height: 100%;
    }
    /* Allow GSAP to handle transforms for pinning */
    .blog-sidebar-wrapper {
      position: relative;
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
                  <h1 class="breadcrumb-title">Our Latest Posts</h1>
                </div>
                <div class="breadcrumb-wrapper">
                  <ul class="rr-breadcrumb">
                    <li><a href="<?= BASE_URL ?>">Home</a></li>
                    <li>Blog</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- breadcrumb area end -->

        <!-- blog-list area start  -->
        <div class="blog-list-area">
          <div class="container rr-container-1410">
            <div class="blog-list-area-inner section-spacing">
              <div class="blog-list-wrapper-box">
                <div class="blog-list-wrapper">
                  <?php 
                  $search = $_GET['search'] ?? '';
                  $cat_filter = $_GET['category'] ?? '';
                  $tag_filter = $_GET['tag'] ?? '';

                  $sql = "SELECT * FROM blogs WHERE deleted_at IS NULL";
                  $params = [];

                  if ($search) {
                      $sql .= " AND (title LIKE ? OR content LIKE ?)";
                      $params[] = "%$search%";
                      $params[] = "%$search%";
                  }
                  if ($cat_filter) {
                      $sql .= " AND category = ?";
                      $params[] = $cat_filter;
                  }
                  if ($tag_filter) {
                      $sql .= " AND tags LIKE ?";
                      $params[] = "%$tag_filter%";
                  }

                  $sql .= " ORDER BY created_at DESC";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute($params);
                  $blogs = $stmt->fetchAll();

                  // Redirect to detail if search has exact one result
                  if ($search && count($blogs) === 1) {
                      header("Location: " . BASE_URL . "blog/" . $blogs[0]['slug']);
                      exit;
                  }
                  
                  if ($blogs):
                    foreach ($blogs as $blog): ?>
                    <article class="blog-4 fade-anim">
                      <div class="thumb">
                        <a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($blog['slug']) ?>"><img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($blog['featured_image']) ?>" alt="<?= htmlspecialchars($blog['title']) ?>"></a>
                      </div>
                      <div class="content">
                        <div class="meta">
                          <span class="category"><i class="fa-regular fa-folder"></i><?= htmlspecialchars($blog['category']) ?></span>
                          <span class="date"><i class="fa-regular fa-calendar"></i><?= date('d M, Y', strtotime($blog['created_at'])) ?></span>
                        </div>
                        <h2 class="title"><a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($blog['slug']) ?>"><?= htmlspecialchars($blog['title']) ?></a>
                        </h2>
                        <p class="text"><?= htmlspecialchars(mb_strimwidth(strip_tags($blog['content']), 0, 250, '...')) ?></p>
                        <a href="<?= BASE_URL ?>blog/<?= htmlspecialchars($blog['slug']) ?>" class="rr-btn">
                          <span class="btn-wrap">
                            <span class="text-one">Read Details <i class="fa-solid fa-angles-right"></i></span>
                            <span class="text-two">Read Details <i class="fa-solid fa-angles-right"></i></span>
                          </span>
                        </a>
                      </div>
                    </article>
                    <?php endforeach;
                  else: ?>
                    <div class="alert alert-info">No blog posts found matching your criteria.</div>
                  <?php endif; ?>
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
                          <input type="text" name="search" placeholder="Enter Keyword" value="<?= htmlspecialchars($search) ?>">
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
                        $stmt_recent = $pdo->prepare("SELECT * FROM blogs WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 3");
                        $stmt_recent->execute();
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
        <!-- blog-list area end  -->

      </main>

       <?php include '../includes/footer.php'; ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      let mm = gsap.matchMedia();
      
      mm.add("(min-width: 992px)", () => {
        const sidebar = document.querySelector('.blog-sidebar-wrapper');
        const container = document.querySelector('.blog-list-area-inner');
        
        if (sidebar && container) {
          ScrollTrigger.create({
            trigger: sidebar,
            start: "top 20px",
            endTrigger: container,
            // End pinning when the sidebar bottom hits the container bottom
            end: () => `bottom ${sidebar.offsetHeight + 20}px`,
            pin: true,
            pinSpacing: false,
            invalidateOnRefresh: true,
            onUpdate: (self) => {
              if (self.progress === 1) {
                sidebar.style.zIndex = "1";
              } else {
                sidebar.style.zIndex = "5";
              }
            }
          });
          
          // Aggressive refresh to ensure all dynamic content/images are loaded
          window.addEventListener('load', () => {
            ScrollTrigger.refresh();
          });
          setTimeout(() => {
            ScrollTrigger.refresh();
          }, 1000);
        }
      });
    }
  });
</script>