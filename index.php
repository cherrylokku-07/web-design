<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        /* Basic styling for demonstration purposes */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
        }
        .button {
            background-color: darkgreen;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            display: inline-block; /* Ensures button behaves like a block element */
        }
        .button:hover {
            background-color: #006400; /* Darker shade of green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Logout</h2>
        <form method="post" action="logout.php">
            <button class="button" type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
