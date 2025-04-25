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

if (!empty($department)) {
    $query .= " AND department = ?";
    $params[] = $department;
}

if (!empty($date)) {
    $query .= " AND date = ?";
    $params[] = $date;
}

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY date ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Static departments
$all_departments = [
    'Computer Science', 'Electronics', 'Mechanical', 'Civil',
    'Electrical', 'Information Technology', 'Biotechnology',
    'Chemical Engineering', 'Business Administration',
    'Humanities', 'Mathematics', 'Physics', 'Chemistry'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events - Event Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
  <?php include 'includes/header.php'; ?>

  <div class="max-w-7xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
      <h1 class="text-3xl font-bold text-blue-700">Upcoming Events</h1>
      <p class="text-gray-600 mt-2">Discover and register for upcoming campus events</p>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-6 rounded-xl shadow mb-10">
      <input
        type="text"
        name="search"
        placeholder="Search events..."
        value="<?= htmlspecialchars($search); ?>"
        class="border p-2 rounded-lg"
      >

      <select name="department" class="border p-2 rounded-lg">
        <option value="">All Departments</option>
        <?php foreach ($all_departments as $dept): ?>
          <option value="<?= htmlspecialchars($dept); ?>" <?= $department === $dept ? 'selected' : ''; ?>>
            <?= htmlspecialchars($dept); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <input
        type="date"
        name="date"
        value="<?= htmlspecialchars($date); ?>"
        class="border p-2 rounded-lg"
      >

      <div class="flex space-x-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Filter</button>
        <a href="events.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Clear</a>
      </div>
    </form>

    <!-- Events Grid -->
    <?php if (empty($events)): ?>
      <div class="bg-white p-6 rounded-xl shadow text-center text-gray-600">
        No events found matching your criteria.
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($events as $event): ?>
          <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h3 class="text-xl font-bold text-blue-600 mb-1"><?= htmlspecialchars($event['title']); ?></h3>
            <p class="text-sm text-gray-500 mb-1">📚 <?= htmlspecialchars($event['department']); ?></p>
            <p class="text-sm text-gray-500 mb-1">📅 <?= date('F d, Y', strtotime($event['date'])); ?></p>
            <p class="text-sm text-gray-500 mb-1">⏰ <?= date('g:i A', strtotime($event['time'])); ?></p>
            <p class="text-sm text-gray-500 mb-2">📍 <?= htmlspecialchars($event['venue']); ?></p>
            <p class="text-gray-700 text-sm mb-4"><?= htmlspecialchars(substr($event['description'], 0, 100)) . '...'; ?></p>

            <?php if (isset($_SESSION['user_id'])): ?>
              <form method="POST" action="register_event.php">
                <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Register Now</button>
              </form>
            <?php else: ?>
              <a href="login.php" class="block w-full text-center bg-gray-300 text-gray-800 py-2 rounded-lg hover:bg-gray-400 transition">
                Login to Register
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
