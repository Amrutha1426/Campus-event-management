<?php
// for_students.php
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
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .dashboard-card {
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 12px;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        padding: 2rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .dashboard-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #6366f1;
    }

    .dashboard-title {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .dashboard-value {
        font-size: 2rem;
        color: #2c3e50;
        font-weight: bold;
    }

    /* Animated Pie Chart */
    .chart-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .chart-description {
        flex: 1;
        padding-right: 2rem;
        text-align: left;
    }

    .chart-description h2 {
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }

    .chart-description p {
        color: #555;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .chart-container {
        flex: 1;
        background-color: #fff;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        max-width: 400px; /* Decrease chart size */
    }

    .chart-container h2 {
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .chart-container canvas {
        width: 100% !important;
        height: auto !important;
    }

    /* Calendar Section */
    #calendar {
        margin-top: 3rem;
    }

    /* Testimonials Section */
    .testimonials {
        margin-top: 3rem;
        text-align: center;
    }

    .testimonial-item {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        border-radius: 8px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .testimonial-item cite {
        display: block;
        font-style: italic;
        margin-top: 0.5rem;
        color: #6366f1;
    }

    /* Feature Cards with Hover Animation */
    .feature-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 2rem;
        text-align: center;
        transition: transform 0.3s ease;
        backdrop-filter: blur(12px);
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #6366f1;
    }

    .feature-card h3 {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .feature-card p {
        color: #555;
    }

    .solutions-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .solution-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .solution-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .solution-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #6366f1;
    }

    .solution-card h3 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .solution-card p {
        color: #555;
    }

    .solution-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .solution-modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        width: 80%;
        max-width: 600px;
        position: relative;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .solution-modal-content h2 {
        font-size: 1.5rem;
        color: #333;
    }

    .solution-modal-content p {
        font-size: 1.1rem;
        color: #555;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
    }
</style>

<div class="container">

<!-- 🔴 Live Dashboard Section -->
<div class="dashboard">
    <div class="dashboard-card">
        <div class="dashboard-icon">📅</div>
        <div class="dashboard-title">Total Events</div>
        <div class="dashboard-value">45</div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-icon">🏅</div>
        <div class="dashboard-title">Upcoming Competitions</div>
        <div class="dashboard-value">12</div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-icon">📚</div>
        <div class="dashboard-title">Registered Courses</div>
        <div class="dashboard-value">18</div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-icon">💬</div>
        <div class="dashboard-title">Recent Feedback</div>
        <div class="dashboard-value">35</div>
    </div>
</div>

<!-- Animated Pie Chart with Description -->
<div class="chart-section">
    <!-- Chart Description -->
    <div class="chart-description">
        <h2>📊 Your Event Stats</h2>
        <p>Here’s an overview of your current event participation statistics. This pie chart displays the distribution of total events, upcoming competitions, and the number of courses you’ve registered for.</p>
        <p><strong>Total Events</strong>: Represents the number of events you’ve attended or are eligible for.</p>
        <p><strong>Upcoming Competitions</strong>: Displays the competitions you can register for or have upcoming in your calendar.</p>
        <p><strong>Registered Courses</strong>: Shows the number of courses you've signed up for as part of event participation.</p>
    </div>

    <!-- Chart Container -->
    <div class="chart-container">
        <h2>Chart Overview</h2>
        <canvas id="studentChart"></canvas>
    </div>
</div>
<script>
    window.onload = function() {
        const ctx = document.getElementById('studentChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Events', 'Upcoming Competitions', 'Registered Courses'],
                datasets: [{
                    label: 'Your Stats',
                    data: [45, 12, 18], // You can dynamically inject these via PHP if needed
                    backgroundColor: ['#6366f1', '#4caf50', '#ff9800'],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const data = context.dataset.data;
                                const total = data.reduce((acc, val) => acc + val, 0);
                                const value = context.raw;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return ${context.label}: ${value} (${percentage}%);
                            }
                        }
                    }
                }
            }
        });
    };
</script>


<!-- Categorized Events -->
<h2>📂 Browse Events by Category</h2>
<div class="dashboard grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php
    $categories = [
        ["🎨", "Arts & Culture", "Engage with artistic showcases, cultural nights, and exhibitions."],
        ["💻", "Tech Events", "Join hackathons, coding challenges, and tech workshops."],
        ["📈", "Business & Management", "Pitch ideas, join B-plan contests, and attend seminars."],
        ["🎤", "Seminars & Talks", "Get inspired by guest lectures and expert sessions."],
        ["⚽", "Sports Meets", "Compete in tournaments and athletic events."],
        ["🎮", "Gaming", "Compete in e-sports and casual gaming contests."]
    ];
    foreach ($categories as $cat) {
        echo '
        <div class="feature-card">
            <div class="icon">'.$cat[0].'</div>
            <h3>'.$cat[1].'</h3>
            <p>'.$cat[2].'</p>
        </div>';
    }
    ?>
</div>
<!-- Competition Timeline -->
<h2>🕑 Upcoming Competitions Timeline</h2>
<div class="border-l-4 border-indigo-500 pl-4 ml-4 my-6">
    <?php
    $timeline = [
        ['May 10', 'Hackathon Kickoff'],
        ['May 12', 'Business Pitch Submission'],
        ['May 14', 'Code Debugging Round'],
        ['May 18', 'Sports Qualifiers'],
        ['May 20', 'Final Presentations'],
    ];
    foreach ($timeline as $item) {
        echo '
        <div class="mb-6 relative">
            <div class="absolute w-4 h-4 bg-indigo-500 rounded-full -left-6 top-1.5"></div>
            <p class="text-sm text-gray-600 font-semibold">'.$item[0].'</p>
            <p class="text-lg text-gray-800">'.$item[1].'</p>
        </div>';
    }
    ?>
