<?php
require_once dirname(dirname(__DIR__)) . '/includes/config.php';
session_start();

// Simple Login Check
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Check current status
    $stmt = $pdo->prepare("SELECT deleted_at FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch();

    if ($blog) {
        if (is_null($blog['deleted_at'])) {
            // Make Inactive (soft delete)
            $stmt = $pdo->prepare("UPDATE blogs SET deleted_at = NOW() WHERE id = ?");
        } else {
            // Make Active (restore)
            $stmt = $pdo->prepare("UPDATE blogs SET deleted_at = NULL WHERE id = ?");
        }
        $stmt->execute([$id]);
    }
}

header("Location: index.php");
exit;