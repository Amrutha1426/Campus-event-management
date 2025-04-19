<?php
session_start();
require_once 'db.php';

// Fetch upcoming events
$stmt = $pdo->query("SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC LIMIT 3");
$upcoming_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="hero">
        <div class="hero-content">
            <h1>Campus Events Management System</h1>
            <p>Discover, register and manage events on your campus with ease</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary">Sign Up Now</a>
                    <a href="login.php" class="btn btn-secondary">Login</a>
                </div>
            <?php else: ?>
                <a href="events.php" class="btn btn-primary">Browse Events</a>
            <?php endif; ?>
        </div>
    </div>

    <section class="features">
        <h2>Why Use Our Platform?</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Easy Event Discovery</h3>
                <p>Find all campus events in one place with powerful filtering options.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✅</div>
                <h3>Simple Registration</h3>
                <p>Register for events with just one click and manage your registrations.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Event Management</h3>
                <p>Create, manage, and track attendance for your events.</p>
            </div>
        </div>
    </section>

    <section class="upcoming-events">
        <h2>Upcoming Events</h2>
        <div class="event-grid">
            <?php foreach ($upcoming_events as $event): ?>
                <div class="event-card">
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p class="event-date">📅 <?php echo date('F d, Y', strtotime($event['date'])); ?></p>
                    <p class="event-time">⏰ <?php echo date('g:i A', strtotime($event['time'])); ?></p>
                    <p class="event-venue">📍 <?php echo htmlspecialchars($event['venue']); ?></p>
                    <a href="events.php?id=<?php echo $event['id']; ?>" class="btn btn-secondary">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>