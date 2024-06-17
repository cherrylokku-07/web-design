<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    require_once "config.php"; // Include your database configuration file

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get movie details from the form
    $movie_name = $_POST["movie_name"];
    $year = $_POST["year"];
    $genre_name = $_POST["genre_name"]; // Correctly capturing genre
    $director_name = $_POST["director_name"];
    $imdb_rating = $_POST["imdb_rating"];

    // SQL query to insert movie into database
    $sql = "INSERT INTO movies (movie_name, year, genre_name, director_name, imdb_rating)
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("siisd", $movie_name, $year, $genre_name, $director_name, $imdb_rating);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $message = "New movie added successfully";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
</head>
<body>
    <h2>Add Movie</h2>
    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    } elseif (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="movie_name">Movie Name:</label>
        <input type="text" name="movie_name" required><br>
        <label for="year">Year:</label>
        <input type="number" name="year" required><br>
        <label for="genre_name">Genre:</label>
        <input type="text" name="genre_name" required><br> <!-- Ensure correct input field name -->
        <label for="director_name">Director:</label>
        <input type="text" name="director_name" required><br>
        <label for="imdb_rating">IMDb Rating:</label>
        <input type="number" step="0.1" name="imdb_rating" required><br>
        <input type="submit" value="Add Movie">
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
