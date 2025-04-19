<?php
session_start();
require_once 'db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];
    $capacity = $_POST['capacity'];
    $department = $_POST['department'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO events (title, description, date, time, venue, capacity, department)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([$title, $description, $date, $time, $venue, $capacity, $department]);
        $success = 'Event created successfully';
    } catch (PDOException $e) {
        $error = 'Failed to create event. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event - Event Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="admin-container">
        <div class="admin-card">
            <h2>Create New Event</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" class="admin-form">
                <div class="form-group">
                    <label for="title">Event Title</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="description">Event Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="venue">Venue</label>
                    <input type="text" id="venue" name="venue" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" id="capacity" name="capacity" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="department">Department</label>
                        <select id="department" name="department" required>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Business">Business</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Fine Arts">Fine Arts</option>
                            <option value="Medicine">Medicine</option>
                            <option value="Law">Law</option>
                            <option value="Science">Science</option>
                        </select>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Create Event</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>