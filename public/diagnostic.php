<?php
// This file helps diagnose Laravel deployment issues

// Display basic PHP info
echo "<h1>Server Diagnostic</h1>";
echo "<h2>Basic PHP Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Current Script: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";

// Check file permissions
echo "<h2>File Permissions</h2>";
$app_dir = dirname(__DIR__);
$storage_dir = $app_dir . '/storage';
$bootstrap_cache = $app_dir . '/bootstrap/cache';
$public_dir = $app_dir . '/public';

echo "<p>Application directory writable: " . (is_writable($app_dir) ? 'Yes' : 'No') . "</p>";
echo "<p>Storage directory writable: " . (is_writable($storage_dir) ? 'Yes' : 'No') . "</p>";
echo "<p>Bootstrap cache writable: " . (is_writable($bootstrap_cache) ? 'Yes' : 'No') . "</p>";
echo "<p>Public directory writable: " . (is_writable($public_dir) ? 'Yes' : 'No') . "</p>";

// List environment variables
echo "<h2>Environment Variables</h2>";
echo "<pre>";
$env_file = $app_dir . '/.env';
if (file_exists($env_file)) {
    echo "Environment file exists at: $env_file\n";
    echo "File contents:\n";
    echo htmlspecialchars(file_get_contents($env_file));
} else {
    echo "Environment file does not exist at: $env_file\n";
    
    // Check for other .env files
    $files = scandir($app_dir);
    $env_files = array_filter($files, function($file) {
        return strpos($file, '.env') === 0;
    });
    
    if (!empty($env_files)) {
        echo "\nFound other environment files:\n";
        foreach ($env_files as $file) {
            echo "- $file\n";
        }
    } else {
        echo "\nNo environment files found in application directory.\n";
    }
}
echo "</pre>";

// Check database connection
echo "<h2>Database Connection Test</h2>";
$db_path = $app_dir . '/database/database.sqlite';
echo "<p>SQLite database file: " . $db_path . "</p>";
echo "<p>File exists: " . (file_exists($db_path) ? 'Yes' : 'No') . "</p>";
echo "<p>File writable: " . (is_writable($db_path) ? 'Yes' : 'No') . "</p>";

// Try direct PDO connection
try {
    $pdo = new PDO('sqlite:' . $db_path);
    echo "<p style='color:green'>Direct PDO connection successful!</p>";
    // Try a simple query
    $stmt = $pdo->query("SELECT sqlite_version()");
    $version = $stmt->fetchColumn();
    echo "<p>SQLite version: " . $version . "</p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>Database connection failed: " . $e->getMessage() . "</p>";
}

// List directories
echo "<h2>Directory Structure</h2>";
echo "<pre>";
function list_dir($dir, $indent = 0) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        $full_path = $dir . '/' . $file;
        echo str_repeat('  ', $indent) . $file . (is_dir($full_path) ? '/' : '') . "\n";
        if (is_dir($full_path) && $indent < 1) {  // Limit recursion depth
            list_dir($full_path, $indent + 1);
        }
    }
}

try {
    list_dir($app_dir);
} catch (Exception $e) {
    echo "Error listing directory: " . $e->getMessage();
}
echo "</pre>";

// Show loaded PHP extensions
echo "<h2>Loaded PHP Extensions</h2>";
echo "<pre>";
print_r(get_loaded_extensions());
echo "</pre>"; 