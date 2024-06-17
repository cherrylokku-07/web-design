<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if movie_name is set and not empty
if(isset($_POST["movie_name"]) && !empty(trim($_POST["movie_name"]))){
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = ""; // No password, leave it empty
    $dbname = "movie_database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a delete statement
    $sql = "DELETE FROM movies WHERE movie_name = ?";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_name);

        // Set parameters
        $param_name = trim($_POST["movie_name"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Movie deleted successfully. Redirect to dashboard
            header("location: dashboard.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();
}
?>
