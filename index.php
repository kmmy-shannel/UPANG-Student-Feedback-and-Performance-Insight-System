<?php
session_start();
require_once __DIR__ . '/dist/includes/db_config.php';



if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            $db = new Database();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND status = 'active' LIMIT 1");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Store session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];

                // Redirect based on role
                if ($user['user_type'] === 'admin') {
                    header("Location: ./dist/admin/dashboard.php");
                    exit;
                } elseif ($user['user_type'] === 'student') {
                    header("Location: ./student-dashboard.php");
                    exit;
                } else {
                    $error = "Unauthorized role.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>UPang Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="." />
    <meta name="keywords" content="." />
    <meta name="author" content="Sniper 2025" />

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./dist/assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/feather.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/material.css" />

    <!-- Main Theme -->
      <style>
        :root {
            --upang-green: #2d5a27;
            --upang-green-light: #4a7c59;
            --upang-green-dark: #1a3518;
            --upang-gold: #d4af37;
            --upang-gold-light: #f4d03f;
            --upang-gold-dark: #b8941f;
            --upang-white: #ffffff;
            --upang-cream: #fefefe;
            --upang-gray-light: #f8f9fa;
            --upang-gray: #6c757d;
            --upang-error: #dc3545;
            --shadow-soft: 0 10px 40px rgba(45, 90, 39, 0.1);
            --shadow-medium: 0 20px 60px rgba(45, 90, 39, 0.15);
            --gradient-primary: linear-gradient(135deg, var(--upang-green) 0%, var(--upang-green-light) 100%);
            --gradient-gold: linear-gradient(135deg, var(--upang-gold) 0%, var(--upang-gold-light) 100%);
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Open Sans', sans-serif;
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('./dist/assets/images/bg.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.03;
            z-index: -1;
        }

        .auth-main {
    background: transparent;
    min-height: 100vh;       /* full screen height */
    display: flex;
    align-items: center;     /* vertical center */
    justify-content: center; /* horizontal center */
}

        .login-container {
            background: var(--upang-white);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: var(--shadow-medium);
            border: 1px solid rgba(45, 90, 39, 0.08);
            max-width: 450px;
            width: 100%;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .school-logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .school-logo {
            width: 90px;
            height: 90px;
            background: var(--gradient-primary);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-soft);
            position: relative;
            animation: logoFloat 3s ease-in-out infinite;
        }

       

        .school-logo::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border: 3px solid var(--upang-gold);
            border-radius: 50%;
            opacity: 0.6;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .login-title {
            color: var(--upang-green-dark);
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .login-subtitle {
            color: var(--upang-gray);
            font-size: 16px;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .error-alert {
            background: linear-gradient(135deg, #fee 0%, #fdd 100%);
            color: var(--upang-error);
            padding: 15px 18px;
            border-radius: 12px;
            border-left: 4px solid var(--upang-error);
            font-size: 14px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            color: var(--upang-green-dark);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

       .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--upang-green);
    font-size: 16px;
}
     .form-input {
    width: 100%;
    padding: 12px 44px 12px 44px;  /* 12px top/bottom, 44px left/right */
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 16px;
    line-height: 1.4;  /* ensures text doesn’t get squished */
    box-sizing: border-box; /* prevents overflow */
}



        .form-input:focus {
            border-color: var(--upang-green);
            box-shadow: 0 0 0 3px rgba(45, 90, 39, 0.1);
            transform: translateY(-1px);
        }

        .form-input::placeholder {
            color: var(--upang-gray);
            font-weight: 400;
        }

      .password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
}

        .password-toggle:hover {
            color: var(--upang-green);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
            color: var(--upang-green-dark);
            font-weight: 500;
        }

        .checkbox-wrapper input {
            display: none;
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 2px solid var(--upang-green);
            border-radius: 4px;
            margin-right: 10px;
            position: relative;
            transition: all 0.2s ease;
        }

        .checkbox-wrapper input:checked + .checkbox-custom {
            background: var(--gradient-primary);
            border-color: var(--upang-green);
        }

        .checkbox-wrapper input:checked + .checkbox-custom::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-password {
            color: var(--upang-green);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--upang-green-dark);
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            background: var(--gradient-primary);
            color: var(--upang-white);
            border: none;
            padding: 18px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            box-shadow: var(--shadow-soft);
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            background: var(--upang-green-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .demo-section {
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
        }

        .demo-title {
            color: var(--upang-gray);
            font-size: 14px;
            margin-bottom: 18px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .demo-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .demo-btn {
            background: var(--upang-white);
            border: 2px solid;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .admin-demo {
            border-color: var(--upang-green);
            color: var(--upang-green);
        }

        .admin-demo:hover {
            background: var(--upang-green);
            color: var(--upang-white);
            transform: translateY(-2px);
        }

        .student-demo {
            border-color: var(--upang-gold);
            color: var(--upang-gold-dark);
        }

        .student-demo:hover {
            background: var(--upang-gold);
            color: var(--upang-white);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .login-title {
                font-size: 24px;
            }
            
            .demo-buttons {
                flex-direction: column;
            }
            
            .demo-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
                padding: 30px 20px;
            }
            
            .school-logo {
                width: 70px;
                height: 70px;
            }
            
            .school-logo::before {
                font-size: 32px;
            }
            
            .login-title {
                font-size: 22px;
            }
            
            .form-input {
                padding: 16px 16px 16px 48px;
                font-size: 15px;
            }
            
            .input-icon {
                left: 16px;
                font-size: 15px;
            }
            
            .password-toggle {
                right: 16px;
            }
        }
    </style>
</head>
<body>
        

    <!-- Login Form -->
    <div class="auth-main relative">
        <div class="auth-wrapper v1 flex items-center w-full h-full min-h-screen justify-center">
            <div class="login-container">
                <!-- Logo and Header -->
                <div class="school-logo-container">
                    <div class="school-logo">
    <img src="./dist/assets/images/school-logo.png" alt="School Logo" style="width: 90px; height: 90px; border-radius: 50%;">
</div>
                    <h2 class="login-title">UPang Student Feedback System</h2>
                    <p class="login-subtitle">Sign in to your account</p>
                </div>
                
                <?php if(!empty($error)): ?>
                <div class="error-alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
                <?php endif; ?>
                
                <!-- Login Form -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email address" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                            <span class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="remember-forgot">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember">
                            <span class="checkbox-custom"></span>
                            Remember me
                        </label>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" name="submit" class="login-btn">
                        <span class="btn-text">Sign In</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                
               
    </div>
    <!-- Required JS -->
    <script src="./dist/assets/js/plugins/simplebar.min.js"></script>
    <script src="./dist/assets/js/plugins/popper.min.js"></script>
    <script src="./dist/assets/js/icon/custom-icon.js"></script>
    <script src="./dist/assets/js/plugins/feather.min.js"></script>
    <script src="./dist/assets/js/component.js"></script>
    <script src="./dist/assets/js/theme.js"></script>
    <script src="./dist/assets/js/script.js"></script>

    
    <script>
      
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
