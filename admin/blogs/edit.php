<?php
require_once dirname(dirname(__DIR__)) . '/includes/config.php';
session_start();

// Simple Login Check
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch blog data
$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch();

if (!$blog) {
    header("Location: index.php");
    exit;
}

$upload_error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'] ?: $title;
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));
    $slug = preg_replace('/-+/', '-', $slug); // Collapse multiple dashes
    $content = $_POST['content'];
    $quote = $_POST['quote'];
    $tags = $_POST['tags'];
    $category = $_POST['category'];
    $facebook_url = $_POST['facebook_url'];
    $twitter_url = $_POST['twitter_url'];
    $instagram_url = $_POST['instagram_url'];
    $linkedin_url = $_POST['linkedin_url'];
    
    // Handle File Upload
    $featured_image = $blog['featured_image']; // Default to current image
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['size'] > 0) {
        // Validate file
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $max_size = 5 * 1024 * 1024; // 5MB
        $file_ext = strtolower(pathinfo($_FILES["featured_image"]["name"], PATHINFO_EXTENSION));
        
        if ($_FILES['featured_image']['error'] !== 0) {
            $upload_error = "Upload error code: " . $_FILES['featured_image']['error'];
            log_error("Blog edit image upload error: " . $upload_error);
        } elseif (!in_array($file_ext, $allowed_ext)) {
            $upload_error = "Invalid file type. Allowed: JPG, PNG, GIF, WEBP";
        } elseif ($_FILES['featured_image']['size'] > $max_size) {
            $upload_error = "File size exceeds 5MB limit";
        } else {
            $target_dir = dirname(dirname(__DIR__)) . "/assets/imgs/blog/";
            
            // Ensure directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $file_name = time() . '_' . $slug . '.' . $file_ext;
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
                $featured_image = $file_name;
                log_error("Blog $id image updated: $file_name");
            } else {
                $upload_error = "Failed to move uploaded file. Check directory permissions.";
                log_error("Blog edit image upload failed: " . $upload_error . " | Target: " . $target_file);
            }
        }
    }

    $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, content = ?, quote = ?, tags = ?, category = ?, featured_image = ?, facebook_url = ?, twitter_url = ?, instagram_url = ?, linkedin_url = ? WHERE id = ?");
    $stmt->execute([$title, $slug, $content, $quote, $tags, $category, $featured_image, $facebook_url, $twitter_url, $instagram_url, $linkedin_url, $id]);

    if (!$upload_error) {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background-color: #343a40; min-height: 100vh; padding: 2rem 1rem; color: #fff; }
        .main-content { padding: 2.5rem; }
        .nav-link { color: #c2c7d0; padding: 0.8rem 1rem; margin-bottom: 0.5rem; border-radius: 8px; }
        .nav-link.active { background-color: #007bff; color: #fff; }
        .nav-link:hover { background-color: rgba(255,255,255,0.1); color: #fff; }
        .card { border: none; border-radius: 12px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 2rem; }
        .form-label { font-weight: 600; color: #495057; }
        .form-control { border-radius: 8px; padding: 0.75rem; border: 1px solid #ced4da; }
        .logo-img { width: 120px; margin-bottom: 2rem; }
        .section-header { border-bottom: 2px solid #e9ecef; padding-bottom: 0.5rem; margin-bottom: 1.5rem; color: #007bff; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-none d-md-block">
                <img src="<?= BASE_URL ?>assets/imgs/logo/mohjaylogo-white.png" alt="Logo" class="logo-img px-3">
                <nav class="nav flex-column">
                    <a class="nav-link active" href="index.php"><i class="fa-solid fa-file-lines me-2"></i> Blogs</a>
                    <a class="nav-link mt-auto" href="../logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Edit Blog Post</h2>
                    <a href="index.php" class="btn btn-outline-secondary px-4"><i class="fa-solid fa-arrow-left me-2"></i> Back to List</a>
                </div>

                <?php if ($upload_error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> <strong>Upload Error:</strong> <?= htmlspecialchars($upload_error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="section-header">Content Details</h5>
                                    <div class="mb-4">
                                        <label for="title" class="form-label">Blog Title</label>
                                        <input type="text" name="title" id="title" class="form-control" required value="<?= htmlspecialchars($blog['title']) ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea name="content" id="editor" rows="15" class="form-control" required><?= htmlspecialchars($blog['content']) ?></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="quote" class="form-label">Highlight Quote</label>
                                        <textarea name="quote" id="quote" rows="3" class="form-control"><?= htmlspecialchars($blog['quote']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="section-header">Post Metadata</h5>
                                    <div class="mb-4">
                                        <label for="slug" class="form-label">Slug (URL)</label>
                                        <input type="text" name="slug" id="slug" class="form-control" value="<?= htmlspecialchars($blog['slug']) ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="IT Solution" <?= $blog['category'] == 'IT Solution' ? 'selected' : '' ?>>IT Solution</option>
                                            <option value="SEO Marketing" <?= $blog['category'] == 'SEO Marketing' ? 'selected' : '' ?>>SEO Marketing</option>
                                            <option value="Website Development" <?= $blog['category'] == 'Website Development' ? 'selected' : '' ?>>Website Development</option>
                                            <option value="Cloud Solution" <?= $blog['category'] == 'Cloud Solution' ? 'selected' : '' ?>>Cloud Solution</option>
                                            <option value="Network Marketing" <?= $blog['category'] == 'Network Marketing' ? 'selected' : '' ?>>Network Marketing</option>
                                        </select>
                                    </div>
                                    <div class="mb-4 text-center">
                                        <img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($blog['featured_image']) ?>" class="img-fluid rounded mb-2" style="max-height: 150px;">
                                    </div>
                                    <div class="mb-4">
                                        <label for="featured_image" class="form-label">Replace Featured Image</label>
                                        <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="mb-4">
                                        <label for="tags" class="form-label">Tags (Comma-separated)</label>
                                        <input type="text" name="tags" id="tags" class="form-control" value="<?= htmlspecialchars($blog['tags']) ?>">
                                    </div>

                                    <h5 class="section-header">Social Media Links</h5>
                                    <div class="mb-3">
                                        <label for="facebook_url" class="form-label small">Facebook URL</label>
                                        <input type="url" name="facebook_url" id="facebook_url" class="form-control form-control-sm" value="<?= htmlspecialchars($blog['facebook_url']) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="twitter_url" class="form-label small">Twitter (X) URL</label>
                                        <input type="url" name="twitter_url" id="twitter_url" class="form-control form-control-sm" value="<?= htmlspecialchars($blog['twitter_url']) ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="instagram_url" class="form-label small">Instagram URL</label>
                                        <input type="url" name="instagram_url" id="instagram_url" class="form-control form-control-sm" value="<?= htmlspecialchars($blog['instagram_url']) ?>">
                                    </div>
                                    <div class="mb-4">
                                        <label for="linkedin_url" class="form-label small">LinkedIn URL</label>
                                        <input type="url" name="linkedin_url" id="linkedin_url" class="form-control form-control-sm" value="<?= htmlspecialchars($blog['linkedin_url']) ?>">
                                    </div>

                                    <div class="d-grid gap-2 pt-2">
                                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa-solid fa-save me-2"></i> Update Post</button>
                                        <a href="index.php" class="btn btn-light">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize CKEditor
        CKEDITOR.replace('editor');

        // Auto Slug Generation (only if manually changing title)
        document.getElementById('title').addEventListener('input', function() {
            // Usually, on Edit we might not want to auto-change slug unless confirmed
            // But if user wants it, they can use this.
        });
    </script>
</body>
</html>