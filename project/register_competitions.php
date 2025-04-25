<?php include 'includes/header.php'; ?>

<style>
  body {
    background-image: url('https://images.unsplash.com/photo-1531746790731-6c087fecd65a'); /* Replace with your desired image URL */
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
</style>

<main class="min-h-screen flex items-center justify-center px-4 py-16 bg-black/60">
  <div class="w-full max-w-xl bg-white/90 shadow-2xl backdrop-blur-md rounded-xl p-10">
    <h1 class="text-3xl font-bold text-center text-blue-700 mb-6">Competition Registration</h1>
    <p class="text-center text-gray-600 mb-8">Fill in your details below to register for your favorite campus competition.</p>

    <form method="POST" action="submit_registration.php" class="space-y-6">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
        <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label>
        <input type="text" name="roll" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
        <input type="text" name="department" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
        <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Select Competition</label>
        <select name="event" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
          <?php
            $events = [
              "Singing", "Dancing", "Ramp Walk", "Basketball", "Kho-Kho", "Throwball",
              "Tug of War", "Cricket", "Chess", "Carroms", "Craft Making", "Photography",
              "Coding Challenge", "Quiz", "Painting", "Short Film"
            ];
            $selectedEvent = isset($_GET['event']) ? $_GET['event'] : '';
            foreach ($events as $e) {
              $selected = $selectedEvent === $e ? 'selected' : '';
              echo "<option value=\"$e\" $selected>$e</option>";
            }
          ?>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
        Register Now
      </button>
    </form>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
