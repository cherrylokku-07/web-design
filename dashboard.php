<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

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

// Query to fetch movies from the database
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Basic styling for demonstration purposes */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .button-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
        }
        .logout-form {
            display: inline-block; /* Ensures button behaves like a block element */
            margin-top: 10px;
        }
        .logout-form button {
            background-color: #007bff; /* Blue color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-form button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <h1>Welcome to the Dashboard, <?php echo $_SESSION["username"]; ?></h1>
    <h2>Movies</h2>
    <table>
        <thead>
            <tr>
                <th>Movie Name</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Director</th>
                <th>IMDb Rating</th>
                <th>Action</th> <!-- New column for delete button -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Display movies from the database
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["movie_name"] . "</td>";
                    echo "<td>" . $row["year"] . "</td>";
                    echo "<td>" . $row["genre_name"] . "</td>";
                    echo "<td>" . $row["director_name"] . "</td>";
                    echo "<td>" . $row["imdb_rating"] . "</td>";
                    echo "<td>"; // New column for delete button
                    echo "<form method='post' action='delete_movie.php'>";
                    echo "<input type='hidden' name='movie_name' value='" . $row["movie_name"] . "'>";
                    echo "<button type='submit'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No movies found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="button-container">
        <button onclick="window.location.href='add_movie.php'">Add Movie</button>
    </div>
    <form class="logout-form" method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
