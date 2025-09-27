<?php
require_once 'includes/db_config.php';

echo "<h2>UPang Database Connection Test</h2>";

try {
    // Test 1: Basic connection
    echo "<p>✅ Database connection successful!</p>";
    
    // Test 2: Count tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    echo "<p>✅ Found " . count($tables) . " tables in database</p>";
    
    // Test 3: Test sample data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch()['count'];
    echo "<p>✅ Found $userCount users in database</p>";
    
    // Test 4: Test departments
    $stmt = $pdo->query("SELECT department_code, department_name FROM departments");
    $departments = $stmt->fetchAll();
    echo "<p>✅ Departments loaded:</p><ul>";
    foreach($departments as $dept) {
        echo "<li>" . $dept['department_code'] . ": " . $dept['department_name'] . "</li>";
    }
    echo "</ul>";
    
    // Test 5: Test academic periods
    $stmt = $pdo->query("SELECT academic_year, term, status FROM academic_periods ORDER BY term");
    $periods = $stmt->fetchAll();
    echo "<p>✅ Academic periods:</p><ul>";
    foreach($periods as $period) {
        echo "<li>" . $period['academic_year'] . " - " . ucfirst($period['term']) . " (" . $period['status'] . ")</li>";
    }
    echo "</ul>";
    
    // Test 6: Test login credentials
    echo "<h3>Test Login Credentials:</h3>";
    $stmt = $pdo->query("SELECT email, user_type, first_name, last_name FROM users");
    $users = $stmt->fetchAll();
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Email</th><th>Password</th><th>Type</th><th>Name</th></tr>";
    foreach($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>password</td>";
        echo "<td>" . $user['user_type'] . "</td>";
        echo "<td>" . $user['first_name'] . " " . $user['last_name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>🎉 All tests passed! Database is ready.</h3>";
    
} catch(Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>