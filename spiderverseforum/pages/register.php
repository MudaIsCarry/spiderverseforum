<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <base href="./"> <!-- Add the base tag with the correct relative URL -->
    <title>User Registration</title>
</head>
<body>
    <header>
                <!-- Placeholder image -->
                <?php include 'includes/header.php'; ?>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
        <h2>Register</h2>
    </header>

    <!-- Registration form -->
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">

        <button type="submit" name="register">Register</button>
    </form>

    <?php
    // Handle form submission
    if (isset($_POST['register'])) {
        // Include the database connection
        include_once '../includes/db_connection.php';

        // Get the database connection
        $conn = getDbConnection();

        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Handle profile picture upload
        $profilePictureName = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
            // Set a unique name for the uploaded profile picture
            $profilePictureName = uniqid('profile_picture_') . '.' . pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            
            // Move the uploaded file to a designated folder
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], '../images/pfp' . $profilePictureName);
        }

        // Insert user into the database
        $sql = "INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $password, $profilePictureName);

        if ($stmt->execute()) {
            echo '<p class="success">Registration successful. You can now <a href="login.php">log in</a>.</p>';
        } else {
            echo '<p class="error">Registration failed. Please try again.</p>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
