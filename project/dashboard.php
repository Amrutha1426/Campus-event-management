<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user's registered events
$stmt = $pdo->prepare("
    SELECT e.*, r.registration_date 
    FROM events e 
    JOIN registrations r ON e.id = r.event_id 
    WHERE r.user_id = ? 
    ORDER BY e.date ASC
");
$stmt->execute([$_SESSION['user_id']]);
$registered_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Event Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p>Manage your event registrations</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Your Registered Events</h3>
                <p class="stat-number"><?php echo count($registered_events); ?></p>
            </div>
        </div>

        <div class="dashboard-content">
            <h2>Your Upcoming Events</h2>
            
            <?php if (empty($registered_events)): ?>
                <div class="empty-state">
                    <p>You haven't registered for any events yet.</p>
                    <a href="events.php" class="btn btn-primary">Browse Available Events</a>
                </div>
            <?php else: ?>
                <div class="event-grid">
                    <?php foreach ($registered_events as $event): ?>
                        <div class="event-card">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="event-date">📅 <?php echo date('F d, Y', strtotime($event['date'])); ?></p>
                            <p class="event-time">⏰ <?php echo date('g:i A', strtotime($event['time'])); ?></p>
                            <p class="event-venue">📍 <?php echo htmlspecialchars($event['venue']); ?></p>
                            <a href="events.php?id=<?php echo $event['id']; ?>" class="btn btn-secondary">View Details</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>