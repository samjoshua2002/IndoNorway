<?php
session_start();
require_once '../database.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Optional: Delete the image file as well?
    // For now, let's keep the file and just delete the record to be safe
    /*
    $stmt = $conn->prepare("SELECT image FROM partners WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row && $row['image']) {
        $filePath = '../assets/files/home/' . $row['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    */

    $stmt = $conn->prepare("DELETE FROM partners WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: partners.php");
exit();
