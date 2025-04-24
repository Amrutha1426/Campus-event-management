<?php
session_start();
require_once 'db.php';

// Handle filters
$department = $_GET['department'] ?? '';
$date = $_GET['date'] ?? '';
$search = $_GET['search'] ?? '';

// Build query based on filters
$query = "SELECT * FROM events WHERE date >= CURDATE()";
$params = [];

if ($department) {
    $query .= " AND department = ?";
    $params[] = $department;
}

if ($date) {
    $query .= " AND date = ?";
    $params[] = $date;
}

if ($search) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY date ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get departments for filter
$stmt = $pdo->query("SELECT DISTINCT department FROM events ORDER BY department");
$departments = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Event Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="events-container">
        <div class="events-header">
            <h1>Upcoming Events</h1>
            <p>Discover and register for upcoming events at your campus</p>
        </div>

        <div class="filters">
            <form method="GET" class="filter-form">
                <input type="text" name="search" placeholder="Search events..." value="<?php echo htmlspecialchars($search); ?>">
                
                <select name="department">
                    <option value="">All Departments</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo $dept; ?>" <?php echo $department === $dept ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dept); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="date" name="date" value="<?php echo $date; ?>">
                
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="events.php" class="btn btn-secondary">Clear Filters</a>
            </form>
        </div>

        <?php if (empty($events)): ?>
            <div class="empty-state">
                <p>No events found matching your criteria.</p>
            </div>
        <?php else: ?>
            <div class="event-grid">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p class="event-department"><?php echo htmlspecialchars($event['department']); ?></p>
                        <p class="event-date">📅 <?php echo date('F d, Y', strtotime($event['date'])); ?></p>
                        <p class="event-time">⏰ <?php echo date('g:i A', strtotime($event['time'])); ?></p>
                        <p class="event-venue">📍 <?php echo htmlspecialchars($event['venue']); ?></p>
                        <p class="event-description"><?php echo htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?></p>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="register_event.php">
                                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-block">Register Now</button>
                            </form>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-secondary btn-block">Login to Register</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>