<?php
include 'db.php'; // Correct path to db.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $event = $_POST['event'];

    try {
        $stmt = $pdo->prepare("INSERT INTO competition_registrations (name, roll, department, phone, email, event) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $roll, $department, $phone, $email, $event]);

        echo "<h3>Thank you, $name! You've registered for $event successfully.</h3>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
