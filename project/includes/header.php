<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Events</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header class="bg-white shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-20">
    <!-- Logo Section -->
    <div class="flex items-center gap-3">
      <img src="https://t4.ftcdn.net/jpg/06/58/52/69/360_F_658526949_OPtABJyZyniWxJKa4TTpVX1SwdRunSEq.jpg" alt="Logo" class="h-10 w-auto">
      <span class="text-2xl font-bold text-gray-800">Campus Events</span>
    </div>

    <!-- Navigation Links -->
    <nav class="hidden md:flex space-x-12">
      <!-- Products Menu -->
      <div class="relative group">
        <button class="flex items-center gap-1 text-gray-700 font-medium hover:text-blue-600 focus:outline-none">
          Products
          <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="absolute left-0 mt-2 w-44 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
          <a href="event_management.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Event Management</a>
          <a href="register.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Registration</a> <!-- ✅ Updated -->
        </div>
      </div>

      <!-- Solutions Menu -->
      <div class="relative group">
        <button class="flex items-center gap-1 text-gray-700 font-medium hover:text-blue-600 focus:outline-none">
          Solutions
          <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="absolute left-0 mt-2 w-44 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
          <a href="for_universities.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">For Universities</a>
          <a href="for_students.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">For Students</a>
        </div>
      </div>

      <!-- Who We Are Menu -->
      <div class="relative group">
        <button class="flex items-center gap-1 text-gray-700 font-medium hover:text-blue-600 focus:outline-none">
          Who We Are
          <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="absolute left-0 mt-2 w-44 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
          <a href="about_us.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">About Us</a>
          <a href="our_team.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Our Team</a>
        </div>
      </div>

      <!-- Resources Menu -->
      <div class="relative group">
        <button class="flex items-center gap-1 text-gray-700 font-medium hover:text-blue-600 focus:outline-none">
          Resources
          <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="absolute left-0 mt-2 w-44 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
          <a href="blog.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Blog</a>
          <a href="help_center.php" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Help Center</a>
        </div>
      </div>
    </nav>

    <!-- Request a Demo Button -->
    <div class="ml-4 hidden md:block">
      <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-2 px-5 rounded-full shadow-md transition">
        Request a Demo
      </a>
    </div>

    <!-- Mobile Menu Button -->
    <div class="md:hidden">
      <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-800 focus:outline-none">
        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Dropdown Menu -->
  <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
    <nav class="flex flex-col space-y-1 p-4">
      <a href="event_management.php" class="text-gray-700 hover:text-blue-600">Event Management</a>
      <a href="register.php" class="text-gray-700 hover:text-blue-600">Registration</a> <!-- ✅ Updated -->
      <a href="for_universities.php" class="text-gray-700 hover:text-blue-600">For Universities</a>
      <a href="for_students.php" class="text-gray-700 hover:text-blue-600">For Students</a>
      <a href="about_us.php" class="text-gray-700 hover:text-blue-600">About Us</a>
      <a href="our_team.php" class="text-gray-700 hover:text-blue-600">Our Team</a>
      <a href="blog.php" class="text-gray-700 hover:text-blue-600">Blog</a>
      <a href="help_center.php" class="text-gray-700 hover:text-blue-600">Help Center</a>
      <a href="#" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-2 px-4 rounded-full text-center shadow-md transition mt-2">
        Request a Demo
      </a>
    </nav>
  </div>

  <!-- Mobile Menu Script -->
  <script>
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</header>
