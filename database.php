<?php
/**
 * Database Connection File
 * Connects to MySQL database using credentials from .env file
 */

// Prevent multiple inclusions
if (!function_exists('loadEnv')) {
    function loadEnv($path)
    {
        if (!file_exists($path)) {
            throw new Exception('.env file not found');
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse KEY=VALUE
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Set as environment variable
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// Load .env file only once
if (!defined('DB_HOST')) {
    loadEnv(__DIR__ . '/.env');

    // Database configuration
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
    define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
    define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
    define('DB_DATABASE', getenv('DB_DATABASE') ?: 'indo');
}

// Create database connection using singleton pattern
if (!isset($GLOBALS['db_connection'])) {
    try {
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Set charset to utf8mb4 for proper Unicode support
        $conn->set_charset("utf8mb4");

        // Store in global variable to reuse
        $GLOBALS['db_connection'] = $conn;

    } catch (Exception $e) {
        // Log error and show user-friendly message
        error_log($e->getMessage());
        die("Database connection failed. Please check your configuration.");
    }
} else {
    // Reuse existing connection
    $conn = $GLOBALS['db_connection'];
}

// Function to safely close the connection
if (!function_exists('closeConnection')) {
    function closeConnection()
    {
        if (isset($GLOBALS['db_connection'])) {
            $GLOBALS['db_connection']->close();
            unset($GLOBALS['db_connection']);
        }
    }

    // Register shutdown function to close connection
    register_shutdown_function('closeConnection');
}

// Return connection for use in other files
return $conn;
?>