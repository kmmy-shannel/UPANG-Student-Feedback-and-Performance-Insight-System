<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <!-- Logo + Greeting -->
    <div class="flex flex-col items-center py-6">
      <!-- School Logo -->
      <div class="school-logo mb-3">
          <a href="dashboard.php">
        <img src="../assets/images/school-logo.png" alt="School Logo" 
             style="width: 90px; height: 90px; border-radius: 50%;">
</a>
      </div>

      <!-- Greeting -->
      <div class="text-center">
        <span class="text-lg font-semibold" style="color: #FFD700;">
          <?php
          if (isset($_SESSION['first_name'])) {
              echo "Hi, " . htmlspecialchars($_SESSION['first_name']);
          } else {
              echo "Hi, Student";
          }
          ?>
        </span>
      </div>
    </div>
     
    </div>
    <div class="navbar-content h-[calc(100vh_-_74px)] relative">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Navigation</label>
        </li>
        <li class="pc-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
          <a href="dashboard.php" class="pc-link">
            <span class="pc-micon"><i data-feather="home"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <li class="pc-item <?php echo basename($_SERVER['PHP_SELF']) == 'my-courses.php' ? 'active' : ''; ?>">
          <a href="my-courses.php" class="pc-link">
            <span class="pc-micon"><i data-feather="book"></i></span>
            <span class="pc-mtext">My Subjects</span>
          </a>
        </li>
        <li class="pc-item <?php echo basename($_SERVER['PHP_SELF']) == 'submit-feedback.php' ? 'active' : ''; ?>">
          <a href="submit-feedback.php" class="pc-link">
            <span class="pc-micon"><i data-feather="edit"></i></span>
            <span class="pc-mtext">Submit Feedback</span>
          </a>
        </li>
        <li class="pc-item <?php echo basename($_SERVER['PHP_SELF']) == 'feedback-history.php' ? 'active' : ''; ?>">
          <a href="feedback-history.php" class="pc-link">
            <span class="pc-micon"><i data-feather="clock"></i></span>
            <span class="pc-mtext">Feedback History</span>
          </a>
        </li>
        <li class="pc-item <?php echo basename($_SERVER['PHP_SELF']) == 'analytics.php' ? 'active' : ''; ?>">
          <a href="analytics.php" class="pc-link">
            <span class="pc-micon"><i data-feather="bar-chart-2"></i></span>
            <span class="pc-mtext">My Analytics</span>
          </a>
        </li>
        <li class="pc-item pc-caption">
          <label>Account</label>
        </li>
        <li class="pc-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
          <a href="profile.php" class="pc-link">
            <span class="pc-micon"><i data-feather="user"></i></span>
            <span class="pc-mtext">Profile</span>
          </a>
        </li>
        <li class="pc-item">
         <a href="../../logout.php" class="pc-link">

            <span class="pc-micon"><i data-feather="log-out"></i></span>
            <span class="pc-mtext">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>