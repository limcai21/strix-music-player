<?php
    // Admin
    $host = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $db = 'audio_project';

    $mysqli = new mysqli($host, $dbUsername, $dbPassword, $db);

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_errror;
        exit();
    }
