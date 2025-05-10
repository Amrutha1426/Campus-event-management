<?php
include 'db.php';

$type = $_POST['type'] ?? '';

switch ($type) {
    case 'add_stat':
        $stmt = $conn->prepare("INSERT INTO dashboard_stats (title, icon, value) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $_POST['title'], $_POST['icon'], $_POST['value']);
        $stmt->execute();
        break;

    case 'add_feature':
        $stmt = $conn->prepare("INSERT INTO features (icon, title, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['icon'], $_POST['title'], $_POST['description']);
        $stmt->execute();
        break;

    case 'add_benefit':
        $stmt = $conn->prepare("INSERT INTO benefits (icon, title, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['icon'], $_POST['title'], $_POST['description']);
        $stmt->execute();
        break;

    case 'approve_testimonial':
        $stmt = $conn->prepare("UPDATE testimonials SET approved = 1 WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        break;

    case 'delete_testimonial':
        $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        break;
}

header("Location: admin_panel.php");
exit;