</div>
<!-- Ticket-style Enrolled Courses with Claim Button -->
<h2>🎫 Your Enrolled Courses</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <?php
    $courses = [
        ['Event Management Basics', 'Enroll Date: April 12, 2025', 'Venue: Online'],
        ['Public Speaking Workshop', 'Enroll Date: March 28, 2025', 'Venue: Hall B'],
        ['Leadership Bootcamp', 'Enroll Date: Feb 20, 2025', 'Venue: Auditorium'],
    ];
    foreach ($courses as $index => $course) {
        echo '
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-purple-500 relative overflow-hidden">
            <div class="absolute -left-6 top-0 h-full w-2 bg-purple-500"></div>
            <h3 class="text-xl font-semibold text-purple-600">'.$course[0].'</h3>
            <p class="text-gray-600 mt-2">'.$course[1].'</p>
            <p class="text-gray-500 mb-4">'.$course[2].'</p>
            <form method="post" action="claim_ticket.php">
                <input type="hidden" name="course_name" value="'.htmlspecialchars($course[0]).'">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    🎟️ Claim Ticket
                </button>
            </form>
        </div>';
    }
    ?>
</div>
<!-- Event Calendar Section -->
<h2 class="mt-16">📅 Your Event Calendar</h2>
<div id="calendar" class="my-10"></div>

<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: [
                { title: 'Event 1', start: '2025-05-10' },
                { title: 'Event 2', start: '2025-05-15' },
                { title: 'Competition 1', start: '2025-05-12' }
            ]
        });
    });
</script>

<!-- Student Dashboard Features -->
<h1>📢 Opportunities for Students</h1>
<div class="card-grid">
    <?php
    $features = [
        ["🎓", "Register for Events", "Explore and register for upcoming university events, competitions, and workshops."],
        ["📜", "Track Your Participation", "View all the events you have participated in and track your progress."],
        ["📝", "Submit Feedback", "Provide valuable feedback after attending events to help improve the system."],
        ["📑", "View Certificates", "Access and download certificates for the events you’ve participated in."],
        ["📅", "Personalized Event Calendar", "Get a personalized calendar that syncs with your events and competition schedules."]
    ];

    foreach ($features as $feature) {
        echo '
        <div class="feature-card">
            <div class="icon">' . $feature[0] . '</div>
            <h3>' . $feature[1] . '</h3>
            <p>' . $feature[2] . '</p>
        </div>';
    }
    ?>
</div>
<!-- Solutions for Students Section (Updated Layout) -->
<h2>🧩 Solutions for Students</h2>
    <div class="solutions-container">
        <?php
        $solutions = [
            ["🧑‍💼", "Career & Internship Portal", "Discover internships and career opportunities tailored to your field of study.", "Find opportunities that match your skills and aspirations."],
            ["📄", "Resume Builder", "Craft a professional resume using pre-designed templates and expert guidance.", "Use templates and tips to create the perfect resume."],
            ["🤝", "Peer Mentorship", "Connect with seniors and alumni to receive mentorship and advice.", "Get personalized guidance for your academic and career path."],
            ["🎯", "Learning Paths", "Follow curated learning tracks to upskill for competitions or careers.", "Choose learning paths that match your goals."],
            ["🗣️", "Discussion Forums", "Collaborate with peers, share notes, ask doubts, and discuss event experiences.", "Join discussions to enhance your learning."],
            ["🎥", "Recorded Webinars", "Watch recordings of previous webinars and expert talks to learn at your pace.", "Access a library of recorded talks to learn at your convenience."]
        ];
        foreach ($solutions as $index => $solution) {
            echo '
            <div class="solution-card" onclick="openModal('.$index.')">
                <div class="solution-icon">'.$solution[0].'</div>
                <h3>'.$solution[1].'</h3>
                <p>'.$solution[2].'</p>
            </div>';

            // Modal content for each solution
            echo '
            <div id="modal-'.$index.'" class="solution-modal">
                <div class="solution-modal-content">
                    <span class="modal-close" onclick="closeModal('.$index.')">&times;</span>
                    <h2>'.$solution[1].'</h2>
                    <p>'.$solution[3].'</p>
                </div>
            </div>';
        }
        ?>
    </div>

    <script>
        function openModal(index) {
            document.getElementById('modal-' + index).style.display = 'flex';
        }

        function closeModal(index) {
            document.getElementById('modal-' + index).style.display = 'none';
        }
    </script>

    <!-- Existing content... -->
</div>


<!-- Testimonials Section -->
<h2>🎓 Student Testimonials</h2>
<div class="testimonials">
    <div class="testimonial-item">
        <p>"This platform has helped me connect with so many opportunities. I’ve grown so much!"</p>
        <cite>- Alice Doe</cite>
    </div>
    <div class="testimonial-item">
        <p>"I love the event calendar! It keeps me on track and makes sure I never miss an important event."</p>
        <cite>- Bob Smith</cite>
    </div>
</div>






</div>

<?php
include './includes/footer.php';
?>