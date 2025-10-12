<?php
session_start();
require_once '../config/db_config.php';

// Check if user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: ../../index.php");
    exit();
}

// Get student information
$db = new Database();
$conn = $db->getConnection();

try {
    // Get user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $student = $stmt->fetch();

    // Mock data for now - replace with real queries when tables are ready
    $enrolled_subjects = 8;
    $feedback_submitted = 5;
    $pending_evaluations = 3;
    $avg_rating = 4.2;

} catch (PDOException $e) {
    error_log("Dashboard Error: " . $e->getMessage());
    $enrolled_subjects = 0;
    $feedback_submitted = 0;
    $pending_evaluations = 0;
    $avg_rating = 0;
}

?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">

<head>
    <title>Student Dashboard - UPang SFPIS</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="../assets/fonts/feather.css" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/fonts/material.css" />
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --upang-gold: #FFD700;
            --upang-green: #228B22;
            --upang-dark-green: #006400;
            --upang-light-gold: #FFF8DC;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, var(--upang-light-gold) 100%);
            border-left: 4px solid var(--upang-gold);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
        <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
            <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
   <?php include 'includes/student-sidebar.php'; ?>
    <!-- [ Sidebar Menu ] end -->
    
    <!-- [ Header Topbar ] start -->
    <?php include 'includes/header.php'; ?>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">Student Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                    </ul>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="grid grid-cols-12 gap-x-6">
                <!-- Statistics Cards -->
                <div class="col-span-12 xl:col-span-3 md:col-span-6">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-3xl mb-2" style="color: var(--upang-green);">
                                        <?php echo $enrolled_subjects; ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Enrolled Subjects</p>
                                </div>
                                <div class="text-4xl opacity-50">📚</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-3 md:col-span-6">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-3xl mb-2" style="color: var(--upang-green);">
                                        <?php echo $feedback_submitted; ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Feedback Submitted</p>
                                </div>
                                <div class="text-4xl opacity-50">✅</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-3 md:col-span-6">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-3xl mb-2" style="color: var(--upang-green);">
                                        <?php echo $pending_evaluations; ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Pending Evaluations</p>
                                </div>
                                <div class="text-4xl opacity-50">⏳</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-3 md:col-span-6">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-3xl mb-2" style="color: var(--upang-green);">
                                        <?php echo number_format($avg_rating, 1); ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Your Avg. Rating</p>
                                </div>
                                <div class="text-4xl opacity-50">⭐</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="col-span-12 xl:col-span-6">
                    <div class="card chart-container">
                        <div class="card-header !pb-3 !border-b-0">
                            <h5 style="color: var(--upang-dark-green);">Course Progress Overview</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="progressChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6">
                    <div class="card chart-container">
                        <div class="card-header !pb-3 !border-b-0">
                            <h5 style="color: var(--upang-dark-green);">Semester Activity</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="activityChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-span-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="flex flex-wrap gap-3">
                                <a href="submit-feedback.php" class="btn btn-primary">
                                    <i class="ti ti-pencil mr-2"></i> Submit New Feedback
                                </a>
                                <a href="my-courses.php" class="btn btn-secondary">
                                    <i class="ti ti-book mr-2"></i> View My Subjects
                                </a>
                                <a href="feedback-history.php" class="btn btn-outline-primary">
                                    <i class="ti ti-history mr-2"></i> Review Past Feedback
                                </a>
                                <a href="analytics.php" class="btn btn-outline-secondary">
                                    <i class="ti ti-chart-bar mr-2"></i> View My Analytics
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <?php include '../includes/footer.php'; ?>

    <!-- Required Js -->
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/icon/custom-icon.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="../assets/js/component.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/script.js"></script>

    <script>
        // Progress Chart
        const progressCtx = document.getElementById('progressChart').getContext('2d');
        new Chart(progressCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [<?php echo $feedback_submitted; ?>, <?php echo $pending_evaluations; ?>],
                    backgroundColor: ['#228B22', '#FFD700'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = <?php echo $enrolled_subjects; ?>;
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Feedback Submissions',
                    data: [2, 3, 1, 4],
                    borderColor: '#228B22',
                    backgroundColor: 'rgba(34, 139, 34, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#228B22',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        layout_change('false');
        layout_theme_sidebar_change('dark');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');
        main_layout_change('vertical');
    </script>
</body>
</html>