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
    // Delete image file if it's not placeholder
    $stmt = $conn->prepare("SELECT image FROM people WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $person = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($person) {
        if ($person['image'] && $person['image'] !== 'placeholder.png' && $person['image'] !== 'ethaya-crop.webp' && $person['image'] !== 'sulalit-crop.webp') {
            // Basic safety check to not delete seeded files if possible, though 'time()_' prefix usually distinguishes uploads.
            // We'll just delete if it exists in people/ folder
            $filePath = '../assets/files/people/' . $person['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $stmt = $conn->prepare("DELETE FROM people WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: people.php");
exit();
?>