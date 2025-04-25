<?php
session_start();
require_once 'db.php';

// Insert sample event (e.g., May 5, 2025) if not already in DB
$checkStmt = $pdo->prepare("SELECT COUNT(*) FROM events WHERE title = ? AND date = ?");
$checkStmt->execute(['Campus Tech Expo', '2025-05-05']);
if ($checkStmt->fetchColumn() == 0) {
    $insertStmt = $pdo->prepare("INSERT INTO events (title, description, department, venue, date, time) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->execute([
        'Campus Tech Expo',
        'A grand showcase of student innovations, robotics, and coding competitions.',
        'Computer Science',
        'Innovation Hall',
        '2025-05-05',
        '10:00:00'
    ]);
}


// Handle event submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $department = $_POST['department'];
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $pdo->prepare("INSERT INTO events (title, description, department, venue, date, time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $department, $venue, $date, $time]);
}

// Handle filters
$search = $_GET['search'] ?? '';
$department = $_GET['department'] ?? '';
$date = $_GET['date'] ?? '';

$query = "SELECT * FROM events WHERE date >= CURDATE()";
$params = [];

if ($search) {
    $query .= " AND title LIKE ?";
    $params[] = "%$search%";
}

if ($department) {
    $query .= " AND department = ?";
    $params[] = $department;
}

if ($date) {
    $query .= " AND date = ?";
    $params[] = $date;
}

$query .= " ORDER BY date ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Add a sample event on May 5, 2025
$sampleEvent = [
    'id' => 0,
    'title' => 'Campus Tech Expo',
    'description' => 'A grand showcase of student innovations, robotics, and coding competitions.',
    'department' => 'Computer Science',
    'venue' => 'Innovation Hall',
    'date' => '2025-05-05',
    'time' => '10:00:00'
];

// Add the sample event to the beginning of the list
array_unshift($events, $sampleEvent);

// Departments list
$departments = [
    'Computer Science', 'Electronics', 'Mechanical', 'Civil',
    'Electrical', 'Information Technology', 'Biotechnology',
    'Chemical Engineering', 'Business Administration', 'Humanities',
    'Mathematics', 'Physics', 'Chemistry'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Event - Event Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<?php include 'includes/header.php'; ?>

<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">Add New Event</h1>

    <form method="POST" class="bg-white p-6 rounded-xl shadow-md grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
        <input type="text" name="title" required placeholder="Title" class="p-3 border rounded-lg">
        <select name="department" required class="p-3 border rounded-lg">
            <option value="">Select Department</option>
            <?php foreach ($departments as $dept): ?>
                <option value="<?= $dept ?>"><?= $dept ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="venue" required placeholder="Venue" class="p-3 border rounded-lg">
        <input type="date" name="date" required class="p-3 border rounded-lg">
        <input type="time" name="time" required class="p-3 border rounded-lg">
        <textarea name="description" required placeholder="Description" class="p-3 border rounded-lg col-span-1 md:col-span-2"></textarea>
        <button type="submit" class="col-span-1 md:col-span-2 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">Add Event</button>
    </form>

    <!-- Search Upcoming Events -->
    <div class="mb-6">
        <form method="GET" class="bg-white p-6 rounded-xl shadow flex flex-wrap gap-4 justify-center">
            <input type="text" name="search" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>" class="p-2 border rounded-lg w-64">
            <select name="department" class="p-2 border rounded-lg w-64">
                <option value="">All Departments</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept ?>" <?= $department === $dept ? 'selected' : '' ?>><?= $dept ?></option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="p-2 border rounded-lg w-64">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Filter</button>
        </form>
    </div>

    <!-- Display Events -->
    <div>
        <?php if (empty($events)): ?>
            <p class="text-center text-gray-500 text-lg">No events found matching your criteria.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($events as $event): ?>
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition relative">
                        <h3 class="text-xl font-bold text-blue-600 mb-1"><?= htmlspecialchars($event['title']) ?></h3>
                        <p class="text-sm text-gray-500 mb-1">📚 <?= htmlspecialchars($event['department']) ?></p>
                        <p class="text-sm text-gray-500 mb-1">📅 <?= date('F d, Y', strtotime($event['date'])) ?></p>
                        <p class="text-sm text-gray-500 mb-1">⏰ <?= date('g:i A', strtotime($event['time'])) ?></p>
                        <p class="text-sm text-gray-500 mb-2">📍 <?= htmlspecialchars($event['venue']) ?></p>
                        <p class="text-gray-700 text-sm mb-4"><?= htmlspecialchars(substr($event['description'], 0, 100)) . '...' ?></p>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="register_event.php">
                                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Register Now</button>
                            </form>
                        <?php else: ?>
                            <a href="login.php" class="block w-full text-center bg-gray-300 text-gray-800 py-2 rounded-lg hover:bg-gray-400 transition">Login to Register</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
