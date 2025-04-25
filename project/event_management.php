<!-- event_management.php -->
<?php include 'includes/header.php'; ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <!-- Hero Section -->
  <section class="text-center mb-12">
    <span class="inline-block bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 shadow">All-in-One Platform</span>
    <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Campus Event Management</h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto">We help streamline and manage campus events with ease — from planning to promotion and registration.</p>
  </section>

  <!-- What We Manage -->
  <section class="mb-16">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-l-4 border-blue-600 pl-3">What We Manage</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition duration-300">
        <h3 class="text-xl font-semibold text-blue-600 mb-2">Workshops & Seminars</h3>
        <p class="text-gray-600">Organize academic sessions including workshops, guest lectures, and technical seminars with hassle-free registration and notifications.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition duration-300">
        <h3 class="text-xl font-semibold text-blue-600 mb-2">Cultural Events</h3>
        <p class="text-gray-600">Manage music nights, dance shows, art exhibitions, and cultural festivals with event scheduling and volunteer coordination.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition duration-300">
        <h3 class="text-xl font-semibold text-blue-600 mb-2">Hackathons & Competitions</h3>
        <p class="text-gray-600">Seamlessly handle technical competitions with team registrations, rule management, live updates, and result display.</p>
      </div>
    </div>
  </section>

  <!-- How We Handle Events -->
  <section class="mb-16">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-l-4 border-blue-600 pl-3">How We Handle Events</h2>
    <div class="space-y-6 text-gray-600">
      <p><strong>Planning:</strong> Our dashboard allows administrators to plan event dates, assign tasks, and allocate resources all in one place.</p>
      <p><strong>Promotion:</strong> Easily share events across campus using social media integrations and newsletter automation.</p>
      <p><strong>Registration:</strong> Students can register via web or QR, with real-time attendee management and analytics.</p>
      <p><strong>Feedback:</strong> Post-event surveys help you improve future events by collecting and analyzing attendee feedback.</p>
    </div>
  </section>

  <!-- Campus Event Highlights -->
  <section class="mb-16">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Campus Event Highlights</h2>
    <p class="text-gray-600 mb-6 text-center max-w-3xl mx-auto">Explore some of the most vibrant and unforgettable moments from past campus events.</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      <div class="bg-white p-3 rounded-xl shadow hover:shadow-lg transition duration-300">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3N6xMfl3HcJ3gtF6i6GA14YuKNtar8fJTGg&s" alt="Movie promotions" class="rounded-lg object-cover h-60 w-full mb-3">
        <p class="text-sm text-gray-700 text-center">Energetic movie promo event featuring celebrity guests and live performances.</p>
      </div>
      <div class="bg-white p-3 rounded-xl shadow hover:shadow-lg transition duration-300">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPiiK21Z8GmIPrwiSfYvFS8Zc_gEWz2smvrg&s" alt="Vista viit" class="rounded-lg object-cover h-60 w-full mb-3">
        <p class="text-sm text-gray-700 text-center">VISTA – A vibrant inter-college cultural fest showcasing art, music, and talent.</p>
      </div>
      <div class="bg-white p-3 rounded-xl shadow hover:shadow-lg transition duration-300">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9PKPIN44uTQt7gnSV9PhB0bLZ1PYOoJr8qg&s" alt="Yuvatarang viit" class="rounded-lg object-cover h-60 w-full mb-3">
        <p class="text-sm text-gray-700 text-center">Yuvatarang – A grand celebration of youth with competitions, fashion shows, and more.</p>
      </div>
    </div>
  </section>

  <!-- Campus Competitions -->
  <section class="mb-20">
    <h2 class="text-2xl font-semibold text-gray-800 mb-10 text-center">Exciting Campus Competitions</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8 text-center">
      <?php
        $competitions = [
            ['name' => 'Singing', 'icon' => '🎤', 'link' => 'register_competitions.php?event=Singing'],
            ['name' => 'Dancing', 'icon' => '💃', 'link' => 'register_competitions.php?event=Dancing'],
            ['name' => 'Ramp Walk', 'icon' => '🕺', 'link' => 'register_competitions.php?event=Ramp%20Walk'],
            ['name' => 'Basketball', 'icon' => '🏀', 'link' => 'register_competitions.php?event=Basketball'],
            ['name' => 'Kho-Kho', 'icon' => '🏃‍♀️', 'link' => 'register_competitions.php?event=Kho-Kho'],
            ['name' => 'Throwball', 'icon' => '🏐', 'link' => 'register_competitions.php?event=Throwball'],
            ['name' => 'Tug of War', 'icon' => '💪', 'link' => 'register_competitions.php?event=Tug%20of%20War'],
            ['name' => 'Cricket', 'icon' => '🏏', 'link' => 'register_competitions.php?event=Cricket'],
            ['name' => 'Chess', 'icon' => '♟️', 'link' => 'register_competitions.php?event=Chess'],
            ['name' => 'Carroms', 'icon' => '🎯', 'link' => 'register_competitions.php?event=Carroms'],
            ['name' => 'Craft Making', 'icon' => '✂️', 'link' => 'register_competitions.php?event=Craft%20Making'],
            ['name' => 'Photography', 'icon' => '📸', 'link' => 'register_competitions.php?event=Photography'],
            ['name' => 'Coding Challenge', 'icon' => '💻', 'link' => 'register_competitions.php?event=Coding%20Challenge'],
            ['name' => 'Quiz', 'icon' => '🧠', 'link' => 'register_competitions.php?event=Quiz'],
            ['name' => 'Painting', 'icon' => '🎨', 'link' => 'register_competitions.php?event=Painting'],
            ['name' => 'Short Film', 'icon' => '🎬', 'link' => 'register_competitions.php?event=Short%20Film'],
          ];
          
        foreach ($competitions as $comp) {
          echo '
          <a href="' . $comp['link'] . '" class="flex flex-col items-center bg-white p-4 rounded-xl shadow hover:shadow-xl transition duration-300 hover:scale-105">
            <div class="text-4xl bg-purple-100 text-purple-700 rounded-full w-16 h-16 flex items-center justify-center mb-3 shadow-inner">' . $comp['icon'] . '</div>
            <span class="text-sm font-medium text-gray-800">' . $comp['name'] . '</span>
          </a>';
        }
      ?>
    </div>
    <p class="text-gray-600 text-center mt-6">Click any event above to see more details, schedule, and registration info.</p>
  </section>

  <!-- Call to Action -->
  <section class="text-center mt-20 bg-gradient-to-r from-blue-600 to-purple-600 py-10 rounded-xl shadow-md text-white">
    <h2 class="text-2xl font-bold mb-4">Ready to Transform Your Campus Events?</h2>
    <a href="register.php" class="inline-block bg-white text-blue-700 font-semibold px-6 py-3 rounded-full shadow-md hover:bg-gray-100 transition">
      Get Started Today
    </a>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
