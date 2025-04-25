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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Campus Events Management</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">

<?php include(__DIR__ . '/includes/header.php'); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 py-20 text-white text-center">
  <div class="max-w-4xl mx-auto px-6">
    <h1 class="text-4xl sm:text-5xl font-bold mb-4">Campus Events Management System</h1>
    <p class="text-lg sm:text-xl mb-8">Discover, register and manage events on your campus with ease</p>

    <?php if (!isset($_SESSION['user_id'])): ?>
      <div class="space-x-4">
        <a href="register.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">Sign Up Now</a>
        <a href="login.php" class="bg-white text-blue-600 font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-gray-100 transition">Login</a>
      </div>
    <?php else: ?>
      <div class="space-x-4">
        <a href="events.php" class="bg-white text-blue-600 font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-gray-100 transition">Browse Events</a>
        <a href="logout.php" class="bg-red-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-red-600 transition">Logout</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-12">Why Use Our Platform?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-4">📅</div>
        <h3 class="text-xl font-semibold mb-2">Easy Event Discovery</h3>
        <p class="text-gray-600">Find all campus events in one place with powerful filtering options.</p>
      </div>
      <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-4">✅</div>
        <h3 class="text-xl font-semibold mb-2">Simple Registration</h3>
        <p class="text-gray-600">Register for events with just one click and manage your registrations.</p>
      </div>
      <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-4">👥</div>
        <h3 class="text-xl font-semibold mb-2">Event Management</h3>
        <p class="text-gray-600">Create, manage, and track attendance for your events.</p>
      </div>
    </div>
  </div>
</section>

<!-- Upcoming Events -->
<section class="py-20 bg-gradient-to-br from-blue-50 via-white to-blue-100">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-4xl font-extrabold text-blue-700 mb-14">🎉 Upcoming Events</h2>

    <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 text-left">
      <!-- Event Card -->
      <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-blue-400 hover:shadow-2xl transition duration-300 ease-in-out">
        <div class="flex items-center gap-3 mb-4">
          <div class="bg-blue-100 text-blue-600 p-2 rounded-full text-xl">🎓</div>
          <h3 class="text-xl font-semibold">Freshers Welcome</h3>
        </div>
        <p class="text-sm text-gray-500 mb-1">📅 August 12, 2025</p>
        <p class="text-sm text-gray-500 mb-3">📍 Main Auditorium</p>
        <p class="text-gray-700">Kickstart your campus journey with music, games, and warm introductions to the student community.</p>
      </div>

      <!-- Farewell -->
      <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-pink-400 hover:shadow-2xl transition duration-300 ease-in-out">
        <div class="flex items-center gap-3 mb-4">
          <div class="bg-pink-100 text-pink-600 p-2 rounded-full text-xl">👋</div>
          <h3 class="text-xl font-semibold">Farewell Party</h3>
        </div>
        <p class="text-sm text-gray-500 mb-1">📅 May 5, 2025</p>
        <p class="text-sm text-gray-500 mb-3">📍 Seminar Hall</p>
        <p class="text-gray-700">A heartfelt goodbye to our graduating students with performances and awards.</p>
      </div>

      <!-- Women's Day -->
      <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-purple-400 hover:shadow-2xl transition duration-300 ease-in-out">
        <div class="flex items-center gap-3 mb-4">
          <div class="bg-purple-100 text-purple-600 p-2 rounded-full text-xl">🌸</div>
          <h3 class="text-xl font-semibold">Women’s Day Celebrations</h3>
        </div>
        <p class="text-sm text-gray-500 mb-1">📅 March 8, 2025</p>
        <p class="text-sm text-gray-500 mb-3">📍 Conference Center</p>
        <p class="text-gray-700">Celebrate achievements of women with special talks, performances, and awards.</p>
      </div>

      <!-- Sankranthi Fest -->
      <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-yellow-400 hover:shadow-2xl transition duration-300 ease-in-out">
        <div class="flex items-center gap-3 mb-4">
          <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full text-xl">🪁</div>
          <h3 class="text-xl font-semibold">Sankranthi Fest</h3>
        </div>
        <p class="text-sm text-gray-500 mb-1">📅 January 14, 2025</p>
        <p class="text-sm text-gray-500 mb-3">📍 Open Grounds</p>
        <p class="text-gray-700">Traditional games, kite flying, and cultural fun to celebrate the harvest season.</p>
      </div>

      <!-- Youth Fest -->
      <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-red-400 hover:shadow-2xl transition duration-300 ease-in-out">
        <div class="flex items-center gap-3 mb-4">
          <div class="bg-red-100 text-red-600 p-2 rounded-full text-xl">🔥</div>
          <h3 class="text-xl font-semibold">Youth Fest</h3>
        </div>
        <p class="text-sm text-gray-500 mb-1">📅 February 20, 2025</p>
        <p class="text-sm text-gray-500 mb-3">📍 Central Plaza</p>
        <p class="text-gray-700">A dynamic showcase of student talent in music, drama, and the arts.</p>
      </div>
    </div>
  </div>
</section>


<?php include 'includes/footer.php'; ?>

</body>
</html>