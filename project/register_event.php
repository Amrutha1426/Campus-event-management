<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Check if already registered
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ? AND user_id = ?");
        $stmt->execute([$event_id, $user_id]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $_SESSION['error'] = 'You are already registered for this event';
        } else {
            // Check event capacity
            $stmt = $pdo->prepare("
                SELECT e.capacity, COUNT(r.id) as registered
                FROM events e
                LEFT JOIN registrations r ON e.id = r.event_id
                WHERE e.id = ?
                GROUP BY e.id
            ");
            $stmt->execute([$event_id]);
            $event = $stmt->fetch();

            if ($event && $event['registered'] < $event['capacity']) {
                $stmt = $pdo->prepare("INSERT INTO registrations (event_id, user_id) VALUES (?, ?)");
                $stmt->execute([$event_id, $user_id]);
                $_SESSION['success'] = 'Successfully registered for the event';
            } else {
                $_SESSION['error'] = 'Event is already full';
            }
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Registration failed. Please try again.';
    }
}

header('Location: events.php');
exit();
?>