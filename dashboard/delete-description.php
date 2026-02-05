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
    $stmt = $conn->prepare("DELETE FROM description WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: description.php");
exit();
