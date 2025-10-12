<?php
session_start();
require_once '../config/db_config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Mock statistics - replace with real queries when tables are ready
$total_feedback = 1247;
$avg_rating = 4.2;
$pending_actions = 23;
$improvement_trend = 15;

?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">

<head>
    <title>Admin Dashboard - UPang SFPIS</title>
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
    <?php include '../includes/sidebar.php'; ?>
    <!-- [ Sidebar Menu ] end -->
    
    <!-- [ Header Topbar ] start -->
    <?php include '../includes/header.php'; ?>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">Dashboard Overview</h5>
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
                                        <?php echo number_format($total_feedback); ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Total Feedback</p>
                                </div>
                                <div class="text-4xl opacity-50">📊</div>
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
                                        <?php echo $avg_rating; ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Average Rating</p>
                                </div>
                                <div class="text-4xl opacity-50">⭐</div>
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
                                        <?php echo $pending_actions; ?>
                                    </h3>
                                    <p class="text-sm font-medium" style="color: var(--upang-dark-green);">Pending Actions</p>
                                </div>
                                <div class="text-4xl opacity-50">⏳</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-3 md:col-span-6">
                    <div class="