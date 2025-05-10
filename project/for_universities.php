<?php
// for_universities.php
include './includes/header.php';
?>

<link rel="stylesheet" href="./assets/css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9fc;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    h1, h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 2rem;
    }

    /* Dashboard Section */
    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .dashboard-card {
        background-color: #ffffff;
        border-left: 5px solid #6366f1;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
    }

    .dashboard-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #6366f1;
    }

    .dashboard-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }

    .dashboard-value {
        font-size: 1.8rem;
        color: #2c3e50;
        font-weight: bold;
    }

    /* Flip Card Styles */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        perspective: 1000px;
    }

    .flip-card {
        background-color: transparent;
        width: 100%;
        height: 260px;
        perspective: 1000px;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 1.5rem;
        backface-visibility: hidden;
    }

    .flip-card-front {
        background-color: #ffffff;
        border-top: 5px solid #6366f1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .flip-card-back {
        background-color: #6366f1;
        color: white;
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 1.5rem;
    }

    .icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .flip-card-front h3,
    .flip-card-back h3 {
        margin: 0.5rem 0;
    }

    .flip-card-back p {
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Glassmorphism Benefits Cards */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .benefit-card {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.4);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        padding: 1.5rem;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .benefit-card:hover {
        transform: translateY(-6px);
    }

    .benefit-card .icon {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        color: #6366f1;
    }

    .benefit-card h3 {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .benefit-card p {
        font-size: 0.95rem;
        color: #333;
    }

    /* Calendar Section */
    #calendar {
        margin-top: 3rem;
    }

    /* Testimonial Section */
    .testimonials {
        margin-top: 3rem;
        text-align: center;
    }

    .testimonial-item {
        background-color: #fff;
        padding: 1.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        border-radius: 8px;
    }

    .testimonial-item cite {
        display: block;
        font-style: italic;
        margin-top: 0.5rem;
        color: #6366f1;
    }

</style>

<div class="container">

    <!-- 🔴 Live Dashboard Section -->
    <div class="dashboard">
        <div class="dashboard-card">
            <div class="dashboard-icon">📅</div>
            <div class="dashboard-title">Total Events</div>
            <div class="dashboard-value">128</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon">👥</div>
            <div class="dashboard-title">Participants</div>
            <div class="dashboard-value">2,450</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon">💬</div>
            <div class="dashboard-title">Feedbacks</div>
            <div class="dashboard-value">982</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon">🏅</div>
            <div class="dashboard-title">Certificates Issued</div>
            <div class="dashboard-value">1,213</div>
        </div>
    </div>

    <!-- Interactive Chart Section -->
    <h2>📊 Event Overview</h2>
    <div style="max-width: 600px; margin: 0 auto;">
        <canvas id="eventChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('eventChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Events', 'Participants', 'Feedbacks'],
                datasets: [{
                    label: 'Event Data',
                    data: [128, 2450, 982],
                    backgroundColor: ['#6366f1', '#4caf50', '#f44336']
                }]
            }
        });
    </script>

    <!-- Event Calendar Section -->
    <h2>📅 Event Calendar</h2>
    <div id="calendar"></div>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: [
                    { title: 'Event 1', start: '2025-05-10' },
                    { title: 'Event 2', start: '2025-05-15' }
                ]
            });
        });
    </script>

    <!-- Flip Cards with Features -->
    <h1>🔗 Solutions for Universities</h1>
    <div class="card-grid">
        <?php
        $features = [
            ["✅", "Admin Dashboard Overview", "A control panel for managing events, users, and feedback with real-time stats and overview cards."],
            ["🗓️", "Create & Manage Events", "Admins can create, edit, or delete events with full details including title, date, time, description, and images."],
            ["📢", "Result Declaration System", "Declare winners and upload event result certificates online for transparent and instant access."],
            ["👥", "User Management", "Add, remove, and manage student and admin accounts, with role-based access control."],
            ["📊", "Event Analytics", "Get graphical insights on student participation, feedback ratings, and popular event types."],
            ["🔒", "Secure Login System", "Ensure access is restricted to authorized users using encrypted credentials and session handling."],
            ["📨", "Bulk Communication", "Easily send out event updates and invitations to registered students via email notifications."],
            ["📟️", "Feedback Analysis", "Track trends and export student feedback data for event improvements and reporting."],
            ["🌐", "University Branding", "Showcase your institution's identity with logos, themes, and custom domain setup."],
            ["🧠", "AI-Based Suggestions", "Future-ready: Get automatic event ideas based on past participation and feedback patterns."]
        ];

        foreach ($features as $feature) {
            echo '
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="icon">' . $feature[0] . '</div>
                        <h3>' . $feature[1] . '</h3>
                    </div>
                    <div class="flip-card-back">
                        <h3>' . $feature[1] . '</h3>
                        <p>' . $feature[2] . '</p>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Testimonials Section -->
    <h2>🎓 Student Testimonials</h2>
    <div class="testimonials">
        <div class="testimonial-item">
            <p>"The event was amazing! I learned so much about teamwork and leadership."</p>
            <cite>- John Doe</cite>
        </div>
        <div class="testimonial-item">
            <p>"A great experience overall. Looking forward to more events like this!"</p>
            <cite>- Jane Smith</cite>
        </div>
    </div>

    <!-- University Management Benefits -->
    <h2>🎓 University Management Benefits</h2>
    <div class="benefits-grid">
        <?php
        $benefits = [
            ["🔗", "Integrated Coherent System", "Offers interlinking of academic and non-academic departments using a cloud-based system for smooth and efficient operations."],
            ["🤝", "Connecting Stakeholders", "Reduces errors and boosts teacher-student communication, while simplifying admissions, exams, and announcements."],
            ["🛡️", "Eliminates Mismanagement", "Protects data from manipulation using encryption and security tools, ensuring fraud-free operations."],
            ["🧑‍💼", "Better Administrative Rights", "Gives admin control over institution operations with a modern dashboard supporting university-specific goals."]
        ];

        foreach ($benefits as $benefit) {
            echo '
            <div class="benefit-card">
                <div class="icon">' . $benefit[0] . '</div>
                <h3>' . $benefit[1] . '</h3>
                <p>' . $benefit[2] . '</p>
            </div>';
        }
        ?>
    </div>

</div>

<?php
include './includes/footer.php';
?>
