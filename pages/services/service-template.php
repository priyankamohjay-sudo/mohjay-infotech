<?php
$serviceSlug = $serviceSlug ?? null;

$dataPath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'services.json';
$services = [];

if (is_readable($dataPath)) {
  $json = file_get_contents($dataPath);
  // Strip UTF-8 BOM if present to avoid json_decode failure on Windows.
  $json = preg_replace('/^\xEF\xBB\xBF/', '', $json);
  $services = json_decode($json, true);
}

$service = null;
if ($serviceSlug && is_array($services) && isset($services[$serviceSlug])) {
  $service = $services[$serviceSlug];
}

if (!$service) {
  http_response_code(404);
  $title = 'Service Not Found | Mohjay Infotech';
  $description = '';
  $tags = '';
  include dirname(dirname(__DIR__)) . '/includes/header.php';
  ?>
  <main>
    <section class="breadcrumb-area">
      <div class="breadcrumb-area-inner">
        <div class="breadcrumb-bg">
          <img src="<?= BASE_URL ?>assets/imgs/gallery/gallery-29.webp" alt="image">
        </div>
        <div class="container rr-container-1410">
          <div class="breadcrumb-content">
            <div class="title-wrapper">
              <h1 class="breadcrumb-title">Service Not Found</h1>
            </div>
            <div class="breadcrumb-wrapper">
              <ul class="rr-breadcrumb">
                <li><a href="<?= BASE_URL ?>">Home</a></li>
                <li>Service Not Found</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="service-details-area">
      <div class="container rr-container-1410">
        <div class="service-details-area-inner section-spacing">
          <div class="service-details-content">
            <div class="section-title-wrapper">
              <div class="title-wrapper">
                <h2 class="section-title">We could not find this service.</h2>
              </div>
            </div>
            <div class="text-wrapper">
              <p class="text">Please check the URL or contact us for assistance.</p>
            </div>
            <div class="btn-wrapper">
              <a href="<?= BASE_URL ?>contact" class="rr-btn">
                <span class="btn-wrap">
                  <span class="text-one">Contact Us <i class="fa-solid fa-arrow-right"></i></span>
                  <span class="text-two">Contact Us <i class="fa-solid fa-arrow-right"></i></span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include dirname(dirname(__DIR__)) . '/includes/footer.php'; ?>
  <?php
  return;
}

$title = $service['meta_title'] ?? 'Mohjay Infotech Services';
$description = $service['meta_description'] ?? '';
$tags = $service['meta_tags'] ?? '';

include dirname(dirname(__DIR__)) . '/includes/header.php';
?>

<main>

  <!-- breadcrumb area start -->
  <section class="breadcrumb-area">
    <div class="breadcrumb-area-inner">
      <div class="breadcrumb-bg">
        <img src="<?= BASE_URL ?><?= htmlspecialchars($service['breadcrumb_bg']) ?>" alt="image">
      </div>
      <div class="container rr-container-1410">
        <div class="breadcrumb-content">
          <div class="title-wrapper">
            <h1 class="breadcrumb-title"><?= htmlspecialchars($service['breadcrumb_title']) ?></h1>
          </div>
          <div class="breadcrumb-wrapper">
            <ul class="rr-breadcrumb">
              <li><a href="<?= BASE_URL ?>">Home</a></li>
              <li><?= htmlspecialchars($service['breadcrumb_title']) ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb area end -->

  <!-- service-details area start  -->
  <section class="service-details-area">
    <div class="container rr-container-1410">
      <div class="service-details-area-inner section-spacing">
        <div class="service-details-content fade-anim" data-direction="left">
          <div class="section-title-wrapper">
            <div class="subtitle-wrapper">
              <span class="section-subtitle"><span class="start-shape"></span><span class="text"><?= htmlspecialchars($service['subtitle']) ?></span><span class="end-shape"></span></span>
            </div>
            <div class="title-wrapper">
              <h2 class="section-title"><?= htmlspecialchars($service['headline']) ?></h2>
            </div>
          </div>
          <div class="text-wrapper">
            <p class="text highlight"><?= htmlspecialchars($service['highlight']) ?></p>
            <p class="text"><?= htmlspecialchars($service['body']) ?></p>
          </div>
          <div class="btn-wrapper">
            <a href="<?= BASE_URL ?><?= htmlspecialchars($service['cta_link']) ?>" class="rr-btn">
              <span class="btn-wrap">
                <span class="text-one"><?= htmlspecialchars($service['cta_text']) ?> <i class="fa-solid fa-arrow-right"></i></span>
                <span class="text-two"><?= htmlspecialchars($service['cta_text']) ?> <i class="fa-solid fa-arrow-right"></i></span>
              </span>
            </a>
          </div>
        </div>
        <div class="service-details-thumb-wrappper fade-anim" data-direction="right">
          <div class="service-details-thumb">
            <img src="<?= BASE_URL ?><?= htmlspecialchars($service['hero_image']) ?>" alt="image">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- service-details area end  -->

  <!-- key-service area start  -->
  <section class="key-service-area fade-anim">
    <div class="key-service-bg">
      <img src="<?= BASE_URL ?><?= htmlspecialchars($service['key_service_bg']) ?>" alt="image">
    </div>
    <div class="container rr-container-1410">
      <div class="key-service-area-inner section-spacing">
        <div class="key-service-content fade-anim">
          <h2 class="key-service-title"><?= htmlspecialchars($service['key_services_title']) ?></h2>
          <ul class="service-list">
            <?php foreach ($service['key_services'] as $item) { ?>
              <li><i class="fa-solid fa-octagon-check"></i><?= htmlspecialchars($item) ?></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- key-service area end  -->

  <!-- process-3 area start  -->
  <section class="process-3-area">
    <div class="container rr-container-1410">
      <div class="process-3-area-inner section-spacing">
        <div class="process-3-header fade-anim">
          <div class="section-title-wrapper">
            <div class="subtitle-wrapper">
              <span class="section-subtitle"><span class="start-shape"></span><span class="text">Our Work Process</span><span class="end-shape"></span></span>
            </div>
            <div class="title-wrapper">
              <h2 class="section-title"><?= htmlspecialchars($service['process_title']) ?></h2>
            </div>
          </div>
        </div>
        <div class="process-3-wrapper-box">
          <div class="process-3-wrapper">
            <?php foreach ($service['process_steps'] as $step) { ?>
              <div class="process-3-box fade-anim">
                <div class="number-box">
                  <div class="number"><?= htmlspecialchars($step['number']) ?></div>
                </div>
                <div class="content">
                  <h3 class="title"><?= htmlspecialchars($step['title']) ?></h3>
                  <p class="text"><?= htmlspecialchars($step['text']) ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- process-3 area end  -->

</main>

<?php include dirname(dirname(__DIR__)) . '/includes/footer.php'; ?>
