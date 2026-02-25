<?php
require_once dirname(dirname(__DIR__)) . '/includes/config.php';
session_start();

// Simple Login Check
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: ../login.php");
    exit;
}

// Fetch all blogs (including those with deleted_at)
$stmt = $pdo->prepare("SELECT * FROM blogs ORDER BY created_at DESC");
$stmt->execute();
$blogs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background-color: #343a40; min-height: 100vh; padding: 2rem 1rem; color: #fff; }
        .main-content { padding: 2.5rem; }
        .nav-link { color: #c2c7d0; padding: 0.8rem 1rem; margin-bottom: 0.5rem; border-radius: 8px; }
        .nav-link.active { background-color: #007bff; color: #fff; }
        .nav-link:hover { background-color: rgba(255,255,255,0.1); color: #fff; }
        .card { border: none; border-radius: 12px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
        .btn-action { width: 32px; height: 32px; border-radius: 8px; padding: 0; display: inline-flex; align-items: center; justify-content: center; margin-right: 5px; }
        .badge-active { background-color: #d1e7dd; color: #0f5132; }
        .badge-inactive { background-color: #f8d7da; color: #842029; }
        .logo-img { width: 120px; margin-bottom: 2rem; }
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
                    <h2 class="fw-bold">Blog Management</h2>
                    <div>
                        <a href="<?= BASE_URL ?>" target="_blank" class="btn btn-outline-secondary me-2">View Website</a>
                        <a href="create.php" class="btn btn-primary px-4"><i class="fa-solid fa-plus me-2"></i> Add New Blog</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Featured</th>
                                        <th class="py-3">Title & Slug</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3 pe-4 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blogs as $blog): 
                                        $is_active = is_null($blog['deleted_at']);
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <img src="<?= BASE_URL ?>assets/imgs/blog/<?= htmlspecialchars($blog['featured_image']) ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover; opacity: <?= $is_active ? '1' : '0.5' ?>;">
                                        </td>
                                        <td>
                                            <div class="fw-bold <?= $is_active ? '' : 'text-muted text-decoration-line-through' ?>"><?= htmlspecialchars($blog['title']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($blog['slug']) ?></small>
                                        </td>
                                        <td>
                                            <?php if ($is_active): ?>
                                                <span class="badge badge-active rounded-pill px-3 py-2">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-inactive rounded-pill px-3 py-2">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M, Y', strtotime($blog['created_at'])) ?></td>
                                        <td class="pe-4 text-end">
                                            <a href="edit.php?id=<?= $blog['id'] ?>" class="btn btn-action btn-outline-primary" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="<?= BASE_URL ?>blog/<?= $blog['slug'] ?>" target="_blank" class="btn btn-action btn-outline-info" title="View"><i class="fa-solid fa-eye"></i></a>
                                            <a href="delete.php?id=<?= $blog['id'] ?>" class="btn btn-action <?= $is_active ? 'btn-outline-danger' : 'btn-outline-success' ?>" title="<?= $is_active ? 'Deactivate' : 'Activate' ?>">
                                                <i class="fa-solid <?= $is_active ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($blogs)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted"><i class="fa-solid fa-folder-open fa-3x mb-3"></i><br>No blog posts found.</div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>