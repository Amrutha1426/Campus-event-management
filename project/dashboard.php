<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch registered events
$stmt = $pdo->prepare("
    SELECT e.*, r.registration_date 
    FROM events e 
    JOIN registrations r ON e.id = r.event_id 
    WHERE r.user_id = ? 
    ORDER BY e.date ASC
");
$stmt->execute([$_SESSION['user_id']]);
$registered_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total number of events
$total_events_stmt = $pdo->query("SELECT COUNT(*) FROM events");
$total_events = $total_events_stmt->fetchColumn();

// Participation Score
$participation_score = count($registered_events);

// Badge Calculation
$badge = '🏅 No Badge';
$badge_color = 'gray-400';
if ($participation_score >= 20) {
    $badge = '🥇 Gold Badge';
    $badge_color = 'yellow-400';
} elseif ($participation_score >= 10) {
    $badge = '🥈 Silver Badge';
    $badge_color = 'gray-400';
} elseif ($participation_score >= 5) {
    $badge = '🥉 Bronze Badge';
    $badge_color = 'yellow-600';
}

// Upcoming Event within 7 days
$upcoming_event = null;
foreach ($registered_events as $event) {
    $event_date = strtotime($event['date']);
    if ($event_date >= strtotime('now') && $event_date <= strtotime('+7 days')) {
        $upcoming_event = $event;
        break;
    }
}

// Sample Notifications
$notifications = [
    "🚀 New event: Coding Marathon! Register Now!",
    "🎉 Hackathon 2025 registrations closing soon!"
];

// Mock Profile Data
$user_department = $_SESSION['department'] ?? 'Computer Science';
$user_email = $_SESSION['email'] ?? 'example@example.com';

// Fetch top 5 participants
$leaderboard_stmt = $pdo->query("
    SELECT u.name, COUNT(r.event_id) AS participation_count
    FROM users u
    JOIN registrations r ON u.id = r.user_id
    GROUP BY u.id
    ORDER BY participation_count DESC
    LIMIT 5
");
$top_participants = $leaderboard_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all upcoming events (not just registered ones)
$all_upcoming_stmt = $pdo->prepare("SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC");
$all_upcoming_stmt->execute();
$all_upcoming_events = $all_upcoming_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Event Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-b from-blue-50 to-white min-h-screen text-gray-800">

<?php include 'includes/header.php'; ?>

<div class="max-w-7xl mx-auto py-12 px-6 space-y-12">

  <!-- Welcome Header -->
  <div class="text-center">
    <h1 class="text-5xl font-extrabold text-blue-700 mb-4 animate-pulse">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h1>
    <p class="text-gray-600 text-lg">Manage your events and achievements with ease</p>
  </div>

  <!-- Dashboard Stats -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div class="bg-white shadow-lg p-6 rounded-2xl border-t-4 border-blue-500">
      <h3 class="text-lg font-semibold">Registered Events</h3>
      <p class="text-4xl font-bold text-blue-700 mt-2"><?php echo $participation_score; ?></p>
    </div>
    <div class="bg-white shadow-lg p-6 rounded-2xl border-t-4 border-green-500">
      <h3 class="text-lg font-semibold">Participation</h3>
      <div class="mt-3 w-full bg-gray-200 rounded-full h-4">
        <div class="bg-green-400 h-4 rounded-full" style="width: <?php echo ($total_events ? ($participation_score / $total_events) * 100 : 0); ?>%;"></div>
      </div>
      <p class="text-sm text-gray-500 mt-2"><?php echo $participation_score . '/' . $total_events; ?> Events</p>
    </div>
    <div class="bg-white shadow-lg p-6 rounded-2xl border-t-4 border-<?php echo $badge_color; ?>">
      <h3 class="text-lg font-semibold">Achievements</h3>
      <p class="text-3xl mt-2"><?php echo $badge; ?></p>
    </div>
    <div class="bg-white shadow-lg p-6 rounded-2xl border-t-4 border-red-400">
      <h3 class="text-lg font-semibold">Certificates</h3>
      <p class="text-sm text-gray-500 mt-2">Available after participation.</p>
      <a href="#" class="inline-block mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 text-sm">Download</a>
    </div>
  </div>

  <!-- All Upcoming Events -->
  <div>
    <h2 class="text-3xl font-bold text-gray-800 mb-8 mt-12">📢 All Upcoming Events</h2>

    <?php if (empty($all_upcoming_events)): ?>
      <div class="bg-white p-8 rounded-2xl shadow text-center">
        <p class="text-gray-600 text-lg mb-6">No upcoming events available right now.</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($all_upcoming_events as $event): ?>
          <div class="bg-white shadow-md rounded-lg p-4 mb-4 relative">
            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
              <?php echo date('M d, Y', strtotime($event['date'])); ?>
            </span>
            <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($event['title']); ?></h2>
            <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($event['description']); ?></p>
            <p class="text-gray-600 text-sm mb-2">📍 <?php echo htmlspecialchars($event['venue']); ?></p>
            <a href="events.php?id=<?php echo $event['id']; ?>" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">View & Register</a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Notifications -->
  <div class="bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">🔔 Notifications</h2>
    <ul class="space-y-2 list-disc list-inside">
      <?php foreach ($notifications as $note): ?>
        <li class="text-gray-700 text-md"><?php echo htmlspecialchars($note); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>

  <!-- Leaderboard -->
  <div class="bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">🏆 Leaderboard - Top Participants</h2>
    <ol class="list-decimal list-inside space-y-2 text-gray-700">
      <?php foreach ($top_participants as $index => $participant): ?>
        <li><span class="font-semibold"><?php echo htmlspecialchars($participant['name']); ?></span> - <?php echo $participant['participation_count']; ?> events</li>
      <?php endforeach; ?>
    </ol>
  </div>

  <!-- Calendar -->
  <div class="bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">📅 Upcoming Events Calendar</h2>
    <div id="calendar" class="grid grid-cols-7 gap-2 text-center text-sm text-gray-700"></div>
  </div>

  <!-- Profile Summary -->
  <div class="bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">👤 Profile Summary</h2>
    <ul class="space-y-2 text-gray-700 text-md">
      <li><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
      <li><strong>Department:</strong> <?php echo htmlspecialchars($user_department); ?></li>
      <li><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></li>
      <li><strong>Events Attended:</strong> <?php echo $participation_score; ?></li>
    </ul>
  </div>

  <!-- Registered Events -->
  <div>
    <h2 class="text-3xl font-bold text-gray-800 mb-8">🎟️ Your Registered Events</h2>

    <?php if (empty($registered_events)): ?>
      <div class="bg-white p-8 rounded-2xl shadow text-center">
        <p class="text-gray-600 text-lg mb-6">You haven't registered for any events yet.</p>
        <a href="events.php" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition">Browse Events</a>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($registered_events as $event): ?>
          <div class="bg-white shadow-md rounded-lg p-4 mb-4 relative">
            <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
              <?php echo date('M d, Y', strtotime($event['date'])); ?>
            </span>
            <h2 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($event['title']); ?></h2>
            <p class="text-gray-700 mb-2"><?php echo htmlspecialchars($event['description']); ?></p>
            <p class="text-gray-600 text-sm mb-2">📍 <?php echo htmlspecialchars($event['venue']); ?></p>
            <a href="events.php?id=<?php echo $event['id']; ?>" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">View Details</a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>

...
<!-- Calendar -->
<div class="bg-white p-6 rounded-2xl shadow-md">
  <h2 class="text-2xl font-bold text-gray-800 mb-4">📅 Upcoming Events Calendar</h2>
  <div id="calendar" class="grid grid-cols-7 gap-2 text-center text-sm text-gray-700"></div>
</div>

<script>
  const upcomingEvents = <?php echo json_encode(array_merge(
    array_map(function($event) {
      return [
        'title' => $event['title'],
        'date' => date('Y-m-d', strtotime($event['date']))
      ];
    }, $all_upcoming_events),
    [
      ['title' => 'Tech Talk - AI in 2025', 'date' => '2025-05-25']  // Manually added
    ]
  )); ?>;

  function renderCalendar(events) {
    const calendar = document.getElementById('calendar');
    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth();

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    calendar.innerHTML = '';

    for (let i = 0; i < firstDay; i++) {
      calendar.appendChild(document.createElement('div'));
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const date = new Date(year, month, day);
      const dateStr = date.toISOString().split('T')[0];
      const event = events.find(e => e.date === dateStr);

      const dayCell = document.createElement('div');
      dayCell.className = 'p-2 rounded-lg border border-gray-200 text-xs text-left';

      const dayText = document.createElement('div');
      dayText.className = 'font-bold';
      dayText.textContent = day;

      dayCell.appendChild(dayText);

      if (event) {
        const eventText = document.createElement('div');
        eventText.className = 'mt-1 text-blue-700';
        eventText.textContent = event.title;
        dayCell.classList.add('bg-yellow-100', 'border-blue-300');
        dayCell.appendChild(eventText);
      }

      calendar.appendChild(dayCell);
    }
  }

  renderCalendar(upcomingEvents);
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>


<?php include 'includes/footer.php'; ?>
</body>
</html>
