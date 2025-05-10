<?php
session_start();

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

if (!is_admin()) {
    header('Location: login.php');
    exit();
}

include './includes/header.php';
require_once './includes/db_connect.php'; // if needed for DB operations
?>

<!-- Tailwind CSS (optional if already included) -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-center mb-6">Admin Panel</h1>

    <!-- Add Dashboard Stats -->
    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Add Dashboard Stat</h2>
        <form action="admin_actions.php" method="POST" class="space-y-4">
            <input type="hidden" name="action" value="add_stat">
            <input type="text" name="stat_name" placeholder="Stat Name" required class="w-full border p-2 rounded">
            <input type="number" name="stat_value" placeholder="Stat Value" required class="w-full border p-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Stat</button>
        </form>
    </div>

    <!-- Add Feature -->
    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Add Feature</h2>
        <form action="admin_actions.php" method="POST" class="space-y-4">
            <input type="hidden" name="action" value="add_feature">
            <input type="text" name="title" placeholder="Feature Title" required class="w-full border p-2 rounded">
            <textarea name="description" placeholder="Feature Description" required class="w-full border p-2 rounded"></textarea>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Feature</button>
        </form>
    </div>

    <!-- Approve Testimonials -->
    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Approve/Delete Testimonials</h2>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM testimonials");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="border p-4 mb-4 rounded shadow">
                <p class="mb-2">"' . htmlspecialchars($row['content']) . '"</p>
                <p class="text-sm text-gray-600">- ' . htmlspecialchars($row['student_name']) . '</p>
                <form action="admin_actions.php" method="POST" class="flex gap-4 mt-2">
                    <input type="hidden" name="testimonial_id" value="' . $row['id'] . '">
                    <input type="hidden" name="action" value="approve_testimonial">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Approve</button>
                </form>
                <form action="admin_actions.php" method="POST" class="mt-2">
                    <input type="hidden" name="testimonial_id" value="' . $row['id'] . '">
                    <input type="hidden" name="action" value="delete_testimonial">
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                </form>
            </div>';
        }
        ?>
    </div>
</div>

<?php include './includes/footer.php'; ?>
